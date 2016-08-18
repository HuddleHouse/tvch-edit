<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Add/Edit Program</title>

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
<?php include 'connect.php';

	if($_GET['id']) {
		//(name, agencyid, contact, email, address, city, state)
		$id = $_GET['id'];
		$query = $conn->prepare('select * from program where id = :id');
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$program = $query->fetch();

		$query = $conn->prepare('select countyid from programcounty p where p.progid = :id');
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetchAll();
		$countyData = array();
		foreach($data as $d){
			$countyData[] = $d[0];
		}

		$query = $conn->prepare('select servicesid from programservices p where p.progid = :id');
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetchAll();
		$serviceData = array();
		foreach($data as $d){
			$serviceData[] = $d[0];
		}

		$query = $conn->prepare('select qualid from programqual p where p.progid = :id');
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetchAll();
		$qualData = array();
		foreach($data as $d){
			$qualData[] = $d[0];
		}

		$query = $conn->prepare('select disqid from programdisqual p where p.progid = :id');
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetchAll();
		$disqualData = array();
		foreach($data as $d){
			$disqualData[] = $d[0];
		}
	}



		$query = $conn->prepare('select agencyname as name, id from agency order by name asc');
		$query->execute();
		$agencies = $query->fetchAll();

		$query = $conn->prepare('select county as name, id from county order by name asc');
		$query->execute();
		$counties = $query->fetchAll();

		$query = $conn->prepare('select servtype as name, id from services order by name asc');
		$query->execute();
		$services = $query->fetchAll();

		$query = $conn->prepare('select qual as name, id from qual order by name asc');
		$query->execute();
		$quals = $query->fetchAll();

		$query = $conn->prepare('select disq as name, id from disqual order by name asc');
		$query->execute();
		$disquals = $query->fetchAll();
	?>
    <!-- Page Content -->
    <div class="container" id="page-container">
    	<div class="row">
    		<div class="col-md-12">
    			<form class="form-horizontal">
				<fieldset>

				<!-- Form Name -->
				<legend>Add/Edit Program</legend>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="name">Program Name</label>
				  <div class="col-md-4">
				  <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
				  </div>
				</div>

				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="agency">Agency</label>
				  <div class="col-md-4">
				    <select id="agency" name="agency" class="form-control">
					    <?php foreach($agencies as $agency) {
						    echo "<option value=".$agency['id'].">".$agency['name']."</option>";
					    }
						?>
				    </select>
				  </div>
				</div>

				<!-- Multiple Checkboxes (inline) -->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="counties">Counties Served</label>
				  <div class="col-md-8">
					  <?php
						  foreach($counties as $county) {
							  echo "<label class='checkbox-inline' for=".$county['id'].">
				      <input type='checkbox' name='counties[]' id='county-".$county['id']."' value=".$county['id'].">".$county['name']."</label>";
						  }
					  ?>
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="contactName">Contact Person</label>
				  <div class="col-md-4">
				  <input id="contactName" name="contactName" type="text" placeholder="" class="form-control input-md">
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="email">Contact Email</label>
				  <div class="col-md-4">
				  <input id="email" name="email" type="text" placeholder="" class="form-control input-md">
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="address">Address</label>
				  <div class="col-md-4">
				  <input id="address" name="address" type="text" placeholder="" class="form-control input-md">
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="city">City</label>
				  <div class="col-md-4">
					  <input id="city" name="city" type="text" placeholder="" class="form-control input-md">
				  </div>
				  <label class="col-md-1 control-label" for="state">State</label>
				  <div class="col-md-1">
					  <input id="state" name="state" type="text" placeholder="TN" value="TN" maxlength="2" class="form-control input-md">
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-2 control-label" for="phone">Phone</label>
				  <div class="col-md-4">
					  <input type="text" id="phone" name="phone" class="form-control input-md bfh-phone" data-country="US">
				  </div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label" for="altphone">Alt Phone</label>
				  <div class="col-md-4">
					<input type="text" id="altphone" name="altphone" class="form-control input-md bfh-phone" data-country="US">
				  </div>
				</div>
				<!-- Text input-->
				<div class="form-group">
				  				</div>

				<!-- Multiple Checkboxes (inline) -->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="services">Services Provided</label>
				  <div class="col-md-8">
				    <?php
						  foreach($services as $service) {
							  echo "<label class='checkbox-inline' for='service-".$service['id']."'>
				      <input type='checkbox' name='services[]' id='service-".$service['id']."' value=".$service['id'].">".$service['name']."</label>";
						  }
					  ?>
				  </div>
				</div>

				<!-- Multiple Checkboxes (inline) -->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="eligibility">Program Eligibility Requirements</label>
				  <div class="col-md-8">
				  	<?php
						  foreach($quals as $qual) {
							  echo "<label class='checkbox-inline' for='qual-".$qual['id']."'>
				      <input type='checkbox' name='quals[]' id='qual-".$qual['id']."' value=".$qual['id'].">".$qual['name']."</label>";
						  }
					  ?>
				  </div>
				</div>

				<!-- Multiple Checkboxes (inline) -->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="disqual">Disqualifying Factors</label>
				  <div class="col-md-8">
				    <?php
						  foreach($disquals as $disqual) {
							  echo "<label class='checkbox-inline' for='disqual-".$disqual['id']."'>
				      <input type='checkbox' name='disquals[]' id='disqual-".$disqual['id']."' value=".$disqual['id'].">".$disqual['name']."</label>";
						  }
					  ?>
				  </div>
				</div>
				<input type="hidden" name="id" value="<?php echo $id ?>">

				<!-- Button (Double) -->
				<div class="form-group" style="margin-top: 40px;">
				  <label class="col-md-8 control-label" for="save"></label>
				  <div class="col-md-4">
				    <a id="save" name="save" class="btn btn-success" onclick="saveData()">Save</a>
				    <a id="delete" name="delete" class="btn btn-danger" onclick="deleteData()">Delete</a>
				  </div>
				</div>

				</fieldset>
				</form>

    		</div>
   		</div>
	</div>

	<div class="modal fade" id="myModal" role="dialog" style="display: none;">
	    <div class="modal-dialog">

	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Saved</h4>
	        </div>
	        <div class="modal-body">
	          <p>Program successfuly saved.</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
	        </div>
	      </div>

	</div>
  </div>

	<div class="modal fade" id="deleteSuccess" role="dialog" style="display: none;">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Deleted</h4>
	        </div>
	        <div class="modal-body">
	          <p>Program successfully deleted.</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
	        </div>
	      </div>
		</div>
	</div>

    <!-- Scripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
	<script src="js/bootstrap-formhelpers-phone.js"></script>
	<script src="js/bootstrap-formhelpers-phone.format.js"></script>

	<script>

		function setProgramValues(name, agencyid, contact, email, address, city, state, phone, altphone){
			$('#name').val(name);
			$('#agency').val(agencyid);
			$('#contactName').val(contact);
			$('#email').val(email);
			$('#address').val(address);
			$('#city').val(city);
			$('#state').val(state);
			$('#phone').val(phone);
			$('#altphone').val(altphone);
		}

		function setCities(counties) {
			$.each(counties, function(index, value){
				$('#county-'+value).prop('checked', true);
			});
		}

		function setServices(services) {
			$.each(services, function(index, value){
				$('#service-'+value).prop('checked', true);
			});
		}

		function setQual(services) {
			$.each(services, function(index, value){
				$('#qual-'+value).prop('checked', true);
			});
		}

		function setDisqual(services) {
			$.each(services, function(index, value){
				$('#disqual-'+value).prop('checked', true);
			});
		}

		function deleteData() {
		      $.ajax({
		           type: "POST",
		           url: 'delete_program.php',
		           data: $('form').serialize(),
		           complete:function(html) {
			         if(html.responseText === '0'){
				         $("#noDelete").modal("toggle");
			         }
			         else if(html.responseText === '1') {
				         $("#deleteSuccess").modal("toggle");
			             var URL = "./";
						 setTimeout(function(){ window.location = URL; }, 2000);
			         }

					 console.log(html.responseText);

		           }
		      });
		 }

		function saveData() {
		      $.ajax({
		           type: "POST",
		           url: 'save_program.php',
		           data: $('form').serialize(),
		           success:function(html) {
		             console.log(html);
		             $("#myModal").modal("toggle");
		             var URL = "./add-program.php?id="+html;

		             setTimeout(function(){ window.location = URL; }, 2000);
		           }
		      });
		 }
	</script>
	<?php
		echo "<script> setProgramValues('".$program['program']."', ".$program['agencyid'].", '".$program['contact']."', '".$program['email']."', '".$program['address1']."', '".$program['address2']."', '".$program['state']."', '".$program['phone']."', '".$program['altphone']."');
		setCities(".json_encode($countyData).");
		setServices(".json_encode($serviceData).");
		setDisqual(".json_encode($disqualData).");
		setQual(".json_encode($qualData).");

		</script>";
	?>

</body>
</html>
