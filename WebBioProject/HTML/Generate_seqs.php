<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="../Ima/LF.ico"> <!--Webpage Icon -->
		<link href="../CSS/Mainbodyseqs.css" rel="stylesheet" type="text/css" /> <!--Link to css file-->
		<link href="../CSS/MenuRes.css" rel="stylesheet" type="text/css" />
		<link href="../CSS/Searchresultsbar.css" rel="stylesheet" type="text/css" />
		<script src="https://kit.fontawesome.com/43eb676244.js" crossorigin="anonymous"></script>
		<!--The following lines put all the Webpage margins in 0-->
		<style type="text/css">
		body {
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;
		}
		</style>
		<title>
		<?php
		error_reporting(E_ALL);
 		ini_set('display_errors', '1');
		echo "E. Coli Gene Database";
		$mysqli = new mysqli("132.248.248.120:3306", "regulonuser", "ReguL1igh22#", "regulondb");
		?>
		</title>
	</head>
	<body>

		<div id="Container">
			<div id="Content-Wrap">
				<div id="Header">
					<a href="./InterfazWeb.html">
					<img src="../Ima/LogHeader.png" alt="" />
					</a>
					<div class="Text">
						<h1>E. Coli Gene Database</h1>
					</div>
				</div>
				<!--The following lines contain the Menu set up-->
				<div id="Menu">
					<ul class="EMenu">
						<li><a href="./InterfazWeb.html" class="has-sub">Home</a></li>
						<li><a href="#" class="has-sub">Download</a>
							<ul>
							<li><a href="#">Dataset</a></li>
							<li><a href="#">Dump</a></li>
							</ul>
						</li>
						<li><a href="./Developers.html">About us</a></li>
					</ul>
				</div> <!--End Menu-->

				<div id="MainBody"> <!--MainBody contains the search bar-->
					<div class="blue-rectangle"></div>
					<form id="form1" name="form1" method="get" action="Searchresults.php">
					<div class="search-box">
						<input class="search-txt" type="text" name="search" placeholder="Type to search">
						<div class="Checkboxes"> <!--Search Parameters-->
							<input type="checkbox" name="gene" id="gene" checked="checked"> Gene
							<input type="checkbox" name="promoter" id="promoter" checked="checked"> Product
						</div>
						<button type="submit" name="submit" class="search-btn">
						<i class="fas fa-search"></i>
						</button>
					</div>
					</form><!--End Form-->
		<?php
		$format=$_GET["format"];
		$type=$_GET["type"];
		$object_id=$_GET["object_id"]; 
		$mysqli = new mysqli("132.248.248.120:3306", "regulonuser", "ReguL1igh22#", "regulondb");
		if ($mysqli->connect_errno)
		{
			echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			$error=1;
		}
		else{
			if($type=="Gene"){
				$quer="select gene_name,gene_sequence,gene_posright,gene_posleft from GENE where gene_id='".$object_id."'";
				$res=$mysqli->query($quer);
				$fila=$res->fetch_assoc();
				$name=$fila["gene_name"];
				//Aqui va el nombre del gen buscado
				$seq=$fila["gene_sequence"]; 
				$str_web = chunk_split($seq, 100, '<br>');
				$str = chunk_split($seq, 100, PHP_EOL);
				//Aqui va el resultado Sequence del gen buscado
			}else{
				$quer="select product_name, product_sequence from PRODUCT where product_id='".$object_id."'";
				$res = $mysqli->query($quer);
				$fila=$res->fetch_assoc();
				$name=$fila["product_name"];
				//Aqui va el nombre del producto buscado.
				$seq=$fila["product_sequence"]; 
				$str_web = chunk_split($seq, 100, '<br>');
				$str = chunk_split($seq, 100, PHP_EOL);
				//Aqui va el resultado Sequence del producto buscado
			}
		echo "<title>".$name."</title>";
		$res->close();
		?>
	</head>
	<body>
<?php
if($seq!=""){
	if($format=="fasta"){
		if($type=="Gene"){
			echo ">Escherichia Coli K-12 | ".$type."=".$name." | Pos_right=".$fila["gene_posright"]." | Pos_left=".$fila["gene_posleft"]."<br>".$str_web."<br><br>";
		}else{
			echo ">Escherichia Coli K-12 | ".$type."=".$name."<br>".$str_web."<br><br>";
		}
		$fasta_path="../Downloads/Fasta/".$type."_".$name.".txt"; 
		//Ruta relativa del archivo FASTA, si el archivo no está creado, se crea uno nuevo; si ya existe, simplemente se muestra el link a dicho archivo ya creado para no tener que crear el archivo otra vez.
		$exists=file_exists($fasta_path);
		if(!$exists){
			$fasta =fopen($fasta_path,"w");
			if($type=="Gene"){
				$text=">Escherichia Coli K-12 | ".$type."=".$name." | Pos_right=".$fila["gene_posright"]." | Pos_left=".$fila["gene_posleft"]."\n".$str;
			}else{
				$text=">Escherichia Coli K-12 | ".$type."=".$name."\n".$str;
			}
			fwrite($fasta,$text);
			fclose($fasta);
		}
		echo "<a href=".$fasta_path." download= ".$type."_".$name."_fasta.txt>Download fasta file</a><br>";
		//Link para descargar FASTA
	}else{
		echo $str."<br><br>";
		$raw_path="../Downloads/Raw/".$type."_".$name.".txt"; 
		//Ruta relativa del archivo RAW, si el archivo no está creado, se crea uno nuevo; si ya existe, simplemente se muestra el link a dicho archivo ya creado para no tener que crear el archivo otra vez.
		$exists=file_exists($raw_path);
		if(!$exists){
			$raw =fopen($raw_path,"w");
			$text=$seq;
			fwrite($raw,$text);
			fclose($raw);
		}
	
		echo "<a href=".$raw_path." download= ".$type."_".$name."_raw.txt>Download raw file</a><br>";
		//Link para descargar raw file
	}
}else{
	echo "<h2>No existe la secuencia buscada</h2>";
}
}
	$mysqli->close();
?>
	</div> <!--End MainBody-->
			</div> <!--End Content Wrap-->
		</div> <!--End Container-->
	</body>
</html>
