<?php
/**
 * [HookBehavior] keyword
 *
 * @copyright		Copyright 2012, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			keyword.models
 * @license			MIT
 */
class KeywordHookBehavior extends ModelBehavior {
/**
 * 登録フック
 *
 * @var array
 * @access public
 */
	var $registerHooks = array(
			'Page'	=> array('afterDelete')
	);
/**
 * afterDelete
 * 
 * @param Object $model
 * @return void
 * @access public
 */
	function afterDelete($model) {

		// 固定ページ削除時、その固定ページが持つキーワード情報を削除する
		if($model->alias == 'Page') {
			$KeywordModel = ClassRegistry::init('Keyword.Keyword');
			$data = $KeywordModel->find('first', array('conditions' => array('Keyword.pages_id' => $model->id)));
			if($data) {
				if(!$KeywordModel->delete($data['Keyword']['id'])) {
					$this->log('ID:' . $data['Keyword']['id'] . 'のキーワードの削除に失敗しました。');
				}
			}
		}

	}

}
