<?php

/**
 * @version     1.0.4
 * @package     com_dw_opportunities_responses_statuses
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Dw_opportunities_responses_statuses.
 */
class Dw_opportunities_responses_statusesViewOpportunitiesresponsesstatuses extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        Dw_opportunities_responses_statusesHelper::addSubmenu('opportunitiesresponsesstatuses');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/dw_opportunities_responses_statuses.php';

        $state = $this->get('State');
        $canDo = Dw_opportunities_responses_statusesHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_TITLE_OPPORTUNITIESRESPONSESSTATUSES'), 'opportunitiesresponsesstatuses.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/opportunityresponsestatus';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('opportunityresponsestatus.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('opportunityresponsestatus.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('opportunitiesresponsesstatuses.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('opportunitiesresponsesstatuses.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'opportunitiesresponsesstatuses.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('opportunitiesresponsesstatuses.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('opportunitiesresponsesstatuses.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'opportunitiesresponsesstatuses.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('opportunitiesresponsesstatuses.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_dw_opportunities_responses_statuses');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_dw_opportunities_responses_statuses&view=opportunitiesresponsesstatuses');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

			//Filter for the field created
			$this->extra_sidebar .= '<small><label for="filter_from_created">'. JText::sprintf('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FROM_FILTER', 'Created') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.from'), 'filter_from_created', 'filter_from_created', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange' => 'this.form.submit();'));
			$this->extra_sidebar .= '<small><label for="filter_to_created">'. JText::sprintf('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_TO_FILTER', 'Created') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.to'), 'filter_to_created', 'filter_to_created', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange'=> 'this.form.submit();'));
			$this->extra_sidebar .= '<hr class="hr-condensed">';

		//Filter for the field status
		$select_label = JText::sprintf('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_FILTER_SELECT_LABEL', 'Response Status');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "pending";
		$options[0]->text = "COM_DW_OPPORTUNITIES_RESPONSES_PENDING";
		$options[1] = new stdClass();
		$options[1]->value = "accepted";
		$options[1]->text = "COM_DW_OPPORTUNITIES_RESPONSES_ACCEPTED";
		$options[2] = new stdClass();
		$options[2]->value = "declined";
		$options[2]->text = "COM_DW_OPPORTUNITIES_RESPONSES_DECLINED";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_status',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.status'), true)
		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.state' => JText::_('JSTATUS'),
		'a.created_by' => JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_OPPORTUNITIESRESPONSESSTATUSES_CREATED_BY'),
		'a.created' => JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_OPPORTUNITIESRESPONSESSTATUSES_CREATED'),
		'a.status' => JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_OPPORTUNITIESRESPONSESSTATUSES_STATUS'),
		'a.response_id' => JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_OPPORTUNITIESRESPONSESSTATUSES_RESPONSE_ID'),
		);
	}

}
