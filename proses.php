<style type="text/css">
	@import url("style.css");
</style>
<script>
	function kelompokcen(notable,no,nama,nilai1,nilai2){
							// Find a <table> element with id="myTable":
						var tabel = notable;
						var table = document.getElementById(tabel);

						// Create an empty <tr> element and add it to the 1st position of the table:
						var row = table.insertRow();

						// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
						var cell1 = row.insertCell(0);
						var cell2 = row.insertCell(1);
						var cell3 = row.insertCell(2);
						var cell4 = row.insertCell(3);

						// Add some text to the new cells:
						cell1.innerHTML = no;
						cell2.innerHTML = nama;
						cell3.innerHTML = nilai1;
						cell4.innerHTML = nilai2;
	}

	function ratacentroid(notable,jml1,jml2,rata1,rata2){
							// Find a <table> element with id="myTable":
						var nama = notable;
						var table = document.getElementById(nama);

						// Create an empty <tr> element and add it to the 1st position of the table:
						var row = table.insertRow();

						// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
						var cell1 = row.insertCell(0);
						var cell2 = row.insertCell(1);
						var cell3 = row.insertCell(2);
						var cell4 = row.insertCell(3);
						

						// Add some text to the new cells:
						cell1.innerHTML = "";
						cell2.innerHTML = "";
						cell3.innerHTML = jml1;
						cell4.innerHTML = jml2;
						cell1.innerHTML = "";
						cell2.innerHTML = "";
						cell3.innerHTML = rata1;
						cell4.innerHTML = rata2;
	}
</script>
<html>
<center>
<?php
	
	include "koneksi.php";
	

	class clusteringkmeans{

		private $threshold = 0.1;
		private $fungsiobjektif = 0.0;
		private $perubahanfo = 0.0;
		private $iterasi = 1;
		public $count;
		public $Klama1, $Klama2, $Klama3 = array();
		public $Kbaru1, $Kbaru2, $Kbaru3 = array();
		public $cekkel = 0;
		
		//public $No,$Nama,$Nilai1,$Nilai2,$K1,$K2,$K3 = array();


		public function __construct(){
			include "koneksi.php";
			if (isset($_POST['proses'])){

			$database = $_POST['database'];

			$query = 'SELECT * from '.$database;
			
			// echo $query;
			$result = mysqli_query($con,$query);
			
			global $count,$No,$Nama,$Nilai1,$Nilai2,$K1,$K2,$K3;
			$count = mysqli_num_rows($result);
			$this->count = $count;
			
			//echo $count."<hr>";
			
			while($hasil=mysqli_fetch_array($result)){
				$No[] = $hasil['No'];
				$Nama[] = $hasil['Nama'];
				$Nilai1[] = $hasil['Nilai1'];
				$Nilai2[] = $hasil['Nilai2'];
				$K1[] = $hasil['K1'];
				$K2[] = $hasil['K2'];
				$K3[]	 = $hasil['K3'];

				// echo $no.' - '.$Nama.' - '.$Nilai1.' - '.$Nilai2.' - '.$K1.' - '.$K2.' - '.$K3.'<br />';

			}

			$this->No = $No;
			$this->Nama = $Nama;
			$this->Nilai1 = $Nilai1;
			$this->Nilai2 = $Nilai2;
			$this->K1 = $K1;
			$this->K2 = $K2;
			$this->K3 = $K3;

	/*		for ($i=0;$i<$count;$i++){

				echo $No[$i];
			}
	*/

			}

			//while (($this->fungsiobjektif)>($this->threshold)){
/*
			echo '<h3> Iterasi Ke-'.$this->iterasi.'</h3>';

			echo "<table width='500' cellpadding=0 cellspacing=0>
            		<tr><th colspan='100'>Data</th></tr>
					<tr><th>No</th>
					<th>Nama</th>
					<th>Nilai1</th>
					<th>Nilai2</th>
					<th>K1</th>
					<th>K2</th>
					<th>K3</th>";
			for ($i=0;$i<$count;$i++){
				echo '<tr><th>'.$No[$i].'</td>';
				echo '<td>'.$Nama[$i].'</td>';
				echo '<td>'.$Nilai1[$i].'</td>';
				echo '<td>'.$Nilai2[$i].'</td>';
				echo '<td>'.$K1[$i].'</td>';
				echo '<td>'.$K2[$i].'</td>';
				echo '<td>'.$K3[$i].'</td>';
			}

			echo "</table>"; 
*/
			//$this->pisahkelompokcentroid();
			//} 
		}

		public function utama(){
			
			echo "Fungsi Objektif Awal = ".$this->fungsiobjektif."<br>";
			echo "Threshold = ".$this->threshold."<br>";

			while ($this->cekkel == 0){		
				
				
				echo "Lanjut Iterasi ke ".$this->iterasi."<br><br>";

				$this->pisahkelompokcentroid();
				echo "<h3>";	

					
					echo "FO = ".$this->fungsiobjektif.'<br>';
					
					
				echo "</h3>";
				
			}

			if ($this->cekkel == 1)	{
				echo "Tidak Ada Perubahan Kelompok";
			} else {
				echo "Fungsi Objektif Rendah dari Threshold";
			}

		}

		public function pisahkelompokcentroid(){

		//	while (($this->fungsiobjektif)>($this->threshold)){


			echo '<h3> Iterasi Ke-'.$this->iterasi.'</h3>';

			echo "<br><table width='500' cellpadding=0 cellspacing=0>
            		<tr><th colspan='100'>Data Iterasi Ke-".$this->iterasi."</th></tr>
					<tr><th>No</th>
					<th>Nama</th>
					<th>Nilai1</th>
					<th>Nilai2</th>
					<th>K1</th>
					<th>K2</th>
					<th>K3</th>";
			for ($i=0;$i<($this->count);$i++){
				echo '<tr><th>'.$this->No[$i].'</td>';
				echo '<td>'.$this->Nama[$i].'</td>';
				echo '<td>'.$this->Nilai1[$i].'</td>';
				echo '<td>'.$this->Nilai2[$i].'</td>';
				echo '<td>'.$this->K1[$i].'</td>';
				echo '<td>'.$this->K2[$i].'</td>';
				echo '<td>'.$this->K3[$i].'</td>';
			}

			echo "</table><br><br>"; 

			$jmln1k1 = $jmln1k2 = $jmln1k3 = $jmln2k1 = $jmln2k2 = $jmln2k3 = $countk1 =$countk2 = $countk3 = 0;
			//echo $this->iterasi;
			echo '<table id="k1'.$this->iterasi.'" width="500" cellpadding=0 cellspacing=0>
            	<tr><th colspan="100"> Kelompok 1 </th>
				</tr>
				<tr> 
				<th>No</th>
				<th>Nama</th>
				<th>Nilai 1</th>
				<th>Nilai 2</th>
				</tr>
				</table><br>';

			echo '<table id="k2'.$this->iterasi.'" width="500" cellpadding=0 cellspacing=0>
            	<tr><th colspan="100"> Kelompok 2 </th>
				</tr>
				<tr> 
				<th>No</th>
				<th>Nama</th>
				<th>Nilai 1</th>
				<th>Nilai 2</th>
				</tr>
				</table><br>';

			echo '<table id="k3'.$this->iterasi.'" width="500" cellpadding=0 cellspacing=0>
            	<tr><th colspan="100"> Kelompok 3 
				</tr>
				<tr> 
				<th>No</th>
				<th>Nama</th>
				<th>Nilai 1</th>
				<th>Nilai 2</th>
				</tr>
				</table><br><br>';

			//for ($k=0;$k<3;$k++){
				
				$count = $this->count;
				for ($i=0;$i<$count;$i++){

					if ($this->K1[$i] == "*"){
						echo "<script> kelompokcen('k1".$this->iterasi."',".$this->No[$i].",'".$this->Nama[$i]."',".$this->Nilai1[$i].",".$this->Nilai2[$i].");</script>";
						$jmln1k1 += $this->Nilai1[$i];
						$jmln2k1 += $this->Nilai2[$i];
						$countk1 ++;
						
					} else if ($this->K2[$i] == "*"){
						echo "<script> kelompokcen('k2".$this->iterasi."',".$this->No[$i].",'".$this->Nama[$i]."',".$this->Nilai1[$i].",".$this->Nilai2[$i].");</script>";
						$jmln1k2 += $this->Nilai1[$i];
						$jmln2k2 += $this->Nilai2[$i];
						$countk2 ++;
						
					} else if ($this->K3[$i] == "*"){
						echo "<script> kelompokcen('k3".$this->iterasi."',".$this->No[$i].",'".$this->Nama[$i]."',".$this->Nilai1[$i].",".$this->Nilai2[$i].");</script>";
						$jmln1k3 += $this->Nilai1[$i];
						$jmln2k3 += $this->Nilai2[$i];
						$countk3 ++;
						
					}
				}
						global $ratan1k1,$ratan2k1,$ratan1k2,$ratan2k2,$ratan1k3,$ratan2k3;
						$ratan1k1 = round($jmln1k1 / $countk1,3);	
						$ratan2k1 = round($jmln2k1 / $countk1,3);	
						echo "<script> ratacentroid(k1".$this->iterasi.",".$jmln1k1.",".$jmln2k1.",".$ratan1k1.",".$ratan2k1.");</script>";
						$ratan1k2 = round($jmln1k2 / $countk2,3);	
						$ratan2k2 = round($jmln2k2 / $countk2,3);	
						echo "<script> ratacentroid(k2".$this->iterasi.",".$jmln1k2.",".$jmln2k2.",".$ratan1k2.",".$ratan2k2.");</script>";
						$ratan1k3 = round($jmln1k3 / $countk3,3);	
						$ratan2k3 = round($jmln2k3 / $countk3,3);	
						echo "<script> ratacentroid(k3".$this->iterasi.",".$jmln1k3.",".$jmln2k3.",".$ratan1k3.",".$ratan2k3.");</script>";

						$this->hitungcentroidkelompok($ratan1k1,$ratan2k1,$ratan1k2,$ratan2k2,$ratan1k3,$ratan2k3);
						$this->hitungfobaru($ratan1k1,$ratan2k1,$ratan1k2,$ratan2k2,$ratan1k3,$ratan2k3);
						$this->alokasiperubahanfo($ratan1k1,$ratan2k1,$ratan1k2,$ratan2k2,$ratan1k3,$ratan2k3);


			/*	echo "N1K1 = ".$jmln1k1."<br />";
				echo "N2K1 = ".$jmln2k1."<br />";
				echo "N1K1 = ".$jmln1k2."<br />";
				echo "N2K1 = ".$jmln2k2."<br />";
				echo "N1K1 = ".$jmln1k3."<br />";
				echo "N2K1 = ".$jmln2k3."<br />";
				echo "Rata - rata N1K1 = ".($ratan1k1 = $jmln1k1 / $countk1)."<br>";
				echo "Rata - rata N2K1 = ".($ratan2k1 = $jmln2k1 / $countk1)."<br>";
				echo "Rata - rata N1K1 = ".($ratan1k2 = $jmln1k2 / $countk2)."<br>";
				echo "Rata - rata N2K1 = ".($ratan2k2 = $jmln2k2 / $countk2)."<br>";
				echo "Rata - rata N1K1 = ".($ratan1k3 = $jmln1k3 / $countk3)."<br>";
				echo "Rata - rata N2K1 = ".($ratan2k3 = $jmln2k3 / $countk3)."<br>";

				*/

			//}
			//cek count	echo "<h1> jumlah data : ".$count." </h1>";		
			//}	
		}

		public function hitungcentroidkelompok($r11,$r21,$r12,$r22,$r13,$r23){

			echo '<table width="500" cellpadding=0 cellspacing=0>
            	<tr><th colspan="100"> Rata - Rata Centroid </th>
				</tr>
				<tr> 
				<th>Kelompok</th>
				<th>Nilai 1</th>
				<th>Nilai 2</th>
				</tr>
				<tr> 
				<th>1</th>
				<td>'.$r11.'</td>
				<td>'.$r21.'</td>
				</tr>
				<tr> 
				<th>2</th>
				<td>'.$r12.'</td>
				<td>'.$r22.'</td>
				</tr>
				<tr> 
				<th>3</th>
				<td>'.$r13.'</td>
				<td>'.$r23.'</td>
				</tr>
				</table><br>';


		}


		public function hitungfobaru($r11,$r21,$r12,$r22,$r13,$r23){

				$hasil = $hasilk1 = $hasilk2 = $hasilk3 = 0;

				echo "<table width='500' cellpadding=0 cellspacing=0>
            		<tr><th colspan='100'>Hitung Fungsi Objektif Baru</th></tr>
					<tr><th>No</th>
					<th>Nama</th>
					<th>Nilai1</th>
					<th>Nilai2</th>
					<th>K1</th>
					<th>K2</th>
					<th>K3</th>
					<th>Kelompok</th>";

				$count = $this->count;
				for ($i=0;$i<$count;$i++){

					echo '<tr><th>'.$this->No[$i].'</th>';
					echo '<td>'.$this->Nama[$i].'</td>';
					echo '<td>'.$this->Nilai1[$i].'</td>';
					echo '<td>'.$this->Nilai2[$i].'</td>';

					if ($this->K1[$i] == "*"){
					echo '<th>'.$hasil = round(sqrt(pow(abs($this->Nilai1[$i]-$r11),2)+(pow(abs($this->Nilai2[$i]-$r21),2))),3).'</th>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td>1</td>';
					$hasilk1 += (float)$hasil;
						
					} else if ($this->K2[$i] == "*"){
					echo '<td></td>';
					echo '<th>'.$hasil = round(sqrt(pow(abs($this->Nilai1[$i]-$r12),2)+(pow(abs($this->Nilai2[$i]-$r22),2))),3).'</th>';
					echo '<td></td>';
					echo '<td>2</td>';
					$hasilk2 += (float)$hasil;
						
					} else if ($this->K3[$i] == "*"){
					echo '<td></td>';
					echo '<td></td>';
					echo '<th>'.$hasil = round(sqrt(pow(abs($this->Nilai1[$i]-$r13),2)+(pow(abs($this->Nilai2[$i]-$r23),2))),3).'</th>';
					$hasilk3 += (float)$hasil;
					echo '<td>3</td>';
					}

					//echo '<th>'.$this->K1[$i].'</th>';
					//echo '<th>'.$this->K2[$i].'</th>';
					//echo '<th>'.$this->K3[$i].'</th>';
				}


				echo '
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th>'.$hasilk1.'</th>
					<th>'.$hasilk2.'</th>
					<th>'.$hasilk3.'</th>
					<th>'.$perubahanfo = $hasilk1+$hasilk2+$hasilk3.'</th>
				</tr>';

				echo "</table>";
				echo "Perubahan Fungsi Objektif = ".$perubahanfo."<br>";
				$this->perubahanfo = $perubahanfo;
				(float)$fobaru = $this->perubahanfo;
				$folama = $this->fungsiobjektif;
				(float)$this->fungsiobjektif = abs((float)$fobaru-(float)$folama);
				echo 'Perubahan Fungsi Objektif = | ' .$fobaru.' - '.$folama.' | = '.$this->fungsiobjektif.'<br />';
				//echo "FO = ".$this->fungsiobjektif.'<br>';
				$this->iterasi ++;
				//echo "Lanjut Iterasi ke".$this->iterasi."<br><br>";


		}

		public function alokasiperubahanfo($r11,$r21,$r12,$r22,$r13,$r23){
			
			$this->cekkel = 1;

			echo "<table width='600' cellpadding=0 cellspacing=0>
            		<tr><th colspan='100'>Perubahan Fungsi Objektif Baru</th></tr>
					<tr><th>No</th>
					<th>Nama</th>
					<th>Nilai1</th>
					<th>Nilai2</th>
					<th>K1</th>
					<th>K2</th>
					<th>K3</th>
					<th>Terdekat</th>
					<th>Kelompok Baru</th>
					<th>Kelompok lama</th>";

			$count = $this->count;
				for ($i=0;$i<$count;$i++){

					echo '<tr><th>'.$this->No[$i].'</th>';
					echo '<td>'.$this->Nama[$i].'</td>';
					echo '<td>'.$this->Nilai1[$i].'</td>';
					echo '<td>'.$this->Nilai2[$i].'</td>';
					echo '<th>'.$hasil1 = round(sqrt(pow(abs($this->Nilai1[$i]-$r11),2)+(pow(abs($this->Nilai2[$i]-$r21),2))),3).'</th>';
					echo '<th>'.$hasil2 = round(sqrt(pow(abs($this->Nilai1[$i]-$r12),2)+(pow(abs($this->Nilai2[$i]-$r22),2))),3).'</th>';
					echo '<th>'.$hasil3 = round(sqrt(pow(abs($this->Nilai1[$i]-$r13),2)+(pow(abs($this->Nilai2[$i]-$r23),2))),3).'</th>';
//cek data terkecil			
					if($hasil1 <= $hasil2 && $hasil1 <= $hasil3){
						echo '<th>'.$hasil1.'</th>';
						echo '<th>1</th>';
						$baru = 1;
					} else if($hasil2 <= $hasil1 && $hasil2 <= $hasil3){
						echo '<th>'.$hasil2.'</th>';	
						echo '<th>2</th>';
						$baru = 2;
					} else if($hasil3 <= $hasil2 && $hasil3 <= $hasil2){
						echo '<th>'.$hasil3.'</th>';
						echo '<th>3</th>';
						$baru = 3;
					}
//cek kelompok alma dan yang baru

						$this->Klama1[$i] = $this->K1[$i];
						$this->Klama2[$i] = $this->K2[$i];
						$this->Klama3[$i] = $this->K3[$i];

						


//kelompok lama
					if ($this->K1[$i] == "*"){
						echo '<td>1</td>';
					} else if ($this->K2[$i] == "*"){
						echo '<td>2</td>';
					} else if ($this->K3[$i] == "*"){
						echo '<td>3</td>';
					}


// rubah kelompok ke yang baru
					if ($baru==1){
						$this->K1[$i] = "*";
						$this->K2[$i] = "";
						$this->K3[$i] = "";
					} else if($baru==2){
						$this->K1[$i] = "";
						$this->K2[$i] = "*";
						$this->K3[$i] = "";
					} else if ($baru==3){
						$this->K1[$i] = "";
						$this->K2[$i] = "";
						$this->K3[$i] = "*";
					}

//cek kelompok baru

						$this->Kbaru1[$i] = $this->K1[$i];
						$this->Kbaru2[$i] = $this->K2[$i];
						$this->Kbaru3[$i] = $this->K3[$i];


						if ($this->Klama1[$i]==$this->Kbaru1[$i] && $this->Klama2[$i]==$this->Kbaru2[$i] && $this->Klama3[$i]==$this->Kbaru3[$i]){
							$this->cekkel *= 1;

							if ($this->fungsiobjektif < $this->threshold){		

							}
						
							
						} else {
							$this->cekkel *= 0;
						
						}

				

					//echo '<th>'.$this->K1[$i].'</th>';
					//echo '<th>'.$this->K2[$i].'</th>';
					//echo '<th>'.$this->K3[$i].'</th>';
				}

				echo "</table>";

// CEK PERUBAHAN KELOMPOK
				//echo "KESAMAAN KELOMPOK = ".$this->cekkel;
				//echo "<hr />";
	/*			echo 'Perubahan Fungsi Objektif = | '.$this->perubahanfo.' - '.$this->fungsiobjektif.' | = '.$this->fungsiobjektif = round(abs($this->perubahanfo)-($this->fungsiobjektif),3).'<br />';
				echo "FO = ".$this->fungsiobjektif;
				$this->iterasi ++;
				echo $this->iterasi;
*/

		}


	}




		$kmeans = new clusteringkmeans();

		//echo $count."<br />";
			
		$kmeans->utama();
		//echo "<hr> asdasd".$No[1]."variable nomor<br />";
		//echo $count;

		//$kmeans->hitungcentroidkelompok();
		//$kmeans->hitungfobaru();



?>

</center>
</html>