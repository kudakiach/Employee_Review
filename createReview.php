<?php
session_start();
	$errors = array();
	// check if user is logged in.
	if (!isset($_SESSION['employee']) || (trim($_SESSION['employee']) == '')) {
    	header("location: index.php");
    	exit(); 
	}

	require_once("conn.php");

	$user = $_SESSION['employee'];
	
	$sql = "SELECT * FROM employee WHERE employee_id='$user'";

	$sql1 = "SELECT * FROM employee WHERE supervisor_id='$user'";
	$res = $dbConn->query($sql1);


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

		<div class="form-area">
			<form method="post">
				<div class="form-group">
					<label>Employee ID</label>
					<select name="emp_id">
						<?php 
							
							
							while ($rows = $res->fetch_assoc()){ 
							$rows['employee_id']
							 ?>
								<option value="<?php echo $rows['employee_id'] ?>"><?php echo $rows['employee_id'] ?></option>
						<?php	}
						 ?>
					</select>

					
				</div>
				<div class="form-group">
					<label>Year Of Review</label>
					<input type="text" name="year" >
				</div>
				<button type="submit" name="firstForm">First Form</button> 
			</form>
		</div>

		<?php  
		
			if(isset($_POST['firstForm'])) {

				if(empty($_POST['year'])) {
					echo "Enter year of Review";
				}

				header("location:create.php?id=".$_POST['emp_id']. "&&year=". $_POST['year']);
			}
		?>
		
		<?php		
			//}

		?>

		
		<!--  -->

	</div>
</body>
</html>
