<?php
/**
  * @file document_content_change.addon.php
  * @biref Depending on the type of posts to change the contents of the set.
  * @author NAVER (developers@xpressengine.com)
  */

if(!defined('__XE__'))
	exit();

if($called_position == 'after_module_proc' && $this->module=="board")
{
	$cur_act = Context::get('act');
	if($cur_act != "" && $cur_act != "dispBoardContent")
		return;
	
	$document_srl = Context::get('document_srl');
	if(!$document_srl)
		return;

	$oDocument = Context::get('oDocument');
	if(!$oDocument)
		return;

	if($oDocument->document_srl != $document_srl)
		return;
	
	$pattern = "/(0[0-9]{1,2})-([0-9]{3,4})-([0-9]{4})/i";
	$replace = "$1-$2-****";

	$oDocument->variables['content'] = preg_replace($pattern, $replace, $oDocument->variables['content']);
}
