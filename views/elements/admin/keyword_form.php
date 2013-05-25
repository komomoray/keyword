<?php
/**
 * [ADMIN] keyword
 *
 * @copyright		Copyright 2012, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			keyword.views
 * @license			MIT
 */
?>
<div id="PluginKeywordBox">
<?php echo $bcForm->hidden('Keyword.id') ?>
<small><?php echo $bcForm->label('Keyword.keywords', 'キーワード') ?></small>
<?php echo $bcForm->error('Keyword.keywords') ?>
<br />
<?php echo $bcForm->input('Keyword.keywords', array(
	'type' => 'textarea', 'cols' => 60, 'rows' => 1, 'maxlength' => 125, 'counter' => true
	)) ?>

<?php if(Configure::read('BcApp.smartphone') || Configure::read('BcApp.mobile')): ?>
	<div id="PluginKeywordLinkedBox">
		<?php if(Configure::read('BcApp.smartphone') && $this->data['Page']['page_type'] == 1): ?>
			<?php if(!empty($smartphoneExists)): ?>
				<?php echo $bcForm->input('Keyword.linked_smartphone', array('type' => 'checkbox', 'label' => 'スマートフォンページでも利用する')) ?>
			<?php endif ?>
		<?php endif ?>
		<?php if(Configure::read('BcApp.mobile') && $this->data['Page']['page_type'] == 1): ?>
			<?php if(!empty($mobileExists)): ?>
				<?php echo $bcForm->input('Keyword.linked_mobile', array('type' => 'checkbox', 'label' => 'モバイルページでも利用する')) ?>
			<?php endif ?>
		<?php endif ?>
	</div>
<?php endif ?>
</div>
