<?php

//  A small standalone test file, to check if pear:db is working from the CLI or browser.
//  Part of php bug tracker.
//  You must edit the connection details for this to work.
//  Don't leave your password in this script, else it may be visible externally.
//
//  If you get "DB Error: extension not found" you are missing the
//  proper PHP database driver for your database.  Install the driver
//  and restart Apache.
//
//  For more info see http://pear.php.net/package/DB

require 'vendor/autoload.php';  // composer

if (php_sapi_name() === 'cli') {
    $cli = true;
    $EOL = "\n";
    printf('you are running php from the command line%s', $EOL);
} else {
    $cli = false;
    $EOL = "<br>\n";
    printf('you are running php from the browser%s', $EOL);
}
printf('you can run this script from the browser or the command line%s', $EOL);

# Step 1 of 2: Set which database you are using:
$testMySQL = 0;
$testPostgreSQL = 0;
$testSqlite3 = 0;
$testOracle = 0;
$useOracleXe = 0;              // dependent on testOracle
$useOracle_mTLS_wallet = 1;    // dependent on testOracle
$useOracle_TLS = 0;            // dependent on testOracle
$testMsSqlServer = 0;

# Step 2 of 2: Set the database connection parameters for your database:
if ($testMySQL) {
    $dsn = array(
        'phptype'  => 'mysqli',
        'hostspec' => 'localhost',
        'database' => 'phpbugtracker',
        'username' => 'bugbuster',
        'password' => 'bugbusterpw',
    );
    //$query = 'SELECT varname, varvalue FROM configuration;';           // w/phpbugtracker database installed and loaded
    //$query = 'SHOW DATABASES;';                                        // just connect & do simple query test
    $query = 'SELECT VERSION();';                                      // just connect & do simple query test
} elseif ($testPostgreSQL) {
    $dsn = array(
        'phptype'  => 'pgsql',
        'hostspec' => 'localhost',
        'database' => 'phpbugtracker',
        'username' => 'bugbuster',
        'password' => 'bugbusterpw',
    );
    //$query = 'SELECT varname, varvalue FROM configuration;';           // w/phpbugtracker database installed and loaded
    //$query = 'SELECT datname FROM pg_database;';                       // just connect & do simple query test
    $query = 'SELECT VERSION();';                                      // just connect & do simple query test
} elseif ($testSqlite3) {
    $dsn = array(
        'phptype'  => 'sqlite3',
        'hostspec' => '',
        // specifying a non-existant database, sqlite3 driver will create it!
        // database location can be stated relative or abs paths
        'database' => 'db/phpbugtracker-demo.sqlite3',
        'username' => '',
        'password' => '',
    );
    //$query = 'SELECT varname, varvalue FROM configuration;';           // w/phpbugtracker database installed and loaded
    //$query = 'SELECT file FROM pragma_database_list;';                 // list of databases defined
    $query = 'SELECT SQLITE_VERSION();';                               // just connect & do simple query test
} elseif ($testOracle) {
    if ($useOracleXe = 0) {
        // local install of free oracle db on your host or lan
        // oci8.php will connect using EasyConnect syntax: oci8(oci8)://phpbt:PASSWORD@localhost/phpbugtracker
        $dsn = array(
            'phptype'  => 'oci8',
            'hostspec' => 'localhost',
            'database' => 'phpbugtracker',
            'username' => 'bugbuster',
            'password' => 'bugbusterpw',
            //'charset'   => 'utf8',                    // client 'charset' may not be relevant depending on the database
            //'new_link'  => false,                     // true => create and use a new connection; will override 'persistent'
        );
    } else {
        // oracle cloud
        // By default the driver looks in /opt/oracle/instantclient_23_26/network/admin (or what version was installed and built against)
        // Environment variable TNS_ADMIN not needed unless you store the credentials someplace else other than netword/admin
        // Setting and use of TNS_ADMIN does not work.

        if ($useOracle_mTLS_wallet) {
            // oracle instant client w/mTLS w/wallet
            printf('Oracle database mTLS w/wallet%s', $EOL);
            $dsn = array(
                'phptype'  => 'oci8',
                'hostspec' => '',                        // not required
                'database' => 'phpbugtracker_low',       // TNS alias name as found in network/admin/tnsnames.ora
                'username' => 'bugbuster',
                'password' => 'bugbusterpw',
                //'charset'  => 'utf8',                 // client 'charset' may not be relevant depending on the database
                //'new_link' => false,                  // true => create and use a new connection; will override 'persistent' opt below
            );
        } elseif ($useOracle_TLS) {
            // oracle instant client w/TLS and wallet not required
            printf('Oracle database w/TLS only%s', $EOL);
            $dsn = array(
                'phptype'  => 'oci8',
                'hostspec' => '',
                'database' => 'test_low',
                'username' => 'bugbuster',
                'password' => 'bugbusterpw',
                //'charset'   => 'utf8',                // client 'charset' may not be relevant depending on the database
                //'new_link'  => false,                 // true => create and use a new connection; will override 'persistent'
            );
        } else {
            printf('Oracle database unknown%s', $EOL);
            die('You need to edit and configure this script for a specific oracle database connection parameters.');
        }
    }
    //$query = 'SELECT varname, varvalue FROM configuration;';           // w/phpbugtracker database installed and loaded
    $query = 'SELECT * FROM PRODUCT_COMPONENT_VERSION';                // just connect & do simple query test
} elseif ($testMsSqlServer) {
    // The PEAR DB mssql driver code is out of date with current PHP 8 so is unusable (and untested)
    $dsn = array(
        'phptype'  => 'mssql',
        'hostspec' => 'localhost',
        'database' => 'phpbugtracker',
        'username' => 'bugbuster',
        'password' => 'bugbusterpw',
    );
    //$query = 'SELECT varname, varvalue FROM configuration;';           // w/phpbugtracker database installed and loaded
    //$query = "SELECT SERVERPROPERTY('productversion'), SERVERPROPERTY('productlevel'), SERVERPROPERTY('edition');";
    $query = "SELECT SERVERPROPERTY('productversion');";               // just connect & do simple query test
} else {
    die('You need to edit and configure this script for a specific database and connection parameters.');
}

// dsn optional settings: see DB.php and the specific db driver code, i.e. oc8.php etc.
// some options will be db specific
$dsnOpts = array(
    'persistent' => 0,  // 0 => no connection pooling, reuse; 1 => use connection pooling if available
    'debug' => 3,       // calls fuctions with error suppression removed '@', i.e. $c = oci_connect(..);
);

// https://pear.php.net/manual/en/package.database.db.db-result.numrows.php
if ($testOracle) {
    $dsnOpts['portability'] = 8;  // Enable hack that makes numRows() work in Oracle: DB.php::define('DB_PORTABILITY_NUMROWS', 8);
}

if ($cli) {
    printf('%s', $EOL);
} else {
    printf('<pre>%s', $EOL);
}

printf('connecting to the database with your supplied information:%s', $EOL);
printf('dsn:%s', $EOL);
print_r($dsn);
printf('%s', $EOL);

printf('dsn options:%s', $EOL);
print_r($dsnOpts);
printf('%s', $EOL);

printf('connecting to database ... %s', $EOL);

$db = DB::Connect($dsn, $dsnOpts);
if (DB::isError($db)) {
    printf('Failed to connect to the database with error code:<br/>' . $db->getMessage() . '<br/>' . $db->getUserInfo() . '<br/>');
    printf('%s', $EOL);
    return;
}

printf('connection made successfully.%s', $EOL);
printf('db->toString() = %s%s', $db->toString(), $EOL);

printf('query to try is [%s]%s', $query, $EOL);

$result = &$db->query($query);

if (DB::isError($result)) {
    printf('<b>Select failed (this is expected if the database is not present or created):</b>%s', $EOL);
    printf('%s%s', $result->getMessage(), $EOL);
    printf('%s%s', $result->getUserInfo(), $EOL);
    return;
}

printf('query successful.%s', $EOL);
printf('query result details:%s', $EOL);
printf('   result->numRows =  [%s] row(s)%s', $result->numRows(), $EOL);
printf('   result->numCols = [%s] column(s)%s', $result->numCols(), $EOL);

$table2rows = '';
$rowCnt = 0;
while ($row = &$result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $columnNames = array_keys($row);

    // cli column names
    if ($rowCnt == 0 && $cli) {
       $colHdr = '              | ';
       for ($i = 0; $i < $result->numCols(); $i++) {
           $colHdr .= sprintf('%s | ', $columnNames[$i]);
       }
       printf('%s%s', $colHdr, $EOL);
    }

    // html row number
    $table2rows .= sprintf('<tr><td><b>row[%d]</b></td>', $rowCnt);

    // cli row number
    if ($cli) {
        printf('row %03d => ', $rowCnt);
    }

    // html td column data and cli column seperator
    foreach ($row as $k => $v) {
        $table2rows .= sprintf('<td>%s</td>', $v);
        if ($cli) {
            printf(' %s |', $v);
        }
    }

    // html and cli end of row
    $table2rows .= '</tr>';
    if ($cli) {
        printf('%s', $EOL);
    }

    $rowCnt++;
}

if (!$cli) {
    printf('</pre>%s', $EOL);
}

// html table header
$colHdr = '<tr><td></td>';
for ($i = 0; $i < $result->numCols(); $i++) {
    $colHdr .= sprintf('<td style="text-align: center;">%s</td>', $columnNames[$i]);
}
$colHdr .= '</tr>';

// html complete table
if (!$cli) {
    printf('<h4>Query results in table format:</h4>%s', $EOL);
    printf('<table border=1><th colspan="%d">table of array row[] key/values</th>%s%s</table>', $result->numCols() + 1, $colHdr, $table2rows);
    printf('%s', $EOL);
}

printf('freeing query result resource.%s', $EOL);
$result->free();

//  Uncomment the next line for lots of information about php setup
if (!$cli) {
    phpinfo();
}

