<?php
/**
 * [ADMIN] keyword
 *
 * @copyright		Copyright 2012 - 2013, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			keyword.views
 * @license			MIT
 */
?>
<br />
<?php echo $bcForm->hidden('Keyword.id') ?>
<?php echo $bcForm->label('Keyword.keywords', 'キーワード') ?>
<?php echo $bcForm->error('Keyword.keywords') ?>
<br />
<?php echo $bcForm->input('Keyword.keywords', array(
	'type' => 'textarea', 'cols' => 60, 'rows' => 2, 'maxlength' => 125, 'counter' => true
	)) ?>
