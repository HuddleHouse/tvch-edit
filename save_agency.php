<?php
	include 'connect.php';

	$agencyName = $_POST['agencyname'];
	$website = $_POST['website'];
	$faith = $_POST['faith'];
	$govt = $_POST['govt'];
	$id = $_POST['id'];



	if($id) {
		$sql = "update agency set agencyname = :name,
		website = :website,
		faith = :faith,
		govt = :govt
		where id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':name', $agencyName, PDO::PARAM_STR);
		$stmt->bindParam(':website', $website, PDO::PARAM_STR);
		$stmt->bindParam(':faith', $faith, PDO::PARAM_STR);
		$stmt->bindParam(':govt', $govt, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
	}
	else {
		$sql = "insert into agency(agencyname, website, faith, govt)
		values (:name, :website, :faith, :govt)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':name', $agencyName, PDO::PARAM_STR);
		$stmt->bindParam(':website', $website, PDO::PARAM_STR);
		$stmt->bindParam(':faith', $faith, PDO::PARAM_STR);
		$stmt->bindParam(':govt', $govt, PDO::PARAM_STR);
		$stmt->execute();
		$id = $conn->lastInsertId();
	}

echo $id;
