<?php
// config-dist.php - Set up configuration options.  This file is copied
// to config.php in a normal install.
//
// ------------------------------------------------------------------------
// Copyright (c) 2001 - 2004 The phpBugTracker Group
// ------------------------------------------------------------------------
// This file is part of phpBugTracker
//
// phpBugTracker is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// phpBugTracker is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with phpBugTracker; if not, write to the Free Software Foundation,
// Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
// ------------------------------------------------------------------------
// $Id: config-dist.php,v 1.41 2008/09/20 21:22:09 brycen Exp $

// Database Config
define ('DB_TYPE', '{db_type}');  // using PEAR::DB naming (mysql, pgsql, etc.)
define ('DB_HOST', '{db_host}'); // hostname of database server
define ('DB_DATABASE', '{db_database}'); // database name
define ('DB_USER', '{db_user}'); // username for database connection
define ('DB_PASSWORD', '{db_pass}'); // password for database connection
define ("DB_CHARSET",  ''); // ibase, oracle, sybase only; mysqli if you manually modify/add to vendor/pear/db/DB/mysqli.php

// Database Table Config
// you can change either the prefix of the table names or each table name individually
define ('CUR_DB_VERSION', 6);  // The version of the database. Copy this to your config.php for upgrades.
define ('TBL_PREFIX', '{tbl_prefix}');	// the prefix for all tables, leave empty to use the old style

define ('TBL_ACTIVE_SESSIONS', TBL_PREFIX.'active_sessions');
define ('TBL_DB_SEQUENCE',     TBL_PREFIX.'db_sequence');
define ('TBL_ATTACHMENT',      TBL_PREFIX.'attachment');
define ('TBL_AUTH_GROUP',      TBL_PREFIX.'auth_group');
define ('TBL_AUTH_PERM',       TBL_PREFIX.'auth_perm');
define ('TBL_AUTH_USER',       TBL_PREFIX.'auth_user');
define ('TBL_BUG',             TBL_PREFIX.'bug');
define ('TBL_BUG_CC',          TBL_PREFIX.'bug_cc');
define ('TBL_BUG_COMMENT',     TBL_PREFIX.'bug_comment');
define ('TBL_BUG_DEPENDENCY',  TBL_PREFIX.'bug_dependency');
define ('TBL_BUG_GROUP',       TBL_PREFIX.'bug_group');
define ('TBL_BUG_HISTORY',     TBL_PREFIX.'bug_history');
define ('TBL_BUG_VOTE',        TBL_PREFIX.'bug_vote');
define ('TBL_COMPONENT',       TBL_PREFIX.'component');
define ('TBL_CONFIGURATION',   TBL_PREFIX.'configuration');
define ('TBL_GROUP_PERM',      TBL_PREFIX.'group_perm');
define ('TBL_OS',              TBL_PREFIX.'os');
define ('TBL_PROJECT',         TBL_PREFIX.'project');
define ('TBL_RESOLUTION',      TBL_PREFIX.'resolution');
define ('TBL_SAVED_QUERY',     TBL_PREFIX.'saved_query');
define ('TBL_SEVERITY',        TBL_PREFIX.'severity');
define ('TBL_STATUS',          TBL_PREFIX.'status');
define ('TBL_USER_GROUP',      TBL_PREFIX.'user_group');
define ('TBL_USER_PERM',       TBL_PREFIX.'user_perm');
define ('TBL_USER_PREF',       TBL_PREFIX.'user_pref');
define ('TBL_VERSION',         TBL_PREFIX.'version');
define ('TBL_PROJECT_GROUP',   TBL_PREFIX.'project_group');
define ('TBL_PROJECT_PERM',    TBL_PREFIX.'project_perm');
define ('TBL_DATABASE',	       TBL_PREFIX.'database_server');
define ('TBL_SITE',            TBL_PREFIX.'site');
// New stuff for database DB_VERSION 5
define ('TBL_BOOKMARK',	       TBL_PREFIX.'bookmark');
define ('TBL_PRIORITY',        TBL_PREFIX.'priority');

// Constants
define ('ONEDAY', 86400);

// bug reports are displayed in localtime (TZ_LOCAL) while database itme is stored as UTC (TZ_DEFAULT) time
define('TZ_DEFAULT', 'UTC');
define('TZ_LOCAL',   'UTC');   // set this to your location, ex. 'America/Chicago'  

// display both html table stats and image stats when USE_JPGRAPH is enabled in Admin->Configuration->USE_JPGRAPH
define('USE_BOTH_JPGRAPH_AND_TABLE_STATS', 0);

// PHPMailer Mail parameters
// If PHPMailer is not installed, sending mail reverts back to using phpBugTracker's own out of date mail routines
// Older PHP5.3-5.5 versions of PHPMailer do not have autoload.php and loads it itself
define('USE_PHPMAILER', file_exists('vendor/autoload.php') && is_dir('vendor/phpmailer/phpmailer'));
define('USE_PHPMAILER_V5', USE_PHPMAILER && version_compare(PHP_VERSION, '5.3.0') > 0 && version_compare(PHP_VERSION, '5.5') < 0);
define("PHPMAILER_DEBUG_LEVEL", 0);      // levels 0,1,2,3,4 
define("PHPMAILER_DEBUG_OUTPUT", "error_log"); // 'echo', 'html', 'error_log'

// Mail parameters
// email "From" is the administrator email address when phpBugTracker was installed: Admin->Configuration->ADMIN_EMAIL
define('SMTP_EMAIL', false);
define('SMTP_HOST', "localhost");
define('SMTP_PORT', 25);
define('SMTP_HELO', "");
define('SMTP_AUTH', false);
define('SMTP_AUTH_USER', "");
define('SMTP_AUTH_PASS', "");
// Address where non-delivery receipts (bounce messages) should be sent if an email cannot be delivered to its intended recipient.
// Sets the envelope Return-Path: if different than From: (ADMIN_EMAIL)
//define('RETURN_PATH', 'bounce@yourdomain.com');
//define('RETURN_PATH', '');
// Email being replied to are delivered to this account, not from From: user
//define('REPLY_TO', 'differentEmail@yourdomain.com');
//define('REPLY_TO_NAME', 'reply to name');

require_once (dirname(__FILE__).'/inc/auth.php');

// DO NOT LEAVE A BLANK LINK AFTER THE CLOSING TAG; SPREADSHEET EXPORT WILL CONTAIN JIBBERISH AND COLUMNS LOST ON IMPORT
?>
