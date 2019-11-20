<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="../Ima/LF.ico"> <!--Webpage Icon -->
		<link href="../CSS/Mainbodyres.css" rel="stylesheet" type="text/css" /> <!--Link to css file-->
		<link href="../CSS/MenuRes.css" rel="stylesheet" type="text/css" />
		<link href="../CSS/Searchresultsbar.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../CSS/Results.css">
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
							<li><a href="./Display_dataset.php">Dataset</a></li>
                                                        <li><a href="./Login.html">Dump</a></li>
							</ul>
						</li>
						<li><a href="./Developers.html">About us</a></li>
					</ul>
				</div> <!--End Menu-->

			<div id="SideBar"></div>
				<div id="MainBody"> <!--MainBody contains the search bar-->
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
	if ($mysqli->connect_errno)
	{
		echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	else
	{
		$object_id=$_GET["object_id"];
		$quer="select gene_name, gene_posleft, gene_posright, gene_strand, gene_note from GENE where gene_id='".$object_id."'";
		$res = $mysqli->query($quer);
		$fila=$res->fetch_assoc();
		$gene=$fila["gene_name"];
		$quer="select object_synonym_name from OBJECT_SYNONYM where object_id='".$object_id."'";
		$res_syn= $mysqli->query($quer);
	
		$quer="select external_db_id from OBJECT_EXTERNAL_DB_LINK where object_id='".$object_id."'";
		$res_ext_id=$mysqli->query($quer);
		$external_data=array();
		for ($num_fila = 1;  $num_fila <= $res_ext_id->num_rows; $num_fila++) {
			$fila_ext_id=$res_ext_id->fetch_assoc();
			$quer="select external_db_name, url from EXTERNAL_DB where external_db_id='".$fila_ext_id["external_db_id"]."'";
			$res_ext_data=$mysqli->query($quer);
			$fila_ext_data=$res_ext_data->fetch_assoc();
			$external_data[$num_fila][1]=$fila_ext_data["external_db_name"];
			$external_data[$num_fila][2]=$fila_ext_data["url"];
			$res_ext_data->close();
		}
		?>
		<table border="1" cellpadding="10" cellspacing="0">
		<tr>
		<th colspan="2">Gene</th>
		</tr>
		<?php
		$campos=array("gene_name", "gene_posleft", "gene_posright", "gene_strand", "gene_seq","object_synonym_name", "external_db", "gene_note");
		foreach($campos as $element){
			echo "<tr>";
			if($element=="gene_name"){
				echo "<td>Name</td>";
			}
			if($element=="gene_posleft"){
				echo "<td>Left Position</td>";
			}
			if($element=="gene_posright"){
				echo "<td>Right Position</td>";
			}
			if($element=="gene_strand"){
				echo "<td>Strand</td>";
			}
			if($element=="object_synonym_name"){
				echo "<td>Synonyms</td>";
			}
			if($element=="gene_note"){
				echo "<td>Notes</td>";
			}
			if($element=="external_db"){
				echo "<td>Links to external databases</td>";
			}
			if($element=="gene_seq"){
				echo "<td>Sequence</td>";
			}
			if($element!="object_synonym_name" and $element!="external_db" and $element!="gene_seq"){
				echo "<td>".$fila[$element]."</td>";
			}
			elseif($element=="object_synonym_name")
			{
				echo "<td>";
				for ($num_fila = 1;  $num_fila <= $res_syn->num_rows; $num_fila++) {
					$syn=$res_syn->fetch_assoc();
					echo $syn["object_synonym_name"]."<br>";
				}
				echo "</td>";
			}
			elseif($element=="gene_seq")
			{
				echo "<td><a href='./Generate_seqs.php?type=Gene&object_id=".$object_id."&format=fasta'>FASTA format</a><br>";
				echo "<a href='./Generate_seqs.php?type=Gene&object_id=".$object_id."&format=raw'>raw format</a></td>";
			}else{
				echo "<td>";
				for ($num_fila = 1;  $num_fila <= $res_ext_id->num_rows; $num_fila++) {
					echo "<a href='".$external_data[$num_fila][2].$gene."'>".$external_data[$num_fila][1]."</a><br>";
				}
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
		
	?>
	<?php
		$quer="select product_id,product_name,molecular_weigth,isoelectric_point,location,product_note,product_type from PRODUCT where product_id=(select product_id from GENE_PRODUCT_LINK where gene_id='".$object_id."')";
//sinónimos
		$res_prod=$mysqli->query($quer);
		$fila_prod=$res_prod->fetch_assoc();

		$quer="select object_synonym_name from OBJECT_SYNONYM where object_id='".$fila_prod['product_id']."'";
		$res_syn= $mysqli->query($quer);

		$campos=array("product_name","product_sequence", "molecular_weigth", "isoelectric_point", "location", "product_synonym", "product_type", "product_note");
		if(($res_prod->num_rows)>=1){
			echo "<br><br><table border='1' cellpadding='10' cellspacing='0'><tr><th colspan='2'>Product</th></tr>";
			foreach($campos as $element){
				echo "<tr>";
				if($element=="product_name"){
					echo "<td>Name</td>";
				}
				if($element=="molecular_weigth"){
					echo "<td>Molecular Weigth</td>";
				}
				if($element=="isoelectric_point"){
					echo "<td>Isoelectric Point</td>";
				}
				if($element=="location"){
					echo "<td>Cellular location</td>";
				}
				if($element=="product_type"){
					echo "<td>Regulatory family</td>";
				}
				if($element=="product_note"){
					echo "<td>Notes</td>";
				}
				if($element=="product_sequence"){
					echo "<td>Sequence</td>";
				}
				if($element=="product_synonym"){
					echo "<td>Synonyms</td>";
				}
				if($element!="product_synonym" and $element!="product_sequence"){
					echo "<td>".$fila_prod[$element]."</td>";
				}
				elseif($element=="product_synonym")
				{
					echo "<td>";
					for ($num_fila = 1;  $num_fila <= $res_syn->num_rows; $num_fila++) {
						$syn=$res_syn->fetch_assoc();
						echo $syn["object_synonym_name"]."<br>";
					}
					echo "</td>";
				}
				else //if($element=="gene_seq")
				{
					echo "<td><a href='./Generate_seqs.php?type=Product&object_id=".$fila_prod["product_id"]. "&format=fasta'>FASTA format</a><br>";
					echo "<a href='./Generate_seqs.php?type=Product&object_id=".$fila_prod["product_id"]."&format=raw'>raw format</a></td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			$res_prod->close();	
		}
	?>
	<?php
	//Para crear la tabla de Operon
		$quer="select operon_name from OPERON where operon_id=(select operon_id from TRANSCRIPTION_UNIT where transcription_unit_id=(select transcription_unit_id from TU_GENE_LINK where gene_id='".$object_id."'))";
		$res_prom_op=$mysqli->query($quer);
		$fila_prom_op=$res_prom_op->fetch_assoc();
		$operon_name=$fila_prom_op["operon_name"];
		$quer="select promoter_sequence from PROMOTER where promoter_id=(select promoter_id from TRANSCRIPTION_UNIT where transcription_unit_id=(select transcription_unit_id from TU_GENE_LINK where gene_id='".$object_id."'))";
		$res_prom_op=$mysqli->query($quer);
		$fila_prom_op=$res_prom_op->fetch_assoc();
		$prom_sequence=$fila_prom_op["promoter_sequence"];
		if($operon_name!="" or $prom_sequence!=""){
			echo "<br><br><table border='1' cellpadding='10' cellspacing='0'><tr><th colspan='2'>Operon</th></tr>";
			echo "<tr><td>Name</td><td>".$operon_name."</td></tr><tr><td>Promoter sequence</td><td>".$prom_sequence."</td></tr>";
		}
		$res_prom_op->close();
	?>
	<?php
	//Para crear la tabla de referencias
		$quer="select author,title,source,years from PUBLICATION where publication_id in (select publication_id from OBJECT_EV_METHOD_PUB_LINK where object_id='".$object_id."')";
		$res_pub=$mysqli->query($quer);
		if(($res_pub->num_rows)>=1){
		?>
			<br><br>
			<table border="1" cellpadding="10" cellspacing="0">
			<tr> 
			<th>References</th>
			</tr>
		<?php
			for($num_fila=1; $num_fila<=$res_pub->num_rows; $num_fila++)
			{
				$fila_pub=$res_pub->fetch_assoc();
				echo "<tr><td>[".$num_fila."] ".$fila_pub["author"].", ".$fila_pub["years"].", ".$fila_pub["title"].", ".$fila_pub["source"]."</td></tr>";
			}
			echo "</table>";
			$res_pub->close();
		}
		$res_ext_id->close();
		$res_syn->close();
		$res->close();
	}
	$mysqli->close();
	?>
				</div> <!--End MainBody-->
			</div> <!--End Content Wrap-->
		</div> <!--End Container-->
	</body>
</html>
