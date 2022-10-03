<?php 
	session_start();

	// check if user is logged in.
	if (!isset($_SESSION['employee']) || (trim($_SESSION['employee']) == '')) {
    	header("location: index.php");
    	exit(); 
	}

	include_once('conn.php');
	$user = $_SESSION['employee'];
	$sql = "SELECT * FROM employee WHERE employee_id='$user'";

	$result = $dbConn->query($sql)->fetch_assoc();
	
	// echo $result['surname']." ". $result['firstname'];


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
			<table border="">
				<tr>
					<th>Review Year</th>
					<th>Date Completed</th>
				</tr> 
			<?php
				$sql1 = "SELECT * FROM review WHERE employee_id = '$user' ORDER BY date_accepted DESC";
				$results = $dbConn->query($sql1);

				while($rows = $results->fetch_assoc())
				{
			?>
				<tr>
					<td><a href="viewReview.php?id=<?php echo $rows['review_id'] ?>"><?php echo $rows['review_year'] ?></a></td>
					<td><?php echo $rows['date_completed'] ?></td>
					
				</tr>
			<?php
					
				}
			?>
			</table>

				

		</div>
		<div class="supervisor">
			<?php 
				$q = "SELECT E.*, R.* FROM employee as E LEFT JOIN review as R ON E.employee_id=R.employee_id WHERE E.supervisor_id = '$user' AND E.employee_id !='$user' ORDER BY date_accepted DESC";
				$res = $dbConn->query($q);
				if($res->num_rows > 0){
			?>	
			<div class="title">
				<h2>summary details </h2>

				<table border="">
				<tr>
					<th>Surname</th>
					<th>FirstName</th>
					<th>Review ID</th>
					<th>Review Year</th>
					<th>Completed Status</th>
					<th>Date Completed</th>
				</tr> 
			<?php
				

				while($rs = $res->fetch_assoc())
				{
					if($rs['completed'] === 'Y') {


			?>	
			<tr>
				<td colspan="6"><h3>Completed Forms</h3></td>
			</tr>
				<tr>
					<td>
						<a href="viewReview.php?id=<?php echo $rs['review_id'] ?>">
							<?php echo $rs['surname'] ?>							
						</a>
					</td>
					<td><?php echo $rs['firstname'] ?></td>
					<td><?php echo $rs['review_id'] ?></td>
					<td><?php echo $rs['review_year'] ?></td>
					<td><?php echo $rs['completed'] ?></td>
					<td><?php echo $rs['date_completed'] ?></td>
					
				</tr>
			<?php
					
				}else{ ?>
					<tr>
				<td colspan="6"><h3>Non Completed Forms</h3></td>
			</tr>
				<tr>
					<td>
						<a href="viewReview.php?id=<?php echo $rs['review_id'] ?>">
							<?php echo $rs['surname'] ?>							
						</a>
					</td>
					<td><?php echo $rs['firstname'] ?></td>
					<td><?php echo $rs['review_id'] ?></td>
					<td><?php echo $rs['review_year'] ?></td>
					<td><?php echo $rs['completed'] ?></td>
					<td><?php echo $rs['date_completed'] ?></td>
					
				</tr>

			<?php	}
			}
			?>
			</table>

			</div>	
			<?php	}
				// while ($rows = $res->fetch_assoc())
				// {
				// 	echo $rows
				// }
				
			?>
			</div>

	</div>
</body>
</html>