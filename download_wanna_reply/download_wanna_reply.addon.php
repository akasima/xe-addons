<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */

/**
 * @file exchange_content.addon.php
 * @brief Addon for change content matched pattern's
 * @author [NAVER](http://www.navercorp.com) (<developers@xpressengine.com)
 */

if(!defined('__XE__'))
	exit();

if($called_position == "before_display_content")
{
}

if($called_position == "before_module_proc" && Context::get('download_wanna_reply') != "")
{
	Context::loadLang(_XE_PATH_.'addons/download_wanna_reply/lang');
	$oModuleHandler = new ModuleHandler;
	$oModuleHandler->error = Context::getLang('msg_download_wanna_reply');
	$oModuleHandler->displayContent($this);
	Context::close();
	exit;
}

if($called_position == "after_module_proc")
{	
	$oDocument = Context::get('oDocument');
	// 글이 없는 경우 처리하지 않음
	if(!$oDocument)
		return;

	$logged_info = Context::get('logged_info');
	if($logged_info)
	{
		// 본인이 작성한 글은 다운로드 가능
		if($logged_info->member_srl == $oDocument->variables['member_srl'])
			return;

		// 댓글 쿼리
		$args = new stdClass;
		$args->document_srl = $oDocument->variables['document_srl'];
		$args->member_srl = $logged_info->member_srl;

		$output = executeQuery('addons.download_wanna_reply.getComment', $args);
		//쿼리에 오류가 있을 경우 다운로드 가능
		if(!$output->toBool())
			return;
		
		// 댓글이 있는 경우 다운로드 가능
		if(count($output->data)>0)
			return;
	}

	// documentItem::getUploadedFiles() 특성을 참고해서 만듬
	$oDocument->getUploadedFiles();
	foreach($oDocument->uploadedFiles['file_srl'] as $key=>$val)
	{
		$oDocument->uploadedFiles['file_srl'][$key]->download_url = substr(getUrl('download_wanna_reply',$val->file_srl), 1);
	}
}

