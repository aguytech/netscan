<?php

/* require
*/
$file = 'config.php';
if (!file_exists($file) || !is_readable($file))
	exit("error - unable to find file '$file'");
include($file);

/* allowed referer request
*/
if (!empty($fqdn_read_allowed) && (! empty($_SERVER['HTTP_REFERER']) && !in_array($_SERVER['HTTP_REFERER'], $fqdn_read_allowed))) {
	echo ";o)";
	exit;
}

/* data
*/
if (!isset($_GET['query']) || empty($_GET['query']))
	exit("error - no command argument or are empty: ");
// function
$query = $_GET['query'];
// arguments
$arg = isset($_GET['arg']) ? $_GET['arg'] : '';
$time_delayed = time() - $query_time_delay;

/* functions
*/
function query($sql)
{
	// DB connection
	try {
		$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PWD);
		// echo "connected";
	} catch (PDOException $e) {
		exit("error - sql - connect - unable to connect: ".$e->getMessage());
	}

	// Query
	try {
		// echo "sql=".$sql.EL;
		return $dbh->query($sql);
	} catch (PDOException $e) {
		exit("error - sql - query: ".$e->getMessage());
	}
}

function last_list($dbt, $time_delayed)
{
	# mac left join members
	$sql = "SELECT MAX(wp.mac) AS mac, MAX(wp.ts) AS ts, member.login AS login, MAX(member.publicname) AS publicname FROM ".$dbt['presence']." AS wp LEFT JOIN (SELECT wpc.mac, ".$dbt['member'].".login, ".$dbt['member'].".publicname FROM ".$dbt['computer']." AS wpc LEFT JOIN (".$dbt['member'].") ON (wpc.id_member = ".$dbt['member'].".id)) AS member ON (wp.mac = member.mac) WHERE wp.ts IN (SELECT MAX(wp1.ts) FROM ".$dbt['presence']." AS wp1) AND wp.ts > FROM_UNIXTIME(".$time_delayed.") GROUP BY login";

	$result = query($sql);
	$data = $result->fetchAll(PDO::FETCH_ASSOC);
	// echo '<pre>'; print_r($data); echo '</pre>'.ELB;
	// $result = json_encode($data);
	$data_encoded = json_encode($data);
	// echo $data_encoded;
	exit($data_encoded);
}

function last_count($dbt, $time_delayed)
{
	// mac left join members
	$sql = "SELECT COUNT(*) AS count FROM ( SELECT MAX(wp.mac) AS mac, MAX(wp.ts) AS ts, member.login AS login, MAX(member.publicname) AS publicname FROM ".$dbt['presence']." AS wp LEFT JOIN (SELECT wpc.mac, ".$dbt['member'].".login, ".$dbt['member'].".publicname FROM ".$dbt['computer']." AS wpc LEFT JOIN (".$dbt['member'].") ON (wpc.id_member = ".$dbt['member'].".id)) AS member ON (wp.mac = member.mac) WHERE wp.ts IN (SELECT MAX(wp1.ts) FROM ".$dbt['presence']." AS wp1) AND wp.ts > FROM_UNIXTIME(".$time_delayed.") GROUP BY login) AS list";

	$result = query($sql);
	$data = $result->fetchAll(PDO::FETCH_COLUMN);
	// echo array_shift($data).ELB;
	$data_encoded = json_encode(intval(array_shift($data)));
	exit($data_encoded);
}

/* route
*/
$func = $query."_".$arg;
// echo "func=".$func.ELB;
if (function_exists($func))
	$func($dbt, $time_delayed);
else
	exit("error - unable to find function: ".$func);
