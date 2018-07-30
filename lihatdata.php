<?php

if (isset($_POST['lihat'])){

			$database = $_POST['database'];

			$query = 'SELECT * from '.$database;
			
			// echo $query;
			$result = mysqli_query($con,$query);
			
					
			//echo $count."<hr>";
			echo "<table width='500' cellpadding=0 cellspacing=0>
            		<tr><th colspan='100'>Data Iterasi Ke-".$this->iterasi."</th></tr>
					<tr><th>No</th>
					<th>Nama</th>
					<th>Nilai1</th>
					<th>Nilai2</th>
					<th>K1</th>
					<th>K2</th>
					<th>K3</th></tr>";

			while($hasil=mysqli_fetch_array($result)){
				echo "<tr>";
				echo "<td>".$hasil['No'];
				echo "<td>".$hasil['Nama'];
				echo "<td>".$hasil['Nilai1'];
				echo "<td>".$hasil['Nilai2'];
				echo "<td>".$hasil['K1'];
				echo "<td>".$hasil['K2'];
				echo "<td>".$hasil['K3'];
				echo "</tr>";

				// echo $no.' - '.$Nama.' - '.$Nilai1.' - '.$Nilai2.' - '.$K1.' - '.$K2.' - '.$K3.'<br />';

			}
		}

?>