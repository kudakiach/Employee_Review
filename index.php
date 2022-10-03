<?php 
	session_start();

	$errors = array();
	include_once('conn.php');


	function sanitize_input($input)
	{
		$input = trim($input);
		$input = stripslashes($input);
	  	$input = htmlspecialchars($input);
	  	return $input;
	}

	
	if (isset($_POST['submit'])) {
		$pass = $_POST['password'];
		$emp_id = sanitize_input($_POST['employee']);

		$hashedPassword = hash('sha256', $pass);
		// echo $hashedPassword;

		if(empty($emp_id)){
			$errors[] .= "Employee ID is required";
		}

		if(empty($pass)){
			$errors[] .= "Password is required";
		}

		if(empty($errors)){

			$sql = "SELECT * FROM employee WHERE employee_id='$emp_id' AND password='$hashedPassword'";
			$results = $dbConn->query($sql);
			$row = $results->fetch_assoc();
			if ($results->num_rows > 0) {
				
				$_SESSION['employee'] = $row['employee_id'];
				header("location:chooseReview.php");
			}
			else
			{
				$errors[] .= "Invalid Username or Password" . $dbConn->error;
			}

		}
			
		
	}

	
 ?>
		

<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/style.css" >
		<title></title>
		
	</head>
	<body class="">

	 

	<div class="container-fluid">
		<div class="container">
			<p>
			The Dunder Mifflin performance planning and review process is intended to assist 
			supervisors to review the performance of staff annually and develop agreed performance 
			plans based on workload agreements and the strategic direction of Dunder Mifflin. 
			</p>
			<p>
			The Performance Planning and Review system covers both results (what was accomplished), and 
			behaviours (how those results were achieved). The most important aspect is what will be 
			accomplished in the future and how this will be achieved within a defined period. The process 
			is continually working towards creating improved performance and behaviours that align and 
			contribute to the mission and values of Dunder Mifflin.
			</p>
		</div>
			<div class="card">
				<h2>Employee Login</h2>
				<hr class="hr" />
				<div class="errors">
				<?php 
					foreach($errors as $error) { ?>
						<div class="error">
							<?php echo $error; ?>
						</div>
				<?php		
					}
				?>
			</div>
				<form method="post">
					<div class="form-group">
						<label>Employee ID</label>
						<input type="text" name="employee" class="form-control">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control">
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-lg" type="submit" name="submit">LOGIN</button>
						
					</div>
				</form>
			</div>
	</div>

</body>
</html>