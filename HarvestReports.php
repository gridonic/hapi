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
 * HarvestReports
 *
 * This file contains the class HarvestReports
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * HarvestReports defines some aggregative reporting methods for quickly
 * obtaining information on users, projects, and weekly statuses
 *
 * <code> 
 * // require the Harvest API core class 
 * require_once( PATH_TO_LIB . '/HarvestReports.php' );
 *
 * // register the class auto loader 
 * spl_autoload_register( array('HarvestReports', 'autoload') );
 *
 * // instantiate the api object 
 * $api = new HarvestReports(); 
 * $api->setUser( "user@email.com" ); 
 * $api->setPassword( "password" ); 
 * $api->setAccount( "account" ); 
 * </code>
 *
 * @package com.mdbitz.harvest
 */
class HarvestReports extends HarvestAPI{
	
	/**
     * @var string Start of Week
     */
    protected $_startOfWeek = 0;

	/**
     * @var string Time Zone
     */
    protected $_timeZone = null;
	
	/**
     * set Start of Work Week for use in Entry Reports
     *
     * <code>
     * $api = new HarvestReports();
     * $api->setStartOfWeek( HarvestReports::MONDAY );
     * </code>
     *
     * @param string $startOfWeek Start day of work week
     * @return void
     */
    public function setStartOfWeek( $startOfWeek ) 
    {
        $this->_startOfWeek = $startOfWeek;
    }
	
	/**
     * set TimeZone for use in Entry Reports
     *
     * <code>
     * $api = new HarvestReports();
     * $api->setTimeZone( "EST" );
     * </code>
     *
     * @param string $timeZone User Time Zone
     * @return void
     */
    public function setTimeZone( $timeZone ) 
    {
        $this->_timeZone = $timeZone;
    }

    /**
     * get all active clients
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getActiveClients();
     * if( $result->isSuccess() ) {
     *     $clients = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getActiveClients() 
    {
		$result = $this->getClients();
		if( $result->isSuccess() ) {
			$clients = array();
			foreach( $result->data as $client ) {
				if( $client->active == "true" ) {
					$clients[$client->id] = $client;
				}
			}
			$result->data = $clients;
		} 
		return $result;
    }
	
	/**
     * get all inactive clients
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getInactiveClients();
     * if( $result->isSuccess() ) {
     *     $clients = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getInactiveClients() 
    {
		$result = $this->getClients();
		if( $result->isSuccess() ) {
			$clients = array();
			foreach( $result->data as $client ) {
				if( $client->active == "false" ) {
					$clients[$client->id] = $client;
				}
			}
			$result->data = $clients;
		} 
		return $result;
    }
	
	/**
     * get all active projects
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getActiveProjects();
     * if( $result->isSuccess() ) {
     *     $projects = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getActiveProjects() 
    {
		$result = $this->getProjects();
		if( $result->isSuccess() ) {
			$projects = array();
			foreach( $result->data as $project ) {
				if( $project->active == "true" ) {
					$projects[$project->id] = $project;
				}
			}
			$result->data = $projects;
		} 
		return $result;
    }
	
	/**
     * get all inactive projects
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getInactiveProjects();
     * if( $result->isSuccess() ) {
     *     $projects = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getInactiveProjects() 
    {
		$result = $this->getProjects();
		if( $result->isSuccess() ) {
			$projects = array();
			foreach( $result->data as $project ) {
				if( $project->active == "false" ) {
					$projects[$project->id] = $project;
				}
			}
			$result->data = $projects;
		} 
		return $result;
    }
	
	/**
     * get all active projects
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getClientActiveProjects( 12345 );
     * if( $result->isSuccess() ) {
     *     $projects = $result->data;
     * }
     * </code>
     *
     * @param int $client_id Client Identifier
     * @return Harvest_Result
     */
    public function getClientActiveProjects( $client_id ) 
    {
		$result = $this->getClientProjects( $client_id );
		if( $result->isSuccess() ) {
			$projects = array();
			foreach( $result->data as $project ) {
				if( $project->active == "true" ) {
					$projects[$project->id] = $project;
				}
			}
			$result->data = $projects;
		} 
		return $result;
    }
	
	/**
     * get all inactive projects of a Client
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getClientInactiveProjects();
     * if( $result->isSuccess() ) {
     *     $projects = $result->data;
     * }
     * </code>
     *
     * @param int $client_id Client Identifier
     * @return Harvest_Result
     */
    public function getClientInactiveProjects( $client_id ) 
    {
		$result = $this->getClientProjects( $client_id );
		if( $result->isSuccess() ) {
			$projects = array();
			foreach( $result->data as $project ) {
				if( $project->active == "false" ) {
					$projects[$project->id] = $project;
				}
			}
			$result->data = $projects;
		} 
		return $result;
    }

	/**
     * get all active users
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getActiveUsers();
     * if( $result->isSuccess() ) {
     *     $users = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getActiveUsers() 
    {
		$result = $this->getUsers();
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $obj ) {
				if( $obj->get("is-active") == "true" ) {
					$data[$obj->id] = $obj;
				}
			}
			$result->data = $data;
		} 
		return $result;
    }
	
	/**
     * get all inactive users
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getInactiveUsers();
     * if( $result->isSuccess() ) {
     *     $users = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getInactiveUsers() 
    {
		$result = $this->getUsers();
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $obj ) {
				if( $obj->get("is-active") == "false" ) {
					$data[$obj->id] = $obj;
				}
			}
			$result->data = $data;
		} 
		return $result;
    }
	
	/**
     * get all admin users
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getAdmins();
     * if( $result->isSuccess() ) {
     *     $users = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getAdmins() 
    {
		$result = $this->getUsers();
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $obj ) {
				if( $obj->get("is-admin") == "true" ) {
					$data[$obj->id] = $obj;
				}
			}
			$result->data = $data;
		} 
		return $result;
    }
	
	/**
     * get all active admin users
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getActiveAdmins();
     * if( $result->isSuccess() ) {
     *     $user = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getActiveAdmins() 
    {
		$result = $this->getUsers();
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $obj ) {
				if( $obj->get("is-active") == "true" && $obj->get("is-admin") == "true" ) {
					$data[$obj->id] = $obj;
				}
			}
			$result->data = $data;
		} 
		return $result;
    }
	
	/**
     * get all inactive admin users
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getInactiveAdmins();
     * if( $result->isSuccess() ) {
     *     $users = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getInactiveAdmins() 
    {
		$result = $this->getUsers();
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $obj ) {
				if( $obj->get("is-active") == "false" && $obj->get("is-admin") ) {
					$data[$obj->id] = $obj;
				}
			}
			$result->data = $data;
		} 
		return $result;
    }
	
	/**
     * get all contractor users
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getContractors();
     * if( $result->isSuccess() ) {
     *     $users = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getContractors() 
    {
		$result = $this->getUsers();
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $obj ) {
				if( $obj->get("is-contractor") == "true" ) {
					$data[$obj->id] = $obj;
				}
			}
			$result->data = $data;
		} 
		return $result;
    }
	
	/**
     * get all active contractor users
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getActiveContractors();
     * if( $result->isSuccess() ) {
     *     $user = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getActiveContractors() 
    {
		$result = $this->getUsers();
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $obj ) {
				if( $obj->get("is-active") == "true" && $obj->get("is-contractor") == "true" ) {
					$data[$obj->id] = $obj;
				}
			}
			$result->data = $data;
		} 
		return $result;
    }
	
	/**
     * get all inactive contractor users
     *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getInactiveContractors();
     * if( $result->isSuccess() ) {
     *     $users = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
    public function getInactiveContractors() 
    {
		$result = $this->getUsers();
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $obj ) {
				if( $obj->get("is-active") == "false" && $obj->get("is-contractor") ) {
					$data[$obj->id] = $obj;
				}
			}
			$result->data = $data;
		} 
		return $result;
    }
	
	/**
     * get all active time entries
	 *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getActiveTimers( );
     * if( $result->isSuccess() ) {
     *     $entries = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
	public function getActiveTimers( ) 
	{
		$result = $this->getActiveUsers( );
		if( $result->isSuccess() ) {
			$data = array();
			foreach( $result->data as $user ) {
				$subResult = $this->getUserEntries( $user->id, Harvest_Range::today( $this->_timeZone ) );
				if( $subResult->isSuccess() ) {
					foreach( $subResult->data as $entry ) {
						if( $entry->timer_started_at != null || $entry->timer_started_at != "" ) {
							$data[$user->id] = $entry;
							break;
						}
					}
				}
			}
			$result->data = $data;
		}
		return $result;
	}
	
	/**
     * get a user's active time entry
	 *
     * <code>
     * $api = new HarvestReports();
     *
     * $result = $api->getUsersActiveTimer( 12345 );
     * if( $result->isSuccess() ) {
     *     $activeTimer = $result->data;
     * }
     * </code>
     *
     * @return Harvest_Result
     */
	public function getUsersActiveTimer( $user_id ) 
	{
		$result = $this->getUserEntries( $user_id, Harvest_Range::today( $this->_timeZone ) );
		if( $result->isSuccess() ) {
			$data = null;
			foreach( $result->data as $entry ) {
				if( $entry->timer_started_at != null || $entry->timer_started_at != "" ) {
					$data = $entry;
					break;
				}
			}
			$result->data = $data;
		}
		return $result;
	}
	
}