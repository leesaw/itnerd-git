<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = 'root';
$db['default']['database'] = 'hostgator_nerd_25102016';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


$db['db2']['hostname'] = "jes";
//$db['db2']['port'] = "1433";
$db['db2']['username'] = 'viewonly';
$db['db2']['password'] = 'justview890';
$db['db2']['database'] = 'JES_NGG';
$db['db2']['dbdriver'] = 'mssql';
$db['db2']['dbprefix'] = '';
$db['db2']['pconnect'] = FALSE; // Pay attention to this, codeigniter makes true for default
$db['db2']['db_debug'] = TRUE;
$db['db2']['cache_on'] = FALSE;
$db['db2']['cachedir'] = '';
$db['db2']['char_set'] = 'utf8';
$db['db2']['dbcollat'] = 'utf8_general_ci';
$db['db2']['swap_pre'] = '';
$db['db2']['autoinit'] = TRUE;
$db['db2']['stricton'] = FALSE;

$db['db3']['hostname'] = 'localhost';
$db['db3']['username'] = 'root';
$db['db3']['password'] = 'root';
$db['db3']['database'] = 'jes_mysql';
$db['db3']['dbdriver'] = 'mysql';
$db['db3']['dbprefix'] = '';
$db['db3']['pconnect'] = TRUE;
$db['db3']['db_debug'] = TRUE;
$db['db3']['cache_on'] = FALSE;
$db['db3']['cachedir'] = '';
$db['db3']['char_set'] = 'utf8';
$db['db3']['dbcollat'] = 'utf8_general_ci';
$db['db3']['swap_pre'] = '';
$db['db3']['autoinit'] = TRUE;
$db['db3']['stricton'] = FALSE;

$db['db4']['hostname'] = 'localhost';
$db['db4']['username'] = 'root';
$db['db4']['password'] = 'root';
$db['db4']['database'] = 'nerd_db';
$db['db4']['dbdriver'] = 'mysql';
$db['db4']['dbprefix'] = '';
$db['db4']['pconnect'] = TRUE;
$db['db4']['db_debug'] = TRUE;
$db['db4']['cache_on'] = FALSE;
$db['db4']['cachedir'] = '';
$db['db4']['char_set'] = 'utf8';
$db['db4']['dbcollat'] = 'utf8_general_ci';
$db['db4']['swap_pre'] = '';
$db['db4']['autoinit'] = TRUE;
$db['db4']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */
