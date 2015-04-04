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

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Opportunityresponsestatus controller class.
 */
class Dw_opportunities_responses_statusesControllerDwOpportunityresponsestatusForm extends Dw_opportunities_responses_statusesController {

    public function save() {
		
		
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('DwOpportunityresponsestatusForm', 'Dw_opportunities_responses_statusesModel');

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Check if user can edit or create the item ---------------------------------------------------------------------------------------------
		$id = ( ( $data['id'] == 0 ) || !isset ( $data['id'] ) ) ? null : (int)$data['id'];
        $user = JFactory::getUser();

        if( $id ) 
		{
        	//Check the user can edit this item
            $authorised = $user->authorise('core.edit', 'com_dw_opportunities_responses_statuses');
			
			if(!$authorised && $user->authorise('core.edit.own', 'com_dw_opportunities_responses_statuses'))
			{
				//Check the owner from the model
				$itemData = $model -> getData($id);
				$itemOwner = ( isset ( $itemData -> created_by ) ) ? $itemData -> created_by : null ;
				$authorised = $user -> id == $itemOwner ; 
			}
		
        } 
		else 
		{
            //Check the user can create new item
            $authorised = $user->authorise('core.create', 'com_dw_opportunities_responses_statuses');
			
            //Check the user has already created a status for this response_id ( ONLY 1 allowed )
            if( $authorised )
            {
				$response_id = ( !empty( $data['response_id'] ) ) ? $data['response_id'] : 0 ;
				
				JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses_statuses/models', 'Dw_opportunities_responses_statusesModel');
				$responsesstatusesModel = JModelLegacy::getInstance('DWOpportunitiesresponsesstatuses', 'Dw_opportunities_responses_statusesModel', array('ignore_request' => true));        
				$responsesstatuses = $responsesstatusesModel -> getItemsByResponse( $response_id );

				if( $responsesstatuses )
				{
					$authorised = false ;
				}
			
			}
			
        }		
		
		if( $authorised )
		{
			//Check if the response belongs to an opportunity that is created by the user
			
			//Get the response object
			JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
			$responseModel = JModelLegacy::getInstance('DwOpportunityresponse', 'Dw_opportunities_responsesModel', array('ignore_request' => true));	
			$response = $responseModel ->getData ( $data['response_id'] );
			
			//Get the opportunity
			JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities/models', 'Dw_opportunitiesModel');
			$opportunityModel = JModelLegacy::getInstance('DwOpportunity', 'Dw_opportunitiesModel', array('ignore_request' => true));	
			$opportunity = $opportunityModel -> getData ( $response -> opportunity_id );
			
			$authorised = $user -> id == $opportunity -> created_by;
			
		}

		if (!$authorised)
		{		
			try
			{
				echo new JResponseJson( '' , JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_WIZARD_PERMISSION_DENIED') , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
		}
		// ------------------------------------------------------------------------------------------------------------------------------
		
		
        // Validate the posted data.
        $form = $model->getForm();
        if (!$form) {
            JError::raiseError(500, $model->getError());
            return false;
        }

        // Validate the posted data.
        $data = $model->validate($form, $data);

        // Check for errors.
        if ($data === false) {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            $input = $app->input;
            $jform = $input->get('jform', array(), 'ARRAY');

            // Save the data in the session.
            $app->setUserState('com_dw_opportunities_responses_statuses.edit.opportunityresponsestatus.data', $jform, array());

			try
			{
				echo new JResponseJson( '' , $errors , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
        }
		
		//parameters fields convert into json before save - yesinternet
		if (isset($data['parameters']) && is_array($data['parameters']))
		{
			$registry = new JRegistry;
			$registry->loadArray($data['parameters']);
			$data['parameters'] = (string) $registry;
		}

        // Attempt to save the data.
        $return = $model->save($data);

        // Check for errors.
        if ($return === false) {
            // Save the data in the session.
            $app->setUserState('com_dw_opportunities_responses_statuses.edit.opportunityresponsestatus.data', $data);

			try
			{
				echo new JResponseJson( '' , 'Could not save the data' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
        }


        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }

		//Notify volunteer about the new status  ----------------------------------------------------------------------------------------------------
		JPluginHelper::importPlugin('donorwiz');
		$dispatcher	= JEventDispatcher::getInstance();
		$dispatcher->trigger( 'onOpportunityResponseStatusUpdate' , array( &$data ) );
		
		try
		{
			echo new JResponseJson( $return );
		}
		catch(Exception $e)
		{
			echo new JResponseJson($e);
		}
	
		jexit();

		}

}
