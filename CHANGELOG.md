# Original HarvestAPI PHP Wrapper Library Changelog

This is the changelog of the HarvestAPI library for PHP. The original library can be found at http://resources.mdbitz.com/2009/11

* 1.1.1 (released 10-04-2010)

    Comment:

    getClientProjects Bug Fix Release

    Changes:

    * missing query parameter fixed – thanks to Warren Sherliker for identifying this issue.


* 1.1.0 (released 08-19-2010)

    Comment:

    Enhancement Release to incorporate latest Harvest API changes including default [SSL security](http://www.getharvest.com/blog/2010/08/secure-connection-for-all-accounts) and [updated_since option](http://forum.getharvest.com/forums/api-and-developer-chat/topics/announcement-updated_since-available-in-invoices-api)

    Changes:

    * default SSL mode set to TRUE
    * Follow Redirects enabled on underlying curl settings to follow 30X redirects
    * *getProjects* optional updated_since parameter added
    * *getClients* optional updated_since parameter added
    * *getContacts* optional updated_since parameter added
    * *Filter* optional updated_since parameter added

* 1.0.1 (released 08-05-2010)

    Comment:

    assignUserToProject Bug Fix Release

	Changes:

    * Typo corrected in assignUserToProject function – thanks to John Vitelli for identifying this issue.

* 1.0.0 (released 05-01-2010)

    Comment:

    Official 1.0 release of the HaPi - PHP Wrapper Library for the Harvest API. This release contains multiple bug fixes as well as the HarvestReports interface for performing common tasks like getting only the active projects and clients.

    Changes:

    * New HarvestReports extension class - extends the HarvestAPI class with additional reporting features
        * getActiveClients
        * getInactiveClients
        * getActiveProjects
        * getInActiveProjects
        * getClientActiveProjects
        * getClientInActiveProjects
        * getActiveUsers
        * getInactiveUsers
        * getAdmins
        * getActiveAdmins
        * getInActiveAdmins
        * getContractors
        * getActiveContractors
        * getInactiveContractors
        * getActiveTimers
        * getUsersActiveTimer

    * Added DateTime support to Range
    * Added the following pre set ranges to Range
        * today
        * thisWeek
        * lastWeek
        * thisMonth
        * lastMonth

    * Added support for getClientProjects to return projects that belong to a single client
    * Addition of underscore converter so users can call properties directly without utilizing get.
    * Bug Fix for createEntry returned data
    * Bug Fix for getUserEntries
    * Conversion of Request class to Throttle
    * Cleanup of code samples in documentation

* 0.4.2 (released 04-20-2010)

    Comment:

    Bug Fix for User & Project Activity

    Changes:

    * DailyActivity object is used both in the time and extended api, however they are inconsistent with the token character used -, _. daily-activity added to parser for quick fix, Version 1.0 will contain conversion checking.

* 0.4.1 (released 04-16-2010)

    Comment:

    Bug Fix for SSL support

    Changes:

    * CURLOPT_SSL_VERIFYPEER option set to false so that request does not fail if SSL Certificate isn't verified

* 0.4.0 (released 12-2-2009)

    Comment:

    Support for Full API

    * getExpense - bug fix of improper generated url
    * parseNode - bug fix for parsing of task assignments
    * Documentation - Class Object Properties added
    * Full Testing of GET methods

* 0.3.0 (released 11-15-2009)

    Comment:

    Support for Full extends REST API minus payment receipts

    Changes:

    * phpDocument - documentation compliant
    * Creation of Currency Class
    * Creation of TimeZone Class
    * HarvestAPI - extended REST Support
    * HarvestAPI - ssl support

* 0.2.0 (released 11-11-2009)

    Comment:

    Added support for POST, PUT, and DELETE requests, toXML functions for Harvest Classes, and Full API implementation of Projects, Clients, Client Contacts

    Changes:

    * Added _toXML_ function to Harvest
    * Added helper functions to HarvestAPI
        * performPUT -> performs PUT request
        * performPOST -> performs POST request
        * performDELETE -> performs DELETE request
        * parseHeader -> parse header into array that can be used in perform functions
        * resetHeader -> reset header array.
    * Addition of HarvestAPI functions for Clients, Projects, and Client Contacts
        * createClient - Create a new Client
        * updateClient - Update an existing Client
        * toggleClient - Toggle CLient active-inactive
        * deleteClient - Delete an existing Client
        * createProject - Create a new Project
        * updateProject - Update an existing Project
        * toggleProject - Toggle Project active-inactive
        * deleteClient - Delete an existing Project
        * createContact - Create a new Client Contact
        * updateContact - Update an existing Client Contact
        * deleteContact - Delete an existing Client Contact
    * Addition of Timer Class
        * Addition of __root_ variable to classes for xml conversion
        * Bug Fix: _isSuccess_ method of Result
        * Bug Fix: replacement of YahooFinance_Exception with HarvestException

* 0.1.0 (released 11-04-2009)

    Comment:

    Initial Version of the HarvestAPI

    Changes:

    * Creation of main Class HarvestAPI
    * Creation of Harvest Class Objects
    * Implementation of GET methods of Harvest API