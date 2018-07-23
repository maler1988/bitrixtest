<?

use Bitrix\Highloadblock as HL;

/**
 * Курсы валют по датам
 */
define('HL_BLOCK_RATES_ID', 3);


/**
 * обёртка для print_r() и var_dump()
 * @var mixed $val - значение переменной
 * @var string $name - имия
 * @var boolean $mode - применить var_dump() 
 * @var boolean $die - вызвать die() после вывода переменной
 * */
function print_p($val, $name = 'Содержимое переменной', $mode = false, $die = false){
	global $USER;
	if($USER->IsAdmin()){
		echo '<pre>'.(!empty($name) ? $name.': ' : ''); if($mode) { var_dump($val); } else { print_r($val); } echo '</pre>';
		if($die) die;
	}
}

/**
 * Получить курсы валют за последние 30 дней
 * пытался подвесить на крон, но какие-то проблемы с планировщиком возникли
 * */
function getRatesByDay(){
	$hlblock = HL\HighloadBlockTable::getById(HL_BLOCK_RATES_ID)->fetch();
	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
	$entityClass = $entity->getDataClass();
	
	//Очищаем всё что есть в SmartFilterURLs
	$resRates = $entityClass::getList(array(
			'select' => array('ID'),
			'order' => array('ID' => 'ASC'),
	));
	
	while($rowRate = $resRates->fetch()){
		$entityClass::Delete($rowRate['ID']);
	}
	
	//Получаем курсы валют за последние 30 дней
	$startDateRates = new DateTime('-30 days');
	$endDateRetes = new DateTime();
	
	// интервал с размером сдвига в 1 день
	$interval = new DateInterval('P1D');
	$dateRange = new DatePeriod($startDateRates, $interval, $endDateRetes);
	
	$arrRates = [];
	foreach($dateRange as $dateRate){
		$rateAnswer = file_get_contents('https://exchangeratesapi.io/api/' .  $dateRate->format('Y-m-d'));
		$rateByDay = json_decode($rateAnswer, true);
		if(!$arrRates[$rateByDay['date']]){
			$arrRates[$rateByDay['date']]['base'] = $rateByDay['base'];
			foreach ($rateByDay['rates'] as $cur => $rate){
				$arrRates[$rateByDay['date']]['rates'][] = [
						'currency' => $cur,
						'rate'     => $rate
				];
			}
		}
	}
	
	//Сохраняем данные HL блок
	if($arrRates){
		foreach ($arrRates as $date => $rateData){
			foreach ($rateData['rates'] as $rateItem){
				$rateItem = [
						'UF_BASE' 		=> $rateData['base'],
						'UF_DATE' 		=> date('d.m.Y', strtotime($date)),
						'UF_CURRENCY' 	=> $rateItem['currency'],
						'UF_RATE'		=> $rateItem['rate']
				];
				$result = $entityClass::add($rateItem);
			}
			
		}
	}
	
	return 'getRatesByDay();';
}

?>