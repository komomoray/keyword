<?php
/**
 * [HookHelper] keyword
 *
 * @copyright		Copyright 2012, materializing.
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
 * afterFormInput
 * 
 * @param string $form
 * @param string $fieldName
 * @param string $out
 * @return string 
 */
	function afterFormInput(&$form, $fieldName, $out) {

		// 説明文入力欄の下にキーワード入力欄を表示する
		if($form->params['controller'] == 'pages') {
			if($this->action == 'admin_add' || $this->action == 'admin_edit') {
				$View =& ClassRegistry::getObject('view');
				if($fieldName == 'Page.description') {
					$out = $out . $View->element('admin/keyword_form', array('plugin' => 'keyword'));
				}
			}
		}
		return $out;

	}

}
