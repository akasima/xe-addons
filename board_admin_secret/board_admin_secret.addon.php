<?php
/**
 * @file
 * @brief Addon for extends board grant 
 * @author akasima (akasima@nate.com)
*/
if(!defined('__XE__'))
	exit();

if($called_position=="before_module_proc" && $this->module=="board")
{
	// change board grant about comment
	$arrCheckAct = array(
		'dispBoardModifyComment',
		'dispBoardWrite',
	);
	if($this->grant->manager && in_array($this->act, $arrCheckAct)) 
	{
		$this->module_info->secret="Y";
	}
}

if($called_position=="after_module_proc" && $this->module=="board")
{
	// change board grant about comment
	$arrCheckAct = array(
		'dispBoardModifyComment',
		'dispBoardWrite',
	);
	if(in_array($this->act, $arrCheckAct)) 
	{
		if($this->grant->manager)
		{
			$status_list = Context::get('status_list');
			if(!isset($status_list['SECRET']))
			{
				$oDocumentModel = getModel('document');
				$statusNameList = $oDocumentModel->getStatusNameList();
				$status_list['SECRET'] = $statusNameList['SECRET'];
				Context::set('status_list', $status_list);
			}
		}
	}
}
