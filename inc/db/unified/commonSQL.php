<?php

// unified/commonSQL.php : based off of mssql.php - Microsoft SQL Server queries
//
// Whomever originally wrote the mssql.php file, wrote it using standard SQL-92 syntax with
// no database specific syntax, function or non-standard usage.
//
// This file mssql.php, was converted to uppercase SQL syntax and tabs expanded with a
// few SQL fixes.
//
// Use this file as common query usage for all SQL databases where applicable.
//
// As it was orignally, each database had it's own SQL query file i.e. mysqli.php, oci8.php, pgsql.php ...
// If this common SQL query file here will not work for a particular database, then revert
// back to its own <db>.php file and tweak anything there for that database.

$QUERY = array(
        'admin-list-components' =>
                'SELECT '.
                        'c.component_id, '.
                        'c.component_name, '.
                        'c.created_date, '.
                        'c.owner, '.
                        'c.active, '.
                        'c.sort_order, '.
                        'count(bug_id) as bug_count '.
                'FROM '.
                        TBL_COMPONENT.' c '.
                        'LEFT JOIN '.TBL_BUG.' b ON b.component_id = c.component_id '.
                'WHERE '.
                        'c.project_id = %s '.
                'GROUP BY '.
                        'c.component_id, '.
                        'c.component_name, '.
                        'c.created_date, '.
                        'c.owner, '.
                        'c.active, '.
                        'c.sort_order '.    // oci8 - added missing sort_order
                'ORDER BY '.
                        'c.sort_order ',
        'admin-list-databases' =>
                'SELECT '.
                        'd.database_id, '.
                        'database_name, '.
                        'sort_order, '.
                        'COUNT(bug_id) AS bug_count '.
                'FROM '.
                        TBL_DATABASE.' d '.
                        'LEFT JOIN '.TBL_BUG.' b ON b.database_id = d.database_id '.
                'GROUP BY '.
                        'd.database_id, '.
                        'database_name, '.
                        'sort_order '.
                'ORDER BY '.
                        '%s %s',
        'admin-list-groups' =>
                'SELECT '.
                        'ag.group_id, '.
                        'group_name, '.
                        'locked, '.
                        'COUNT(ug.group_id) AS count '.
                'FROM '.
                        TBL_AUTH_GROUP.' ag '.
                        'LEFT JOIN '.TBL_USER_GROUP.' ug ON ug.group_id = ag.group_id '.
                        'LEFT JOIN '.TBL_AUTH_USER.' au ON ug.user_id = au.user_id '.
                'WHERE '.
                        ' %s '.
                'GROUP BY '.
                        'ag.group_id, '.
                        'group_name, '.
                        'locked '.
                'ORDER BY '.
                        '%s %s',
        'admin-list-oses' =>
                'SELECT '.
                        's.os_id, '.
                        'os_name, '.
                        'regex, '.
                        'sort_order, '.
                        'COUNT(bug_id) AS bug_count '.
                'FROM '.
                        TBL_OS.' s '.
                        'LEFT JOIN '.TBL_BUG.' b ON s.os_id = b.os_id '.
                'GROUP BY '.
                        's.os_id, '.
                        'os_name, '.
                        'regex, '.
                        'sort_order '.
                'ORDER BY '.
                        '%s %s',
        'admin-list-priorities' =>
                'SELECT '.
                        'p.priority_id, '.
                        'priority_name, '.
                        'priority_desc, '.
                        'priority_color, '.
                        'sort_order, '.
                        'COUNT(bug_id) AS bug_count '.
                'FROM '.
                        TBL_PRIORITY.' p '.
                        'LEFT JOIN '.TBL_BUG.' b ON b.priority = p.priority_id '.
                'GROUP BY '.
                        'p.priority_id, '.
                        'priority_name, '.
                        'priority_desc, '.
                        'priority_color, '.
                        'sort_order '.
                'ORDER BY '.
                        '%s %s',
        'admin-list-resolutions' =>
                'SELECT '.
                        's.resolution_id, '.
                        'resolution_name, '.
                        'resolution_desc, '.
                        'sort_order, '.
                        'COUNT(bug_id) AS bug_count '.
                'FROM '.
                        TBL_RESOLUTION.' s '.
                        'LEFT JOIN '.TBL_BUG.' b ON b.resolution_id = s.resolution_id '.
                'GROUP BY '.
                        's.resolution_id, '.
                        'resolution_name, '.
                        'resolution_desc, '.
                        'sort_order '.
                'ORDER BY '.
                        '%s %s',
        'admin-list-severities' =>
                'SELECT '.
                        's.severity_id, '.
                        'severity_name, '.
                        'severity_desc, '.
                        'severity_color, '.
                        'sort_order, '.
                        'COUNT(bug_id) AS bug_count '.
                'FROM '.
                        TBL_SEVERITY.' s '.
                        'LEFT JOIN '.TBL_BUG.' b ON b.severity_id = s.severity_id '.
                'GROUP BY '.
                        's.severity_id, '.
                        'severity_name, '.
                        'severity_desc, '.
                        'severity_color, '.
                        'sort_order '.
                'ORDER BY '.
                        '%s %s',
        'admin-list-sites' =>
                'SELECT '.
                        's.site_id, '.
                        'site_name, '.
                        'sort_order, '.
                        'COUNT(bug_id) AS bug_count '.
                'FROM '.
                        TBL_SITE.' s '.
                        'LEFT JOIN '.TBL_BUG.' b ON b.site_id = s.site_id '.
                'GROUP BY '.
                        's.site_id, '.
                        'site_name, '.
                        'sort_order '.
                'ORDER BY '.
                        '%s %s',
        'admin-list-statuses' =>
                'SELECT '.
                        's.status_id, '.
                        'status_name, '.
                        'status_desc, '.
                        'sort_order, '.
                        'bug_open, '.
                        'COUNT(bug_id) AS bug_count '.
                'FROM '.
                        TBL_STATUS.' s '.
                        'LEFT JOIN '.TBL_BUG.' b ON b.status_id = s.status_id '.
                'GROUP BY '.
                        's.status_id, '.
                        'status_name, '.
                        'status_desc, '.
                        'sort_order, '.
                        'bug_open '.
                'ORDER BY '.
                        '%s %s',
        'admin-list-versions' =>
                'SELECT '.
                        'v.version_id, '.
                        'v.version_name, '.
                        'v.created_date, '.
                        'v.active, '.
                        'sort_order, '.
                        'COUNT(bug_id) AS bug_count '.
                'FROM '.
                        TBL_VERSION.' v '.
                        'LEFT JOIN '.TBL_BUG.' b ON b.version_id = v.version_id '.
                'WHERE '.
                        'v.project_id = %s '.
                'GROUP BY '.
                        'v.version_id, '.
                        'v.version_name, '.
                        'v.created_date, '.
                        'v.active, '.
                        'sort_order '.          // oci8 - added missing sort_order
                'ORDER BY '.                    // sqlite3 - added missing ORDER BY
                        'sort_order ',
        'admin-show-component' =>
                'SELECT '.
                        'c.*, '.
                        'p.project_name AS project_name '.
                'FROM '.
                        TBL_COMPONENT.' c  '.
                        'LEFT JOIN '.TBL_PROJECT.' p ON p.project_id = c.project_id '.
                'WHERE '.
                        'component_id = \'%s\'',
        'admin-show-version' =>
                'SELECT '.
                        'v.*, '.
                        'p.project_name AS project_name '.
                'FROM '.
                        TBL_VERSION.' v '.
                        'LEFT JOIN '.TBL_PROJECT.' p ON p.project_id = v.project_id '. // oci - add space to end: "..._id '"
                'WHERE '.
                        'version_id = \'%s\'',
        'admin-user-groups' =>
                'SELECT '.
                        'ug.group_id '.
                'FROM '.
                        TBL_USER_GROUP.' ug '.
                        'LEFT JOIN '.TBL_AUTH_GROUP.' g ON g.group_id = ug.group_id '.
                'WHERE '.
                        'user_id = %s ',
        'bug-cc-list' =>
                'SELECT '.
                        'email '.
                'FROM '.
                        TBL_BUG_CC.' b '.
                        'LEFT JOIN '.TBL_AUTH_USER.' u ON u.user_id = b.user_id, '.
                        TBL_USER_PREF.' p '.
                'WHERE '.
                        'bug_id = %s '.
                        'AND u.user_id = p.user_id '.
                        'AND email_notices = 1',
        'bug-history' =>
                'SELECT '.
                        'bh.*, '.
                        'login '.
                'FROM '.
                        TBL_BUG_HISTORY.' bh '.
                        'LEFT JOIN '.TBL_AUTH_USER.' ON bh.created_by = user_id '.
                'WHERE '.
                        'bug_id = %s '.
                'ORDER BY '.
                        'bh.created_date',
        'bug-printable' =>
                'SELECT '.
                        'b.*, '.
                        'reporter.login AS reporter, '.
                        'owner.login AS owner, '.
                        'project_name, '.
                        'component_name, '.
                        'version_name, '.
                        'severity_name, '.
                        'priority_name, '.
                        'os_name, '.
                        'status_name, '.
                        'resolution_name '.
                'FROM '.
                        TBL_BUG.' b '.
                        'LEFT JOIN '.TBL_AUTH_USER.' owner ON b.assigned_to = owner.user_id '.
                        'LEFT JOIN '.TBL_AUTH_USER.' reporter ON b.created_by = reporter.user_id '.
                        'LEFT JOIN '.TBL_BOOKMARK.' bookmark ON b.bug_id = bookmark.bug_id '.
                        'LEFT JOIN '.TBL_RESOLUTION.' r ON b.resolution_id = r.resolution_id, '.
                        TBL_SEVERITY.' sv, '.
                        TBL_STATUS.' st, '.
                        TBL_OS.' os, '.
                        TBL_VERSION.' v, '.
                        TBL_PRIORITY.' priority, '.
                        TBL_COMPONENT.' c, '.
                        TBL_PROJECT.' p '.
                'WHERE '.
                        'b.bug_id = %s '.
                        'AND b.project_id NOT IN (%s) '.
                        'AND b.severity_id = sv.severity_id '.
                        'AND b.priority = priority.priority_id '.
                        'AND b.os_id = os.os_id '.
                        'AND b.version_id = v.version_id '.
                        'AND b.component_id = c.component_id '.
                        'AND b.project_id = p.project_id '.
                        'AND b.status_id = st.status_id',
        'bug-show-bug' =>
                'SELECT '.
                        'b.*, '.
                        'reporter.login AS reporter, '.
                        'owner.login AS owner, '.
                        'status_name, '.
                        'resolution_name '.
                'FROM '.
                        TBL_BUG.' b '.
                        'LEFT JOIN '.TBL_AUTH_USER.' owner ON b.assigned_to = owner.user_id '.
                        'LEFT JOIN '.TBL_AUTH_USER.' reporter ON b.created_by = reporter.user_id '.
                        'LEFT JOIN '.TBL_BOOKMARK.' bookmark ON b.bug_id = bookmark.bug_id '.
                        'LEFT JOIN '.TBL_RESOLUTION.' r ON b.resolution_id = r.resolution_id, '.
                        TBL_SEVERITY.' sv, '.
                        TBL_STATUS.' st, '.
                        TBL_SITE.' site, '.
                        TBL_PRIORITY.' prio '.
                'WHERE '.
                        'b.bug_id = %s '.
                        'AND b.project_id NOT IN (%s) '.
                        'AND b.site_id = site.site_id '.
                        'AND b.severity_id = sv.severity_id '.
                        'AND b.status_id = st.status_id '.
                        'AND b.priority = prio.priority_id',
        'functions-bug-cc' =>
                'SELECT '.
                        'b.user_id, '.
                        'login '.
                'FROM '.
                        TBL_BUG_CC.' b '.
                        'LEFT JOIN '.TBL_AUTH_USER.' a ON a.user_id = b.user_id '.
                'WHERE '.
                        'bug_id = %s',
        'functions-project-js' =>
                'SELECT '.
                        'p.project_id, '.
                        'p.project_name '.
                'FROM '.
                        TBL_PROJECT.' p '.
                        'LEFT JOIN '.TBL_PROJECT_GROUP.' pg ON pg.project_id = p.project_id '.
                'WHERE '.
                        'active = 1 '.
                        'AND (pg.project_id is null or pg.group_id IN (%s)) '.
                'GROUP BY '.
                        'p.project_id, '.
                        'p.project_name '.
                'ORDER BY '.
                        'project_name',
        'include-template-bookmark' =>
                'SELECT '.
                        'SUM(CASE WHEN s.status_id IN ('.OPEN_BUG_STATUSES.') THEN 1 ELSE 0 END ), '.
                        'SUM(CASE WHEN s.status_id NOT IN ('.OPEN_BUG_STATUSES.') THEN 1 ELSE 0 END ) '.
                'FROM '.
                        TBL_BUG.' b '.
                        'LEFT JOIN '.TBL_STATUS.' s ON s.status_id = b.status_id, '.
                        TBL_BOOKMARK.' w '.
                'WHERE '.
                        'w.user_id=%s '.
                        'AND w.bug_id = b.bug_id',
        'include-template-owner' =>
                'SELECT '.
                        'SUM(CASE WHEN s.status_id IN ('.OPEN_BUG_STATUSES.') THEN 1 ELSE 0 END ), '.
                        'SUM(CASE WHEN s.status_id NOT IN ('.OPEN_BUG_STATUSES.') THEN 1 ELSE 0 END ) '.
                'FROM '.
                        TBL_BUG.' b '.
                        'LEFT JOIN '.TBL_STATUS.' s ON s.status_id = b.status_id '.
                'WHERE '.
                        'assigned_to = %s',
        'include-template-reporter' =>
                'SELECT '.
                        'SUM(CASE WHEN s.status_id IN ('.OPEN_BUG_STATUSES.') THEN 1 ELSE 0 END ), '.
                        'SUM(CASE WHEN s.status_id NOT IN ('.OPEN_BUG_STATUSES.') THEN 1 ELSE 0 END ) '.
                'FROM '.
                        TBL_BUG.' b '.
                        'LEFT JOIN '.TBL_STATUS.' s ON s.status_id = b.status_id '.
                'WHERE '.
                        'created_by = %s',
        'index-projsummary-1' =>
                'SELECT project_name AS "Project", '.
                'SUM(CASE WHEN resolution_id = 0 THEN 1 ELSE 0 end) AS "Open"',
        'index-projsummary-2' =>
                'SELECT resolution_name, ',
        'index-projsummary-3' =>
                "', SUM(CASE WHEN resolution_id = '",
        'index-projsummary-4' =>
                "' THEN 1 ELSE 0 end) AS \"'",
        'index-projsummary-5' =>
                ' FROM '.TBL_RESOLUTION.
                ' ORDER BY sort_order',
        'index-projsummary-6' =>
                '%s, COUNT(bug_id) AS "Total" '.
                'FROM '.TBL_BUG.' b '.
                'LEFT JOIN '.TBL_PROJECT.' p ON b.project_id = p.project_id '.
                'WHERE b.project_id NOT IN (%s) '.
                'GROUP BY b.project_id, project_name '.
                'ORDER BY project_name',
        'join-where' =>
                'WHERE',
        /* Buggy: modern postgres wants to insist on group by and order by rules */
        // 2026/02/19 rpj: apparently postgres 17 doesn't care anymore 
        'query-list-bugs' =>
                'SELECT '.
                        '%s '.
                'FROM '.
                        TBL_BUG.' b '.
                        'LEFT JOIN '.TBL_AUTH_USER.' owner ON b.assigned_to = owner.user_id '.
                        'LEFT JOIN '.TBL_AUTH_USER.' reporter ON b.created_by = reporter.user_id '.
                        'LEFT JOIN '.TBL_AUTH_USER.' lastmodifier ON b.last_modified_by = lastmodifier.user_id '.
                        'LEFT JOIN '.TBL_BOOKMARK.' bookmark ON b.bug_id = bookmark.bug_id '.
                        'LEFT JOIN '.TBL_RESOLUTION.' resolution ON b.resolution_id = resolution.resolution_id '.
                        'LEFT JOIN '.TBL_DATABASE.' ON b.database_id = '.TBL_DATABASE.'.database_id '.
                        'LEFT JOIN '.TBL_VERSION.' version2 ON b.to_be_closed_in_version_id = version2.version_id '.
                        'LEFT JOIN '.TBL_VERSION.' version3 ON b.closed_in_version_id = version3.version_id '.
                        '%s, '.
                        TBL_SEVERITY.' severity, '.
                        TBL_STATUS.' status, '.
                        TBL_OS.' os, '.
                        TBL_SITE.' site, '.
                        TBL_VERSION.' version, '.
                        TBL_COMPONENT.' component, '.
                        TBL_PROJECT.' project, '.
                        TBL_PRIORITY.' priority '.
                'WHERE '.
                        'b.severity_id = severity.severity_id '.
                        'AND b.priority = priority.priority_id '.
                        'AND b.status_id = status.status_id '.
                        'AND b.os_id = os.os_id '.
                        'AND b.site_id = site.site_id '.
                        'AND b.version_id = version.version_id '.
                        'AND b.component_id = component.component_id '.
                        'AND b.project_id = project.project_id %s '.
                // 2026/02/16 rpj: oracle chokes on this; why would you need a GROUP BY when there is ony 1 bug_id per bug ?
                // [nativecode=ORA-00979: not a GROUP BY expression Help: https://docs.oracle.com/error-help/db/ora-00979/]
                //'GROUP BY '.
                //        'b.bug_id '.
                'ORDER BY '.
                        '%s %s, '.
                        'b.bug_id asc',
        'query-list-bugs-count' =>
                'SELECT '.
                        'COUNT(*) '.
                'FROM '.
                        TBL_BUG.' b '.
                        'LEFT JOIN '.TBL_AUTH_USER.' owner ON b.assigned_to = owner.user_id '.
                        'LEFT JOIN '.TBL_AUTH_USER.' reporter ON b.created_by = reporter.user_id '.
                        'LEFT JOIN '.TBL_BOOKMARK.' bookmark ON b.bug_id = bookmark.bug_id ',
        'query-list-bugs-count-join' =>
                'WHERE ',
        'report-resbyeng-1' =>
                'SELECT u.email AS "Assigned To", '.
                'SUM(CASE WHEN resolution_id = 0 THEN 1 ELSE 0 end) AS "Open"',
        'report-resbyeng-2' =>
                'SELECT resolution_name, ',
        'report-resbyeng-3' =>
                "', SUM(CASE WHEN resolution_id = '",
        'report-resbyeng-4' =>
                "' THEN 1 ELSE 0 end) AS \"'",
        'report-resbyeng-5' =>
                ' FROM '.TBL_RESOLUTION,
        'report-resbyeng-6' =>
                '%s, COUNT(bug_id) AS "Total" '.
                'FROM '.TBL_BUG.' b '.
                'LEFT JOIN '.TBL_AUTH_USER.' u ON assigned_to = user_id %s '.
                'GROUP BY assigned_to, u.email',
        );

?>
