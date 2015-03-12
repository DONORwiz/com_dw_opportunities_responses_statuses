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

jimport('joomla.application.component.controllerform');

/**
 * Opportunityresponsestatus controller class.
 */
class Dw_opportunities_responses_statusesControllerOpportunityresponsestatus extends JControllerForm
{

    function __construct() {
        $this->view_list = 'opportunitiesresponsesstatuses';
        parent::__construct();
    }

}