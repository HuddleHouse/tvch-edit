<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Edit Community Resources</title>

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<?php
		include 'connect.php';

		$json = array();

		$query = $conn->prepare('select agencyname as name, id from agency order by name asc');
		$query->execute();
		$agencies = $query->fetchAll();

		foreach($agencies as $row){
			if($row['name']) {
				$name = $row['name'];
			}
			else {
				$name = 'no name';
			}
			array_push($json, array('id' => $row['id'], 'agency' => $name, 'name' => $name, 'type' => 'Agency'));
		}

		$p = $conn->prepare('select program as name, id from program order by name asc');
		$p->execute();
		$programs = $p->fetchAll();

		foreach($programs as $row){
			if($row['name']) {
				$name = $row['name'];
			}
			else {
				$name = 'no name';
			}
			array_push($json, array('id' => $row['id'], 'program' => $name, 'name' => $name, 'type' => 'Programs'));
		}
	?>
    <!-- Page Content -->
    <div class="container" id="page-container">
    	<div class="row">
    		<div class="col-md-8 col-md-offset-2">
				<div class="form-horizontal">
					<fieldset>

					<!-- Form Name -->
					<legend>Add/Edit an Agency or Program Boobs</legend>

					<!-- Button (Double) -->
					<div class="form-group">
					  <div class="row " style="padding:10px;">
					    <a  id="add-agency" name="add-agency" class="btn btn-default" href="./add-agency.php">Add an Agency</a>
					    <a  id="add-program" name="add-program" class="btn btn-default" href="./add-program.php">Add a Program</a>
					  </div>
					</div>

					<!-- Search input-->
					<div class="form-group">
					  <label class="col-md-2 control-label" for="inputSearch">Search</label>
					  <div class="col-md-8">
					    <input id="inputSearch" onchange="update()" onkeyup="update()" onpaste="update()" oninput="update()" name="inputSearch" placeholder="Agency/Program Name" class="form-control input-md">
					    <div style="padding-top: 7px;">
							<input id="agency" onchange="update()" checked type="checkbox" class="fuse-checkbox">
							<label for="agency" style="padding-right: 5px;">Agencies</label>
							<input id="program" onchange="update()" checked type="checkbox" class="fuse-checkbox">
							<label for="program">Programs</label>
					    </div>
					  </div>
					</div>

					</fieldset>
				</div>

			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-med-8 col-md-offset-2">
					<div id="theResults">

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div id="results">
		<!-- Results Render here -->
		</div>
	</div>

    <!-- Scripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/fuse.js"></script>

	<script>
		var data = <?php echo json_encode($json); ?>;

		function update(){
			var thekeys = [];
			if(document.getElementById("agency").checked) {
				thekeys.push('agency');
			}
			if(document.getElementById("program").checked) {
				thekeys.push('program');
			}


			var options = {
			  keys: thekeys,
			  threshold: 0.4
			}
			var f = new Fuse(data, options);

			 var result = f.search(document.getElementById("inputSearch").value);
				$("#theResults").empty();

			 result.forEach(function(entry) {
				 if(entry.type === "Agency") {
					 var node = "<div class='row'><a href='./add-agency.php?id="+entry.id+"'><h4>"+entry.type+" - "+entry.name+"</h4></a></div>";
				 }
				 else {
					 var node = "<div class='row'><a href='./add-program.php?id="+entry.id+"'><h4>"+entry.type+" - "+entry.name+"</h4></a></div>";
				 }

			    $("#theResults").append(node);
			});
		}


	</script>
</body>
</html>
