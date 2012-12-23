<?php
/**
 * [Component] keyword
 *
 * @copyright		Copyright 2012, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			keyword.controllers
 * @license			MIT
 */
class KeywordHookComponent extends Object {
/**
 * 登録フック
 *
 * @var array
 * @access public
 */
	var $registerHooks = array(
		'beforeRender', 'afterPageAdd', 'afterPageEdit');
/**
 * キーワードモデル
 * 
 * @var Object
 * @access public
 */
	var $KeywordModel = null;
/**
 * constructer
 * 
 * @return void
 * @access private
 */
	function __construct() {
		parent::__construct();
		$this->KeywordModel = ClassRegistry::init('Keyword.Keyword');
	}
/**
 * beforeRender
 * 
 * @param Controller $controller 
 * @return void
 * @access public
 */
	function beforeRender(&$controller) {

		if($controller->name == 'Pages') {

			// 固定ページ編集画面で実行
			if($controller->action == 'admin_edit') {
				$data = $this->KeywordModel->findByPagesId($controller->data['Page']['id']);
				if($data) {
					$controller->data['Keyword'] = $data['Keyword'];
				}
			}

			// 固定ページ表示画面で実行
			if(empty($controller->params['prefix']) ||
				$controller->params['prefix'] == 'smartphone' ||
				$controller->params['prefix'] == 'mobile') {

				if(!empty($controller->params['url']['url'])) {

					$PageModel = ClassRegistry::init('Page.Pages');
					// 参考：/baser/views/helpers/bc_page.php：beforeRender()
					$param = Configure::read('BcRequest.pureUrl');
					if($param && preg_match('/\/$/is',$param)){
						$param .= 'index';
					}
					if(Configure::read('BcRequest.agent')) {
						$param = Configure::read('BcRequest.agentPrefix').'/'.$param;
					}
					if(!$param || $param == 'smartphone/' || $param == 'mobile/') {
						$param = $param . 'index';
					}
					$pageData = $PageModel->findByUrl('/' . $param, array(
						'fields' => 'id'
					));
					if($pageData) {
						$keyword = $this->KeywordModel->findByPagesId($pageData['Pages']['id']);
						if($keyword) {
							$controller->viewVars['keywords'] = $keyword['Keyword']['keywords'];
						}
					}

				}

			}

		}

	}
/**
 * afterPageAdd
 *
 * @param Controller $controller
 * @return void
 * @access public
 */
	function afterPageAdd(&$controller) {

		// 固定ページ保存時にエラーがなければ保存処理を実行
		if(empty($controller->Page->validationErrors)) {
			$this->_dataSave($controller);
		}

	}
/**
 * afterPageEdit
 *
 * @param Controller $controller
 * @return void
 * @access public
 */
	function afterPageEdit(&$controller) {

		// 固定ページ保存時にエラーがなければ保存処理を実行
		if(empty($controller->Page->validationErrors)) {
			$this->_dataSave($controller);
		}

	}
/**
 * キーワード情報を保存する
 * 
 * @param Controller $controller 
 * @return void
 * @access private
 */
	function _dataSave($controller) {

		if($controller->action == 'admin_add') {
			$controller->data['Keyword']['pages_id'] = $controller->Page->getLastInsertId();
		} else {
			$controller->data['Keyword']['pages_id'] = $controller->Page->id;
		}

		if(empty($controller->data['Keyword']['id'])) {
			$this->KeywordModel->create($controller->data['Keyword']);
		} else {
			$this->KeywordModel->set($controller->data['Keyword']);
		}

		if(!$this->KeywordModel->save()) {
			$this->log('キーワードの保存に失敗しました。');
		}

	}

}
