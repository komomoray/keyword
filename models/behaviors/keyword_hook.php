<?php
/**
 * [HookBehavior] keyword
 *
 * @copyright		Copyright 2012 - 2013, materializing.
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
			'Page'	=> array('afterDelete', 'beforeValidate')
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
			$data = $KeywordModel->findByPagesId($model->id);
			if($data) {
				if(!$KeywordModel->delete($data['Keyword']['id'])) {
					$this->log('ID:' . $data['Keyword']['id'] . 'のキーワードの削除に失敗しました。');
				}
			}
		}

	}
/**
 * beforeValidate
 * 
 * @param Object $model
 * @return boolean
 * @access public
 */
	function beforeValidate($model) {

		// 固定ページ保存の手前で Keyword モデルのデータに対して validation を行う
		if($model->alias == 'Page') {
			$KeywordModel = ClassRegistry::init('Keyword.Keyword');
			$KeywordModel->set($model->data);
			return $KeywordModel->validates();
		}

		return true;

	}

}
