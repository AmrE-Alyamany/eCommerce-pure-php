<?php 

	function lang ( $phrase){

		static $lang = array(
			//Homepage
			
			'HOME_ADMIN' 	=> '',
			'CATEGORIES' 	=> '',
			'ITEMS' 		=> '',
			'MEMBER' 		=> '',
			'STATISTICS' 	=> '',
			'LOGS' 			=> '',
			'' 				=> '',
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
			'' => ''

			);
		return $lang[$phrase];
	}