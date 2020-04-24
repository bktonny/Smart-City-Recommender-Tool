<?php

$DB->query("INSERT INTO ". $DB->prefix ."case_id(case_id, case_time, case_note) 
VALUES('". $Info->case_id ."', ". CURRENT_TIME .", 'case_rating:". $record_id ."')");
		return true;
		for ($i=0; $i<$this->cat_count; $i++){
			if ( ($parent_id == $this->cat_data[$i]['cat_parent_id']) && ($except_cid != $this->cat_data[$i]['cat_id']) && empty($this->cat_data[$i]['redirect_url']) ){
				$counter	= ($this->cat_data[$i]['case_counter'] || $this->cat_data[$i]['subcat_counter'])  ?  'true' : 'false';
				$Template->set_block_vars("catrow", array(
					'ID'=> $this->cat_data[$i]['cat_id'],
					'ORDER'=> $this->cat_data[$i]['cat_order'],
					'NAME'	=> $this->cat_data[$i]['cat_title'],
					'case_COUNTER'=> $this->cat_data[$i]['case_counter'],
					'SUBCAT_COUNTER'=> $this->cat_data[$i]['case_counter'],
					'PREFIX'=> $str_prefix .$symbol
				));
				$this->set_all_cats($this->cat_data[$i]['cat_id'], $except_cid, $level+1, $url_append, $symbol, $prefix);
			}}}}
 function learn_case(){
		global $DB, $Info, $Cache, $Template, $Lang, $Func;
		$record_id= $Func->request_get('id', 0);
		$number= $Func->request_get('number', 0);
		if ( !$record_id || ($number < 1) || ($number > 5) ){
			return false;}
		//Get case info
		$DB->query('SELECT case_id, case_count FROM '. $DB->prefix .'case WHERE case_id='. $record_id .' AND enabled='. SYS_ENABLED);
		if ( !$DB->num_rows() ){
			return false; }
		$record_info = $DB->fetch_array();
			echo $Lang->data['case_saved'];
			return true;
?>