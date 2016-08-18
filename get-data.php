<?php
	include 'connect.php';

	$json = array();

	$query = $conn->prepare('select agencyname as name, id from agency');
	$query->execute();
	$agencies = $query->fetchAll();

	foreach($agencies as $row){
		array_push($json, array('id' => $row['id'], 'agency' => $row['name'], 'program' => ''));
	}

	$p = $conn->prepare('select program as name, id from program');
	$p->execute();
	$programs = $p->fetchAll();

	foreach($programs as $row){
		array_push($json, array('id' => $row['id'], 'program' => $row['name'], 'agency' => ''));
	}
?>