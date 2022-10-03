<?php 
	session_start();

	if (!isset($_SESSION['employee']) || (trim($_SESSION['employee']) == '')) {
    	header("location: index.php");
    	exit();
	}
	
	include_once('conn.php');
	$user = $_SESSION['employee'];
	$id = $_GET['id'];
	$sql = "SELECT * FROM employee WHERE employee_id='$user'";


	$result = $dbConn->query($sql)->fetch_assoc();
	$job = $result['job_id'];
	$sql2 = "SELECT * FROM job WHERE job_id='$job'";

	$res = $dbConn->query($sql2)->fetch_assoc();

	
	// echo $result['surname']." ". $result['firstname'];
	$sql1 = "SELECT E.*, R.* FROM review as R LEFT JOIN employee as E ON R.employee_id = E.employee_id WHERE review_id = '$id'";
	$results = $dbConn->query($sql1);


	$rows = $results->fetch_assoc();

	if(isset($_POST['accept'])){
		if(isset($_POST['agree'])) {
			$now = date('Y-m-d');
			//echo $now;
			$update = " UPDATE review set accepted='Y', date_accepted='$now' WHERE review_id='$id'";
			$result = $dbConn->query($update);
			if($result){
				header("location:viewReview.php?id=" . $rows['review_id'] );
			}
		}
	}
	


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
		</div>
		<div class="results">
			<div class="card">
				<div class="details">
					<h2>Employee Information</h2>	
					<hr>
					<div class="form-group">
						<b>Full Names:</b> <?php echo $rows['surname'] ." ".$rows['firstname'] ?>	
					</div>
					<div class="form-group">
						<b>Employement Mode:</b> <?php echo $res['job_title']; ?>	
					</div>
					<div class="form-group">
						<b>Review Year:</b> <?php echo $rows['review_year'] ?>	
					</div>
				</div>
					
				<div class="details">
					<h2>Rating Details</h2>	
					<hr>
					
					
					<div class="form-group">
						<b>Job Knowledge:</b> <div style="width:100%;height: 30px; border:1px"><div class="rating" style="width: <?php echo (20 * $rows['job_knowledge']) ?>%;">
							<?php echo $rows['job_knowledge'] ?>
						</div></div>	
					</div>
					<div class="form-group">
						<b>Work Quality:</b> <div style="width:100%;height: 30px; border:1px"><div class="rating" style="width: <?php echo (20 * $rows['work_quality']) ?>%; ">
													<?php echo $rows['work_quality'] ?>
												</div>	</div>
					</div>
					<div class="form-group">
						<b>Communication:</b> <div style="width:100%; height: 30px; border:1px"><div class="rating" style="width: <?php echo (20 * $rows['communication']) ?>%;">
							<?php echo $rows['communication'] ?>
						</div></div>	
					</div>
					<div class="form-group">
						<b
						>Initiative:</b> <div style="width:100%; height: 30px; border:1px"><div class="rating" style="width:<?php echo (20 * $rows['initiative'])?>%;">
							<?php echo $rows['initiative'] ?>
						</div></div>

					</div>
					<div class="form-group">
						<b>Dependability:</b> <div style="width:100%; height: 30px; border:1px"><div class="rating" style="width: <?php echo (20 * $rows['dependability']); ?>%;">
							<?php echo $rows['dependability'] ?>
						</div>	</div>
					</div>
					
				</div>
				<div class="details">
					<h2>Evaluation Details</h2>	
					<hr>
					<div class="form-group">
						<b>Comments</b> <?php echo $rows['additional_comment']  ?>	
					</div>
					<div class="form-group">
						<b>Review Date:</b> <?php echo $rows['date_completed']  ?>	
					</div>
					
				</div>
			</card>
			<div class="details">
				<?php 
				if($rows['accepted'] === 'N') { ?>
					<p> 
					Thank you for taking part in your Dunder Mifflin Performance Review. This review is an important 
					aspect of the development of our organisation and its profits and of you as a valued employee.
					By electronically signing this form, you confirm that you have discussed this review in detail 
					with your supervisor. <small>The fine print: Signing this form does not necessarily indicate that you agree with this evaluation.</small>
					</p>;
					<form method="post">
				<div class="form-group">
					<label> Do you agree to our terms <input type="checkbox" name="agree"></label>
				</div>
				<button type="submit" name="accept">Confirm</button>
			</form>
				<?php }
			?>
			</div>
		</div>
	</div>
</body>
</html>