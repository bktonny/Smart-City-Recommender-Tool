<?php

function get_top_cases($limit = 0){
		global $DB, $Template, $Info, $Func, $Lang;
		if ( !$limit ){
			$limit		= $Info->option['case_limit_item_hot'];
		}
		$record_id		= $Func->request_get('id', 0);
		$where_sql		= $record_id ? ' AND case_id!='. $record_id : '';
		$DB->query('SELECT case_id, cat_id, pic_thumb, title, content_url, posted_date, case_type, hits FROM '. $DB->prefix .'case AS A '. $this->filter['where_sql'] . $where_sql .' AND is_hot='. SYS_CASE_HOT .' AND case_type='. SYS_CASE_FULL .' AND hits>0 ORDER BY hits DESC, case_id DESC LIMIT 0,'. $limit);
		$record_count	= $DB->num_rows();
		$record_data	= $DB->fetch_all_array();
		$DB->free_result();
		for ($i=0; $i<$record_count; $i++){
$record_data[$i]['case_id'] .'/'. $record_data[$i]['pic_thumb'] .'" border="0" />' : '',
				'TITLE'	=> $record_data[$i]['title'],
				'INITIATIVE'=> $record_data[$i]['hits'],
				'CASE_DESCRIPTION'=> $Func->compile_url('mod='. MOD_CASE .'&id='. $record_data[$i]['case_id'], $record_data[$i]['title'])));
			if ( $i < $record_count - 1){
				$Template->set_block_vars("top_viewcase:sepline", array());}}}
	function get_cat_navigation(&$cat_navigation, $cat_id){
		global $Func, $Info, $DB;
		if ( !$this->cat_count ){

			//Get all case initiatives/categories
			$DB->query('SELECT * FROM '. $DB->prefix .'case_category WHERE enabled=1 ORDER BY cat_order ASC');
			$this->cat_count	= $DB->num_rows();
			$this->cat_data		= $DB->fetch_all_array();
			$DB->free_result();
		}
		for ($i=0; $i<$this->cat_count; $i++){
			if ( $cat_id == $this->cat_data[$i]['cat_id'] ){
				if ( !empty($cat_navigation) ){
					$cat_navigation	= " &raquo; ". $cat_navigation;
				}
				if ( $this->cat_data[$i]['cat_parent_id'] ){
					$cat_navigation	= '<a href="'. $Func->compile_url('mod='. MOD_CASE .'&cid='. $this->cat_data[$i]['cat_id'], $this->cat_data[$i]['cat_title']) .'">'. $this->cat_data[$i]['cat_title'] .'</a>' . $cat_navigation;
					$this->get_cat_navigation($cat_navigation, $this->cat_data[$i]['cat_parent_id']);
				}
				else{
					$cat_navigation	= '<a href="'. $Func->compile_url('mod='. MOD_CASE .'&cid='. $this->cat_data[$i]['cat_id'], $this->cat_data[$i]['cat_title']) .'">'. $this->cat_data[$i]['cat_title'] .'</a> <span>' . $cat_navigation .'</span>';
				}
				break;
		}}}
		
		?>
