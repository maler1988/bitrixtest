<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>




	    <? if($arResult['ITEMS']) { ?>
	    
	    	<h3>Пример фильтра</h3>
	    	<ul>
	    		<li><a href="<?=$APPLICATION->GetCurPage();?>?date_start=03-07-2018">Курсы с 03-07-2018</a></li>
	    		<li><a href="<?=$APPLICATION->GetCurPage();?>?date_start=27-06-2018&date_end=12-07-2018">Курсы с 27-06-2018 по 12-07-2018</a></li>
	    		<li><a href="<?=$APPLICATION->GetCurPage();?>?date_end=18-07-2018">Курсы до 18-07-2018</a></li>
	    	</ul>
	    	
	    
	    	<h3>Таблица курсов</h3>
			<div class="table-responsive">
				<table class="table table-striped">
				  <tr>
				  	<th>Валюта</th>
				  	<? foreach ($arResult['DATE_LIST'] as $date) { ?>
				  		<th><?=$date;?></th>
				  	<? } ?>
				  </tr>
				<? foreach ($arResult['ITEMS'] as $currency => $rates) { ?>
					<tr>
						<td><?=$currency;?></td>
						<? foreach ($rates as $rate) { ?>
							<td><?=$rate;?></td>
						<? } ?>
					</tr>	
				<? } ?>
				</table>	
			</div>

		<? } else { ?>
			<b>Нет данных по заданному фильтру</b>
		<? } ?>
		
		




	
	
	
