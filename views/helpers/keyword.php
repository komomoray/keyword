<?php
/**
 * [Helper] keyword
 *
 * @copyright		Copyright 2013, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @license			MIT
 */
class KeywordHelper extends AppHelper {
/**
 * ヘルパー
 *
 * @var array
 * @access public
 */
	var $helpers = array('Blog', 'Html');
/**
 * 「テキスト」を取得する
 *
 * @param array $data
 * @return string or ''
 * @access public
 */
	function getKeywordName($data = array()) {
		
		if($data) {
			if(!empty($data['name'])) {
				return $data['name'];
			}
		}
		
		return;
		
	}
	
}
