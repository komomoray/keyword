<?php
/**
 * [HookHelper] keyword
 *
 * @copyright		Copyright 2012 - 2013, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			keyword.views
 * @license			MIT
 */
class KeywordHookHelper extends AppHelper {
/**
 * 登録フック
 *
 * @var array
 * @access public
 */
	var $registerHooks = array('afterFormInput');
/**
 * ビュー
 * 
 * @var View 
 */
	var $View = null;
/**
 * Construct 
 * 
 */
	function __construct() {

		parent::__construct();
		$this->View = ClassRegistry::getObject('view');

	}
/**
 * afterFormInput
 * 
 * @param Object $form
 * @param string $fieldName
 * @param string $out
 * @return string 
 * @access public
 */
	function afterFormInput($form, $fieldName, $out) {

		// 説明文入力欄の下にキーワード入力欄を表示する
		if($form->params['controller'] == 'pages') {
			if($this->action == 'admin_add' || $this->action == 'admin_edit') {
				if($fieldName == 'Page.description') {
					$out = $out . $this->View->element('admin/keyword_form', array('plugin' => 'keyword'));
				}
			}
		}

		return $out;

	}

}
