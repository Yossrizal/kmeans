<!DOCTYPE html>
<html>
<head>
	<title>Algoritma K-means</title>
</head>
<body>

</body>
</html>

<?php
	include "koneksi.php";

	$query = "SHOW tables FROM kmeans";

	$result = mysqli_query($con,$query);
	echo '<center><form action="proses.php" method="POST">';
	echo "<h2> Pilih Database </h2>";
	echo "<hr />";
	echo '<select name="database">';
	$count = mysqli_num_rows($result);
	echo $count;
	while($hasil=mysqli_fetch_array($result)){
			
			echo '<option value="'.$hasil[0].'"> '.$hasil[0].' </option>';
	}

					

	echo "</select>";

	echo '<input type="submit" name="proses" value="pilih">';

	echo '</form></center>';



?>


	
	