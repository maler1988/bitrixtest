<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>



<? if($arResult['ITEMS']) { ?>
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
<? } ?>