<?php
/**
 * [Component] keyword
 *
 * @copyright		Copyright 2012 - 2013, materializing.
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
		'startup', 'beforeRender', 'afterPageAdd', 'afterPageEdit');
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
 * startup
 * 
 * @param Object $controller
 * @return void
 * @access public
 */
	function startup($controller) {

		if($controller->name == 'Pages') {
			if($controller->action == 'admin_edit') {
				$association = array(
					'Keyword' => array(
						'className' => 'Keyword.Keyword',
						'foreignKey' => 'pages_id'
					)
				);
				$controller->Page->bindModel(array('hasOne' => $association));
			}
		}

	}

/**
 * beforeRender
 * 
 * @param Object $controller 
 * @return void
 * @access public
 */
	function beforeRender($controller) {

		if($controller->name == 'Pages') {

			// 固定ページ表示画面で実行
			if(empty($controller->params['prefix']) || $controller->params['prefix'] != 'admin') {

				if(!empty($controller->params['url']['url'])) {

					// 参考：/baser/views/helpers/bc_page.php：beforeRender()
					$param = Configure::read('BcRequest.pureUrl');
					if($param && preg_match('/\/$/is',$param)){
						$param .= 'index';
					}
					
					// PC版固定ページのデータを取得する
					$pageDataPc = $controller->Page->findByUrl('/' . $param, array(
						'fields' => 'id'
					));
					// PC版固定ページのデータを元に、キーワードデータを取得する
					if($pageDataPc) {
						$keywordPc = $this->KeywordModel->findByPagesId($pageDataPc['Page']['id']);
						if($keywordPc) {
							// キーワード・データに「スマホ共通利用」指定があれば、そのデータを利用する
							if($keywordPc['Keyword']['linked_smartphone']) {
								$controller->viewVars['keywords'] = $keywordPc['Keyword']['keywords'];
								return;
							}
							// キーワード・データに「モバイル共通利用」指定があれば、そのデータを利用する
							if($keywordPc['Keyword']['linked_mobile']) {
								$controller->viewVars['keywords'] = $keywordPc['Keyword']['keywords'];
								return;
							}
						}
					}

					// プレフィックスが付いた場合
					if(Configure::read('BcRequest.agent')) {
						$param = Configure::read('BcRequest.agentPrefix').'/'.$param;
					}
					if(!$param || $param == 'smartphone/' || $param == 'mobile/') {
						$param = $param . 'index';
					}
					$pageData = $controller->Page->findByUrl('/' . $param, array(
						'fields' => 'id'
					));
					if($pageData) {
						$keyword = $this->KeywordModel->findByPagesId($pageData['Page']['id']);
						if($keyword) {
							$controller->viewVars['keywords'] = $keyword['Keyword']['keywords'];
						}
					}
					
				}
				
			}

			// Ajaxコピー処理時に実行
			//   ・Ajax削除時は、内部的に Model->delete が呼ばれているため afterDelete で処理可能
			if($controller->action == 'admin_ajax_copy') {
				// 固定ページコピー保存時にエラーがなければ保存処理を実行
				if(empty($controller->Page->validationErrors)) {
					$keywordData = $this->KeywordModel->find('first', array(
						'conditions' => array('Keyword.pages_id' => $controller->params['pass']['0']),
						'recursive' => -1
					));
					$saveData = array();
					if($keywordData) {
						$saveData['Keyword']['keywords'] = $keywordData['Keyword']['keywords'];
					}
					$saveData['Keyword']['pages_id'] = $controller->viewVars['data']['Page']['id'];

					$this->KeywordModel->create($saveData);
					$this->KeywordModel->save(null, false);
				}
			}

		}

	}
/**
 * afterPageAdd
 *
 * @param Object $controller
 * @return void
 * @access public
 */
	function afterPageAdd($controller) {

		// 固定ページ保存時にエラーがなければ保存処理を実行
		if(empty($controller->Page->validationErrors)) {
			$this->_dataSave($controller);
		}

	}
/**
 * afterPageEdit
 *
 * @param Object $controller
 * @return void
 * @access public
 */
	function afterPageEdit($controller) {

		// 固定ページ保存時にエラーがなければ保存処理を実行
		if(empty($controller->Page->validationErrors)) {
			$this->_dataSave($controller);
		}

	}
/**
 * キーワード情報を保存する
 * 
 * @param Object $controller 
 * @return void
 * @access private
 */
	function _dataSave($controller) {

		if($controller->action == 'admin_add') {
			$controller->data['Keyword']['pages_id'] = $controller->Page->getLastInsertId();
		} else {
			$controller->data['Keyword']['pages_id'] = $controller->data['Page']['id'];
		}

		if(empty($controller->data['Keyword']['id'])) {
			$this->KeywordModel->create($controller->data);
		} else {
			$this->KeywordModel->set($controller->data);
		}

		if(!$this->KeywordModel->save()) {
			$this->log('キーワードの保存に失敗しました。');
		}

	}

}
