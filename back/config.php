<?php
/**
 * Configuration
 */

# array of allowed ip addresses to connect to record data
# if empty, no filters request
$ips_reccord_allowed = array('129.20.228.2','129.20.228.3','129.20.228.4','129.20.228.20','188.165.4.35');

# array of FQDN alowed to connect to read data
# if empty, no filters request
$fqdn_read_allowed = array(
	'http://presence.coworking-lannion.org/',
	'https://presence.coworking-lannion.org/',
	'http://www.coworking-lannion.org/',
	'https://www.coworking-lannion.org/'
);

# defines the delay to keep valid the key, is a exponent of 10 seconds
$key_time_delay = 2;
# defines the search time for the latest logs in seconds.
# default is equal to 1 * (periods of cron in seconds ) + 60
$query_time_delay = 300;

# url or hosname of database
define('DB_HOST', 'coworkinurcworg.mysql.db');
# name of database
define('DB_NAME', 'coworkinurcworg');
# name of user to connect to database
define('DB_USER', 'coworkinurcworg');
# password of user to connect to database
define('DB_PWD', 'I4xvjyQqA9IRxo');

# table names of database used
$dbt = array(
	'presence' => 'netscan_presence',
	'computer' => 'netscan_computer',
	'member' => 'wp_users '
);

# defines the security key
# if you change the definition of this key, please agjust the definition of key in netscan bash script
function key_gen($key_time_delay)
{
	$key_time = substr(time(), 2, -$key_time_delay);
	$key_hash = hash('sha256', $key_time);
	return substr($key_hash, 10, 20);
}

# end line
define('EL', "\n");
define('ELB', "<br />\n");
