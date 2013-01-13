<?php
/**
 * keywordモデル
 *
 * @copyright		Copyright 2012 - 2013, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			keyword.models
 * @license			MIT
 */
class Keyword extends BaserPluginAppModel {
/**
 * モデル名
 * 
 * @var string
 * @access public
 */
	var $name = 'Keyword';
/**
 * プラグイン名
 * 
 * @var string
 * @access public
 */
	var $plugin = 'Keyword';
/**
 * バリデーション
 *
 * @var array
 * @access public
 */
	var $validate = array(
		'keywords' => array(
			'maxLength' => array(
				'rule'		=> array('maxLength', 255),
				'message'	=> 'キーワードは255文字以内で入力してください。'
			)
		)
	);

}
