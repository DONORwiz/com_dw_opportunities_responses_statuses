<?php
/**
 * @version     1.0.4
 * @package     com_dw_opportunities_responses_statuses
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// no direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_dw_opportunities_responses_statuses');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_dw_opportunities_responses_statuses')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_CREATED'); ?></th>
			<td><?php echo $this->item->created; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_MODIFIED_BY'); ?></th>
			<td><?php echo $this->item->modified_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_MODIFIED'); ?></th>
			<td><?php echo $this->item->modified; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_STATUS'); ?></th>
			<td><?php echo $this->item->status; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_RESPONSE_ID'); ?></th>
			<td><?php echo $this->item->response_id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FORM_LBL_OPPORTUNITYRESPONSESTATUS_PARAMETERS'); ?></th>
			<td><?php echo $this->item->parameters; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities_responses_statuses&task=opportunityresponsestatus.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_dw_opportunities_responses_statuses')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities_responses_statuses&task=opportunityresponsestatus.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_ITEM_NOT_LOADED');
endif;
?>
