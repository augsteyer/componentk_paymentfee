<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute("quote_address", "fee_total", array("type"=>"varchar"));
$installer->addAttribute("order", "fee_total", array("type"=>"varchar"));
//@todo: implement invoice & creditmemo

$installer->endSetup();
	 