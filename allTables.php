<?php
/**
 * Allows one to view all tables and their data in a database
 */
require_once("conn.php");
$sql = "SHOW TABLES";
$tables = $dbConn->query($sql);

$tablesAndTheirData = array();
while($tableName = $tables->fetch_array()) {
	$sql = "SELECT * FROM $tableName[0]";
	$data = $dbConn->query($sql);
    array_push($tablesAndTheirData, array(
        'name' => $tableName[0],
        'fields' => $data->fetch_fields(),
        'data' => $data
    ));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Database Tables</title>
  <link rel="stylesheet" href="css/projectMaster.css">
</head>
<body>
<!-- The ':' in php gives an alternative way for introducing control structures.
For details, please see http://php.net/manual/en/control-structures.alternative-syntax.php
-->
<?php foreach($tablesAndTheirData as $table): ?>
<h2><code><?php echo $table['name'];?></code> Table</h2>
	<?php if($table['data']->num_rows):?>
		<table>
			<thead>
				<tr style="font-weight:bold">
				<?php foreach($table['fields'] as $field): ?>

					<td><?php echo $field->name;?></td>

				<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
		<?php while($row = $table['data']->fetch_assoc()): ?>
			<tr>
				<?php foreach($row as $key => $value):?>
					<td><?php echo $value; ?>
					</td>
				<?php endforeach; ?>
			</tr>
		<?php endwhile;?>
			</tbody>
		</table>
	<?php else:?>
		<p>Table does not have any data</p>
	<?php endif;?>
<?php endforeach;
$dbConn->close();
?>
</body>
</html>
