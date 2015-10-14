<?php

		// uncomment the following to define a path alias
		// Yii::setPathOfAlias('local','path/to/local-folder');

		// This is the main Web application configuration. Any writable
		// CWebApplication properties can be configured here.
		return array(
		
		'basePath'=>dirname(__FILE__). DIRECTORY_SEPARATOR .'..',
		'name'=>'High Clean',
		'defaultController'=>'site/index',


		// preloading 'log' component
		'preload'=>array(),

	'behaviors' => array(
	 	'runEnd' => array(
	       'class' => 'application.components.WebApplicationEndBehavior',
	    ),
	),


		// autoloading model and component classes
		'import'=>array(
		'application.models.*',
		'application.components.*',
        	'application.extensions.yii-aws-2.*',
        	'application.extensions.yii-aws-2.AwsBase',
		'application.extensions.messagemedia.SmsInterface',
		'application.extensions.resize-image.resize',
		'application.extensions.S3.S3',
		'application.extensions.mailgun.MailgunApi',
		'application.extensions.MPDF56.mPDF',
		'application.modules.User.models.*',
		'application.modules.User.components.*',
		'application.modules.Group.models.*',
		'application.modules.Group.components.*',
		'application.modules.Setting.models.*',
		'application.modules.Setting.components.*',
		'application.modules.Service.models.*',
		'application.modules.Service.components.*',
		'application.modules.ListItems.models.*',
		'application.modules.ListItems.components.*',
		'application.modules.Company.models.*',
		'application.modules.Company.components.*',
		'application.modules.Contact.models.*',
		'application.modules.Contact.components.*',
		'application.modules.ContactsSite.models.*',
		'application.modules.ContactsSite.components.*',
		'application.modules.Buildings.models.*',
		'application.modules.Buildings.components.*',
		'application.modules.Quotes.models.*',
		'application.modules.Quotes.components.*',
		'application.modules.Swms.models.*',
		'application.modules.Swms.components.*',
		'application.modules.SwmsTask.models.*',
		'application.modules.SwmsTask.components.*',
		'application.modules.SwmsHzrdsConsqs.models.*',
		'application.modules.SwmsHzrdsConsqs.components.*',
		'application.modules.Calendar.models.*',
		'application.modules.Calendar.components.*',
		'application.modules.EmailFormat.components.*',
		'application.modules.EmailFormat.models.*',		
		'application.modules.LicencesType.components.*',
		'application.modules.LicencesType.models.*',		
		'application.modules.InductionType.components.*',
		'application.modules.InductionType.models.*',		
		'application.modules.InductionCompany.components.*',
		'application.modules.InductionCompany.models.*',	
		'application.modules.Induction.components.*',
		'application.modules.Induction.models.*',	
		'application.modules.Hazard.components.*',
		'application.modules.Hazard.models.*',	
		'application.modules.Incident.components.*',
		'application.modules.Incident.models.*',	
		'application.modules.Maintenance.components.*',
		'application.modules.Maintenance.models.*',	
		'application.modules.Timesheet.components.*',
		'application.modules.Timesheet.models.*',	
		'application.modules.StaffJobAllocation.components.*',
		'application.modules.StaffJobAllocation.models.*',	
		'application.modules.TimesheetPayDates.components.*',
		'application.modules.TimesheetPayDates.models.*',
		'application.modules.SmsFormat.components.*',
		'application.modules.SmsFormat.models.*',
		'application.modules.SystemOwner.components.*',
		'application.modules.SystemOwner.models.*',				
		'application.modules.Agent.components.*',
		'application.modules.Agent.models.*',				
		'application.modules.AgentDashboard.components.*',
		'application.modules.AgentDashboard.models.*',				
		'application.modules.MemberDashboard.components.*',
		'application.modules.MemberDashboard.models.*',	
		'application.modules.OperationManager.components.*',
		'application.modules.OperationManager.models.*',	
		'application.modules.StateManager.components.*',
		'application.modules.StateManager.models.*',
		'application.modules.StateDashboard.components.*',
		'application.modules.StateDashboard.models.*',		
		'application.modules.OperationDashboard.components.*',
		'application.modules.OperationDashboard.models.*',		
		'application.modules.HireStaff.components.*',
		'application.modules.HireStaff.models.*',		

),

		'modules'=>array(

		'User',		 
		'Dashboard',
		'ServiceClient',
		'Group',
		'Setting',
		'Service',
		'ListItems',
		'Company',
		'Contact',
		'ContactsSite',
		'Buildings',
		'Quotes',
		'Swms',
		'SwmsTask',
		'SwmsHzrdsConsqs',
		'Calendar',
		'EmailFormat',
		'LicencesType',
		'InductionType',
		'InductionCompany',
		'Induction',
		'Hazard',
		'Incident',
		'Maintenance',
		'Timesheet',
		'StaffJobAllocation',
		'TimesheetPayDates',
		'Report',
		'SmsFormat',
		'SystemOwner',
		'Agent',
		'AgentDashboard',
		'MemberDashboard',
		'OperationManager',
		'StateManager',
		'StateDashboard',
		'OperationDashboard',
		'HireStaff',
		// uncomment the following to enable the Gii tool


		'UserAdmin' => array(
		'cache_time' => 3600,
		),




		'gii'=>array(
		'class'=>'system.gii.GiiModule',
		'password'=>'edreamz',
		// If removed, Gii defaults to localhost only. Edit carefully to taste.
		'ipFilters'=>array('127.0.0.1',$_SERVER['REMOTE_ADDR']),
		),

		),



		// application components
		'components'=>array(
                    
'clientScript'=>array(
      'packages'=>array(
        'jquery'=>array(
          'baseUrl'=>'js',
          'js'=>array('jquery-1.11.1.min.js'),
        )
      ),                    
    ),
                    
                    
		'user'=>array(
		// enable cookie-based authentication
		'allowAutoLogin'=>true,
		),



		'session' => array(
		'timeout' => 86400,
		),



		/* 
		'db'=>array(
		'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		), */
		// uncomment the following to use a MySQL database

			'db'=> array(
			  'connectionString' => 'mysql:host=localhost;dbname=highclea_system',
			  'emulatePrepare' => true,
			  'username' => 'root',
			  'password' => '',
			  'charset' => 'utf8',
			  'tablePrefix' => 'hc_',
			  ), 


		'errorHandler'=>array(
		// use 'site/error' action to display errors
		'errorAction'=>'site/error',
		),

		'log'=>array(
		'class'=>'CLogRouter',
		'routes'=>array(
		array(
		'class'=>'CFileLogRoute',
		'levels'=>'error, warning',
		),
		// uncomment the following to show log messages on web pages
		/*
		array(
		'class'=>'CWebLogRoute',
		),
		*/
		),
		),
		),

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
		// this is used in contact page
		'adminEmail'=>'mikhil.kotak@highclean.com.au',
		'defaultPageSize'=>25,

		),


		);
