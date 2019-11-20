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
		$name=escapeshellcmd($_GET["search"]);
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
		$gene=0;
		$promoter=0;
		$tu=0;
		if (isset($_GET['gene'])){
			$gene=1;
		}
		if (isset($_GET['promoter'])){
			$promoter=1;
		}
		if (isset($_GET['tu'])){
			$tu=1;
		}
		$resultados=0;
		if($gene){
			$quer="select gene_id,gene_name from GENE where gene_name like'%".$name."%'";
			$res_gene= $mysqli->query($quer);
			$quer="select object_id,object_synonym_name from OBJECT_SYNONYM where object_synonym_name like '%".$name."%'";
			$res_gene_syn= $mysqli->query($quer);
			$resultados+=($res_gene->num_rows);
			$resultados+=($res_gene_syn->num_rows);
		}
		if($promoter){
			$quer="select PRODUCT.product_id,PRODUCT.product_name,GENE_PRODUCT_LINK.gene_id from PRODUCT LEFT JOIN GENE_PRODUCT_LINK on PRODUCT.product_id=GENE_PRODUCT_LINK.product_id where product_name like'%".$name."%'";
			$res_prod= $mysqli->query($quer);
			$resultados+=($res_prod->num_rows);	
		}
		echo '<h3>'.$resultados.' results were found using the term "'.$name.'":<br></h3>';
		if($resultados){
		echo '<table border="1" cellpadding="10" cellspacing="0"><tr><th>Result type</th><th>Name</th></tr>';
		if($gene){
			for($num_fila=1;$num_fila<=$res_gene->num_rows;$num_fila++){
				$fila_gene=$res_gene->fetch_assoc();
				echo "<tr><td>Gene</td><td><a href='./Results.php?object_id=".$fila_gene['gene_id']."'>".$fila_gene["gene_name"]."</a></td></tr>";
			}
			for($num_fila=1;$num_fila<=$res_gene_syn->num_rows;$num_fila++){
				$fila_gene_syn=$res_gene_syn->fetch_assoc();
				echo "<tr><td>Synonyms</td><td><a href='./Results.php?object_id=".$fila_gene_syn['object_id']."'>".$fila_gene_syn["object_synonym_name"]."</a></td></tr>";
			}
			$res_gene->close();
			$res_gene_syn->close();
		}
		if($promoter){
			for($num_fila=1;$num_fila<=$res_prod->num_rows;$num_fila++){
				$fila_prod=$res_prod->fetch_assoc();
				echo "<tr><td>Product</td><td><a href='./Results.php?object_id=".$fila_prod['gene_id']."'>".$fila_prod["product_name"]."</a></td></tr>";
			}
			$res_prod->close();
		}
		echo "</table>";
		}
	}
	$mysqli->close();
?>
</div> <!--End MainBody-->
			</div> <!--End Content Wrap-->
		</div> <!--End Container-->
	</body>
</html>

