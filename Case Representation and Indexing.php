<?php

//Get Smart City Initiative
		$DB->query('SELECT case_id, .cat_id, pic_thumb, title, posted_date, case_type FROM '. $DB->prefix .'case AS '. $where_sql .' AND case_type!='. SYS_CASE_SUMMARY .' AND posted_date<'. $record_info['posted_date'] .' ORDER BY posted_date DESC LIMIT 0,'. $Info->option['case_limit_item_next']);
		$record_count	= $DB->num_rows();
		$record_data	= $DB->fetch_all_array();
		$DB->free_result();
		for ($i=0; $i<$record_count; $i++){
			$Template->set_block_vars("next_caserow", array(
				'DATE'	=> $Func->translate_date(gmdate($date_format, $record_data[$i]['posted_date'] + $timezone)),
				$Func->get_image_dir($record_data[$i]['posted_date']) . $record_data[$i]['case_id'] .'/'. $record_data[$i]['pic_thumb'] .'" border="0" />' : '',
				'TITLE'=> $record_data[$i]['title'],
				'U_VIEW'=> $Func->compile_url('mod='. MOD_CASE .'&id='. $record_data[$i]['case_id'], $record_data[$i]['title'])
			))
			;
			}}
?>