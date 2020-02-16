<?php
/**
 * Configuration
 */

# array of authorized ip addresses alowed to connect to record & read data
# if empty, no filters ip adresses
$ips_read_authorized = array();

# defines the delay to keep valid the key, is a exponent of 10 seconds
$key_time_delay = 2;
# defines the search time for the latest logs in seconds.
# default is equal to 1 * (periods of cron in seconds ) + 60
$query_time_delay = 300;

# url or hosname of database
define('DB_HOST', '');
# name of database
define('DB_NAME', '');
# name of user to connect to database
define('DB_USER', '');
# password of user to connect to database
define('DB_PWD', '');

# table names of database used
$dbt = array(
	'presence' => 'netscan_presence',
	'computer' => 'netscan_computer',
	'member' => 'netscan_member'
);

# defines the security key
# if you change the definition of this key, please agjust the definition of key in netscan bash script
function key_gen($key_time_delay)
{
	key_time = substr(time(), 0, -$key_time_delay);
	key_hash = md5($key_time);
	return substr($key_hash, 5, 20);
}

# end line
define('EL', "\n");
define('ELB', "<br />\n");
