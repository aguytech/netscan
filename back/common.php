<?php

/**
 * Common
 */

# require config.php
$file = 'config.php';
if (!file_exists($file) || !is_readable($file))
	exit("error - unable to find file '$file'");
include($file);


# secure incoming requests
if (!empty($ips_read_authorized) && !in_array($_SERVER['REMOTE_ADDR'], $ips_read_authorized)) {
	echo ";o)";
	exit;
}
