<?php 

	function lang ( $phrase){

		static $lang = array(
			//Dashboard page
			'HOME_ADMIN' 	=> 'KOFY'		,
			'CATEGORIES' 	=> 'Categories',
			'ITEMS' 		=> 'Items',
			'MEMBERS' 		=> 'Members',
			'COMMENTS'		=> 'Comments',
			'STATISTICS' 	=> 'Statistics',
			'LOGS' 			=> 'Logs',
			'' 				=> '',
			'' 				=> '',
			'' 				=> '',
			'' 				=> '',
			'' 				=> '',
			'' 				=> '',
			'' 				=> '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => ''
			);
		return $lang[$phrase];
	}