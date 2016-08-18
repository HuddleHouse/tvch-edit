<?php
	include 'connect.php';

	$id = $_POST['id'];

	if($id) {
// 		$stmt = $conn->prepare("select * from program where agencyid = :id");
// 		$stmt->bindParam(':id', $id);
// 		$stmt->execute();
// 		$data = $stmt->fetchAll();
/*
		if($data) {
			echo json_encode($id);
		}
		else {
*/
			echo json_encode(1);
			$stmt = $conn->prepare("delete from programqual where progid = :id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$stmt = $conn->prepare("delete from programservices where progid = :id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$stmt = $conn->prepare("delete from programdisqual where progid = :id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$stmt = $conn->prepare("delete from programcounty where progid = :id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$stmt = $conn->prepare("delete from program where id = :id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();
// 		}
	}