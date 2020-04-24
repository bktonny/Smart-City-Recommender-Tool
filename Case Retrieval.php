<?php

function get_related_case($record_info){
		global $Template, $Info, $Func, $DB;
		if ( !$record_info['topic_id'] ){
		return false; }
		//Get smart city case initiatives/categories
		$disabled_cats	= $Func->get_disabled_cats("case_category");
		$where_sql= sizeof($disabled_cats) ? $this->filter['where_sql'] ." AND cat_id NOT IN (". implode(",", $disabled_cats) .") " : $this->filter['where_sql'];
		//Get related cases
		$DB->query('SELECT case_id, cat_id, pic_thumb, title, posted_date, case_type FROM '. $DB->prefix .'case AS A '. $where_sql .' AND case_type!='. SYS_CASE_SUMMARY .' AND topic_id='. $record_info['topic_id'] .' AND case_id!='. $record_info['case_id'] .' ORDER BY posted_date DESC LIMIT 0,5');
		$record_count	= $DB->num_rows();
		$record_data	= $DB->fetch_all_array();
		$DB->free_result();
		for ($i=0; $i<$record_count; $i++){
$record_data[$i]['case_id'] .'/'. $record_data[$i]['pic_thumb'] .'" border="0" />' : '',
				'TITLE'			=> $record_data[$i]['title'],
				'U_VIEW'		=> $Func->compile_url('mod='. MOD_CASE .'&id='. $record_data[$i]['case_id'], $record_data[$i]['title'])
			));
			if ( $i < $record_count - 1){
				$Template->set_block_vars("related_caserow:sepline", array());
			}}}
?>