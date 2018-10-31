<?php
require_once __DIR__ . '/vendor/autoload.php';
$websev = "https://welcome-something88.herokuapp.com";
$client = new Zend\Soap\Client($websev.'/data_aircon/server.php?wsdl');

$link_to_xml_aircon = ($websev."/data_aircon/Aircon.xml");
$link_to_xml_personal = ($websev."/data_aircon/Personal.xml");
$link_to_xml_product = ($websev."/data_aircon/Product.xml");


/** 
	// <== Disable Service
*/

	/**
		Please Insert for AirConditionor
	*/

	// $result = $client->InsertDataAirCon([
	// 	'room'=> '88',
	// 	'temp'=>'25',
	// 	'time'=>'12:00 AM'
	// ]);
	// echo "Added Airconditionor";
	// echo $result['InsertDataAirConResult'];
	// echo ("<br>");
	// echo ("<a href='".$link_to_xml_personal."'>Click here to XML AirConditionor</a>");

	

	/** 
		Please Query for AirConditionor 
	*/
	// header("Content-Type: text/xml");
	// $result = $client->QueryDataAirCon();
	// echo $result->QueryDataAirConResult;



/** ================================T E S T I N G================================================ */


	/**
		Query for Personal
	*/
	// header("Content-Type: text/xml");
	// $result = $client->showPersonal();
	// echo $result->showPersonalResult;



	/**
		Please Insert for Product
	*/

	// $result = $client->addProduct([
	// 	'id_product' => rand(1000, 9999),
	// 	'owner_product'=> 'Trakansak',
	// 	'address_product'=>'674/31',
	// 	'weight_product'=>'20'
	// ]);
	// echo "Added Product";
	// echo $result['addProductResult'];
	// echo ("<br>");
	// echo ("<a href='".$link_to_xml_product."'>Click here to XML Product</a>");



	/**
		Confirm Delivery for Product
	*/

	$result = $client->confirmProduct(['id_product'=> 1598]);
	echo ("Confirm Product");
	echo $result['confirmProductResult'];
	echo ("<br>");
	echo ("<a href='".$link_to_xml_product."'>Click here to XML Product</a>");


	/**
		Query Delivery for Product
	*/
	// header("Content-Type: text/xml");
	// $result = $client->queryProduct();
	// echo $result->queryProductResult;


?>