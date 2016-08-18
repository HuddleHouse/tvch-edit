<?php
	include_once("connect.php");

	$county = $_GET['county'];
	$offer = $_GET['offer'];


$search = array(
    "select" => "SELECT agency.id, agency.agencyname, agency.website, agency.faith as funding_faith, agency.govt as funding_govt, program.program, program.phone, program.address1, program.address2, program.altphone, program.contact, program.email, program.id as id2
			FROM program
			
			LEFT JOIN agency
			ON agency.id = program.agencyid
			
			LEFT JOIN programcounty
			ON programcounty.progid = program.id

			LEFT JOIN programservices
			ON programservices.progid = program.id",
    
    "where" => "WHERE programcounty.countyid = $county",
    
    "and" => "AND programservices.servicesid =  $offer",
	"group" => "GROUP BY program",
    "limit" => "LIMIT 550"
);

	if ($county=="all") {
	    unset($search["where"]);
	    $search["and"]="WHERE programservices.servicesid =  $offer";
	}
	if ($offer=="all") {
	    unset($search["and"]);
	}

	$search = implode(' ', $search);
	$result = $conn->query($search);

	$bootstrap_row=1;
?>



<?php	
	while ($row = $result->fetch_assoc()){
		extract($row);

		//SQL for Counties
		$e_counties[$id]='None';
		$sql2="SELECT county.county
		FROM county
		LEFT JOIN programcounty
		ON programcounty.countyid = county.id
		WHERE progid = $id2";
		$result2 = $conn->query($sql2);
		while ($row2 = $result2 -> fetch_assoc()){
			if ($e_counties[$id]=='None') $e_counties[$id]='';
			$e_counties[$id] .= "$row2[county], ";
			
		}
		//Remove comma
		$e_counties[$id] = substr($e_counties[$id], 0, -2);

		//SQL for Services
		$e_services[$id] ='None';
		$sql2="SELECT services.servtype
		FROM services
		LEFT JOIN programservices
		ON programservices.servicesid = services.id
		WHERE progid = $id2";
		$result2 = $conn->query($sql2);
		while ($row2 = $result2 -> fetch_assoc()){
			if ($e_services[$id]=='None') $e_services[$id]='';
			$e_services[$id] .= "$row2[servtype], ";
		}
		//Remove comma
		$e_services[$id] = substr($e_services[$id], 0, -2);

		//SQL for Requirements
		$e_requirements[$id] ='None';
		$sql2="SELECT qual.qual
		FROM qual
		LEFT JOIN programqual
		ON programqual.qualid = qual.id
		WHERE progid = $id2";
		$result2 = $conn->query($sql2);
		while ($row2 = $result2 -> fetch_assoc()){
			if ($e_requirements[$id]=='None') $e_requirements[$id]='';
			$e_requirements[$id] .= "$row2[qual], ";
		}
		//Remove comma
		$e_requirements[$id] = substr($e_requirements[$id], 0, -2);

		//SQL for Disqualifications
		$e_disqual[$id]='None';
		$sql2="SELECT disqual.disq
		FROM disqual
		LEFT JOIN programdisqual
		ON programdisqual.disqid = disqual.id
		WHERE progid = $id2";
		$result2 = $conn->query($sql2);
		while ($row2 = $result2 -> fetch_assoc()){
			if ($e_disqual[$id]=='None') $e_disqual[$id]='';
			$e_disqual[$id] .= "$row2[disq], ";
		}
		//Remove comma
		$e_disqual[$id] = substr($e_disqual[$id], 0, -2);

		//SQL for Funding
		if ($funding_faith<>"" || $funding_govt<>"") {
			if ($funding_faith<>"") $funding[$id]="Faith"; //echo "Faith";
			if ($funding_govt<>"") $funding[$id]="Government"; //echo "Government";
		}
		else {$funding[$id] ='None';}

		//Cleanup
		if ($website=='') $website="<br/>";
		if ($address2=='') $address2="<br/>";

		//Bootstrap Row
		if ($bootstrap_row % 2 == 0) {
  			$new_row="<div class='row'>";
  			$close_row="</div>";
  			$bootstrap_row++;
		}
		else {
			$new_row="";
			$close_row="";
			$bootstrap_row++;
		}

?>
<!-- Render Start -->
	<div class="row fader">	
		<div class="col-md-8 full-row">
			<!-- Agency Name -->
			<div class="purple-heading">
				<strong class="uppercase"><?php echo $agencyname ?></strong><br/>
				<small><?php echo $program ?></small>
			</div>
			<!-- Row 0 -->
			<div class="purple-bg full-row">
				<strong class="uppercase">Counties Served:</strong><br/>
				<?php echo $e_counties[$id] ?>		
			</div>	
			<!-- Row 1 -->
			<div class="gray-bg">
				<div class="result-row " style="border-right:2px solid black;">
					
					<strong class="uppercase">Contact Person:</strong><br/>
					<?php echo $contact ?><br/><br/>


				</div><div class="result-row">
					<strong class="uppercase">Contact Email:</strong><br/>
					<a href="mailto:<?php echo $website ?>"><?php echo $email ?></a>
				</div>
			</div>
			<!-- Row 2 -->
			<div class="purple-bg">
				<div class="result-row" style="border-right:2px solid black;">
					
					<strong class="uppercase">Address:</strong><br/>
					<?php echo $address1 ?><br/>
					<?php echo $address2 ?>

				</div><div class="result-row">
					<strong class="uppercase">Phone Number:</strong><br/>
					<?php echo $phone ?><br/>
					<?php echo $altphone ?>
				</div>
			</div>
			<!-- Row 3 -->
			<div class="gray-bg full-row">
				<strong class="uppercase">Services Provided:</strong><br/>
				<?php echo $e_services[$id] ?>		
			</div>	
			<!-- Row 4 -->
			<div class="purple-bg full-row">
				<strong class="uppercase">Program Eligibility Requirements:</strong><br/>
				<?php echo $e_requirements[$id] ?>		
			</div>
			<!-- Row 5 -->
			<div class="gray-bg full-row">
				<strong class="uppercase">Disqualifying Factors:</strong><br/>
				<?php echo $e_disqual[$id] ?>			
			</div>	
			<!-- Row 6 -->
			<div class="purple-bg">
				<div class="result-row " style="border-right:2px solid black;">
					<strong class="uppercase">Agency Website:</strong><br/>
					<a href="http://<?php echo $website ?>"><?php echo $website ?></a>
				</div><div class="result-row">
					<strong class="uppercase">Funding:</strong><br/>
					<?php echo $funding[$id] ?>
				</div>
			</div>		
		</div>
	</div>
<!-- Render End -->



<?php	}; ?>


