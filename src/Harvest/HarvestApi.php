<?php

namespace Harvest;

use Harvest\Model\Client,
    Harvest\Model\Contact,
    Harvest\Model\DayEntry,
    Harvest\Model\Expense,
    Harvest\Model\ExpenseCategory,
    Harvest\Model\Invoice,
    Harvest\Model\InvoiceItemCategory,
    Harvest\Model\InvoiceMessage,
    Harvest\Model\Payment,
    Harvest\Model\Project,
    Harvest\Model\Result,
    Harvest\Model\Task,
    Harvest\Model\User,
    Harvest\Model\UserAssignment,
    Harvest\Model\TaskAssignment,
    Harvest\Model\DailyActivity,
    Harvest\Model\Timer,
    Harvest\Model\Throttle,
    Harvest\Model\Range;
use Harvest\Model\Invoice\Filter;

/**
 * HarvestApi
 *
 * This file contains the class HarvestApi
 *
 */

/**
 * HarvestApi defines the methods available to the API, as well as
 * handlers for parsing the returned data.
 *
 * <code>
 * // require the Harvest API core class
 * require_once(PATH_TO_LIB . '/HarvestApi.php');
 *
 * // register the class auto loader
 * spl_autoload_register(array('HarvestApi', 'autoload'));
 *
 * // instantiate the api object
 * $api = new HarvestApi();
 * $api->setUser("user@email.com");
 * $api->setPassword("password");
 * $api->setAccount("account");
 * </code>
 *
 */
 class HarvestApi
 {
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
     * $api = new HarvestApi();
     * $api->setUser("user name");
     * </code>
     *
     * @param  string $user User name
     * @return void
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * set Harvest Password
     *
     * <code>
     * $api = new HarvestApi();
     * $api->setPassword("password");
     * </code>
     *
     * @param  string $password User Password
     * @return void
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * set Harvest Account
     *
     * <code>
     * $api = new HarvestApi();
     * $api->setAccount("account");
     * </code>
     *
     * @param  string $account Account Name
     * @return void
     */
    public function setAccount($account)
    {
        $this->_account = $account;
    }

    /**
     * set retry mode
     *
     * <code>
     * $api = new HarvestApi();
     * $api->setRetryMode(HarvestApi::RETRY);
     * </code>
     *
     * @param  boolean $mode retry mode
     * @return void
     */
    public function setRetryMode($mode)
    {
        $this->_mode = $mode;
    }

    /**
     * get your current throttle status
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getThrottleStatus();
     * $throttle = $result->data;
     * </code>
     *
     * @return Result
     */
    public function getThrottleStatus()
    {
        $url = "account/rate_limit_status";

        return $this->performGet($url, false);
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
     * $api = new HarvestApi();
     *
     * $result = $api->getDailyActivity($day_of_year, $year);
     * if ($result->isSuccess()) {
     *     $entries= $result->data;
     * }
     * </code>
     *
     * @param  int    $day_of_year Day of Year
     * @param  int    $year        Year
     * @return Result
     */
    public function getDailyActivity($day_of_year = null, $year = null)
    {
        $url = "daily/";
        if (! is_null($day_of_year) && ! is_null($year)) {
            $url .= $day_of_year . "/" . $year;
        }

        return $this->performGet($url, false);
    }

    /**
     * gets the entry specified
     *
     * <code>
     * $entry_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getEntry($entry_id);
     * if ($result->isSuccess()) {
     *     $entry = $result->data;
     * }
     * </code>
     *
     * @param  int    $entry_id Entry Identifier
     * @return Result
     */
    public function getEntry($entry_id)
    {
        $url = "daily/show/" . $entry_id;

        return $this->performGet($url, false);
    }

    /**
     * toggle a timer on/off
     *
     * <code>
     * $entry_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->toggleTimer($entry_id);
     * if ($result->isSuccess()) {
     *     $timer = $result->data;
     * }
     * </code>
     *
     * @param $entry_id    DayEntry Identifier
     * @return Result
     */
    public function toggleTimer($entry_id)
    {
        $url = "daily/timer/" . $entry_id;

        return $this->performGet($url, false);
    }

     /**
      * create an entry
      *
      * <code>
      * $entry = new DayEntry();
      * $entry->set("notes", "Test Support");
      * $entry->set("hours", 3);
      * $entry->set("project_id", 3);
      * $entry->set("task_id", 14);
      * $entry->set("spent_at", "Tue, 17 Oct 2006");
      *
      * $api = new HarvestApi();
      *
      * $result = $api->createEntry($entry);
      * if ($result->isSuccess()) {
      *     $timer = $result->data;
      * }
      * </code>
      *
      * @param DayEntry $entry Day Entry
      * @return Result
      */
    public function createEntry(DayEntry $entry)
    {
        $url = "daily/add";

        return $this->performPost($url, $entry->toXML(), false);
    }

     /**
      * creates an entry and starts its timer
      *
      * <code>
      * $entry = new DayEntry();
      * $entry->set("notes", "Test Support");
      * $entry->set("project_id", 3);
      * $entry->set("task_id", 14);
      * $entry->set("spent_at", "Tue, 17 Oct 2006");
      *
      * $api = new HarvestApi();
      *
      * $result = $api->startNewTimer($entry);
      * if ($result->isSuccess()) {
      *     $timer = $result->data;
      * }
      * </code>
      *
      * @param DayEntry $entry Day Entry
      * @return Result
      */
    public function startNewTimer(DayEntry $entry)
    {
        $entry->set("hours", " ");
        $url = "daily/add";

        return $this->performPost($url, $entry->toXML(), false);
    }

    /**
     * delete an entry
     *
     * <code>
     * $entry_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->deleteEntry($entry_id);
     * if ($result->isSuccess()) {
     *     //success logic
     * }
     * </code>
     *
     * @param $entry_id    DayEntry Identifier
     * @return Result
     */
    public function deleteEntry($entry_id)
    {
        $url = "daily/delete/" . $entry_id;

        return $this->performDelete($url);
    }

     /**
      * update an entry
      *
      * <code>
      * $entry = new DayEntry();
      * $entry->set("id" 11111);
      * $entry->set("notes", "Test Support");
      * $entry->set("hours", 3);
      * $entry->set("project_id", 3);
      * $entry->set("task_id", 14);
      * $entry->set("spent_at", "Tue, 17 Oct 2006");
      *
      * $api = new HarvestApi();
      *
      * $result = $api->updateEntry($entry);
      * if ($result->isSuccess()) {
      *     // success logic
      * }
      * </code>
      *
      * @param DayEntry $entry Day Entry
      * @return Result
      */
    public function updateEntry(DayEntry $entry)
    {
        $url = "daily/update/$entry->id";

        return $this->performPost($url, $entry->toXML());
    }

    /*--------------------------------------------------------------*/
    /*------------------------- Client API -------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all clients
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getClients();
     * if ($result->isSuccess()) {
     *     $clients = $result->data;
     * }
     * </code>
     *
     * @param  mixed  $updated_since DateTime
     * @return Result
     */
    public function getClients($updated_since = null)
    {
        $url = "clients" . $this->appendUpdatedSinceParam($updated_since);

        return $this->performGet($url, true);
    }

    /**
     * get a single client
     *
     * <code>
     * $client_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->getClient($client_id);
     * if ($result->isSuccess()) {
     *     $client = $result->data;
     * }
     * </code>
     *
     * @param  int    $client_id Client Identifier
     * @return Result
     */
    public function getClient($client_id)
    {
        $url = "clients/$client_id";

        return $this->performGet($url, false);
    }

    /**
     * create new client
     *
     * <code>
     * $client = new Client();
     * $client->set("name", "Company LLC");
     * $client->set("details", "Company Details");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createClient($client);
     * if ($result->isSuccess()) {
     *     // get id of created client
     *     $client_id = $result->data;
     * }
     * </code>
     *
     * @param  Client $client Client
     * @return Result
     */
    public function createClient(Client $client)
    {
        $url = "clients";

        return $this->performPost($url, $client->toXML());
    }

    /**
     * update a client
     *
     * <code>
     * $client = new Client();
     * $client->set("id", 11111);
     * client->set("name", "Company LLC");
     * $client->set("details", "New Company Details");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateClient($client);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  Client $client Client
     * @return Result
     */
    public function updateClient(Client $client)
    {
        $url = "clients/$client->id";

        return $this->performPut($url, $client->toXML());
    }

     /**
      * activate / deactivate a client
      *
      * <code>
      * $client_id = 11111;
      * $api = new HarvestApi();
      * $result = $api->toggleClient($client_id);
      * if ($result->isSuccess()) {
      *     // addtional logic
      * }
      * </code>
      *
      * @param string $client_id
      * @return Result
      * @internal param client_id $int Client Identifier
      */
    public function toggleClient($client_id)
    {
        $url = "clients/$client_id/toggle";

        return $this->performPut($url, "");
    }

    /**
     * delete a client
     *
     * <code>
     * $client_id = 11111;
     * $api = new HarvestApi();
     * $result = $api->deleteClient($client_id);
     * if ($result->isSuccess()) {
     *      // additional logic
     * }
     * </code>
     *
     * @param  int    $client_id Client Identifier
     * @return Result
     */
    public function deleteClient($client_id)
    {
        $url = "clients/$client_id";

        return $this->performDelete($url);
    }

    /*--------------------------------------------------------------*/
    /*---------------------- Client Contacts API -------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all contacts for an account
     *
     * <code>
     * $api = new HarvestApi();
     * $result = $api->getContacts();
     * if ($result->isSuccess()) {
     *     $contacts = $result->data;
     * }
     * </code>
     *
     * @param  mixed  $updated_since DateTime
     * @return Result
     */
    public function getContacts($updated_since = null)
    {
        $url = "contacts" . $this->appendUpdatedSinceParam($updated_since);

        return $this->performGet($url, true);

    }

    /**
     * get all contacts for a client
     *
     * <code>
     * $client_id = 11111;
     * $api = new HarvestApi();
     * $result = $api->getClientContacts($client_id);
     * if ($result->isSuccess()) {
     *     $contacts = $result->data;
     * }
     * </code>
     *
     * @param  int    $client_id Client Identifier
     * @return Result
     */
    public function getClientContacts($client_id)
    {
        $url = "clients/$client_id/contacts";

        return $this->performGet($url, true);
    }

    /**
     * get a client contact
     *
     * <code>
     * $contact_id = 11111;
     * $api = new HarvestApi();
     * $result = $api->getContact($contact_id);
     * if ($result->isSuccess()) {
     *     $contact = $result->data;
     * }
     * </code>
     *
     * @param  int    $contact_id Contact Identifier
     * @return Result
     */
    public function getContact($contact_id)
    {
        $url = "contacts/$contact_id";

        return $this->performGet($url, false);
    }

    /**
     * create new contact
     *
     * <code>
     * $contact = new Contact();
     * $contact->set("first-name", "Jane");
     * $contact->set("last-name", "Doe");
     * $contact->set("email", "jd@email.com");
     * $contact->set("client-id", 12345);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createContact($Contact);
     * if ($result->isSuccess()) {
     *     // get id of created contact
     *     $contact_id = $result->data;
     * }
     * </code>
     *
     * @param  Contact $contact Contact
     * @return Result
     */
    public function createContact(Contact $contact)
    {
        $url = "contacts";

        return $this->performPost($url, $contact->toXML());
    }

    /**
     * update a contact
     *
     * <code>
     * $contact = new Contact();
     * $contact->set("id", 11111);
     * $contact->set("first-name", "John");
     * $contact->set("last-name", "Smith");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateContact($contact);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  Contact $contact Contact
     * @return Result
     */
    public function updateContact(Contact $contact)
    {
        $url = "contacts/$contact->id";

        return $this->performPut($url, $contact->toXML());
    }

     /**
      * delete a contact
      *
      * <code>
      * $contact_id = 11111;
      * $api = new HarvestApi();
      *
      * $result = $api->deleteContact($contact_id);
      * if ($result->isSuccess()) {
      *      // additional logic
      * }
      * </code>
      *
      * @param string $contact_id
      * @return Result
      * @internal param int $contact_Id Contact Identifier
      */
    public function deleteContact($contact_id)
    {
        $url = "contacts/$contact_id";

        return $this->performDelete($url);
    }

    /*--------------------------------------------------------------*/
    /*----------------------- Projects API -------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all projects
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getProjects();
     * if ($result->isSuccess()) {
     *     $projects = $result->data;
     * }
     * </code>
     *
     * @param  mixed  $updated_since DateTime
     * @return Result
     */
    public function getProjects($updated_since = null)
    {
        $url = "projects" . $this->appendUpdatedSinceParam($updated_since);

        return $this->performGet($url, true);
    }

    /**
     * get all projects of a client
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getClientProjects();
     * if ($result->isSuccess()) {
     *     $projects = $result->data;
     * }
     * </code>
     *
     * @param  int    $client_id Client Identifier
     * @return Result
     */
    public function getClientProjects($client_id)
    {
        $url = "projects?client=$client_id";

        return $this->performGet($url, true);
    }

    /**
     * get a single project
     *
     * <code>
     * $project_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->getProject($project_id);
     * if ($result->isSuccess()) {
     *     $project = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @return Result
     */
    public function getProject($project_id)
    {
        $url = "projects/$project_id";

        return $this->performGet($url, false);
    }

    /**
     * create new project
     *
     * <code>
     * $project = new Project();
     * $project->set("name", "New Project");
     * $project->set("client-id", 11111);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createProject($project);
     * if ($result->isSuccess()) {
     *     // get id of created project
     *     $project_id = $result->data;
     * }
     * </code>
     *
     * @param  Project $project Project
     * @return Result
     */
    public function createProject(Project $project)
    {
        $url = "projects";

        return $this->performPost($url, $project->toXML());
    }

    /**
     * update a Project
     *
     * <code>
     * $project = new Project();
     * $project->set("id", 12345);
     * $project->set("name", "New Project");
     * $project->set("client-id", 11111);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateProject($project);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  Project $project Project
     * @return Result
     */
    public function updateProject(Project $project)
    {
        $url = "projects/$project->id";

        return $this->performPut($url, $project->toXML());
    }

    /**
     * activate / deactivate a project
     *
     * <code>
     * $project_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->toggleProject($project_id);
     * if ($result->isSuccess()) {
     *     // addtional logic
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @return Result
     */
    public function toggleProject($project_id)
    {
        $url = "projects/$project_id/toggle";

        return $this->performPut($url, "");
    }

    /**
     * delete a project
     *
     * <code>
     * $project_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->deleteProject($project_id);
     * if ($result->isSuccess()) {
     *      // additional logic
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @return Result
     */
    public function deleteProject($project_id)
    {
        $url = "projects/$project_id";

        return $this->performDelete($url);
    }

    /*--------------------------------------------------------------*/
    /*-------------------------- Tasks API -------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all tasks
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getTasks();
     * if ($result->isSuccess()) {
     *     $tasks = $result->data;
     *  }
     * </code>
     *
     * @return Result
     */
    public function getTasks()
    {
        $url = "tasks";

        return $this->performGet($url, true);
    }

    /**
     * get a single task
     *
     * <code>
     * $task_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->getTask($task_id);
     * if ($result->isSuccess()) {
     *    $task = $result->data;
     * }
     * </code>
     *
     * @param  int    $task_id Task Identifier
     * @return Result
     */
    public function getTask($task_id)
    {
        $url = "tasks/$task_id";

        return $this->performGet($url, false);
    }

    /**
     * create new task
     *
     * <code>
     * $task = new Task();
     * $task->set("name", "Task Name");
     * $task->set("billable-by-default", true);
     * $task->set("default-hourly-rate", 65.50);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createTask($task);
     * if ($result->isSuccess()) {
     *     // get id of created task
     *     $task_id = $result->data;
     * }
     * </code>
     *
     * @param  Task   $task Task
     * @return Result
     */
    public function createTask(Task $task)
    {
        $url = "tasks";

        return $this->performPost($url, $task->toXML());
    }

    /**
     * update a Task
     *
     * <code>
     * $task = new Task();
     * $task->set("id", 12345);
     * $task->set("name", "New Task name");
     * $task->set("default-hourly-rate", 73.00);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateTask($task);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  Task   $task Task
     * @return Result
     */
    public function updateTask(Task $task)
    {
        $url = "tasks/$task->id";

        return $this->performPut($url, $task->toXML());
    }

    /**
     * delete a task
     *
     * <code>
     * $task_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->deleteTask($task_id);
     * if ($result->isSuccess()) {
     *      // additional logic
     * }
     * </code>
     *
     * @param  int    $task_id Task Identifier
     * @return Result
     */
    public function deleteTask($task_id)
    {
        $url = "tasks/$task_id";

        return $this->performDelete($url);
    }

    /*--------------------------------------------------------------*/
    /*------------------------- People API -------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all users
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getUsers();
     * if ($result->isSuccess()) {
     *     $users = $result->data;
     * }
     * </code>
     *
     * @return Result
     */
    public function getUsers()
    {
        $url = "people";

        return $this->performGet($url, true);
    }

    /**
     * get a user
     *
     * <code>
     * $user_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->getUser($user_id);
     * if ($result->isSuccess()) {
     *     $user = $result->data;
     * }
     * </code>
     *
     * @param  int    $user_id User Identifier
     * @return Result
     */
    public function getUser($user_id)
    {
        $url = "people/$user_id";

        return $this->performGet($url, false);
    }

    /**
     * create new user
     *
     * <code>
     * $user = new User();
     * $user->set('first_name', "Matthew");
     * $user->set('last_name', "Denton");
     * $user->set('email', "test@example.com");
     * $user->set('password', 'password');
     * $user->set('password_confirmation', 'password_confirmation');
     * $user->set('timezone', TimeZone::EASTERN_TIME);
     * $user->set('is_admin', false);
     * $user->set('telephone', '555-2345');
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createUser($user);
     * if ($result->isSuccess()) {
     *     // get id of created user
     *     $user_id = $result->data;
     * }
     * </code>
     *
     * @param  User   $user User
     * @return Result
     */
    public function createUser(User $user)
    {
        $url = "people";

        return $this->performPost($url, $user->toXML());
    }

    /**
     * update a User
     *
     * <code>
     * $user = new User();
     * $user->set("id", 12345);
     * $user->set("first_name", "Matthew");
     * $user->set("last_name", "Denton");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateUser($user);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  User   $user User
     * @return Result
     */
    public function updateUser(User $user)
    {
        $url = "people/$user->id";

        return $this->performPut($url, $user->toXML());
    }

    /**
     * archive / activate a user
     *
     * <code>
     * $user_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->toggleUser($user_id);
     * if ($result->isSuccess()) {
     *     // addtional logic
     * }
     * </code>
     *
     * @param  int    $user_id User Identifier
     * @return Result
     */
    public function toggleUser($user_id)
    {
        $url = "people/$user_id/toggle";

        return $this->performPut($url, "");
    }

    /**
     * reset User's password
     *
     * <code>
     * $user_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->resetUserPassword($user_id);
     * if ($result->isSuccess()) {
     *     //additional logic
     * }
     * </code>
     *
     * @param  int    $user_id User Identifier
     * @return Result
     */
    public function resetUserPassword($user_id)
    {
        $url = "people/$user_id/reset_password";

        return $this->performPut($url, "");
    }

    /**
     * delete a user
     *
     * <code>
     * $user_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->deleteuser($user_id);
     * if ($result->isSuccess()) {
     *      // additional logic
     * }
     * </code>
     *
     * @param  int    $user_id User Identifier
     * @return Result
     */
    public function deleteUser($user_id)
    {
        $url = "people/" . $user_id;

        return $this->performDelete($url);
    }

    /*--------------------------------------------------------------*/
    /*------------------------ Expenses API ------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all expense categories
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getExpenseCategories();
     * if ($result->isSuccess()) {
     *     $expenseCategories = $result->data;
     * }
     * </code>
     *
     * @return Result
     */
    public function getExpenseCategories()
    {
        $url = "expense_categories";

        return $this->performGet($url, true);
    }

    /**
     * create new expense category
     *
     * <code>
     * $expenseCategory = new ExpenseCategory();
     * $expenseCategory->set('name', "Mileage");
     * $expenseCategory->set('unit-name', "Miles");
     * $expenseCategory->set('unit-price', "0.485");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createExpenseCategory($expenseCategory);
     * if ($result->isSuccess()) {
     *     // get id of created expense category
     *     $expenseCategory_id = $result->data;
     * }
     * </code>
     *
     * @param  ExpenseCategory $expenseCategory Expense Category
     * @return Result
     */
    public function createExpenseCategory(ExpenseCategory $expenseCategory)
    {
        $url = "expense_categories";

        return $this->performPost($url, $expenseCategory->toXML());
    }

    /**
     * update an Expense Category
     *
     * <code>
     * $expenseCategory= new ExpenseCategory();
     * $expenseCategory->set("id", 12345);
     * $expenseCategory->set("unit-name", "Kilometers");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateExpenseCategory($expenseCategory);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  ExpenseCategory $expenseCategory Expense Category
     * @return Result
     */
    public function updateExpenseCategory(ExpenseCategory $expenseCategory)
    {
        $url = "expesnse_categories/$expenseCategory->id";

        return $this->performPut($url, $expenseCategory->toXML());
    }

    /**
     * delete an expense category
     *
     * <code>
     * $expenseCategory_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->deleteExpenseCategory($expenseCategory_id);
     * if ($result->isSuccess()) {
     *      // additional logic
     * }
     * </code>
     *
     * @param  int    $expense_category_id Expense Category Identifier
     * @return Result
     */
    public function deleteExpenseCategory($expense_category_id)
    {
        $url = "expense_categories/$expense_category_id";

        return $this->performDelete($url);
    }

    /*--------------------------------------------------------------*/
    /*-------------------- Expenses Tracking API -------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get expense
     *
     * <code>
     * $expense_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->getExpense($expense_id);
     * if ($result->isSuccess()) {
     *     $expense = $result->data;
     * }
     * </code>
     *
     * @param  int    $expense_id Expense Identifier
     * @return Result
     */
    public function getExpense($expense_id)
    {
        $url = "expenses/$expense_id";

        return $this->performGet($url, false);
    }

    /**
     * create new expense
     *
     * <code>
     * // Total Cost
     * $expense = new Expense();
     * $expense->set("notes", "Office Supplies");
     * $expense->set("total_cost", 18.97);
     * $expense->set("project_id", 12345);
     * $expense->set("expense_category_id", 1);
     * $expense->set("spent_at", "Sun, 10 Feb 2008");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateExpense($expense);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     *
     * // Unit Based
     * $expense = new Expense();
     * $expense->set("notes", "Drive to Rochester");
     * $expense->set("units", 33);
     * $expense->set("project_id", 12345);
     * $expense->set("expense_category_id", 2);
     * $expense->set("spent_at", "Sun, 10 Feb 2008");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateExpense($expense);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  Expense $expense Expense
     * @return Result
     */
    public function createExpense(Expense $expense)
    {
        $url = "expenses";

        return $this->performPost($url, $expense->toXML());
    }

    /**
     * update an Expense
     *
     * <code>
     * // Total Cost
     * $expense = new Expense();
     * $expense->set("id", 12345);
     * $expense->set("notes", "Office Supplies");
     * $expense->set("total_cost", 18.97);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateExpense($expense);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     *
     * // Unit Based
     * $expense = new Expense();
     * $expense->set("id", 12346);
     * $expense->set("notes", "Drive to Rochester");
     * $expense->set("units", 33);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateExpense($expense);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  Expense $expense Expense
     * @return Result
     */
    public function updateExpense(Expense $expense)
    {
        $url = "expenses/$expense->id";

        return $this->performPut($url, $expense->toXML());
    }

    /**
     * delete an expense
     *
     * <code>
     * $expense_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->deleteExpense($expense_id);
     * if ($result->isSuccess()) {
     *      // additional logic
     * }
     * </code>
     *
     * @param  int    $expense_id Expense Identifier
     * @return Result
     */
    public function deleteExpense($expense_id)
    {
        $url = "expenses/" . $expense_id;

        return $this->performDelete($url);
    }

    /**
     * Get a receipt image associated with an expense
     *
     * <code>
     * $expense_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getReceipt($expense_id);
     * if ($result->isSuccess()) {
     *     echo $result->data;
     * }
     * </code>
     *
     * @param $expense_id Expense Identifier
     * @return Result
     */
    public function getReceipt($expense_id)
    {
        $url = "expenses/$expense_id/receipt";

        return $this->performGet($url, "raw");
    }

    /**
     * Attach a receipt image to an expense
     *
     * <code>
     * $expense_id = 12345;
     * $image_url = "test.jpg"
     *
     * $api = new HarvestApi();
     *
     * $result = $api->attachReceipt($expense_id, $image_url);
     * if ($result->isSuccess()) {
     *     // success logic
     * }
     * </code>
     *
     * @param Expense $expense_id Identifier
     * @param string $image_url Image URL
     * @return Result
     */
    public function attachReceipt($expense_id, $image_url)
    {
        $url = "expenses/$expense_id/receipt";
        $data = array();
        $data["expense[receipt]"] = "@$image_url";

        return $this->performMultiPart($url, $data);
    }

    /*--------------------------------------------------------------*/
    /*--------------------- User Assignment API --------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all user assignments to a given project
     *
     * <code>
     * $project_id = 12345;
     * $api = new HarvestApi();
     *
     * $result = $api->getProjectUserAssignments($project_id);
     * if ($result->isSuccess()) {
     *     $users = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @return Result
     */
    public function getProjectUserAssignments($project_id)
    {
        $url = "projects/$project_id/user_assignments";

        return $this->performGet($url, true);
    }

    /**
     * get a user assignment
     *
     * <code>
     * $project_id = 11111;
     * $userAssignment_id = 12345;
     * $api = new HarvestApi();
     *
     * $result = $api->getProjectUserAssignment($project_id, $userAssignment_id);
     * if ($result->isSuccess()) {
     *     $userAssignment = $result->data;
     * }
     * </code>
     *
     * @param  int            $project_id         Project Identifier
     * @param  int            $user_assignment_id User Assignment Identifier
     * @return UserAssignment
     */
    public function getProjectUserAssignment($project_id, $user_assignment_id)
    {
        $url = "projects/$project_id/user_assignments/$user_assignment_id";

        return $this->performGet($url, false);
    }

    /**
     * create new Project User Assignment
     *
     * <code>
     * $project_id = 12345;
     * $user_id = 23456;
     *
     * $api = new HarvestApi();
     *
     * $api->assignUserToProject($project_id, $user_id);
     * if ($result->isSuccess()) {
     *     // get userassignment id
     *     $user_assignment_id = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @param  int    $user_id    User Identifier
     * @return Result
     */
    public function assignUserToProject($project_id, $user_id)
    {
        $url = "projects/$project_id/user_assignments";

        return $this->performPost($url, "<user><id>$user_id</id></user>");
    }

    /**
     * delete a Project User Assignment
     *
     * <code>
     * $project_id = 12345;
     * $userAssignment_id = 23456;
     *
     * $api = new HarvestApi();
     *
     * $api->removeUserFromProject($project_id, $userAssignment_id);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  int    $project_id         Project Identifier
     * @param  int    $user_assignment_id User Assignment Identifier
     * @return Result
     */
    public function removeUserFromProject($project_id, $user_assignment_id)
    {
        $url = "projects/$project_id/user_assignments/$user_assignment_id";

        return $this->performDelete($url);
    }

    /**
     * update a Project User Assignment
     *
     * <code>
     * $userAssignment = new UserAssignment();
     * $userAssignment->set("id", 22222);
     * $userAssignment->set("user-id", 11111);
     * $userAssignment->set("project-id", 12345);
     * $userAssignment->set("deactivated", true);
     * $userAssignment->set("hourly-rate", 74.50);
     * $userAssignment->set("is-project-manager", false);
     *
     * $api = new HarvestApi();
     *
     * $api->updateProjectUserAssignment($userAssignment);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  UserAssignment $userAssignment UserAssignment
     * @return Result
     */
    public function updateProjectUserAssignment(UserAssignment $userAssignment)
    {
        $url = "projects/" . $userAssignment->get("project-id") . "/user_assignments/" . $userAssignment->get("id");

        return $this->performPut($url, $userAssignment->toXML());
    }

    /*--------------------------------------------------------------*/
    /*--------------------- Task Assignment API --------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all task assignments to a given project
     *
     * <code>
     * $project_id = 12345;
     * $api = new HarvestApi();
     *
     * $result = $api->getProjectTaskAssignments($project_id);
     * if ($result->isSuccess()) {
     *     $taskAssignments = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @return Result
     */
    public function getProjectTaskAssignments($project_id)
    {
        $url = "projects/$project_id/task_assignments";

        return $this->performGet($url, true);
    }

    /**
     * get a task assignment
     *
     * <code>
     * $project_id = 11111;
     * $taskAssignment_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getProjectTaskAssignment($project_id, $taskAssignment_id);
     * if ($result->isSuccess()) {
     *     $taskAssignment = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id         Project Identifier
     * @param  int    $task_assignment_id Task Assignment Identifier
     * @return Result
     */
    public function getProjectTaskAssignment($project_id, $task_assignment_id)
    {
        $url = "projects/$project_id/task_assignments/$task_assignment_id";

        return $this->performGet($url, false);
    }

    /**
     * assign a task to a project
     *
     * <code>
     * $project_id = 12345;
     * $task_id = 23456;
     *
     * $api = new HarvestApi();
     *
     * $api->assignTaskToProject($project_id, $task_id);
     * if ($result->isSuccess()) {
     *     // get taskAssignment id
     *     $task_assignment_id = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @param  int    $task_id    Task Identifier
     * @return Result
     */
    public function assignTaskToProject($project_id, $task_id)
    {
        $url = "projects/$project_id/task_assignments";

        return $this->performPost($url, "<task><id>$task_id</id></task>");
    }

    /**
     * create a new task for a project
     *
     * <code>
     * $project_id = 11111;
     * $task = new Task();
     * $task->set("name", "Task Name");
     *
     * $api = new HarvestApi();
     *
     * $api->createProjectTaskAssignment($project_id, $task);
     * if ($result->isSuccess()) {
     *     // get taskAssignment id
     *     $task_assignment_id = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @param  Task   $task       Task
     * @return Result
     */
    public function createProjectTaskAssignment($project_id, Task $task)
    {
        $url = "projects/$project_id/task_assignments/add_with_create_new_task";

        return $this->performPost($url, $task->toXML());
    }

    /**
     * delete Project Task assignment
     *
     * <code>
     * $project_id = 12345;
     * $taskAssignment_id = 23456;
     *
     * $api = new HarvestApi();
     *
     * $api->deleteProjectTaskAssignment($project_id, $taskAssignment_id);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  int    $project_id         Project Identifier
     * @param  int    $task_assignment_id Task Assignment Identifier
     * @return Result
     */
    public function deleteProjectTaskAssignment($project_id, $task_assignment_id)
    {
        $url = "projects/$project_id/task_assignments/$task_assignment_id";

        return $this->performDelete($url);
    }

    /**
     * update a Project Task Assignment
     *
     * <code>
     * $taskAssignment = new TaskAssignment();
     * $taskAssignment->set("id", 67849);
     * $taskAssignment->set("project-id", 12345);
     * $taskAssignment->set("deactivated", false);
     * $taskAssignment->set("hourly-rate", 74.50);
     *
     * $api = new HarvestApi();
     *
     * $api->updateProjectTaskAssignment($taskAssignment);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  TaskAssignment $taskAssignment Task Assignment
     * @return Result
     */
    public function updateProjectTaskAssignment(TaskAssignment $taskAssignment)
    {
        $url = "projects/" . $taskAssignment->get("project-id") . "/task_assignments/" . $taskAssignment->get("id");

        return $this->performPut($url, $taskAssignment->toXML());
    }

    /*--------------------------------------------------------------*/
    /*------------------------- Reports API ------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all project entries for given time range for a particular user if specified
     *
     * <code>
     * $range = new Range("20090712", "20090719");
     * $project_id = 12345;
     * $user_id = 11111;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getProjectEntries($project_id, $range, $user_id);
     * if ($result->isSuccess()) {
     *     $dayEntries = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @param  Range  $range      Time Range
     * @param  int    $user_id    User identifier optional
     * @return Result
     */
    public function getProjectEntries($project_id, Range $range, $user_id = null)
    {
        $url = "projects/" . $project_id . "/entries?from=" . $range->from() . '&to=' . $range->to();
        if (! is_null($user_id)) {
            $url .= "&user_id=" . $user_id;
        }

        return $this->performGet($url, true);
    }

    /**
     * get all user entries for given time range and for a particular project if specified
     *
     * <code>
     * $range = new Range("20090712", "20090719");
     * $project_id = 12345;
     * $user_id = 11111;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getUserEntries($user_id, $range, $project_id);
     * if ($result->isSuccess()) {
     *     $dayEntries = $result->data;
     * }
     * </code>
     *
     * @param  int    $user_id    User Identifier
     * @param  Range  $range      Time Range
     * @param  int    $project_id Project identifier optional
     * @return Result
     */
    public function getUserEntries($user_id, Range $range, $project_id = null)
    {
        $url = "people/" . $user_id . "/entries?from=" . $range->from() . '&to=' . $range->to();
        if (! is_null($project_id)) {
            $url .= "&project_id=" . $project_id;
        }

        return $this->performGet($url, true);
    }

    /**
     * get all user expenses for given time range
     *
     * <code>
     * $range = new Range("20090712", "20090719");
     * $user_id = 11111;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getUserExpenses($user_id, $range);
     * if ($result->isSuccess()) {
     *     $expenses = $result->data;
     * }
     * </code>
     *
     * @param  int    $user_id User Identifier
     * @param  Range  $range   Time Range
     * @return Result
     */
    public function getUserExpenses($user_id, Range $range)
    {
        $url = "people/" . $user_id . "/expenses?from=" . $range->from() . '&to=' . $range->to();

        return $this->performGet($url, true);
    }

    /*--------------------------------------------------------------*/
    /*------------------------ Invoices API ------------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all invoices
     *
     * <code>
     * $filter = new Filter();
     * $filter->set("status", Filter::UNPAID);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getInvoice($filter);
     * if ($result->isSuccess()) {
     *     $invoices = $result->data;
     * }
     * </code>
     *
     * @param  Filter $filter Filter Options
     * @return Result
     */
    public function getInvoices(Filter $filter = null)
    {
        $url = "invoices";
        if (! is_null($filter)) {
            $url .= $filter->toURL();
        }

        return $this->performGet($url, true);
    }

    /**
     * get a specific invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getInvoice($invoice_id);
     * if ($result->isSuccess()) {
     *     $invoice = $result->data;
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @return Result
     */
    public function getInvoice($invoice_id)
    {
        $url = "invoices/" . $invoice_id;

        return $this->performGet($url, false);
    }

    /**
     * create new invoice
     *
     * <code>
     * $invoice = new Invoice();
     * $invoice->set("client-id", 11111);
     * $invoice->set("notes", "Some Notes");
     * // set other values
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createInvoice($invoice);
     * if ($result->isSuccess()) {
     *     // get invoice id
     *     $id = $result->data;
     * }
     * </code>
     *
     * @param  Invoice $invoice Invoice
     * @return Result
     */
    public function createInvoice(Invoice $invoice)
    {
        $url = "invoices";

        return $this->performPost($url, $invoice->toXML());
    }

    /**
     * update an Invoice
     *
     * <code>
     * $invoice = new Invoice();
     * $invoice->set("id", 12345);
     * $invoice->set("notes", "Some Notes");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateInvoice($invoice);
     * if ($result->isSuccess()) {
     *     // success logic
     * }
     * </code>
     *
     * @param  Invoice $invoice Invoice
     * @return Result
     */
    public function updateInvoice(Invoice $invoice)
    {
        $url = "invoices/" . $invoice->get("id");

        return $this->performPut($url, $invoice->toXML());
    }

    /**
     * delete an Invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->deleteInvoice($invoice_id);
     * if ($result->isSuccess()) {
     *     // success logic
     * }
     * </code>
     *
     * @param  $invoice_id int Invoice Identifier
     * @return Result
     */
    public function deleteInvoice($invoice_id)
    {
        $url = "invoices/" . $invoice_id;

        return $this->performDelete($url);
    }

    /**
     * close invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->closeInvoice($invoice_id);
     * if ($result->isSuccess()) {
     *     // success logic
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @return Result
     */
    public function closeInvoice($invoice_id)
    {
        $url = "invoices/$invoice_id/mark_as_closed";

        return $this->performPut($url, null);
    }

    /**
     * alias for close invoice
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->markOffInvoice($invoice_id);
     * if ($result->isSuccess()) {
     *     // success logic
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @return Result
     */
    public function markOffInvoice($invoice_id)
    {
        return $this->closeInvoice($invoice_id);
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
     * $api = new HarvestApi();
     *
     * $result = $api->getInvoiceMessages($invoice_id);
     * if ($result->isSuccess()) {
     *     $invoiceMessages = $result->data;
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @return Result
     */
    public function getInvoiceMessages($invoice_id)
    {
        $url = "invoices/" . $invoice_id . "/messages";

        return $this->performGet($url, true);
    }

    /**
     * get a particular invoice message
     *
     * <code>
     * $invoice_id = 12345;
     * $message_id = 11111;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getInvoiceMessage($invoice_id, $message_id);
     * if ($result->isSuccess()) {
     *     $invoiceMessage = $result->data;
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @param  int    $message_id Message Identifier
     * @return Result
     */
    public function getInvoiceMessage($invoice_id, $message_id)
    {
        $url = "invoices/" . $invoice_id . "/messages/" . $message_id;

        return $this->performGet($url, false);
    }

    /**
     * Send an invoice with message
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $message = new InvoiceMessage();
     * $message->set("body", "The Message");
     * $message->set("recipients", "test@example.com");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->sendInvoiceMessage($invoice_id, $message);
     * if ($result->isSuccess()) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     *
     * @param  int            $invoice_id Invoice Identifier
     * @param  InvoiceMessage $message    Invoice Message
     * @return Result
     */
    public function sendInvoiceMessage($invoice_id, InvoiceMessage $message)
    {
        $url = "invoices/$invoice_id/messages";

        return $this->performPost($url, $message->toXML());
    }

    /**
     * delete an Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     * $message_id = 11111;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->deleteInvoiceMessage($invoice_id, $message_id);
     * if ($result->isSuccess()) {
     *     // success logic
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @param  int    $message_id Invoice Message Identifier
     * @return Result
     */
    public function deleteInvoiceMessage($invoice_id, $message_id)
    {
        $url = "invoices/$invoice_id/messages/$message_id";

        return $this->performDelete($url);
    }

    /**
     * create Sent Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $message = new InvoiceMessage();
     * $message->set("body", "The Message");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createSentInvoiceMessage($invoice_id, $message);
     * if ($result->isSuccess()) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     *
     * @param  int            $invoice_id Invoice Identifier
     * @param  InvoiceMessage $message    Invoice Message
     * @return Result
     */
    public function createSentInvoiceMessage($invoice_id, InvoiceMessage $message)
    {
        $url = "invoices/$invoice_id/messages/mark_as_sent";

        return $this->performPost($url, $message->toXML());
    }

    /**
     * create Closed Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $message = new InvoiceMessage();
     * $message->set("body", "The Message");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createClosedInvoiceMessage($invoice_id, $message);
     * if ($result->isSuccess()) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     *
     * @param  int            $invoice_id Invoice Identifier
     * @param  InvoiceMessage $message    Invoice Message
     * @return Result
     */
    public function createClosedInvoiceMessage($invoice_id, InvoiceMessage $message)
    {
        $url = "invoices/$invoice_id/messages/mark_as_closed";

        return $this->performPost($url, $message->toXML());
    }

    /**
     * Create re-open Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $message = new InvoiceMessage();
     * $message->set("body", "The Message");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createReOpenInvoiceMessage($invoice_id, $message);
     * if ($result->isSuccess()) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     *
     * @param  int            $invoice_id Invoice Identifier
     * @param  InvoiceMessage $message    Invoice Message
     * @return Result
     */
    public function createReOpenInvoiceMessage($invoice_id, InvoiceMessage $message)
    {
        $url = "invoices/$invoice_id/messages/re_open";

        return $this->performPost($url, $message->toXML());
    }

    /**
     * create mark-as-draft Invoice Message
     *
     * <code>
     * $invoice_id = 12345;
     *
     * $message = new InvoiceMessage();
     * $message->set("body", "The Message");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createMarkAsDraftInvoiceMessage($invoice_id, $message);
     * if ($result->isSuccess()) {
     *     // invoice message id
     *     $id = $result->data;
     * }
     * </code>
     *
     * @param  int            $invoice_id Invoice Identifier
     * @param  InvoiceMessage $message    Invoice Message
     * @return Result
     */
    public function createMarkAsDraftInvoiceMessage($invoice_id, InvoiceMessage $message)
    {
        $url = "invoices/$invoice_id/messages/mark_as_draft";

        return $this->performPost($url, $message->toXML());
    }

    /*--------------------------------------------------------------*/
    /*-------------------- Invoice Payments API --------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all recorded payments for an invoice
     *
     * <code>
     * $api = new HarvestApi();
     * $invoice_id = 1111;
     *
     * $result = $api->getInvoicePayments($invoice_id);
     * if ($result->isSuccess()) {
     *     $invoicePayments = $result->data;
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @return Result
     */
    public function getInvoicePayments($invoice_id)
    {
        $url = "invoices/$invoice_id/payments";

        return $this->performGet($url, true);
    }

    /**
     * get a particular Invoice Payment
     *
     * <code>
     * $invoice_id = 12345;
     * $payment_id = 11111;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->getInvoicePayment($invoice_id, $payment_id);
     * if ($result->isSuccess()) {
     *     $payment = $result->data;
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @param  int    $payment_id Payment Identifier
     * @return Result
     */
    public function getInvoicePayment($invoice_id, $payment_id)
    {
        $url = "invoices/$invoice_id/payments/$payment_id";

        return $this->performGet($url, false);
    }

    /**
     * Create an Invoice Payment
     *
     * <code>
     * $payment = new Payment();
     * $payment->set("paid-at", "2008-02-14T00:00:00Z");
     * $payment->set("amount", 5400.00);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createInvoicePayment($payment);
     * if ($result->isSuccess()) {
     *     //get id of new Invoice Payment
     *     $id = $result->data;
     * }
     * </code>
     *
     * @param  int     $invoice_id Invoice Identifier
     * @param  Payment $payment    Payment
     * @return Result
     */
    public function createInvoicePayment($invoice_id, Payment $payment)
    {
        $url = "invoices/$invoice_id/payments";

        return $this->performPost($url, $payment->toXML());
    }

    /**
     * delete an Invoice Payment
     *
     * <code>
     * $invoice_id = 12345;
     * $payment_id = 12111;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->deleteInvoicePayment($invoice_id, $payment_id);
     * if ($result->isSuccess()) {
     *     //success logic
     * }
     * </code>
     *
     * @param  int    $invoice_id Invoice Identifier
     * @param  int    $payment_id Payment Identifier
     * @return Result
     */
    public function deleteInvoicePayment($invoice_id, $payment_id)
    {
        $url = "invoices/$invoice_id/payments/$payment_id";

        return $this->performDelete($url);
    }

    /*--------------------------------------------------------------*/
    /*------------------- Invoice Categories API -------------------*/
    /*--------------------------------------------------------------*/

    /**
     * get all invoice categories
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getInvoiceCategories();
     * if ($result->isSuccess()) {
     *     $invoiceCategories = $result->data;
     * }
     * </code>
     *
     * @return Result
     */
    public function getInvoiceCategories()
    {
        $url = "invoice_item_categories";

        return $this->performGet($url, true);
    }

    /**
     * Create an Invoice Category
     *
     * <code>
     * $invoiceCategory = new InvoiceItemCategory();
     * $invoiceCategory->set("name", "Entertainment");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createInvoiceCategory($invoiceCategory);
     * if ($result->isSuccess()) {
     *     //get id of new Invoice Category
     *     $id = $result->data;
     * }
     * </code>
     *
     * @param  InvoiceItemCategory $invoiceCategory Invoice Category
     * @return Result
     */
    public function createInvoiceCategory(InvoiceItemCategory $invoiceCategory)
    {
        $url = "invoice_item_categories";

        return $this->performPost($url, $invoiceCategory->toXML());
    }

    /**
     * Update an Invoice Category
     *
     * <code>
     * $invoiceCategory = new InvoiceItemCategory();
     * $invoiceCategory->set("id", 11111);
     * $invoiceCategory->set("name", "Entertainment");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateInvoiceCategory($invoiceCategory);
     * if ($result->isSuccess()) {
     *     //success logic
     * }
     * </code>
     *
     * @param  InvoiceItemCategory $invoiceCategory Invoice Category
     * @return Result
     */
    public function updateInvoiceCategory(InvoiceItemCategory $invoiceCategory)
    {
        $url = "invoice_item_categories/" . $invoiceCategory->get("id");

        return $this->performPut($url, $invoiceCategory->toXML());
    }

    /**
     * delete an Invoice Category
     *
     * <code>
     * $invoiceCategory_id = 12345;
     *
     * $api = new HarvestApi();
     *
     * $result = $api->deleteInvoiceCategory($invoiceCategory_id);
     * if ($result->isSuccess()) {
     *     //success logic
     * }
     * </code>
     *
     * @param  $invoiceCategory_id int Invoice Category Identifier
     * @return Result
     */
    public function deleteInvoiceCategory($invoiceCategory_id)
    {
        $url = "invoice_item_categories/$invoiceCategory_id";

        return $this->performDelete($url);
    }

    /*--------------------------------------------------------------*/
    /*----------------- API Access & Parse Methods -----------------*/
    /*--------------------------------------------------------------*/

     /**
      * generate the update_since query params
      * @param \DateTime $updated_since
      * @return string
      * @internal param mixed $update_since DateTime
      */
    public function appendUpdatedSinceParam($updated_since = null)
    {
        if (is_null($updated_since)) {
            return "";
        } elseif ($updated_since instanceOf \DateTime) {
            return '?updated_since=' . urlencode($updated_since->format("Y-m-d G:i"));
        } else {
            return '?updated_since=' . urlencode($updated_since);
        }
    }

    /**
     * perform http get command
     * @param  string $url   url of server to process request
     * @param  mixed  $multi Flag to specify if multiple items are returned by request
     * @return Result
     */
    protected function performGet($url, $multi = true)
    {
        $data = null;
        $code = null;
        $success = false;
        while (! $success) {
            $ch = $this->generateCurl($url);
            $data = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($this->_mode == HarvestApi::RETRY && $code == "503") {
                $success = false;
                sleep($this->_headers['Retry-After']);
            } else {
                $success = true;
            }
        }
        if ("2" == substr($code, 0, 1)) {
            if ($multi === true) {
                $data = $this->parseItems($data);
            } elseif ($multi == "raw") {
                //$data = $data;
            } else {
                $data = $this->parseItem($data);
            }
        }

        return new Result($code, $data, $this->_headers);
    }

    /**
     * generate cURL get request
     * @param string $url
     * @return resource cURL Handler
     */
    protected function generateCurl($url)
    {
        $this->resetHeader();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://" . $this->_account . ".harvestapp.com/" . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: PHP Wrapper Library for Harvest API', 'Accept: application/xml', 'Content-Type: application/xml', 'Authorization: Basic (' . base64_encode($this->_user . ":" . $this->_password). ')'));
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array(&$this,'parseHeader'));

        return $ch;
    }

    /**
     * perform http put command
     * @param  string $url  url of server to process request
     * @param  string $data data to be sent
     * @return Result
     */
    protected function performPut($url, $data)
    {
        $rData = null;
        $code = null;
        $success = false;
        while (! $success) {
            $ch = $this->generatePutCurl($url, $data);
            $rData = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($this->_mode == HarvestApi::RETRY && $code == "503") {
                $success = false;
                sleep($this->_headers['Retry-After']);
            } else {
                $success = true;
            }
        }

        return new Result($code, $rData, $this->_headers);
    }

     /**
      * generate cURL put request
      * @param $url
      * @param $data
      * @return resource
      */
    protected function generatePutCurl($url, $data)
    {
        $ch = $this->generateCurl($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        return $ch;
    }

     /**
      * perform http post command
      * @param  string $url url of server to process request
      * @param  string $data data to be sent
      * @param string $multi
      * @return Result
      */
    protected function performPost($url, $data, $multi = "id")
    {
        $rData = null;
        $code = null;
        $success = false;
        while (! $success) {
            $ch = $this->generatePostCurl($url, $data);
            $rData = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($this->_mode == HarvestApi::RETRY && $code == "503") {
                $success = false;
                sleep($this->_headers['Retry-After']);
            } else {
                $success = true;
            }
        }
        if ("2" == substr($code, 0, 1)) {
            if ($multi == "id" && isset($this->_headers["Location"])) {
                $rData = $this->_headers["Location"];
            } elseif ($multi === true) {
                $rData = $this->parseItems($rData);
            } elseif ($multi == "raw") {
                $rData = $data;
            } else {
                $rData = $this->parseItem($rData);
            }
        }

        return new Result($code, $rData, $this->_headers);
    }

    /**
     * generate cURL get request
     * @param $url
     * @param $data Array of Post Data
     * @return resource cURL Handler
     */
    protected function generatePostCurl($url, $data)
    {
        $ch = $this->generateCurl($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        return $ch;
    }

    /**
     * perform http delete command
     * @param  string $url url of server to process request
     * @return Result
     */
    protected function performDelete($url)
    {
        $data = null;
        $code = null;
        $success = false;
        while (! $success) {
            $ch = $this->generateDeleteCurl($url);
            $data = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($this->_mode == HarvestApi::RETRY && $code == "503") {
                $success = false;
                sleep($this->_headers['Retry-After']);
            } else {
                $success = true;
            }
        }

        return new Result($code, $data, $this->_headers);
    }

    /**
     * generate cURL get request
     * @param $url
     * @return resource cURL Handler
     */
    protected function generateDeleteCurl($url)
    {
        $ch = $this->generateCurl($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        return $ch;
    }

    /**
     * perform http post of MultiPart Form-Data
     *
     * @param  string $url  url of server to process request
     * @param  array  $data Associated Aray of form data
     * @return Result
     */
    protected function performMultiPart($url, $data)
    {
        $rData = null;
        $code = null;
        $success = false;
        while (! $success) {
            $ch = $this->generateMultiPartCurl($url, $data);
            $rData = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($this->_mode == HarvestApi::RETRY && $code == "503") {
                $success = false;
                sleep($this->_headers['Retry-After']);
            } else {
                $success = true;
            }
        }

        return new Result($code, $rData, $this->_headers);
    }

    /**
     * generate MultiPart/Form-Data request
     * @param $url
     * @param $data array of MultiPart Form Data
     * @return resource cURL Handler
     */
    protected function generateMultiPartCurl($url, $data)
    {
        $ch = $this->generateCurl($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: PHP Wrapper Library for Harvest API', 'Accept: application/xml', 'Content-Type: multipart/form-data', 'Authorization: Basic (' . base64_encode($this->_user . ":" . $this->_password). ')'));

        return $ch;
    }

    /**
     * parse XML list
     * @param  string $xml XML String
     * @return array
     */
    protected function parseItems($xml)
    {
        $items = array();
        $xmlDoc = new \DOMDocument();
        $xmlDoc->loadXML($xml);
        $x = $xmlDoc->documentElement;
        foreach ($x->childNodes AS $item) {
            $item = $this->parseNode($item);
            if (! is_null($item)) {
                $items[$item->id()] = $item;
            }
        }

        return $items;
    }

    /**
     * parse XML item
     * @param  string $xml XML String
     * @return mixed
     */
    protected function parseItem($xml)
    {
        $xmlDoc = new \DOMDocument();
        $xmlDoc->loadXML($xml);
        $itemNode = $xmlDoc->documentElement;

        return $this->parseNode($itemNode);
    }

    /**
     * parse xml node
     * @param  \DOMElement $node document element
     * @return mixed
     */
    protected function parseNode($node)
    {
        $item = null;
        switch ($node->nodeName) {
            case "expense-category":
                $item = new ExpenseCategory();
            break;
            case "client":
                $item = new Client();
            break;
            case "contact":
                $item = new Contact();
            break;
            case "add":
                $children = $node->childNodes;
                foreach ($children as $child) {
                    if ($child->nodeName == "day_entry") {
                        $node = $child;
                        break;
                    }
                }
            case "day_entry":
            case "day-entry":
                $item = new DayEntry();
            break;
            case "expense":
                $item = new Expense();
            break;
            case "invoice":
                $item = new Invoice();
            break;
            case "invoice-item-category":
                $item = new InvoiceItemCategory();
            break;
            case "invoice-message":
                $item = new InvoiceMessage();
            break;
            case "payment":
                $item = new Payment();
            break;
            case "project":
                $item = new Project();
            break;
            case "task":
                $item = new Task();
            break;
            case "user":
                $item = new User();
            break;
            case "user-assignment":
                $item = new UserAssignment();
            break;
            case "task-assignment":
                $item = new TaskAssignment();
            break;
            case "daily":
                $item = new DailyActivity();
            break;
            case "timer":
                $item = new Timer();
            break;
            case "hash":
                $item = new Throttle();
            break;
            default:
            break;
        }
        if (! is_null($item)) {
            $item->parseXml($node);
        }

        return $item;
    }

    /**
     * parse cURL Header text
     * @param  cURL-Handle $ch     cURL Handle
     * @param  string      $header Header line text to be parsed
     * @return int
     */
    protected function parseHeader($ch,$header)
    {
        $pos = strpos($header, ":");
        $key = substr($header, 0, $pos);
        $value = trim(substr($header, $pos + 1));
        if ($key == "Location") {
            $this->_headers[$key] = trim(substr($value, strrpos($value, "/") + 1));
        } else {
            $this->_headers[$key] = $value;
        }

        return strlen($header);
    }

    /**
     * reset headers variable
     * @return void
     */
    protected function resetHeader()
    {
        $this->_headers = array();
    }

     /**
      * simple autoload function
      * returns true if the class was loaded, otherwise false
      *
      * <code>
      * // register the class auto loader
      * spl_autoload_register(array('HarvestApi', 'autoload'));
      * </code>
      *
      * @param string $className Name of Class to be loaded
      * @return bool
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
     * $api = new HarvestApi();
     * $api->getPath();
     * </code>
     *
     * @return String
     */
    public static function getPath()
    {
        if (! self::$_path) {
            self::$_path = dirname(__FILE__);
        }

        return self::$_path;
    }
}
