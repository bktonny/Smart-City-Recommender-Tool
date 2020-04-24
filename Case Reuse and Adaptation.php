<?php

//Get cases to reuse
//Get cases to reuse
		$this->get_related_cases($record_info);
		return true; }
	function get_next_cases($record_info){
		global $Template, $Info, $Func, $DB;
		$where_sql= $this->filter['where_sql'];
		if ( !$this->filter['cat_id'] ){
			if ( !$this->cat_count ){
				//Get all case initiatives/categories
				$DB->query('SELECT * FROM '. $DB->prefix .'case_category WHERE enabled=1 ORDER BY cat_order ASC');
				$this->cat_count	= $DB->num_rows();
				$this->cat_data		= $DB->fetch_all_array();
				$DB->free_result();
			}
			$cat_ids= array();
			$cat_ids[]= $record_info['cat_id'];
			$Func->get_subcat_ids($cat_ids, $record_info['cat_id'], $this->cat_count, $this->cat_data);
			$where_sql.= sizeof($cat_ids) ? ' AND cat_id IN ('. implode(',', $cat_ids) .')' : '';}
		$DB->query('SELECT case_id, cat_id, pic_thumb, title, posted_date, case_type FROM '. $DB->prefix .'case AS A '. $where_sql .' AND case_type!='. SYS_CASE_SUMMARY .' AND posted_date<'. $record_info['posted_date'] .' ORDER BY posted_date DESC LIMIT 0,'. $Info->option['case_limit_item_next']);
		$record_count	= $DB->num_rows();
		$record_data	= $DB->fetch_all_array();
		$DB->free_result();
		for ($i=0; $i<$record_count; $i++){
			$Template->set_block_vars("next_caserow", array(
				'DATE'	=> $Func->translate_date(gmdate($date_format, $record_data[$i]['posted_date'] + $timezone)),
				'PIC_THUMB'=> !empty($record_data[$i]['pic_thumb']) ? '<img src="'. CASE_IMAGE_PATH . $Func->get_image_dir($record_data[$i]['posted_date']) . $record_data[$i]['case_id'] .'/'. $record_data[$i]['pic_thumb'] .'" border="0" />' : '',
				'TITLE'=> $record_data[$i]['title'],
				'U_VIEW'=> $Func->compile_url('mod='. MOD_CASE .'&id='. $record_data[$i]['case_id'], $record_data[$i]['title'])
			));
}}
	function get_related_cases($record_info){
		global $Template, $Info, $Func, $DB;

		if ( !$record_info['topic_id'] ){
			return true;
		}
		
	?>
