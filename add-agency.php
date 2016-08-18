<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Filtering Results</title>

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
	<?php include_once('connect.php');

	if($_GET['id']) {
		//(name, agencyid, contact, email, address, city, state)
		$id = $_GET['id'];
		$query = $conn->prepare('select * from agency where id = :id');
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$agency = $query->fetch();
		$faith = 0;
		$govt = 0;
		if($agency['faith'] == 'on') {
			$faith = 1;
		}
		if($agency['govt'] == 'on') {
			$govt = 1;
		}

	}

	?>

    <!-- Page Content -->
    <div class="container" id="page-container">
    	<div class="row">
    		<div class="col-md-8 col-md-offset-2">
    			<form class="form-horizontal">
				<fieldset>

				<!-- Form Name -->
				<legend>Add/Edit an Agency</legend>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="agencyname">Agency Name</label>
				  <div class="col-md-4">
				  <input id="agencyname" name="agencyname" type="text" placeholder="" class="form-control input-md" required="">
				  <span class="help-block">The name of the Agency.</span>
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="website">Website</label>
				  <div class="col-md-4">
				  <input id="website" name="website" type="text" placeholder="" class="form-control input-md" required="">
				  <span class="help-block">The website of the agency</span>
				  </div>
				</div>

				<!-- Multiple Radios (inline) -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="faith">Faith Based</label>
				  <div class="col-md-4">
				    <label class="radio-inline" for="faith-0">
				      <input type="radio" name="faith" id="faith-0" value="on" >
				      Yes
				    </label>
				    <label class="radio-inline" for="faith-1">
				      <input type="radio" name="faith" id="faith-1" value="off" checked="checked">
				      No
				    </label>
				  </div>
				</div>

				<!-- Multiple Radios (inline) -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="govt">Government Funded</label>
				  <div class="col-md-4">
				    <label class="radio-inline" for="govt-0">
				      <input type="radio" name="govt" id="govt-0" value="on">
				      Yes
				    </label>
				    <label class="radio-inline" for="govt-1">
				      <input type="radio" name="govt" id="govt-1" value="off" checked="checked">
				      No
				    </label>
				  </div>
				</div>
				<input type="hidden" name="id" value="<?php echo $id ?>">

				<!-- Button -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="save"></label>
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
	          <p>Agency successfully saved.</p>
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
	          <p>Agency successfully deleted.</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
	        </div>
	      </div>
		</div>
	</div>
	<div class="modal fade" id="noDelete" role="dialog" style="display: none;">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Error</h4>
	        </div>
	        <div class="modal-body">
	          <p>Cannot delete this Agency because it is assigned to one or more Programs. Change the agency on each Program first and then try again.</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
	        </div>
	      </div>
		</div>
	</div>
    <!-- Scripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

	<script>

		function setAgencyValues(name, website, faith, govt){
			$('#agencyname').val(name);
			$('#website').val(website);
			if(faith == 1) {
				$('#faith-0').prop('checked', true);

			}
console.log(faith);
			if(govt == 1) {
				$('#govt-0').prop('checked', true);
			}
		}

		function deleteData() {
		      $.ajax({
		           type: "POST",
		           url: 'delete_agency.php',
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
		           url: 'save_agency.php',
		           data: $('form').serialize(),
		           success:function(html) {
		             $("#myModal").modal("toggle");
		             var URL = "./add-agency.php?id="+html;

		             setTimeout(function(){ window.location = URL; }, 2000);
		           }
		      });
		 }

	</script>
	<?php
		echo "<script> setAgencyValues('".$agency['agencyname']."', '".$agency['website']."', ".$faith.", ".$govt.");


		</script>";
	?>

</body>
</html>
