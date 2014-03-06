<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */

/**
 * @file exchange_content.addon.php
 * @brief Addon for change content matched pattern's
 * @author [NAVER](http://www.navercorp.com) (<developers@xpressengine.com)*/

if(!defined('__XE__'))
	exit();

$document_srl = Context::get('document_srl');
if($called_position=="after_module_proc" && $this->module=="board")
{
	$document_srl = Context::get('document_srl');
	if(!$document_srl)
		return false;

	$cur_act = Context::get('act');
	if($cur_act != "" && $cur_act != "dispBoardContent")
		return false;
	
	$oDocument = Context::get('oDocument');	// set from documentView::dispBoardContentView()
	if(!$oDocument)
		return false;

	if($oDocument->document_srl != $document_srl)
		return false;
	
	$pattern = array();
	$pattern['phone_number'] = "/(0[0-9]{1,2})-([0-9]{3,4})-([0-9]{4})/i";

	$replace['phone_number'] = "$1-$2-****";

	$oDocument->variables['content'] = preg_replace($pattern, $replace, $oDocument->variables['content']);

}
