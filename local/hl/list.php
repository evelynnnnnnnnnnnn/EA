<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("HL list");
?><?$APPLICATION->IncludeComponent(
	"bitrix:highloadblock.list", 
	".default", 
	array(
		"BLOCK_ID" => "2",
		"CHECK_PERMISSIONS" => "N",
		"DETAIL_URL" => "/local/hl/view.php?ID=#ID#",
		"FILTER_NAME" => "",
		"PAGEN_ID" => "page",
		"ROWS_PER_PAGE" => "2",
		"SORT_FIELD" => "UF_YEAR",
		"SORT_ORDER" => "DESC",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>