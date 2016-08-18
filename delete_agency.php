<?php
	include 'connect.php';

	$id = $_POST['id'];



	if($id) {
		$stmt = $conn->prepare("select * from program where agencyid = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$data = $stmt->fetchAll();
		if($data) {
			echo json_encode(0);
		}
		else {
			echo json_encode(1);
			$stmt = $conn->prepare("delete from agency where id = :id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();
		}
	}
