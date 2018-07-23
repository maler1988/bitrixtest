<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Highloadblock as HL;

class CurrencyRates extends CBitrixComponent {
	
	/**
	 * Обработка входных параметров
	 *
	 * @param mixed[] $arParams
	 * @return mixed[] $arParams
	 */
	public function onPrepareComponentParams($arParams) {
		// время кэширования
		$arParams["CACHE_TIME"] = (int)$arParams["CACHE_TIME"];

		return $arParams;
	}
	
	/**
	 * Получаем курсы валют за выбранный промежуток времение (по умолчанию 30 последних дней)
	 * */
	public function getResult(){
		
		$defaultFilter = array();
		
		if(!empty($_GET['date_start'])){
			$defaultFilter['>=UF_DATE'] = \Bitrix\Main\Type\DateTime::createFromUserTime($defaultFilter);
		}
		
		if(!empty($_GET['date_end'])){
			$defaultFilter['<=UF_DATE'] = \Bitrix\Main\Type\DateTime::createFromUserTime($defaultFilter);
		}
		
		$hlblock = HL\HighloadBlockTable::getById(HL_BLOCK_RATES_ID)->fetch();
		$entity = HL\HighloadBlockTable::compileEntity($hlblock);
		$entityClass = $entity->getDataClass();
		
		
		$resRates = $entityClass::getList(array(
				'select' 	=> array(
						'ID', 
						'UF_DATE', 
						'UF_CURRENCY', 
						'UF_RATE'
				),
				'filter' 	=> $defaultFilter,
				'order' 	=> array('UF_DATE' => 'ASC'),
		));
		
		$ratesList = array();
		$dateList = array();
		while($row = $resRates->fetch()){
			$date = $row['UF_DATE']->format('d-m-Y');
			$ratesList[$row['UF_CURRENCY']][$date] = $row['UF_RATE'];
			if(!in_array($date, $dateList)){
				$dateList[] = $date;
			}
			
		}
		
		$this->arResult['ITEMS'] = $ratesList;
		$this->arResult['DATE_LIST'] = $dateList;
	}

	/**
	 * Логика компонента
	 */
	public function executeComponent() {

		try {
			
			//Кешируем данные
			if($this->StartResultCache($this->arParams["CACHE_TIME"])) {
				$this->getResult();
				$this->includeComponentTemplate();
			}

		} catch(Exception $e) {
			ShowError($e->getMessage());
		}
	}
}