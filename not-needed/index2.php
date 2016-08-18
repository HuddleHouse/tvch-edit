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
	<?php include_once('connect.php'); ?>

    <!-- Page Content -->
    <div class="container" id="page-container">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="btn-group">
	    		<div class="dropdown">
				  <button class="btn btn-default dropdown-toggle btn-county" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				    County
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	<li class="counties county-all"><a href="#" id='all' class="county">All Counties</a></li>
				  	<li role="presentation" class="divider"></li>
					  <?php
					  $sql = "SELECT * FROM county";
					  $result = $conn->query($sql);
					  while ($row = $result->fetch_assoc()){
							extract($row);

							echo '<li class="counties county-'.$id.'"><a href="#" id="'.$id.'" class="county">'.$county.'</a></li>';
						}
					  ?>
				  </ul>
				</div>
				</div>

				<div class="btn-group">
	    		<div class="dropdown">
				  <button class="btn btn-default dropdown-toggle btn-offer" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				    Service
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  <li class="offers offer-all"><a href="#" id='all' class="offer">All Services</a></li>
				  <li role="presentation" class="divider"></li>
					  <?php
					  $sql = "SELECT * FROM services";
					  $result = $conn->query($sql);
					  while ($row = $result->fetch_assoc()){
							extract($row);
							echo '<li class="offers offer-'.$id.'"><a href="#" id="'.$id.'" class="offer">'.$servtype.'</a></li>';
						}
					  ?>
				  </ul>
				</div>
				</div>
				<br/><br/>	
				<div class="alert alert-success" style=" display:none;" role="alert">
					County Filter: <span id="active-county" class="strong">all</span><br/>
					Service Filter: <span id="active-offer" class="strong">all</span>
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

</body>
</html>
