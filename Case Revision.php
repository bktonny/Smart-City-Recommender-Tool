<?php

//Get case info
		$DB->query('SELECT * FROM '. $DB->prefix .'case_category WHERE cat_id='. $record_info['cat_id'] .' AND enabled='. SYS_ENABLED);
		if ( !$DB->num_rows() ){
			$this->list_cases();
			return false;
		}
		$cat_info	= $DB->fetch_array();
			'TITLE'					=> $Func->highlight_text($record_info['page_title'], $highlight, $match),
			'DATE'					=> $Func->translate_date(gmdate($date_format, $record_info['posted_date'] + $timezone)),
			'CASE'					=> $record_info['hits'] + 1,
			'CONTENT'				=> $Func->highlight_text(html_entity_decode($record_info['content_detail']), $highlight, $match),
			'AUTHOR'				=> $record_info['author'],
			'U_PRINT'				=> $Func->compile_url('mod='. MOD_CASE .'&id='. $record_info['case_id'] .'&rp='. $page_id .'&act=print&rf=1', $Lang->data['general_print']),
       		'S_ADD_CASE_COMMENT'			=> $Info->option['site_url'] . AJAX_INDEX .'?mod='. MOD_CASE_COMMENT .'&id='. $record_id .'&act=add_comment',
       		'U_LIST_ CASE_COMMENTS'		=> $Info->option['site_url'] . AJAX_INDEX .'?mod='. MOD_CASE_COMMENT .'&id='. $record_id
		));
		//Update hits
		if ( $Cache->turn_on == CACHE_NORMAL ){
			//Use ajax to update hits
			$Template->set_block_vars('update_hits', array(
				'U_UPDATE'		=> $Info->option['site_url'] . AJAX_INDEX .'?mod='. MOD_CASE .'&act=hit&id='. $record_id
			));
		}
		else{
			//Update hits directly
			$DB->query('UPDATE '. $DB->prefix .'case SET hits=hits+1 WHERE case_id='. $record_id); }


?>