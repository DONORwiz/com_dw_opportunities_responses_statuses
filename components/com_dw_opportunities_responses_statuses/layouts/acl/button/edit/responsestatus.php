<?php

defined('_JEXEC') or die;

JFactory::getLanguage()->load('com_dw_opportunities_responses_statuses');

$responseStatus = $displayData['responseStatus'];

$user = JFactory::getUser();

//Check if the user can edit the response status
$canEditResponseStatus = $user->authorise('core.edit', 'com_dw_opportunities_responses_statuses');
if (!$canEditResponseStatus && $user->authorise('core.edit.own', 'com_dw_opportunities_responses_statuses'))
	$canEditResponseStatus = $user->id == $responseStatus -> created_by;


?>

<?php if( $canEditResponseStatus ) : ?>

	<?php echo JLayoutHelper::render(
		'popup-button', 
		array (
			'buttonText' => JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_WIZARD_EDIT_STATUS'),
			'buttonTooltip' => JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_WIZARD_EDIT_STATUS_TOOLTIP'),
			'buttonIcon' => 'uk-icon-edit uk-icon-small uk-margin-small-right',
			'buttonType' => 'uk-button uk-button-blank uk-button-small uk-width-1-1',
			'buttonID' => 'responsestatusform_'.$responseStatus->id,
			'popupParams' => array (
								'header' => '<h2>'.JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_WIZARD_EDIT_STATUS').'</h2>',
								'footer' => '',
							),
			'layoutPath' => JPATH_ROOT .'/components/com_dw_opportunities_responses_statuses/layouts/wizard',
			'layoutName' => 'responsestatus',
			'layoutParams' => array( 'responseStatus' => $responseStatus )
		), 
		JPATH_ROOT .'/components/com_donorwiz/layouts/popup' , 
		null ); 
	?>

<?php endif; ?>