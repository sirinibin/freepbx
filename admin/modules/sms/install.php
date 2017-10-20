<?php
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2013 Schmooze Com Inc.
//
out('Creating SMS Message Table');
$table = FreePBX::Database()->migrate("sms_messages");
$cols = array(
	"id" => array(
		"type" => "integer",
		"primaryKey" => true,
		"autoincrement" => true
	),
	"from" => array(
		"type" => "string",
		"length" => 20,
		"notnull" => true,
	),
	"to" => array(
		"type" => "string",
		"length" => 20,
		"notnull" => true,
	),
	"threadid" => array(
		"type" => "string",
		"length" => 50,
		"notnull" => true,
	),
	"cnam" => array(
		"type" => "string",
		"length" => 40,
		"notnull" => false,
	),
	"direction" => array(
		"type" => "string",
		"length" => 3,
		"notnull" => true,
	),
	"tx_rx_datetime" => array(
		"type" => "datetime",
	),
	"body" => array(
		"type" => "text",
		"notnull" => true,
	),
	"delivered" => array(
		"type" => "boolean",
		"default" => '0'
	),
	"read" => array(
		"type" => "boolean",
		"default" => '0'
	),
	"adaptor" => array(
		"type" => "string",
		"length" => 45,
		"notnull" => false,
	),
	"emid" => array(
		"type" => "string",
		"length" => 255,
		"notnull" => false,
	),
);
$s = $table->modify($cols);
unset($table);

out('Creating SMS Routing Table');
$table = FreePBX::Database()->migrate("sms_routing");
$cols = array(
	"id" => array(
		"type" => "integer",
		"primaryKey" => true,
		"autoincrement" => true
	),
	"did" => array(
		"type" => "string",
		"length" => 45,
		"notnull" => true,
	),
	"uid" => array(
		"type" => "integer",
		"notnull" => true,
	),
	"accepter" => array(
		"type" => "string",
		"length" => 45,
		"notnull" => false,
	),
	"adaptor" => array(
		"type" => "string",
		"length" => 45,
		"notnull" => false,
	),
);
$s = $table->modify($cols);
unset($table);

out('Creating SMS Media Table');
$table = FreePBX::Database()->migrate("sms_media");
$cols = array(
	"id" => array(
		"type" => "integer",
		"primaryKey" => true,
		"autoincrement" => true
	),
	"mid" => array(
		"type" => "integer",
		"notnull" => true,
	),
	"name" => array(
		"type" => "string",
		"length" => 255,
		"notnull" => true,
	),
	"raw" => array(
		"type" => "blob",
		"notnull" => true,
	)
);
$s = $table->modify($cols);
unset($table);

$sth = FreePBX::Database()->prepare("SELECT * FROM sms_messages WHERE threadid = ''");
$sth->execute();
$messages = $sth->fetchAll(PDO::FETCH_ASSOC);
$threads = array();
foreach($messages as $message) {
	if($message['direction'] == 'in') {
		$local = $message['to'];
		$remote = $message['from'];
	} else {
		$local = $message['from'];
		$remote = $message['to'];
	}
	$threadid = sha1($local.$remote);
	$message['threadid'] = $threadid;
	$threads[$threadid][] = $message;
	$sth = FreePBX::Database()->prepare("UPDATE sms_messages SET threadid = :threadid WHERE id = :id");
	$sth->execute(array("threadid" => $threadid, "id" => $message['id']));
}
