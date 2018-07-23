<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Курсы валют");
?><?$APPLICATION->IncludeComponent(
	"custom:tablerates",
	"",
	Array(
		"CACHE_TIME" => 3600,
	)
);?>
<br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>