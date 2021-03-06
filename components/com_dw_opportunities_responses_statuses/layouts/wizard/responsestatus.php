<?php
 
// no direct access
defined('_JEXEC') or die;

$responseStatus = $displayData['responseStatus'];


//Load the Response Status Wizard form
$form = new JForm( 'com_dw_opportunities_responses_statuses.dwopportunityresponsestatusform' , array( 'control' => 'jform', 'load_data' => true ) );
$form->loadFile( JPATH_ROOT . '/components/com_dw_opportunities_responses_statuses/models/forms/dwopportunityresponsestatusform.xml' );

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses_statuses/models', 'Dw_opportunities_responses_statusesModel');
$responsestatusModel = JModelLegacy::getInstance('DwOpportunityresponsestatus', 'Dw_opportunities_responses_statusesModel', array('ignore_request' => true));	
$responsestatusData = $responsestatusModel->getData( $responseStatus ->id );	
$form->bind( $responsestatusData );

if( !$responsestatusData -> state )
	$responsestatusData -> state = '1';

$script = array();

$script[] = 'var waitingModal;';
$script[] = 'var JText_COM_DONORWIZ_WIZARD_SAVE_FAIL = "'.JText::_('COM_DONORWIZ_WIZARD_SAVE_FAIL').'";';
$script[] = 'var JText_COM_DONORWIZ_WIZARD_TRASH_CONFIRM = "'.JText::_('COM_DONORWIZ_WIZARD_TRASH_CONFIRM').'";';
$script[] = 'var JText_COM_DONORWIZ_MODAL_PLEASE_WAIT = "'.JText::_('COM_DONORWIZ_MODAL_PLEASE_WAIT').'";';	

JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
JHtml::_('jquery.framework');


?>

<div class="uk-article">

	<form id="form-response" class="uk-form uk-form-horizontal dw-wizard" action="<?php echo JURI::base();?>index.php?option=com_dw_opportunities_responses_statuses&task=dwopportunityresponsestatusform.save" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
		<div class="uk-hidden">
		
			<?php echo $form->getInput('id'); ?>
			<input id="jform_state" type="hidden" name="jform[state]" value="<?php echo $responsestatusData->state; ?>" />	
			<?php echo $form->getInput('created_by'); ?>
			
		</div>

		<div class="uk-form-row">
			<label class="uk-form-label"><?php echo $form->getLabel('status'); ?>
			<?php if( $form ->getFieldAttribute( 'status' , 'tooltip' , '' , '') ) :?>
			<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'status', 'tooltip' , '' , '') );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
			<?php endif;?>	
			</label>
			<div class="uk-form-controls"><?php echo $form->getInput('status'); ?></div>
		</div>

		<div class="uk-form-row">
			<label class="uk-form-label"><?php echo $form->getLabel('notify','parameters'); ?>
			<?php if( $form ->getFieldAttribute( 'notify' , 'tooltip' , '' , 'parameters') ) :?>
			<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'notify', 'tooltip' , '' , 'parameters') );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
			<?php endif;?>	
			</label>
			<div class="uk-form-controls"><?php echo $form->getInput('notify','parameters'); ?></div>
		</div>
		
		<div class="uk-form-row" data-uk-margin>
			<button type="submit" class="validate uk-button uk-button-primary uk-button-large"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_WIZARD_SUBMIT'); ?></button>

		</div>
		
		<input type="hidden" name="jform[response_id]" value="<?php echo $responseStatus->response_id; ?>" />
		
		<?php echo JHtml::_('form.token'); ?>

	</form>

</div>