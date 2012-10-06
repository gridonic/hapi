<?php
/*
 * copyright (c) 2009 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of HarvestAPI.
 *
 * HarvestAPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HarvestAPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HarvestAPI. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * HarvestAPI
 *
 * This file contains the class HarvestAPI
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * HarvestAPI defines the methods available to the API, as well as
 * handlers for parsing the returned data.
 *
 * <code> 
 * // require the Harvest API core class 
 * require_once( PATH_TO_LIB . '/HarvestAPI.php' );
 *
 * // register the class auto loader 
 * spl_autoload_register( array('HarvestAPI', 'autoload') );
 *
 * // instantiate the api object 
 * $api = new HarvestAPI(); 
 * $api->setUser( "user@email.com" ); 
 * $api->setPassword( "password" ); 
 * $api->setAccount( "account" ); 
 * </code>
 *
 * @package com.mdbitz.harvest
 */ 
 class HarvestAPI{
    
	/**
     *  WAIT
     */
    const RETRY = "WAIT";

	/**
     *  FAIL
     */
    const FAIL = "FAIL";

    /**
     * @var string User Name
     */
    protected $_user;

    /**
     * @var string User Password
     */
    protected $_password;
    
    /**
     * @var string Harvest Account Name
     */
    protected $_account;
    
    /**
     * @var boolean is SSL enabled account?
     */
    protected $_ssl = true;
    
    /**
     * @var string retry mode for over threshold
     */
    protected $_mode = "FAIL";
    
    /**
     * @var string harvest root directory
     */
    protected static $_path;

	/**
     * @var array Header Associated Array
     */
    protected $_headers;
    
    /**
     * set Harvest User Name
     *
     * <code>
     * $api = new HarvestAPI();
     * $api->setUser( "user name" );
     * </code>
     *
     * @param string $user User name
     * @return void
     */
    public function setUser( $user ) 
    {
        $this->_user = $user;
    }
    
    /**
     * set Harvest Password
     *
     * <code>
     * $api = new HarvestAPI();
     * $api->setPassword( "password" );
     * </code>
     *
     * @param string $password User Password
     * @return void
     */
    public function setPassword( $password ) 
    {
        $this->_password = $password;
    }
    
    /**
     * set Harvest Account
     *
     * <code>
     * $api = new HarvestAPI();
     * $api->setAccount( "account" );
     * </code>
     *
     * @param string $account Account Name
     * @return void
     */
    public function setAccount( $account ) 
    {
        $this->_account = $account;
    }
    
    /**
     * set SSL enabled
     * 
     * <code>
     * $api = new HarvestAPI();
     * $api->setSSL( true );
     * </code>
     *
     * @param boolean $ssl ssl enabled
     * @return void
     */
    public function setSSL( $ssl ) 
    {
        $this->_ssl = $ssl;
    }
    
	/**
     * set retry mode
     * 
     * <code>
     * $api = new HarvestAPI();
     * $api->setRetryMode( HarvestAPI::RETRY );
     * </code>
     *
     * @param boolean $mode retry mode
     * @return void
     */
    public function setRetryMode( $mode ) 
    {
        $this->_mode = $mode;
    }

    /**
     * get your current throttle status
     *
     * <code>
     * $api = new HarvestAPI();
     *
     * $result = $api->getThrottleStatus();
	 * $throttle = $result->data;
     * </code>
     *
     * @return Harvest_Result
     */
    public function getThrottleStatus()
    {
        $url = "account/rate_limit_status";
        return $this->performGET( $url, false );
    }

    /*--------------------------------------------------------------*/
    /*--------------------- Time Tracking API ----------------------*/
    /*--------------------------------------------------------------*/

    /**
     * gets the activity of the requesting user for the day
     *
     * <code>
     * $day_of_year = 267;
     * $year = 2009
     * 
     * $api = new HarvestAPI();
     *
     * $result = $api->getDailyActivity( $day_of_year, $year );
     * if( $result->isSuccess() ) {
     *     $entries= $result->data;
     * }
     * </code>
     *
     * @param int $day_of_year Day of Year
     * @param int $year Year
     * @return Harvest_Result
     */
    public function getDailyActivity( $day_of_year = null, $year = null ) 
    {
        $url = "daily/";
        if( ! is_null( $day_of_year ) && ! is_null( $year ) ) {
            $url .= $day_of_year . "/" . $year;
        }
        return $this->performGET( $url, false );
    }

    /**
     * gets the entry specified
     *
     * <code>
     * $entry_id = 12345;
     * 
     * $api = new HarvestAPI();
     *
     * $result = $api->getEntry( $entry_id );
     * if( $result->isSuccess() ) {
     *     $entry = $result->data;
     * }
     * </code>
     * 
     * @param int $entry_id Entry Identifier
     * @return Harvest_Result
     */
    public function getEntry( $entry_id ) 
    {
        $url = "daily/show/" . $entry_id;
        return $this->performGET( $url, false );
    }

	/**
     * toggle a timer on/off
     *
     * <code>
     * $entry_id = 12345;
     * 
     * $api = new HarvestAPI();
     * 
     * $result = $api->toggleTimer( $entry_id );
     * if( $result->isSuccess() ) {
     *     $timer = $result->data;
     * } 
     * </code>
     *
     * @param $entry_id    Day Entry Identifier
     * @return Harvest_Result
     */
    public function toggleTimer( $entry_id ) 
    {
        $url = "daily/timer/" . $entry_id;
        return $this->performGET( $url, false );
    }

    /**
     * create an entry
     *
     * <code>
     * $entry = new Harvest_DayEntry();
     * $entry->set( "notes", "Test Support" );
     * $entry->set( "hours", 3 );
     * $entry->set( "project_id", 3 );
     * $entry->set( "task_id", 14 );
     * $entry->set( "spent_at", "Tue, 17 Oct 2006" );
     * 
     * $api = new HarvestAPI();
     * 
     * $result = $api->createEntry( $entry );
     * if( $result->isSuccess() ) {
     *     $timer = $result->data;
     * } 
     * </code>
     *
     * @param $entry    Day Entry
     * @return Harvest_Result
     */
    public function createEntry( $entry ) 
    {
        $url = "daily/add";
        return $this->performPOST( $url, $entry->toXML(), false );
    }

    /**
     * creates an entry and starts its timer
     *
     * <code>
     * $entry = new Harvest_DayEntry();
     * $entry->set( "notes", "Test Support" );
     * $entry->set( "project_id", 3 );
     * $entry->set( "task_id", 14 );
     * $entry->set( "spent_at", "Tue, 17 Oct 2006" );
     * 
     * $api = new HarvestAPI();
     * 
     * $result = $api->startNewTimer( $entry );
     * if( $result->isSuccess() ) {
     *     $timer = $result->data;
     * } 
     * </code>
     *
     * @param $entry    Day Entry
     * @return Harvest_Result
     */
    public function startNewTimer( $entry ) 
    {
        $entry->set( "hours", " " );
        $url = "daily/add";
        return $this->performPOST( $url, $entry->toXML(), false );
    }

    /**
     * delete an entry
     *
     * <code>
     * $entry_id = 12345;
     * 
     * $api = new HarvestAPI();
     * 
     * $result = $api->deleteEntry( $entry_id );
     * if( $result->isSuccess() ) {
     *     //success logic
     * } 
     * </code>
     *
     * @param $entry_id    Day Entry Identifier
     * @return Harvest_Result
     */
    public function deleteEntry( $entry_id ) 
    {
        $url = "daily/delete/" . $entry_id;
        return $this->performDELETE( $url);
    }

    /**
     * update an entry
     *
     * <code>
     * $entry = new Harvest_DayEntry();
     * $entry->set( "id" 11111 );
     * $entry->set( "notes", "Test Support" );
     * $entry->set( "hours", 3 );
     * $entry->set( "project_id", 3 );
     * $entry->set( "task_id", 14 );
     * $entry->set( "spent_at", "Tue, 17 Oct 2006" );
     * 
     * $api = new HarvestAPI();
     * 
     * $result = $api->updateEntry( $entry );
     * if( $result->isSuccess() ) {
     *     // success logic
     * } 
     * </code>
     *
     * @param $entry    Day Entry
     * @return Harvest_Result
     */
    public function updateEntry( $entry ) 
    {
        $url = "daily/update/$entry->id";
        return $this->performPOST( $url, $entry->toXML() );
    }

    /*--------------------------------------------------------------*/
    /*------------------------- Client API -------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all clients
     *
     * <code>
     * $api = new HarvestAPI();
     *
     * $result = $api->getClients();
     * if( $result->isSuccess() ) {
     *     $clients = $result->data;
     * }
     * </code>
     *
     * @param mixed $updated_since  DateTime
     * @return Harvest_Result
     */
    public function getClients( $updated_since = null) 
    {
        $url = "clients" . $this->appendUpdatedSinceParam( $updated_since );
        return $this->performGET( $url, true );
    }

    /**
     * get a single client
     *
     * <code> 
     * $client_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getClient( $client_id ); 
     * if( $result->isSuccess() ) { 
     *     $client = $result->data; 
     * } 
     * </code>
     *
     * @param int $client_id  Client Identifier
     * @return Harvest_Result
     */
    public function getClient( $client_id ) 
    {
        $url = "clients/$client_id";
        return $this->performGET( $url, false );
    }

    /**
     * create new client
     *
     * <code> 
     * $client = new Harvest_Client(); 
     * $client->set( "name", "Company LLC" ); 
     * $client->set( "details", "Company Details" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->createClient( $client ); 
     * if( $result->isSuccess() ) { 
     *     // get id of created client 
     *     $client_id = $result->data; 
     * } 
     * </code>
     *
     * @param Harvest_Client $client Client
     * @return Harvest_Result
     */
    public function createClient( Harvest_Client $client ) 
    {
        $url = "clients";
        return $this->performPOST( $url, $client->toXML() );
    }

    /**
     * update a client
     *
     * <code> 
     * $client = new Harvest_Client(); 
     * $client->set( "id", 11111 ); 
     * client->set( "name", "Company LLC" ); 
     * $client->set( "details", "New Company Details" );
	 *
     * $api = new HarvestAPI(); 
     * 
	 * $result = $api->updateClient( $client ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     *
     * @param Harvest_Client $client Client
     * @return Harvest_Result
     */
    public function updateClient( Harvest_Client $client ) 
    {
        $url = "clients/$client->id";
        return $this->performPUT( $url, $client->toXML() );
    }

    /**
     * activate / deactivate a client
     *
     * <code> 
     * $client_id = 11111;
     * $api = new HarvestAPI(); 
     * $result = $api->toggleClient( $client_id ); 
     * if( $result->isSuccess() ) { 
     *     // addtional logic 
     * } 
     * </code>
     *
     * @param $int client_id Client Identifier
     * @return Harvest_Result
     */
    public function toggleClient( $client_id ) 
    {
        $url = "clients/$client_id/toggle";
        return $this->performPUT( $url, "" );
    }

    /**
     * delete a client
     *
     * <code> 
     * $client_id = 11111;
     * $api = new HarvestAPI(); 
     * $result = $api->deleteClient( $client_id ); 
     * if( $result->isSuccess() ) { 
     *      // additional logic 
     * } 
     * </code>
     * 
     * @param int $client_id Client Identifier
     * @return Harvest_Result
     */
    public function deleteClient( $client_id ) 
    {
        $url = "clients/$client_id";
        return $this->performDELETE( $url );
    }

    /*--------------------------------------------------------------*/
    /*---------------------- Client Contacts API -------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all contacts for an account
     *
     * <code>
     * $api = new HarvestAPI();
     * $result = $api->getContacts();
     * if( $result->isSuccess() ) {
     *     $contacts = $result->data;
     * }
     * </code>
     * 
	 * @param mixed $updated_since DateTime
     * @return Harvest_Result
     */
    public function getContacts($updated_since = null) {

        $url = "contacts" . $this->appendUpdatedSinceParam( $updated_since );
        return $this->performGET( $url, true );

    }

    /**
     * get all contacts for a client
     *
     * <code> 
     * $client_id = 11111;
     * $api = new HarvestAPI(); 
     * $result = $api->getClientContacts( $client_id ); 
     * if( $result->isSuccess() ) { 
     *     $contacts = $result->data; 
     * } 
     * </code>
     * 
     * @param int $client_id Client Identifier
     * @return Harvest_Result
     */
    public function getClientContacts( $client_id ) 
    {
        $url = "clients/$client_id/contacts";
        return $this->performGET( $url, true );
    }

    /**
     * get a client contact
     *
     * <code> 
     * $contact_id = 11111;
     * $api = new HarvestAPI(); 
     * $result = $api->getContact( $contact_id ); 
     * if( $result->isSuccess() ) { 
     *     $contact = $result->data; 
     * } 
     * </code>
     * 
     * @param int $contact_id Contact Identifier
     * @return Harvest_Result
     */
    public function getContact( $contact_id ) 
    {
        $url = "contacts/$contact_id";
        return $this->performGET( $url, false );
    }

    /**
     * create new contact
     *
     * <code> 
     * $contact = new Harvest_Contact(); 
     * $contact->set( "first-name", "Jane" ); 
     * $contact->set( "last-name", "Doe" ); 
     * $contact->set( "email", "jd@email.com" ); 
     * $contact->set( "client-id", 12345 );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->createContact( $Contact ); 
     * if( $result->isSuccess() ) { 
     *     // get id of created contact 
     *     $contact_id = $result->data; 
     * } 
     * </code>	
     * 
     * @param Harvest_Contact $contact Contact
     * @return Harvest_Result
     */
    public function createContact( Harvest_Contact $contact ) {
        $url = "contacts";
        return $this->performPOST( $url, $contact->toXML() );
    }

    /**
     * update a contact
     *
     * <code>
     * $contact = new Harvest_Contact(); 
     * $contact->set( "id", 11111 ); 
     * $contact->set( "first-name", "John" ); 
     * $contact->set( "last-name", "Smith" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateContact( $contact ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_Contact $contact Contact
     * @return Harvest_Result
     */
    public function updateContact( Harvest_Contact $contact ) 
    {
        $url = "contacts/$contact->id";
        return $this->performPUT( $url, $contact->toXML() );
    }

    /**
     * delete a contact
     *
     * <code> 
     * $contact_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->deleteContact( $contact_id ); 
     * if( $result->isSuccess() ) { 
     *      // additional logic 
     * } 
     * </code>
     * 
     * @param int $contact_Id Contact Identifier
     * @return Harvest_Result
     */
    public function deleteContact( $contact_id ) 
    {
        $url = "contacts/$contact_id";
        return $this->performDELETE( $url );
    }
  
    /*--------------------------------------------------------------*/
    /*----------------------- Projects API -------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all projects
     *
     * <code>
     * $api = new HarvestAPI();
     * 
     * $result = $api->getProjects();
     * if( $result->isSuccess() ) {
     *     $projects = $result->data;
     * }
     * </code>
     * 
	 * @param mixed $updated_since DateTime
     * @return Harvest_Result
     */
    public function getProjects( $updated_since = null ) 
    {
        $url = "projects" . $this->appendUpdatedSinceParam( $updated_since );
        return $this->performGET( $url, true );
    }
	
	/**
     * get all projects of a client
     *
     * <code>
     * $api = new HarvestAPI();
     * 
     * $result = $api->getClientProjects();
     * if( $result->isSuccess() ) {
     *     $projects = $result->data;
     * }
     * </code>
     * 
     * @param int $client_id Client Identifier
     * @return Harvest_Result
     */
    public function getClientProjects( $client_id) 
    {
        $url = "projects?client=$client_id";
        return $this->performGET( $url, true );
    }

    /**
     * get a single project
     *
     * <code> 
     * $project_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getProject( $project_id ); 
     * if( $result->isSuccess() ) { 
     *     $project = $result->data; 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @return Harvest_Result
     */
    public function getProject( $project_id ) 
    {
        $url = "projects/$project_id";
        return $this->performGET( $url, false );
    }

    /**
     * create new project
     *
     * <code> 
     * $project = new Harvest_Project(); 
     * $project->set( "name", "New Project" ); 
     * $project->set( "client-id", 11111 );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->createProject( $project ); 
     * if( $result->isSuccess() ) { 
     *     // get id of created project 
     *     $project_id = $result->data; 
     * } 
     * </code>
     * 
     * @param Harvest_Project $project Project
     * @return Harvest_Result
     */
    public function createProject( Harvest_Project $project ) 
    {
        $url = "projects";
        return $this->performPOST( $url, $project->toXML() );
    }

    /**
     * update a Project
     *
     * <code> 
     * $project = new Harvest_Project(); 
     * $project->set( "id", 12345 ); 
     * $project->set( "name", "New Project" ); 
     * $project->set( "client-id", 11111 );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateProject( $project ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_Project $project Project
     * @return Harvest_Result
     */
    public function updateProject( Harvest_Project $project ) 
    {
        $url = "projects/$project->id";
        return $this->performPUT( $url, $project->toXML() );
    }

    /**
     * activate / deactivate a project
     *
     * <code> 
     * $project_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->toggleProject( $project_id ); 
     * if( $result->isSuccess() ) { 
     *     // addtional logic 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @return Harvest_Result
     */
    public function toggleProject( $project_id ) 
    {
        $url = "projects/$project_id/toggle";
        return $this->performPUT( $url, "" );
    }

    /**
     * delete a project
     *
     * <code> 
     * $project_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->deleteProject( $project_id ); 
     * if( $result->isSuccess() ) { 
     *      // additional logic 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @return Harvest_Result
     */
    public function deleteProject( $project_id ) 
    {
        $url = "projects/$project_id";
        return $this->performDELETE( $url );
    }

    /*--------------------------------------------------------------*/
    /*-------------------------- Tasks API -------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all tasks
     *
     * <code>
     * $api = new HarvestAPI();
     * 
     * $result = $api->getTasks();
     * if( $result->isSuccess() ) {
     *     $tasks = $result->data;
     *  }
     * </code>
     * 
     * @return Harvest_Result
     */
    public function getTasks() 
    {
        $url = "tasks";
        return $this->performGET( $url, true );
    }

    /**
     * get a single task
     *
     * <code> 
     * $task_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getTask( $task_id ); 
     * if( $result->isSuccess() ) { 
     *    $task = $result->data; 
     * } 
     * </code>
     * 
     * @param int $task_id Task Identifier
     * @return Harvest_Result
     */
    public function getTask( $task_id ) 
    {
        $url = "tasks/$task_id";
        return $this->performGET( $url, false );
    }

    /**
     * create new task
     *
     * <code> 
     * $task = new Harvest_Task(); 
     * $task->set( "name", "Task Name" ); 
     * $task->set( "billable-by-default", true ); 
     * $task->set( "default-hourly-rate", 65.50 );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->createTask( $task ); 
     * if( $result->isSuccess() ) { 
     *     // get id of created task 
     *     $task_id = $result->data; 
     * } 
     * </code>
     * 
     * @param Harvest_Task $task Task
     * @return Harvest_Result
     */
    public function createTask( Harvest_Task $task ) 
    {
        $url = "tasks";
        return $this->performPOST( $url, $task->toXML() );
    }

    /**
     * update a Task
     *
     * <code> 
     * $task = new Harvest_Task(); 
     * $task->set( "id", 12345 ); 
     * $task->set( "name", "New Task name" ); 
     * $task->set( "default-hourly-rate", 73.00 );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateTask( $task ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_Task $task Task
     * @return Harvest_Result
     */
    public function updateTask( Harvest_Task $task ) 
    {
        $url = "tasks/$task->id";
        return $this->performPUT( $url, $task->toXML() );
    }

    /**
     * delete a task
     *
     * <code> 
     * $task_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->deleteTask( $task_id ); 
     * if( $result->isSuccess() ) { 
     *      // additional logic 
     * } 
     * </code>
     * 
     * @param int $task_id Task Identifier
     * @return Harvest_Result
     */
    public function deleteTask( $task_id ) 
    {
        $url = "tasks/$task_id";
        return $this->performDELETE( $url );
    }

    /*--------------------------------------------------------------*/
    /*------------------------- People API -------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all users
     *
     * <code>
     * $api = new HarvestAPI();
     * 
     * $result = $api->getUsers();
     * if( $result->isSuccess() ) {
     *     $users = $result->data;
     * }
     * </code>
     * 
     * @return Harvest_Result
     */
    public function getUsers() 
    {
        $url = "people";
        return $this->performGET( $url, true );
    }

    /**
     * get a user
     *
     * <code> 
     * $user_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getUser( $user_id ); 
     * if( $result->isSuccess() ) { 
     *     $user = $result->data; 
     * } 
     * </code>
     * 
     * @param int $user_id  User Identifier
     * @return Harvest_Result
     */
    public function getUser( $user_id ) 
    {
        $url = "people/$user_id";
        return $this->performGET( $url, false );
    }

    /**
     * create new user
     *
     * <code> 
     * $user = new Harvest_User(); 
     * $user->set( 'first_name', "Matthew" ); 
     * $user->set( 'last_name', "Denton" ); 
     * $user->set( 'email', "test@example.com" ); 
     * $user->set( 'password', 'password' ); 
     * $user->set( 'password_confirmation', 'password_confirmation' ); 
     * $user->set( 'timezone', Harvest_TimeZone::EASTERN_TIME ); 
     * $user->set( 'is_admin', false ); 
     * $user->set( 'telephone', '555-2345' );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->createUser( $user ); 
     * if( $result->isSuccess() ) { 
     *     // get id of created user 
     *     $user_id = $result->data; 
     * } 
     * </code>
     * 
     * @param Harvest_User $user User
     * @return Harvest_Result
     */
    public function createUser( Harvest_User $user ) 
    {
        $url = "people";
        return $this->performPOST( $url, $user->toXML() );
    }

    /**
     * update a User
     *
     * <code> 
     * $user = new Harvest_User(); 
     * $user->set( "id", 12345 ); 
     * $user->set( "first_name", "Matthew" ); 
     * $user->set( "last_name", "Denton" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateUser( $user ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_User $user User
     * @return Harvest_Result
     */
    public function updateUser( Harvest_User $user ) 
    {
        $url = "people/$user->id";
        return $this->performPUT( $url, $user->toXML() );
    }

    /**
     * archive / activate a user
     *
     * <code> 
     * $user_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->toggleUser( $user_id ); 
     * if( $result->isSuccess() ) { 
     *     // addtional logic 
     * } 
     * </code>
     * 
     * @param int $user_id User Identifier
     * @return Harvest_Result
     */
    public function toggleUser( $user_id ) 
    {
        $url = "people/$user_id/toggle";
        return $this->performPUT( $url, "" );
    }

    /**
     * reset User's password
     *
     * <code> 
     * $user_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->resetUserPassword( $user_id ); 
     * if( $result->isSuccess() ) { 
     *     //additional logic 
     * }
     * </code>
     * 
     * @param int $user_id User Identifier
     * @return Harvest_Result
     */
    public function resetUserPassword( $user_id ) 
    {
        $url = "people/$user_id/reset_password";
        return $this->performPUT( $url, "" );
    }

    /**
     * delete a user
     *
     * <code> 
     * $user_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->deleteuser( $user_id ); 
     * if( $result->isSuccess() ) { 
     *      // additional logic 
     * } 
     * </code>
     * 
     * @param int $user_id User Identifier
     * @return Harvest_Result
     */
    public function deleteUser( $user_id ) 
    {
        $url = "people/" . $user_id;
        return $this->performDELETE( $url );
    }

    /*--------------------------------------------------------------*/
    /*------------------------ Expenses API ------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all expense categories
     *
     * <code>
     * $api = new HarvestAPI();
     * 
     * $result = $api->getExpenseCategories();
     * if( $result->isSuccess() ) {
     *     $expenseCategories = $result->data;
     * }
     * </code>
     * 
     * @return Harvest_Result
     */
    public function getExpenseCategories() 
    {
        $url = "expense_categories";
        return $this->performGET( $url, true );
    }

    /**
     * create new expense category
     *
     * <code> 
     * $expenseCategory = new Harvest_ExpenseCategory(); 
     * $expenseCategory->set( 'name', "Mileage" ); 
     * $expenseCategory->set( 'unit-name', "Miles" ); 
     * $expenseCategory->set( 'unit-price', "0.485" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->createExpenseCategory( $expenseCategory ); 
     * if( $result->isSuccess() ) { 
     *     // get id of created expense category 
     *     $expenseCategory_id = $result->data; 
     * } 
     * </code>
     * 
     * @param Harvest_ExpenseCategory $expenseCategory Expense Category
     * @return Harvest_Result
     */
    public function createExpenseCategory( Harvest_ExpenseCategory $expenseCategory ) 
    {
        $url = "expense_categories";
        return $this->performPOST( $url, $expenseCategory->toXML() );
    }

    /**
     * update an Expense Category
     *
     * <code> 
     * $expenseCategory= new Harvest_ExpenseCategory(); 
     * $expenseCategory->set( "id", 12345 ); 
     * $expenseCategory->set( "unit-name", "Kilometers" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateExpenseCategory( $expenseCategory ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_ExpenseCategory $expenseCategory Expense Category
     * @return Harvest_Result
     */
    public function updateExpenseCategory( Harvest_ExpenseCategory $expenseCategory ) 
    {
        $url = "expesnse_categories/$expenseCategory->id";
        return $this->performPUT( $url, $expenseCategory->toXML() );
    }

    /**
     * delete an expense category
     *
     * <code> 
     * $expenseCategory_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->deleteExpenseCategory( $expenseCategory_id ); 
     * if( $result->isSuccess() ) { 
     *      // additional logic 
     * } 
     * </code>
     * 
     * @param int $expense_category_id Expense Category Identifier
     * @return Harvest_Result
     */
    public function deleteExpenseCategory( $expense_category_id ) 
    {
        $url = "expense_categories/$expense_category_id";
        return $this->performDELETE( $url );
    }

    /*--------------------------------------------------------------*/
    /*-------------------- Expenses Tracking API -------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get expense
     *
     * <code> 
     * $expense_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getExpense( $expense_id ); 
     * if( $result->isSuccess() ) { 
     *     $expense = $result->data; 
     * } 
     * </code>
     * 
     * @param int $expense_id Expense Identifier
     * @return Harvest_Result
     */
    public function getExpense( $expense_id) 
    {
        $url = "expenses/$expense_id";
        return $this->performGET( $url, false );
    }

    /**
     * create new expense
     *
     * <code> 
     * // Total Cost 
     * $expense = new Harvest_Expense(); 
     * $expense->set( "notes", "Office Supplies" ); 
     * $expense->set( "total_cost", 18.97 ); 
     * $expense->set( "project_id", 12345 ); 
     * $expense->set( "expense_category_id", 1 ); 
     * $expense->set( "spent_at", "Sun, 10 Feb 2008" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateExpense( $expense ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * }
     * 
     * // Unit Based 
     * $expense = new Harvest_Expense(); 
     * $expense->set( "notes", "Drive to Rochester" ); 
     * $expense->set( "units", 33 ); 
     * $expense->set( "project_id", 12345 ); 
     * $expense->set( "expense_category_id", 2 ); 
     * $expense->set( "spent_at", "Sun, 10 Feb 2008" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateExpense( $expense ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_Expense $expense Expense
     * @return Harvest_Result
     */
    public function createExpense( Harvest_Expense $expense ) 
    {
        $url = "expenses";
        return $this->performPOST( $url, $expense->toXML() );
    }

    /**
     * update an Expense
     *
     * <code> 
     * // Total Cost 
     * $expense = new Harvest_Expense(); 
     * $expense->set( "id", 12345 ); 
     * $expense->set( "notes", "Office Supplies" ); 
     * $expense->set( "total_cost", 18.97 );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateExpense( $expense ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * }
     * 
     * // Unit Based 
     * $expense = new Harvest_Expense(); 
     * $expense->set( "id", 12346 ); 
     * $expense->set( "notes", "Drive to Rochester" ); 
     * $expense->set( "units", 33 );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateExpense( $expense ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_Expense $expense Expense
     * @return Harvest_Result
     */
    public function updateExpense( Harvest_Expense $expense ) 
    {
        $url = "expesnses/$expense->id";
        return $this->performPUT( $url, $obj->toXML() );
    }

    /**
     * delete an expense
     *
     * <code> 
     * $expense_id = 11111;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->deleteExpense( $expense_id ); 
     * if( $result->isSuccess() ) { 
     *      // additional logic 
     * } 
     * </code>
     * 
     * @param int $expense_id Expense Identifier
     * @return Harvest_Result
     */
    public function deleteExpense( $expense_id ) 
    {
        $url = "expenses/" . $expense_id;
        return $this->performDELETE( $url );
    }

	/**
     * Get a receipt image associated with an expense
     *
     * <code>
     * $expense_id = 12345;
     * 
     * $api = new HarvestAPI();
     * 
     * $result = $api->getReceipt( $expense_id );
     * if( $result->isSuccess() ) {
     *     echo $result->data;
     * } 
     * </code>
     *
     * @param $expense_id Expense Identifier
     * @return Harvest_Result
     */
    public function getReceipt( $expense_id ) 
    {
        $url = "expenses/$expense_id/receipt";
        return $this->performGET( $url, "raw");
    }

    /**
     * Attach a receipt image to an expense
     *
     * <code>
     * $expense_id = 12345;
     * $image_url = "test.jpg"
     * 
     * $api = new HarvestAPI();
     * 
     * $result = $api->attachReceipt( $expense_id, $image_url );
     * if( $result->isSuccess() ) {
     *     // success logic
     * } 
     * </code>
     *
     * @param $expense_id Expense Identifier
     * @param $image_url Image URL
     * @return Harvest_Result
     */
    public function attachReceipt( $expense_id, $image_url ) 
    {
        $url = "expenses/$expense_id/$receipt";
        $data = array();
        $data["expense[receipt]"] = "@$image_url";
        return $this->performMultiPart( $url, $data);
    }

    /*--------------------------------------------------------------*/
    /*--------------------- User Assignment API --------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all user assignments to a given project
     *
     * <code> 
     * $project_id = 12345;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getProjectUserAssignments( $project_id ); 
     * if( $result->isSuccess() ) { 
     *     $users = $result->data; 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @return Harvest_Result
     */
    public function getProjectUserAssignments( $project_id ) 
    {
        $url = "projects/$project_id/user_assignments";
        return $this->performGET( $url, true );
    }

    /**
     * get a user assignment
     *
     * <code> 
     * $project_id = 11111; 
     * $userAssignment_id = 12345;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getProjectUserAssignment( $project_id, $userAssignment_id ); 
     * if( $result->isSuccess() ) { 
     *     $userAssignment = $result->data; 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @param int $user_assignment_id User Assignment Identifier
     * @return Harvest_UserAssignment
     */
    public function getProjectUserAssignment( $project_id, $user_assignment_id ) 
    {
        $url = "projects/$project_id/user_assignments/$user_assignment_id";
        return $this->performGET( $url, false );
    }

    /**
     * create new Project User Assignment
     *
     * <code> 
     * $project_id = 12345; 
     * $user_id = 23456;
     * 
     * $api = new HarvestAPI(); 
     * 
     * $api->assignUserToProject( $project_id, $user_id ); 
     * if( $result->isSuccess() ) { 
     *     // get userassignment id 
     *     $user_assignment_id = $result->data; 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @param int $user_id User Identifier
     * @return Harvest_Result
     */
    public function assignUserToProject( $project_id, $user_id ) 
    {
        $url = "projects/$project_id/user_assignments";
        return $this->performPOST( $url, "<user><id>$user_id</id></user>" );
    }

    /**
     * delete a Project User Assignment
     *
     * <code> 
     * $project_id = 12345; 
     * $userAssignment_id = 23456;
     * 
     * $api = new HarvestAPI(); 
     * 
     * $api->removeUserFromProject( $project_id, $userAssignment_id ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @param int $user_assignment_id User Assignment Identifier
     * @return Harvest_Result
     */
    public function removeUserFromProject( $project_id, $user_assignment_id ) 
    {
        $url = "projects/$project_id/user_assignments/$user_assignment_id";
        return $this->performDELETE( $url );
    }

    /**
     * update a Project User Assignment
     *
     * <code> 
     * $userAssignment = new Harvest_UserAssignment(); 
     * $userAssignment->set( "user-id", 11111 ); 
     * $userAssignment->set( "project-id", 12345 ); 
     * $userAssignment->set( "deactivated", true ); 
     * $userAssignment->set( "hourly-rate", 74.50 ); 
     * $userAssignment->set( "is-project-manager", false );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $api->updateProjectUserAssignment( $userAssignment ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_UserAssignment $userAssignment UserAssignment
     * @return Harvest_Result
     */
    public function updateProjectUserAssignment( Harvest_UserAssignment $userAssignment ) 
    {
        $url = "projects/" . $userAssignment->get("project-id") . "/user_assignments/" . $userAssignment->get("user-id");
        return $this->performPUT( $url, $userAssignment->toXML() );
    }

    /*--------------------------------------------------------------*/
    /*--------------------- Task Assignment API --------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all task assignments to a given project
     *
     * <code> 
     * $project_id = 12345;
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getProjectTaskAssignments( $project_id ); 
     * if( $result->isSuccess() ) { 
     *     $taskAssignments = $result->data; 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @return Harvest_Result
     */
    public function getProjectTaskAssignments( $project_id ) 
    {
        $url = "projects/$project_id/task_assignments";
        return $this->performGET( $url, true );
    }

    /**
     * get a task assignment
     *
     * <code> 
     * $project_id = 11111; 
     * $taskAssignment_id = 12345;
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->getProjectTaskAssignment( $project_id, $taskAssignment_id ); 
     * if( $result->isSuccess() ) { 
     *     $taskAssignment = $result->data; 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @param int $task_assignment_id Task Assignment Identifier
     * @return Harvest_Result
     */
    public function getProjectTaskAssignment( $project_id, $task_assignment_id ) 
    {
        $url = "projects/$project_id/task_assignments/$task_assignment_id";
        return $this->performGET( $url, false );
    }

    /**
     * assign a task to a project
     *
     * <code> 
     * $project_id = 12345; 
     * $task_id = 23456;
     * 
     * $api = new HarvestAPI(); 
     * 
     * $api->assignTaskToProject( $project_id, $task_id ); 
     * if( $result->isSuccess() ) { 
     *     // get taskAssignment id 
     *     $task_assignment_id = $result->data; 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @param int $task_id Task Identifier
     * @return Harvest_Result
     */
    public function assignTaskToProject( $project_id, $task_id ) 
    {
        $url = "projects/$project_id/task_assignments";
        return $this->performPOST( $url, "<task><id>$task_id</id></task>" );
    }

    /**
     * create a new task for a project
     *
     * <code> 
     * $project_id = 11111; 
     * $task = new Harvest_Task(); 
     * $task->set( "name", "Task Name" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $api->createProjectTaskAssignment( $project_id, $task ); 
     * if( $result->isSuccess() ) { 
     *     // get taskAssignment id 
     *     $task_assignment_id = $result->data; 
     * }
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @param Harvest_Task $task Task
     * @return Harvest_Result
     */
    public function createProjectTaskAssignment( $project_id, $task ) 
    {
        $url = "projects/$project_id/task_assignments/add_with_create_new_task";
        return $this->performPOST( $url, $task->toXML() );
    }

    /**
     * delete Project Task assignment
     *
     * <code> 
     * $project_id = 12345; 
     * $taskAssignment_id = 23456;
     * 
     * $api = new HarvestAPI(); 
     * 
     * $api->deleteProjectTaskAssignment( $project_id, $taskAssignment_id ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @param int $task_assignment_id Task Assignment Identifier
     * @return Harvest_Result
     */
    public function deleteProjectTaskAssignment( $project_id, $task_assignment_id ) 
    {
        $url = "projects/$project_id/task_assignments/$task_assignment_id";
        return $this->performDELETE( $url );
    }

    /**
     * update a Project Task Assignment
     *
     * <code> 
     * $taskAssignment = new Harvest_TaskAssignment(); 
     * $taskAssignment->set( "id", 67849 ); 
     * $taskAssignment->set( "project-id", 12345 ); 
     * $taskAssignment->set( "deactivated", false ); 
     * $taskAssignment->set( "hourly-rate", 74.50 );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $api->updateProjectTaskAssignment( $taskAssignment ); 
     * if( $result->isSuccess() ) { 
     *     // additional logic 
     * } 
     * </code>
     * 
     * @param Harvest_TaskAssignment $taskAssignment Task Assignment
     * @return Harvest_Result
     */
    public function updateProjectTaskAssignment( Harvest_TaskAssignment $taskAssignment ) 
    {
        $url = "projects/" . $taskAssignment->get("project-id") . "/task_assignments/" . $taskAssignment->get("id");
        return $this->performPUT( $url, $taskAssignment->toXML() );
    }

    /*--------------------------------------------------------------*/
    /*------------------------- Reports API ------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all project entries for given time range for a particular user if specified
     *
     * <code>
     * $range = new Harvest_Range( "20090712", "20090719" );
     * $project_id = 12345;
     * $user_id = 11111;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->getProjectEntries( $project_id, $range, $user_id );
     * if( $result->isSuccess() ) {
     *     $dayEntries = $result->data;
     * }
     * </code>
     * 
     * @param int $project_id Project Identifier
     * @param Harvest_Range $range Time Range
     * @param int $user_id User identifier optional
     * @return Harvest_Result
     */
    public function getProjectEntries( $project_id, Harvest_Range $range, $user_id = null ) 
    {
        $url = "projects/" . $project_id . "/entries?from=" . $range->from() . '&to=' . $range->to();
        if( ! is_null( $user_id ) ) {
            $url .= "&user_id=" . $user_id;
        }
        return $this->performGET( $url, true );
    }

    /**
     * get all user entries for given time range and for a particular project if specified
     *
     * <code>
     * $range = new Harvest_Range( "20090712", "20090719" );
     * $project_id = 12345;
     * $user_id = 11111;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->getUserEntries( $user_id, $range, $project_id );
     * if( $result->isSuccess() ) {
     *     $dayEntries = $result->data;
     * }
     * </code>
     * 
     * @param int $user_id User Identifier
     * @param Harvest_Range $range Time Range
     * @param int $project_id Project identifier optional
     * @return Harvest_Result
     */
    public function getUserEntries( $user_id, Harvest_Range $range, $project_id = null ) 
    {
        $url = "people/" . $user_id . "/entries?from=" . $range->from() . '&to=' . $range->to();
        if( ! is_null( $project_id ) ) {
            $url .= "&project_id=" . $project_id;
        }
        return $this->performGET( $url, true );
    }

    /**
     * get all user expenses for given time range
     *
     * <code>
     * $range = new Harvest_Range( "20090712", "20090719" );
     * $user_id = 11111;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->getUserExpenses( $user_id, $range );
     * if( $result->isSuccess() ) {
     *     $expenses = $result->data;
     * }
     * </code>
     * 
     * @param int $user_id User Identifier
     * @param Harvest_Range $range Time Range
     * @return Harvest_Result
     */
    public function getUserExpenses( $user_id, Harvest_Range $range ) 
    {
        $url = "people/" . $user_id . "/expenses?from=" . $range->from() . '&to=' . $range->to();
        return $this->performGET( $url, true );
    }
    
    /*--------------------------------------------------------------*/
    /*------------------------ Invoices API ------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all invoices
     *
     * <code>
     * $filter = new Harvest_Invoice_Filter();
     * $filter->set( "status", Harvest_Invoice_Filter::UNPAID );
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->getInvoice( $filter );
     * if( $result->isSuccess() ) {
     *     $invoices = $result->data;
     * }
     * </code>
     * 
     * @param Harvest_Invoice_Filter $filter Filter Options
     * @return Harvest_Result
     */
    public function getInvoices( Harvest_Invoice_Filter $filter = null) 
    {
        $url = "invoices";
        if( ! is_null( $filter ) ) {
            $url .= $filter->toURL();
        }
        return $this->performGET( $url, true );
    }

    /**
     * get a specific invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->getInvoice( $invoice_id);
     * if( $result->isSuccess() ) {
     *     $invoice = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @return Harvest_Result
     */
    public function getInvoice( $invoice_id ) 
    {
        $url = "invoices/" . $invoice_id;
        return $this->performGET( $url, false );
    }

    /**
     * create new invoice
     *
     * <code> 
     * $invoice = new Harvest_Invoice(); 
     * $invoice->set( "client-id", 11111 );
     * $invoice->set( "notes", "Some Notes" );
     * // set other values
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->createInvoice( $invoice ); 
     * if( $result->isSuccess() ) { 
     *     // get invoice id
     *     $id = $result->data;
     * } 
     * </code>
     * 
     * @param Harvest_Invoice $invoice Invoice
     * @return Harvest_Result
     */
    public function createInvoice( Harvest_Invoice $invoice ) 
    {
        $url = "invoices";
        return $this->performPOST( $url, $invoice->toXML() );
    }

    /**
     * update an Invoice
     *
     * <code> 
     * $invoice = new Harvest_Invoice(); 
     * $invoice->set( "id", 12345 );
     * $invoice->set( "notes", "Some Notes" );
     * 
     * $api = new HarvestAPI(); 
     * 
     * $result = $api->updateInvoice( $invoice ); 
     * if( $result->isSuccess() ) { 
     *     // success logic
     * } 
     * </code>
     * 
     * @param Harvest_Invoice $invoice Invoice
     * @return Harvest_Result
     */
    public function updateInvoice( Harvest_Invoice $invoice ) 
    {
        $url = "invoices/" . $invoice->get("id");
        return $this->performPUT( $url, $invoice->toXML() );
    }

    /**
     * delete an Invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->deleteInvoice( $invoice_id);
     * if( $result->isSuccess() ) {
     *     // success logic
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @return Harvest_Result
     */
    public function deleteInvoice( $invoice_id ) 
    {
        $url = "invoices/" . $invoice_id;
        return $this->performDELETE( $url );
    }

    /**
     * close invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->closeInvoice( $invoice_id);
     * if( $result->isSuccess() ) {
     *     // success logic
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @return Harvest_Result
     */
    public function closeInvoice( $invoice_id ) 
    {
        $url = "invoices/$invoice_id/mark_as_closed";
        return $this->performPUT( $url );
    }

    /**
     * alias for close invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->markOffInvoice( $invoice_id);
     * if( $result->isSuccess() ) {
     *     // success logic
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @return Harvest_Result
     */
    public function markOffInvoice( $invoice_id ) 
    {
        return $this->closeInvoice( $invoice_id );
    }

    /*--------------------------------------------------------------*/
    /*-------------------- Invoice Messages API --------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all messages sent for an invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->getInvoiceMessages( $invoice_id);
     * if( $result->isSuccess() ) {
     *     $invoiceMessages = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @return Harvest_Result
     */
    public function getInvoiceMessages( $invoice_id ) 
    {
        $url = "invoices/" . $invoice_id . "/messages";
        return $this->performGET( $url, true );
    }

    /**
     * get a particular invoice message
     *
     * <code>
     * $invoice_id = 12345;
     * $message_id = 11111;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->getInvoiceMessage( $invoice_id, $message_id );
     * if( $result->isSuccess() ) {
     *     $invoiceMessage = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param int $message_id Message Identifier
     * @return Harvest_Result
     */
    public function getInvoiceMessage( $invoice_id, $message_id ) 
    {
        $url = "invoices/" . $invoice_id . "/messages/" . $message_id;
        return $this->performGET( $url, false );
    }

    /**
     * Send an invoice with message
     *
     * <code>
     * $invoice_id = 12345;
     * 
     * $message = new Harvest_InvoiceMessage();
     * $message->set( "body", "The Message" );
     * $message->set( "recipients", "test@example.com" );
     * 
     * $api = new HarvestAPI();
     *
     * $result = $api->sendInvoiceMessage( $invoice_id, $message );
     * if( $result->isSuccess() ) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param Harvest_InvoiceMessage $message Invoice Message
     * @return Harvest_Result
     */
    public function sendInvoiceMessage( $invoice_id, Harvest_InvoiceMessage $message ) 
    {
        $url = "invoices/$invoice_id/messages";
        return $this->performPOST( $url, $message->toXML() );
    }

    /**
     * delete an Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     * $message_id = 11111;
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->deleteInvoiceMessage( $invoice_id, $message_id );
     * if( $result->isSuccess() ) {
     *     // success logic
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param int $message_id Invoice Message Identifier
     * @return Harvest_Result
     */
    public function deleteInvoiceMessage( $invoice_id, $message_id ) 
    {
        $url = "invoices/$inovice_id/messages/$message_id";
        return $this->performDELETE( $url );
    }

    /**
     * create Sent Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     * 
     * $message = new Harvest_InvoiceMessage();
     * $message->set( "body", "The Message" );
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->createSentInvoiceMessage( $invoice_id, $message );
     * if( $result->isSuccess() ) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param Harvest_InvoiceMessage $message Invoice Message
     * @return Harvest_Result
     */
    public function createSentInvoiceMessage( $invoice_id, Harvest_InvoiceMessage $message ) 
    {
        $url = "invoices/$invoice_id/messages/mark_as_sent";
        return $this->performPOST( $url, $message->toXML() );
    }

    /**
     * create Closed Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     * 
     * $message = new Harvest_InvoiceMessage();
     * $message->set( "body", "The Message" );
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->createClosedInvoiceMessage( $invoice_id, $message );
     * if( $result->isSuccess() ) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param Harvest_InvoiceMessage $message Invoice Message
     * @return Harvest_Result
     */
    public function createClosedInvoiceMessage( $invoice_id, Harvest_InvoiceMessage $message ) 
    {
        $url = "invoices/$invoice_id/messages/mark_as_closed";
        return $this->performPOST( $url, $message->toXML() );
    }

    /**
     * Create re-open Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     * 
     * $message = new Harvest_InvoiceMessage();
     * $message->set( "body", "The Message" );
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->createReOpenInvoiceMessage( $invoice_id, $message );
     * if( $result->isSuccess() ) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param Harvest_InvoiceMessage $message Invoice Message
     * @return Harvest_Result
     */
    public function createReOpenInvoiceMessage( $invoice_id, Harvest_InvoiceMessage $message ) 
    {
        $url = "invoices/$invoice_id/messages/re_open";
        return $this->performPOST( $url, $message->toXML() );
    }
	
    /**
     * create mark-as-draft Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     * 
     * $message = new Harvest_InvoiceMessage();
     * $message->set( "body", "The Message" );
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->createMarkAsDraftInvoiceMessage( $invoice_id, $message );
     * if( $result->isSuccess() ) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param Harvest_InvoiceMessage $message Invoice Message
     * @return Harvest_Result
     */
    public function createMarkAsDraftInvoiceMessage( $invoice_id, Harvest_InvoiceMessage $message ) 
    {
        $url = "invoices/$invoice_id/messages/mark_as_draft";
        return $this->performPOST( $url, $message->toXML() );
    }

    /*--------------------------------------------------------------*/
    /*-------------------- Invoice Payments API --------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all recorded payments for an invoice
     *
     * <code>
     * $api = new HarvestAPI();
     * $invoice_id = 1111;
	 * 
     * $result = $api->getInvoicePayments( $invoice_id );
     * if( $result->isSuccess() ) {
     *     $invoicePayments = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @return Harvest_Result
     */
    public function getInvoicePayments( $invoice_id ) 
    {
        $url = "invoices/$invoice_id/payments";
        return $this->performGET( $url, true );
    }

    /**
     * get a particular Invoice Payment
     *
     * <code>
     * $invoice_id = 12345;
     * $payment_id = 11111;
     * 
     * $api = new HarvestAPI();
     *
     * $result = $api->getInvoicePayment( $invoice_id, $payment_id );
     * if( $result->isSuccess() ) {
     *     $payment = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param int $payment_id Payment Identifier
     * @return Harvest_Result
     */
    public function getInvoicePayment( $invoice_id, $payment_id ) 
    {
        $url = "invoices/$invoice_id/payments/$payment_id";
        return $this->performGET( $url, false );
    }

    /**
     * Create an Invoice Payment
     *
     * <code>
     * $payment = new Harvest_Payment();
     * $payment->set( "paid-at", "2008-02-14T00:00:00Z" );
     * $payment->set( "amount", 5400.00 ); 
     *
     * $api = new HarvestAPI();
     *
     * $result = $api->createInvoicePayment( $payment );
     * if( $result->isSuccess() ) {
     *     //get id of new Invoice Payment
     *     $id = $result->data;
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param Harvest_Payment $payment Payment
     * @return Harvest_Result
     */
    public function createInvoicePayment( $invoice_id, Harvest_Payment $payment ) 
    {
        $url = "invoices/$invoice_id/payments";
        return $this->performPOST( $url, $payment->toXML() );
    }

    /**
     * delete an Invoice Payment
     *
     * <code>
     * $invoice_id = 12345;
     * $payment_id = 12111;
     * 
     * $api = new HarvestAPI();
     *
     * $result = $api->deleteInvoicePayment( $invoice_id, $payment_id );
     * if( $result->isSuccess() ) {
     *     //success logic
     * }
     * </code>
     * 
     * @param int $invoice_id Invoice Identifier
     * @param int $payment_id Payment Identifier
     * @return Harvest_Result
     */
    public function deleteInvoicePayment( $invoice_id, $payment_id ) 
    {
        $url = "invoices/$inovice_id/payments/$payment_id";
        return $this->performDELETE( $url );
    }

    /*--------------------------------------------------------------*/
    /*------------------- Invoice Categories API -------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all invoice categories
     *
     * <code>
     * $api = new HarvestAPI();
     *
     * $result = $api->getInvoiceCategories( );
     * if( $result->isSuccess() ) {
     *     $invoiceCategories = $result->data;
     * }
     * </code>
     * 
     * @return Harvest_Result
     */
    public function getInvoiceCategories() 
    {
        $url = "invoice_item_categories";
        return $this->performGET( $url, true );
    }

    /**
     * Create an Invoice Category
     *
     * <code>
     * $invoiceCategory = new Harvest_InvoiceItemCategory();
     * $invoiceCategory->set( "name", "Entertainment" );
     * 
     * $api = new HarvestAPI();
     *
     * $result = $api->createInvoiceCategory( $invoiceCategory );
     * if( $result->isSuccess() ) {
     *     //get id of new Invoice Category
     *     $id = $result->data;
     * }
     * </code>
     * 
     * @param Harvest_InvoiceItemCategory $invoiceCategory Invoice Category
     * @return Harvest_Result
     */
    public function createInvoiceCategory( Harvest_InvoiceItemCategory $invoiceCategory ) 
    {
        $url = "invoice_item_categories";
        return $this->performPOST( $url, $invoiceCategory->toXML() );
    }

    /**
     * Update an Invoice Category
     *
     * <code>
     * $invoiceCategory = new Harvest_InvoiceItemCategory();
     * $invoiceCategory->set( "id", 11111 );
     * $invoiceCategory->set( "name", "Entertainment" );
     * 
     * $api = new HarvestAPI();
     *
     * $result = $api->updateInvoiceCategory( $invoiceCategory );
     * if( $result->isSuccess() ) {
     *     //success logic
     * }
     * </code>
     * 
     * @param Harvest_InvoiceItemCategory $invoiceCategory Invoice Category
     * @return Harvest_Result
     */
    public function updateInvoiceCategory( Harvest_InvoiceItemCategory $invoiceCategory ) 
    {
        $url = "invoice_item_categories/" . $invoiceCategory->get( "id" );
        return $this->performPUT( $url, $invoiceCategory->toXML() );
    }

    /**
     * delete an Invoice Category
     *
     * <code>
     * $invoiceCategory_id = 12345;
     * 
     * $api = new HarvestAPI();
     *
     * $result = $api->deleteInvoiceCategory( $invoiceCategory_id );
     * if( $result->isSuccess() ) {
     *     //success logic
     * }
     * </code>
     * 
     * @param int $invoiceCategory_id Invoice Category Identifier
     * @return Harvest_Result
     */
    public function deleteInvoiceCategory( int $invoiceCategory_id ) 
    {
        $url = "invoice_item_categories/$invoiceCategory_id";
        return $this->performDELETE( $url );
    }

    /*--------------------------------------------------------------*/
    /*----------------- API Access & Parse Methods -----------------*/
    /*--------------------------------------------------------------*/

	/**
	 * generate the update_since query params
	 * @param mixed $update_since DateTime
	 * @return string
	 */
	public function appendUpdatedSinceParam( $updated_since = null ) 
	{
		if( is_null( $updated_since) ) {
			return "";
		} else if( $updated_since instanceOf DateTime ) {
			return '?updated_since=' . urlencode($updated_since->format("Y-m-d G:i"));
		} else {
			return '?updated_since=' . urlencode($updated_since);
		}
	}
	
    /**
     * perform http get command
     * @param string $url url of server to process request
     * @param mixed $multi Flag to specify if multiple items are returned by request
     * @return Harvest_Result
     */
    protected function performGET( $url, $multi = true ) 
    {
	    $data = null;
        $code = null;
        $success = false;
        while( ! $success ) {
            $ch = $this->generateCURL( $url );
            $data = curl_exec( $ch );
            $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            if( $this->_mode == HarvestAPI::RETRY && $code == "503") {
                $success = false;
                sleep( $this->_headers['Retry-After'] );
            } else {
                $success = true;
            }
        }
        if( "2" == substr( $code, 0, 1 ) ) {
            if( $multi === true ) {
                $data = $this->parseItems( $data );
            } else if( $multi == "raw" ) {
                $data = data;
            } else {
                $data = $this->parseItem( $data );
            }
        }
        return new Harvest_Result( $code, $data, $this->_headers );
    }

    /**
     * generate cURL get request
     * @param $url 
     * @return object cURL Handler
     */
    protected function generateCURL( $url )
    {
	    $this->resetHeader();
        $http = "http://";
        if( $this->_ssl ) {
            $http = "https://";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $http . $this->_account . ".harvestapp.com/" . $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: PHP Wrapper Library for Harvest API', 'Accept: application/xml', 'Content-Type: application/xml', 'Authorization: Basic (' . base64_encode( $this->_user . ":" . $this->_password ). ')' ) );
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array(&$this,'parseHeader'));
        return $ch;
    }

    /**
     * perform http put command
     * @param string $url url of server to process request
     * @param string $data data to be sent
     * @return Harvest_Result
     */
    protected function performPUT( $url, $data ) 
    {
        $rData = null;
        $code = null;
        $success = false;
        while( ! $success ) {
            $ch = $this->generatePUTCURL( $url, $data );
            $rData = curl_exec( $ch );
            $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            if( $this->_mode == HarvestAPI::RETRY && $code == "503") {
                $success = false;
                sleep( $this->_headers['Retry-After'] );
            } else {
                $success = true;
            }
        }
        return new Harvest_Result( $code, $rData, $this->_headers );
    }

    /**
     * generate cURL put request
     * @param $url 
     * @param $data PUT Data
     * @return object cURL Handler
     */
    protected function generatePUTCURL( $url, $data )
    {
	    $ch = $this->generateCURL( $url );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
        return $ch;
    }

    /**
     * perform http post command
     * @param string $url url of server to process request
     * @param string $data data to be sent
     * @return Harvest_Result
     */
    protected function performPOST( $url, $data, $multi = "id" ) 
    {
        $rData = null;
        $code = null;
        $success = false;
        while( ! $success ) {
            $ch = $this->generatePOSTCURL( $url, $data );
            $rData = curl_exec( $ch );
            $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            if( $this->_mode == HarvestAPI::RETRY && $code == "503") {
                $success = false;
                sleep( $this->_headers['Retry-After'] );
            } else {
                $success = true;
            }
        }
        if( "2" == substr( $code, 0, 1 ) ) {
			if( $multi == "id" ) {
				$rData = $this->_headers["Location"];
			} else if( $multi === true ) {
                $rData = $this->parseItems( $rData );
            } else if( $multi == "raw" ) {
                $rData = $data;
            } else {
                $rData = $this->parseItem( $rData );
            }
        }
        return new Harvest_Result( $code, $rData, $this->_headers );
    }

    /**
     * generate cURL get request
     * @param $url 
     * @param $data Array of Post Data
     * @return object cURL Handler
     */
    protected function generatePOSTCURL( $url, $data )
    {
        $ch = $this->generateCURL( $url );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
        return $ch;
    }

    /**
     * perform http delete command
     * @param string $url url of server to process request
     * @return Harvest_Result
     */
    protected function performDELETE( $url) 
    {
		$data = null;
        $code = null;
        $success = false;
        while( ! $success ) {
            $ch = $this->generateDELETECURL( $url );
            $data = curl_exec( $ch );
            $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            if( $this->_mode == HarvestAPI::RETRY && $code == "503") {
                $success = false;
                sleep( $this->_headers['Retry-After'] );
            } else {
                $success = true;
            }
        }
        return new Harvest_Result( $code, $data, $this->_headers );
    }

    /**
     * generate cURL get request
     * @param $url 
     * @return object cURL Handler
     */
    protected function generateDELETECURL( $url )
    {
	    $ch = $this->generateCURL( $url );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $ch;
    }

    /**
     * perform http post of MultiPart Form-Data
     *
     * @param string $url url of server to process request
     * @param array $data Associated Aray of form data
     * @return Harvest_Result
     */
    protected function performMultiPart( $url, $data ) 
    {
        $rData = null;
        $code = null;
        $success = false;
        while( ! $success ) {
            $ch = $this->generateMultiPartCURL( $url, $data );
            $rData = curl_exec( $ch );
            $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            if( $this->_mode == HarvestAPI::RETRY && $code == "503") {
                $success = false;
                sleep( $this->_headers['Retry-After'] );
            } else {
                $success = true;
            }
        }
        return new Harvest_Result( $code, $rData, $this->_headers );
    }

    /**
     * generate MultiPart/Form-Data request
     * @param $url 
     * @param $data array of MultiPart Form Data
     * @return object cURL Handler
     */
    protected function generateMultiPartCURL( $url, $data )
    {
        $ch = $this->generateCURL( $url );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'User-Agent: PHP Wrapper Library for Harvest API', 'Accept: application/xml', 'Content-Type: multipart/form-data', 'Authorization: Basic (' . base64_encode( $this->_user . ":" . $this->_password ). ')' ) );	
        return $ch;
    }

    /**
     * parse XML list
     * @param string $xml XML String
     * @return array
     */
    protected function parseItems( $xml ) 
    {
        $items = array();
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($xml);
        $x = $xmlDoc->documentElement;
        foreach ($x->childNodes AS $item)
        {
            $item = $this->parseNode( $item );
            if( ! is_null( $item ) )
            {
                $items[$item->id()] = $item;
            }
        }
        return $items;
	}
    
    /**
     * parse XML item
     * @param string $xml XML String
     * @return mixed
     */
    protected function parseItem( $xml ) 
    {
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($xml);
        $itemNode = $xmlDoc->documentElement;
        return $this->parseNode( $itemNode );
    }

    /**
     * parse xml node
     * @param DocumentElement $node document element
     * @return mixed
     */
    protected function parseNode( $node ) 
    {
        $item = null;
        switch( $node->nodeName )
        {    
            case "expense-category":
                $item = new Harvest_ExpenseCategory();
            break;
            case "client":
                $item = new Harvest_Client();
            break;
            case "contact":
                $item = new Harvest_Contact();
            break;
			case "add":
				$children = $node->childNodes;
				foreach( $children as $child ) {
					if( $child->nodeName == "day_entry" ) {
						$node = $child;
						break;
					}
				}
            case "day_entry":
			case "day-entry":
                $item = new Harvest_DayEntry();
            break;
            case "expense":
                $item = new Harvest_Expense();
            break;
            case "invoice":
                $item = new Harvest_Invoice();
            break;
            case "invoice-item-category":
                $item = new Harvest_InvoiceItemCategory();
            break;
            case "invoice-message":
                $item = new Harvest_InvoiceMessage();
            break;
            case "payment":
                $item = new Harvest_Payment();
            break;
            case "project":
                $item = new Harvest_Project();
            break;
            case "task":
                $item = new Harvest_Task();
            break;
            case "user":
                $item = new Harvest_User();
            break;
            case "user-assignment":
                $item = new Harvest_UserAssignment();
            break;
            case "task-assignment":
                $item = new Harvest_TaskAssignment();
            break;
            case "daily":
                $item = new Harvest_DailyActivity();
            break;
            case "timer":
                $item = new Harvest_Timer();
            break;
			case "hash":
				$item = new Harvest_Throttle();
			break;
            default:
            break;
        }
        if( ! is_null( $item ) ) {
            $item->parseXML( $node );
        }
        return $item;
    }

    /**
     * parse cURL Header text
     * @param cURL-Handle $ch cURL Handle
     * @param string $header Header line text to be parsed
     * @return int
     */
    protected function parseHeader( $ch, $header ) 
    {
        $pos = strpos( $header, ":" );
        $key = substr( $header, 0, $pos );
        $value = trim( substr( $header, $pos + 1 ) );
        if( $key == "Location") {
            $this->_headers[ $key ] = trim( substr( $value, strrpos($value, "/") + 1) );
        } else {
            $this->_headers[ $key ] = $value;
        }
        return strlen($header);
    }

    /**
     * reset headers variable
     * @return void
     */
    protected function resetHeader( ) 
    {
	    $this->_headers = array();
    }

    /**
     * simple autoload function
     * returns true if the class was loaded, otherwise false
     *
     * <code>
     * // register the class auto loader 
	 * spl_autoload_register( array('HarvestAPI', 'autoload') );
     * </code>
     * 
     * @param string $classname Name of Class to be loaded
     * @return boolean
     */
    public static function autoload($className)
    {
        if (class_exists($className, false) || interface_exists($className, false)) {
            return false;
        }
        $class = self::getPath() . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        if (file_exists($class)) {
            require $class;
            return true;
        }
        return false;
    }

    /**
     * Get the root path to Harvest API
     *
     * <code>
     * $api = new HarvestAPI();
     * $api->getPath();
     * </code>
     *
     * @return String
     */
    public static function getPath()
    {
        if ( ! self::$_path) {
            self::$_path = dirname(__FILE__);
        }
        return self::$_path;
    }

}