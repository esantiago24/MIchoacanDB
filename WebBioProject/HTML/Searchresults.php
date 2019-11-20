<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="../Ima/LF.ico"> <!--Webpage Icon -->
		<link href="../CSS/Mainbodyres.css" rel="stylesheet" type="text/css" /> <!--Link to css file-->
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
			MDB Search results
		</title>

		<?php
                error_reporting(E_ALL);
                ini_set('display_errors', '1');
                $gene=escapeshellcmd($_GET["search"]);
                $mysqli = new mysqli("132.248.248.120:3306", "regulonuser", "ReguL1igh22#", "regulondb");
                ?>

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
						<li><a href="./Login.html" class="has-sub">Download</a>
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
							<input type="checkbox" name="tu" id="tu" checked="checked"> Operon
						</div>
						<button type="submit" name="submit" class="search-btn">
						<i class="fas fa-search"></i>
						</button>
					</div>
					</form><!--End Form-->
				</div> <!--End MainBody-->
			</div> <!--End Content Wrap-->
		</div> <!--End Container-->

		<?php
		if ($mysqli->connect_errno) {
		    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}else{
			$quer="SELECT gene_name,gene_posleft,gene_posright,gene_strand,gene_note FROM GENE WHERE gene_name='".$gene."'";
			$res = $mysqli->query($quer);

			/*Más lento
			$quer="SELECT GENE.gene_name,GENE.gene_posleft,GENE.gene_posright,GENE.gene_strand,GENE.gene_note FROM GENE JOIN OBJECT_SYNONYM on GENE.gene_id=OBJECT_SYNONYM.object_id WHERE OBJECT_SYNONYM.object_synonym_name='".$gene."' or GENE.gene_name='".$gene."'";
			$res = $mysqli->query($quer);
*/

		}
		$fila=$res->fetch_assoc();
		if(is_null($fila)){
			$quer="SELECT GENE.gene_name,GENE.gene_posleft,GENE.gene_posright,GENE.gene_strand,GENE.gene_note FROM GENE JOIN OBJECT_SYNONYM on GENE.gene_id=OBJECT_SYNONYM.object_id WHERE OBJECT_SYNONYM.object_synonym_name='".$gene."' or GENE.gene_name='".$gene."'";
			$res = $mysqli->query($quer);
			$fila=$res->fetch_assoc();
		}
		if(is_null($fila)){
			echo "Error, no se ha encontrado el elemento a buscar";
		}else{
			echo '<table border="1" cellpadding="10" cellspacing="0">';
			echo '<tr>'; 
			echo '<th colspan="2">Gene</th>';
			echo '</tr>';
			$campos=array("gene_name","gene_posleft","gene_posright","gene_strand","gene_note");
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
				if($element=="gene_note"){
					echo "<td>Note</td>";
				}
				echo "<td>".$fila[$element]."</td>";
				echo "<tr>";
			}
			echo "</table>";
		}
		?>
		<?php
    		$res->close();
		$mysqli->close();
		?>
	</body>
</html>
