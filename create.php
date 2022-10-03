<?php
session_start();

// check if user is logged in.
	if (!isset($_SESSION['employee']) || (trim($_SESSION['employee']) == '')) {
    	header("location: index.php");
    	exit(); 
	}

	require_once("conn.php");

	$user = $_SESSION['employee'];

	$paramID = $_GET['id'];
	$reviewYear = $_GET['year'];



	$secondForm = false;
	$firstForm = true;
	
	$sql = "SELECT * FROM employee WHERE employee_id='$user'";

	$sql1 = "SELECT E.*, j.*, d.* FROM employee AS E LEFT join job as j on E.job_id = j.job_id LEFT join department as d ON d.department_id = e.department_id
	 WHERE E.employee_id='$paramID'";

	// $sql1 = "SELECT * FROM employee WHERE supervisor_id='$user'";
	$res = $dbConn->query($sql1)->fetch_assoc();


	$result = $dbConn->query($sql)->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title></title>
</head>
<body>
	<div class="container-fluid">
		<nav>
			<ul>
				<li><a href="chooseReview.php">Choose Review</a></li>
				<!-- <li><a href="viewReview.php">View Review</a></li> -->
				<li><a href="createReview.php">Create Review</a></li>
			</ul>
			<div class="logoff">
				<a class="logout" href="logoff.php">LogOff</a>
			</div>
		</nav>
		<div class="title">
			<h1>Welcome <span style="color:#2224ff"><?php echo $result['surname']." ". $result['firstname']; ?></span>, today is <?php echo date('l jS \of F Y'); ?> </h1>
			<hr>
		</div>

		<div class="card">
			<div class="user-info">
				<h3>Employee Information</h3>
				<hr>
				<div class="form-group">
					<b>Employee ID : </b><span><?php echo $res['employee_id']; ?></span>
				</div>
				<div class="form-group">
					<b>Full Name : </b><span><?php echo $res['firstname'] . " " . $res['surname']; ?></span>
				</div>
				<div class="form-group">
					<b>Job Title : </b><span><?php echo $res['job_title']; ?></span>
				</div>
				<div class="form-group">
					<b>Department Name : </b><span><?php echo $res['department_name']; ?></span>
				</div>
				<div class="form-group">
					<b>Review Year : </b><span><?php echo $reviewYear; ?></span>
				</div>
			</div>
			<form method="post">
				<h3>Rating Information</h3>
				<hr />
				<div class="form-group">
					<label>
						Job Knowledge
					</label>
					<input type="text" name="knowledge" >
				</div>
				<div class="form-group">
					<label>
						Work Quality
					</label>
					<input type="text" name="Quality" >
				</div>
				<div class="form-group">
					<label>
						Initiative
					</label>
					<input type="text" name="initiative" >
				</div>
				<div class="form-group">
					<label>
						Communication
					</label>
					<input type="text" name="communication" >
				</div>
				<div class="form-group">
					<label>
						Dependability
					</label>
					<input type="text" name="dependability" >
				</div>

				<h3>Evaluation Section</h3>
				<hr />
				<div class="form-group">
					<label>
						Additional Comments
					</label>
					<textarea name="comments" class="textbox"></textarea>
				</div>
				<h3>Evaluation Section</h3>
				<hr />
				<div class="form-group">
					<label>
						<b>Form Completed</b>
						<input type="checkbox" name="completed" value="Y">
					</label>
					
				</div>

				<button type="submit" name="secondForm">Submit</button> 
			</form>
		</div>

		<div class="form-are">
			
		</div>

		<?php  

			if(isset($_POST['firstForm'])) { 

				header("location:create.php?id=".$_POST['emp_id']."" );
			}
		?>
		
		<?php		
			//}

		?>

		
		<!--  -->

	</div>
</body>
</html>
