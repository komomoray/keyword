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
				$conditions = array(
					'Keyword.pages_id' => $controller->data['Page']['id']
				);
				$data = $this->KeywordModel->find('first', array('conditions' => $conditions));
				if($data) {
					$controller->data['Keyword'] = $data['Keyword'];
				}
			}

			if(empty($controller->params['prefix']) ||
					$controller->params['prefix'] == 'smartphone' ||
					$controller->params['prefix']) {

				// 固定ページ表示画面で実行
				if(!empty($controller->params['url']['url'])) {

					$PageModel = ClassRegistry::init('Page.Pages');
					$pageUrl = $controller->params['url']['url'];
					// TODO prefix が smartphone と mobile の際の対応を考慮する
					if(!empty($pageUrl)) {
						if($pageUrl != '/') {
							$pageUrl = '/' . $pageUrl;
						} else {
							$pageUrl = '/index';
						}
						// 日本語ページを考慮して decode する
						$pageUrl = urldecode($pageUrl);
						$pageData = $PageModel->find('first', array(
							'conditions' => array(
								'url' => $pageUrl
							),
							'fields' => 'id'
						));
						if($pageData) {
							$keyword = $this->KeywordModel->find('first', array(
								'conditions' => array('Keyword.pages_id' => $pageData['Pages']['id'])
							));
							if($keyword) {
								$controller->viewVars['keywords'] = $keyword['Keyword']['keywords'];
							}
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

			$controller->data['Keyword']['pages_id'] = $controller->Page->getLastInsertId();
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

			$controller->data['Keyword']['pages_id'] = $controller->Page->id;
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

}
