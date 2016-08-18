<?php
	include 'connect.php';

	$counties = $_POST['counties'];
	$services = $_POST['services'];
	$qual = $_POST['quals'];
	$disqual = $_POST['disquals'];
	$id = $_POST['id'];
	$address = $_POST['address'] . ' ' . $_POST['city'] . ' ' . $_POST['state'];
    $address = str_replace(' ', '+', $address);
    $latLongJsonString = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyCRNDY56oSlDyDE8N-GNCOOOrYwHdtffi0";
    $geocode=file_get_contents($latLongJsonString);
    $output= json_decode($geocode);
    $lat = $output->results[0]->geometry->location->lat;
    $long = $output->results[0]->geometry->location->lng;

	if($id) {
		$sql = "update program set program = :name,
		agencyid = :agency,
		contact = :contact,
		email = :email,
		address1 = :address,
		address2 = :city,
		state = :state,
		phone = :phone,
		altphone = :altphone,
	    latitude = :lat,
	    longitude = :long
		where id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
		$stmt->bindParam(':agency', $_POST['agency'], PDO::PARAM_STR);
		$stmt->bindParam(':contact', $_POST['contactName'], PDO::PARAM_STR);
		$stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
		$stmt->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
		$stmt->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
		$stmt->bindParam(':state', $_POST['state'], PDO::PARAM_STR);
		$stmt->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
		$stmt->bindParam(':altphone', $_POST['altphone'], PDO::PARAM_STR);
		$stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
		$stmt->bindParam(':long', $long, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
	}
	else {
		$sql = "insert into program(program, agencyid, contact, email, address1, address2, state, phone, altphone, latitude, longitude)
		values (:name, :agency, :contact, :email, :address, :city, :state, :phone, :altphone, :lat, :long)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
		$stmt->bindParam(':agency', $_POST['agency'], PDO::PARAM_STR);
		$stmt->bindParam(':contact', $_POST['contactName'], PDO::PARAM_STR);
		$stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
		$stmt->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
		$stmt->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
		$stmt->bindParam(':state', $_POST['state'], PDO::PARAM_STR);
		$stmt->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
		$stmt->bindParam(':altphone', $_POST['altphone'], PDO::PARAM_STR);
        $stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
        $stmt->bindParam(':long', $long, PDO::PARAM_STR);
		$stmt->execute();
		$id = $conn->lastInsertId();
	}
echo $id;


	$query = $conn->prepare('select countyid from programcounty p where p.progid = :id');
	$query->bindParam(':id', $id, PDO::PARAM_STR);
	$query->execute();
	$data = $query->fetchAll();
	$countyData = array();
	foreach($data as $d){
		$countyData[$d[0]] = $d[0];
	}

	foreach($counties as $county){
		if($countyData[$county]) {
			unset($countyData[$county]);
		}
		else {
			$stmt = $conn->prepare("INSERT INTO programcounty (progid, countyid) VALUES (:progid, :countyid)");
			$stmt->bindParam(':progid', $id);
			$stmt->bindParam(':countyid', $county);
			$stmt->execute();
		}
	}

	foreach($countyData as $county) {
		$stmt = $conn->prepare("delete from programcounty where progid = :progid and countyid = :countyid");
		$stmt->bindParam(':progid', $id);
		$stmt->bindParam(':countyid', $county);
		$stmt->execute();
	}


	$query = $conn->prepare('select servicesid from programservices p where p.progid = :id');
	$query->bindParam(':id', $id, PDO::PARAM_STR);
	$query->execute();
	$data = $query->fetchAll();
	$serviceData = array();
	foreach($data as $d){
		$serviceData[$d[0]] = $d[0];
	}

	foreach($services as $service){
		if($serviceData[$service]) {
			unset($serviceData[$service]);

		}
		else {
			$stmt = $conn->prepare("INSERT INTO programservices (progid, servicesid) VALUES (:progid, :servicesid)");
			$stmt->bindParam(':progid', $id);
			$stmt->bindParam(':servicesid', $service);
			$stmt->execute();
		}
	}


	foreach($serviceData as $service) {
		$stmt = $conn->prepare("delete from programservices where progid = :progid and servicesid = :servicesid");
		$stmt->bindParam(':progid', $id);
		$stmt->bindParam(':servicesid', $service);
		$stmt->execute();
	}

	$query = $conn->prepare('select qualid from programqual p where p.progid = :id');
	$query->bindParam(':id', $id, PDO::PARAM_STR);
	$query->execute();
	$data = $query->fetchAll();
	$qualData = array();
	foreach($data as $d){
		$qualData[$d[0]] = $d[0];
	}

	foreach($qual as $q){
		if($qualData[$q]) {
			unset($qualData[$q]);
		}
		else {
			$stmt = $conn->prepare("INSERT INTO programqual (progid, qualid) VALUES (:progid, :qualid)");
			$stmt->bindParam(':progid', $id);
			$stmt->bindParam(':qualid', $q);
			$stmt->execute();

		}
	}

	foreach($qualData as $q) {
		$stmt = $conn->prepare("delete from programqual where progid = :progid and qualid = :qualid");
		$stmt->bindParam(':progid', $id);
		$stmt->bindParam(':qualid', $q);
		$stmt->execute();
	}

	$query = $conn->prepare('select disqid from programdisqual p where p.progid = :id');
	$query->bindParam(':id', $id, PDO::PARAM_STR);
	$query->execute();
	$data = $query->fetchAll();
	$disqualData = array();
	foreach($data as $d){
		$disqualData[$d[0]] = $d[0];
	}

	foreach($disqual as $d){
		if($disqualData[$d]) {
			unset($disqualData[$d]);
		}
		else {
			$stmt = $conn->prepare("INSERT INTO programdisqual (progid, disqid) VALUES (:progid, :disqid)");
			$stmt->bindParam(':progid', $id);
			$stmt->bindParam(':disqid', $d);
			$stmt->execute();

		}
	}

	foreach($disqualData as $d) {
		$stmt = $conn->prepare("delete from programdisqual where progid = :progid and disqid = :disqid");
		$stmt->bindParam(':progid', $id);
		$stmt->bindParam(':disqid', $d);
		$stmt->execute();
	}
