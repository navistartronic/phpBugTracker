phpBugTracker "2025" README.txt
===============================

What
--------------------------------------------------------------------------------
phpBugTracker "2025" is an modernization of the last version of phpBugtracker 
1.0.5 circa 2009 by Ben Curtis (https://sourceforge.net/projects/phpbt/files/phpbt/phpbt-1.0.5/)

Purpose/Features/Why of Interest
--------------------------------------------------------------------------------
phpBugTracker "2025" primary purpose is to bring the last release 1.0.5 up to 
and usable with current versions of PHP and databases with minimal changes to
keep the same functionality without introducing any bugs.

It is the intent of the revived project to use phpBugTracker for what it is: a 
simple, functional, clean UI, and ease of use bug tracker.

There are no plans to try and duplicate any other bug trackers or add endless 
features. If you want all that then use those bug trackers. I just want to *use*
phpBugTracker "2025" in my projects and not take on an open source project. 
phpBugTracker "2025" is being released in the hopes that others will find its
usefulness in their projects.

See CHANGELOG for brief summary of changes.

Composer Packages Required
--------------------------------------------------------------------------------
Composer is required for phpBugTracker "2025" and requires package pear/db as 
a minimum.

phpBugTracker "2025" still uses PEAR::DB packages but instead of installing 
these manually or via pecl, they are installed via Composer.

In this release, all Composer packages are included so you need to do nothing.
Reason is is there are a couple of local bug fixes that are not in the pear/db
distribution (Oracle & SQLite3). Also, this makes the install and tryout a no
brainer no error install for those just wanting to do a test drive to check out
phpBugTracker "2025".

All other Composer packages are optional but highly recommended (and included).
E-mail can be sent using phpBugTracker's original internal mail routines, but,
it is not recommended. Use PHPMailer via Composer which is already included with
the sources.

Composer packages used and included are:  
  o pear/db                       -- (required) db api's
  o pear/spreadsheet_excel_writer -- (optional) export bugs to Excel spreadsheet
  o JpGraph                       -- (optional) Pie chart graph on main page
  o phpMailer                     -- (recommended) fully RFC compliant MTA

An online Users Guide help can be read as one of phpBugTracker's navigation menu
"Help". This is information is out of date and has not been updated, but worth 
looking at though.

Databases
--------------------------------------------------------------------------------
MySQL is the most tested database. All others appear to functionally work. YMMV.

These databases are available and tried for the backend are:
  o MySQL 5, 8
  o PostgreSQL 17
  o SQLite3 (new to phpBugTracker)
  o Oracle Database 19c Enterprise Edition (Oracle OCI Automous AI DB w/mTLS)
  
phpBugTracker 1.0.5 has provisions for MS SQLServer but the PEAR::DB driver for
SQLServer uses the old ext/mssql extension that was deprecated in PHP 7 and 
PEAR::DB has not been upgraded to use the newer SQLServer ext/sqlsrv extension.

See README-DATABASES for more details.
  
Demo
--------------------------------------------------------------------------------
phpBugTracker "2025" includes a populated SQLite3 demo database with its 
matching config.php file.

See README-SQLITE3-DEMO for details.

Installation
--------------------------------------------------------------------------------
See README-INSTALL for details.

Final Note
--------------------------------------------------------------------------------
To install a new fresh installation or redo and start over from scratch, delete
your database and recreate it, delete the current config.php file, and reload
the browser to start the installation again. The presence or absence of a
config.php file is what determines whether or not the installation routine
install.php used. 

Do not open up phpBugTracker to the internet. Use it only it behind your 
firewall and where you can trust your users.

From bcurtis original 1.0.5 README:
  *Thanks for taking a look at phpBugTracker. I hope you enjoy using 
    phpBugTracker, and that you find it useful.*

Screen Shots (from included SQLite3 Demo Database)
--------------------------------------------------------------------------------

phpBugTracker "2025" Home
[screenshot of phpBugTracker Home]

phpBugTracker Add a New Bug
[screenshot phpBugTracker Add a New Bug]
Interface for submitting new bug reports, assigning severity levels, 
and tracking initial issues.

phpBugTracker Bug List Query Results
[screenshot of phpBugTracker Bug List]
Sortable and filterable overview of all reported issues across active project
development streams.

phpBugTracker View Bug Report
[screenshot of phpBugTracker View Bug]
Detailed breakdown of a single bug report including comment history, status
updates, and resolutions.

phpBugTracker Admin -> Projects Page
[screenshot of phpBugTracker Admin Projects Page])
Administrative panel for managing user permissions, project categories, and
system configurations.

