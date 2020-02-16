<?php

/* require
*/
$file = 'common.php';
if (!file_exists($file) || !is_readable($file))
	exit("error - unable to find file '$file'");
include($file);

/* data
*/
// no valid data
if (!isset($_POST['data'], $_POST['key']))
	exit("error - wrong format or missing: data,key");
// empty data
if (empty($_POST['data']) || empty($_POST['data'][0]))
	exit("error - empty _POST['data']");
$data=json_decode($_POST['data'], true);
// echo 'data: '.var_dump($data).EL;
// echo 'count(data): '.count($data).EL;

$time_now = time();
$key = key_gen($key_time_delay);
// echo 'time: '.time().EL; echo 'keyfrom: '.$_POST['key'].EL; echo 'key: '.$key.EL;

/* key
*/
// wrong key
if ($_POST['key'] != $key)
	exit("error - wrong key");

/* sql
*/
$sql = "";
$sql_count = 0;
foreach ($data as $key => $host) {
	$fields = implode(",", array_keys($host));
	$values = implode("','", array_values($host));
	if (!empty($fields) && !empty($values)) {
		$sql .= "INSERT INTO ".$dbt['presence']." (ts,".$fields.") VALUES (FROM_UNIXTIME(".$time_now."),'".$values."'); ";
		$sql_count++;
	}
}
// echo "sql: $sql".EL;

// No query
if (empty($sql))
	exit("failed - sql - no query to execute for data:".json_encode($data));

/* DB
*/
// DB connection
try {
	$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PWD);
	// echo "connected";
} catch (PDOException $e) {
	exit("error - sql - connect - unable to connect: ".$e->getMessage());
}

// Query
try {
	$result = $dbh->exec($sql);
	$str = empty($result) ? 'error' : 'success';
	echo $str." - ".count($data)." - $sql_count - $result - $time_now";
} catch (PDOException $e) {
	echo "error - sql - insert ".$e->getMessage();
}
