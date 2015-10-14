CREATE TABLE IF NOT EXISTS `hc_system_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_logined` datetime NOT NULL,
  `salt` varchar(32) NOT NULL,
  `ip_address` varchar(32) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `hc_system_owner` ADD `status` ENUM('0','1') NOT NULL DEFAULT '1' AFTER `date_added`;
ALTER TABLE `hc_system_owner` CHANGE `last_logined` `last_logined` DATETIME NULL, CHANGE `salt` `salt` VARCHAR(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `ip_address` `ip_address` VARCHAR(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;

INSERT INTO `hc_system_owner` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `last_logined`, `salt`, `ip_address`, `date_added`) VALUES (NULL, 'Vinayak', 'N', 'admin', MD5('Edreamz@123'), 'vinayak.n@edreamz.in', '2015-08-26 00:00:00', '', '183.87.225.34', CURRENT_TIMESTAMP);
INSERT INTO `hc_system_owner` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `last_logined`, `salt`, `ip_address`, `date_added`) VALUES (NULL, 'Mikhil', 'Kotak', 'admin123', MD5('Edreamz@123'), 'mikhil.kotak@highclean.com.au', '2015-08-26 00:00:00', '', '183.87.225.34', CURRENT_TIMESTAMP);



UPDATE `hc_user` SET `role_id`=5 WHERE `role_id`=1 ;


CREATE TABLE IF NOT EXISTS `hc_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_first_name` varchar(150) NOT NULL,
  `agent_last_name` varchar(150) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `abn` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `signature_image` varchar(255) DEFAULT NULL,
  `business_url_code` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `business_email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `last_logined` datetime DEFAULT CURRENT_TIMESTAMP,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state_province` varchar(100) DEFAULT NULL,
  `zip_code` varchar(100) DEFAULT NULL,
  `fax` varchar(150) DEFAULT NULL,
  `added_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `hc_agent`
--

INSERT INTO `hc_agent` (`id`, `agent_first_name`, `agent_last_name`, `business_name`, `abn`, `website`, `logo`, `signature_image`, `business_url_code`, `auth_key`, `business_email_address`, `password`, `ip_address`, `phone`, `mobile`, `last_logined`, `street`, `city`, `state_province`, `zip_code`, `fax`, `added_date`, `status`) VALUES
(1, 'Vinayak', 'N', 'eDreamz Tech', '87871025744', 'edreamztech.com', '76060-03_11_2014_10_11_40_Miami,-FL-2.jpg', '65554-sign.png', 'edreamz-tech', 'KGHKGHJK324264gdff54', 'vinayak.n@edreamz.in', 'f3143375d1bcbff5a9fd25db483e7c63', '183.87.225.34', '9545802910', '9545802910', '2015-08-27 00:00:00', '123 main street', 'Pune', 'MH', '411051', '048398 0888', '2015-08-27 00:00:00', '1'),
(2, 'Mikhil', 'Kotak', 'High Clean', '45631025732', 'highclean.com.au', '48446-21_07_2014_10_07_30_richmond-virginia-2.jpg', '62372-sign.png', 'high-clean', 'w8k4Ztgz6dcfjkMg6s78zyzWqDhbhJve', 'mikhil.kotak@highclean.com.au', 'f3143375d1bcbff5a9fd25db483e7c63', NULL, '03 8398 0804', '03 8398 0804', '0000-00-00 00:00:00', '1/ 92 Railway Street South', 'Altona', 'VIC', '', '03 8398 0899', '0000-00-00 00:00:00', '1');

  

ALTER TABLE hc_buildings ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_buildings
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_building_documents ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_building_documents
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_building_images ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_building_images
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_company ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_company
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_contact ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_contact
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_contact_user_relation ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_contact_user_relation
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_job_extra_member ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_job_extra_member
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_job_images ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_job_images
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_job_site_supervisor ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_job_site_supervisor
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_job_staff ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_job_staff
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_job_supervisor ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_job_supervisor
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_job_working ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_job_working
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_quotes ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_quotes
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_quote_jobs ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_quote_jobs
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_quote_job_services ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_quote_job_services
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_site_contact_relation ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_site_contact_relation
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_timesheet_approved_status ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_timesheet_approved_status
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_timesheet_pay_dates ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_timesheet_pay_dates
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_timesheet_pay_dates_user ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_timesheet_pay_dates_user
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_user ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_user
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_user_licenses ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_user_licenses
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_induction ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_induction
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE hc_site ADD `agent_id` INT(11) NULL DEFAULT '1';
ALTER TABLE hc_site
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


CREATE TABLE IF NOT EXISTS `hc_operation_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `last_logined` datetime DEFAULT CURRENT_TIMESTAMP,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state_province` varchar(100) DEFAULT NULL,
  `zip_code` varchar(100) DEFAULT NULL,
  `added_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `hc_state_manager`
--

CREATE TABLE IF NOT EXISTS `hc_state_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `last_logined` datetime DEFAULT CURRENT_TIMESTAMP,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state_province` varchar(100) DEFAULT NULL,
  `zip_code` varchar(100) DEFAULT NULL,
  `added_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


update hc_buildings set agent_id=2;
update hc_building_documents set agent_id=2;
update hc_building_images set agent_id=2;
update hc_company set agent_id=2;
update hc_contact set agent_id=2;
update hc_contact_user_relation set agent_id=2;
update hc_job_extra_member set agent_id=2;
update hc_job_images set agent_id=2;
update hc_job_site_supervisor set agent_id=2;
update hc_job_supervisor set agent_id=2;
update hc_job_working set agent_id=2;
update hc_quotes set agent_id=2;
update hc_quote_jobs set agent_id=2;
update hc_quote_job_services set agent_id=2;
update hc_site_contact_relation set agent_id=2;
update hc_site set agent_id=2;
update hc_timesheet_approved_status set agent_id=2;
update hc_timesheet_pay_dates set agent_id=2;
update hc_timesheet_pay_dates_user set agent_id=2;
update hc_user set agent_id=2;
update hc_user_licenses set agent_id=2;
update hc_induction set agent_id=2;






/* adding business partner test details */
INSERT INTO `hc_company` (`id`, `name`, `office_address`, `office_suburb`, `mailing_address`, `mailing_suburb`, `abn`, `phone`, `mobile`, `fax`, `email`, `website`, `number_of_site`, `office_state`, `office_postcode`, `mailing_state`, `mailing_postcode`, `created_at`, `updated_at`, `status`, `agent_id`) VALUES
(454, 'Brahma', 'Manikbaug', 'Pune', 'Address', 'Suburb', '45454545', '9898989898', '9898989898', '55225522', 'rohit.ss@edreamz.in', 'http://www.info.highclean.com', 10, 'MH', '411051', 'State', 'Postcode', '2015-09-25 18:37:47', '2015-09-25 10:37:47', '1', 1);

INSERT INTO `hc_contact` (`id`, `company_id`, `first_name`, `surname`, `address`, `suburb`, `state`, `postcode`, `phone`, `mobile`, `email`, `position`, `no_of_sites_managed`, `created_at`, `updated_at`, `status`, `agent_id`) VALUES
(402, 54, 'Sagar', 'Shinde', 'Swargate', 'Pune', 'MH', '411057', '7845124587', '875465655', 'sagar@gmail.com', '9898989898', 12, '2015-09-25 18:50:50', '2015-09-25 10:50:50', '1', 1);

INSERT INTO `hc_contact_user_relation` (`id`, `contact_id`, `user_id`, `agent_id`) VALUES
(475, 102, 117, 1);

INSERT INTO `hc_site` (`id`, `site_name`, `site_id`, `address`, `suburb`, `state`, `postcode`, `phone`, `mobile`, `email`, `site_contact`, `site_comments`, `how_many_buildings`, `created_at`, `updated_at`, `need_induction`, `status`, `induction_company_id`, `agent_id`) VALUES
(507, 'Goyal Ganga', '123', '123 main street', 'Pune', 'MH', '410251', '8998989811', '8787878741', 'xyaz@zlhjf.com', '9898989852', 'N/A', 12, '2015-09-25 18:52:15', '2015-09-25 10:52:15', '0', '1', 0, 1);

INSERT INTO `hc_buildings` (`id`, `building_name`, `building_no`, `water_source_availability`, `dist_from_office`, `no_of_floors`, `size_of_building`, `height_of_building`, `job_notes`, `site_id`, `building_type_id`, `created_at`, `updated_at`, `agent_id`) VALUES
(589, 'Biulding A', '4', '0', '12', 12, '12', '12', 'This is test note on Buliding-A.', 207, 1, '2015-09-25 18:53:25', '2015-09-25 10:53:25', 1);



DELETE FROM `hc_group` WHERE `hc_group`.`id` =1 LIMIT 1 ;
DELETE FROM `hc_group` WHERE `hc_group`.`id` =2 LIMIT 1 ;
DELETE FROM `hc_group` WHERE `hc_group`.`id` =7 LIMIT 1 ;


/* Adding Hire Staff Table */

CREATE TABLE IF NOT EXISTS `hc_hire_staff` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sent_email_count` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `email_sent` datetime NOT NULL,
  `registered` enum('0','1') NOT NULL DEFAULT '0'
);

ALTER TABLE `hc_hire_staff` ADD PRIMARY KEY(`id`);
ALTER TABLE `hc_hire_staff` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;




--
-- Dumping data for table `hc_hire_staff`
--


ALTER TABLE hc_hire_staff
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


INSERT INTO `hc_hire_staff` (`id`, `first_name`, `last_name`, `email`, `auth_key`, `created_at`, `sent_email_count`, `agent_id`, `email_sent`, `registered`) VALUES
(1, 'Prajakta', 'Dhanke', 'prajaktadhanke@edreamz.in', 'gQQ6bawtxJ5hI1ddhmAqJZCN7H3oldcu', '2015-10-02 11:19:43', 0, 1, '0000-00-00 00:00:00', '0');





ALTER TABLE `hc_hazard` ADD `agent_id` INT(11) NOT NULL AFTER `photo`;
update hc_hazard set agent_id=2;
ALTER TABLE hc_hazard
ADD FOREIGN KEY(agent_id)
REFERENCES hc_agent(id);


ALTER TABLE `hc_incident` ADD `agent_id` INT(11) NOT NULL AFTER `photo`;
update hc_incident set agent_id=2;
ALTER TABLE hc_incident
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);


ALTER TABLE `hc_maintenance` ADD `agent_id` INT(11) NOT NULL AFTER `photo`;
update hc_maintenance set agent_id=2; 
ALTER TABLE hc_maintenance
ADD FOREIGN KEY (agent_id)
REFERENCES hc_agent(id);

ALTER TABLE `hc_user` ADD `bank_name` VARCHAR(255) NULL , ADD `bank_bsb` VARCHAR(255) NULL , ADD `bank_account` VARCHAR(255) NULL ;

INSERT INTO `hc_email_format` (`email_format_ID`, `email_format_name`, `email_format`, `note`) VALUES
(15, 'Register yourself to {business_name}', '<p>Hello <em>{user_first_name}</em>,</p>\r\n\r\n<p>{business_name} shared you a link to do register to their business as a staff member.</p>\r\n\r\n<p>Please click on below link to register.</p>\r\n\r\n<p>{registration_link}</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Staff self registration');




