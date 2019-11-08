<html>
	<head>
                <title>Search Results</title>
                <link rel="icon" href="./Images/LF.ico"> <!--Webpage Icon -->
                <link href="../CSS/Searchresults.css" rel="stylesheet" type="text/css" />
		<link href="../CSS/Searchresultsbar.css" rel="stylesheet" type="text/css" />
		<script src="https://kit.fontawesome.com/43eb676244.js" crossorigin="anonymous"></script>

	</head>

	<body>
		<div id="Container">
			<div id="Header">
				<a href="./InterfazWeb.html">
				<img src="../Ima/LogHeader.png" alt="" />
				</a>
			<div class="Text">
				<h1>E. Coli Gene Database</h1>
                        </div>
			</div>
		</div>

		<div id="MainBody"> <!--MainBody contains the search bar-->

			<form id="form2" name="form2" method="get" action="Searchresults.php">

				<div class="search-box">
					<input class="search-txt" type="text" name="search" placeholder="Type to search">

					<div class="Checkboxes"> <!--Search Parameters-->
						<h3>Select below which information to display</h3>
						<input type="checkbox" name="gene" id="gene" checked="checked"> Gene information
						<input type="checkbox" name="promoter" id="promoter" checked="checked"> Promoter information
						<input type="checkbox" name="tu" id="tu" checked="checked"> Transcriptional Unit information
					</div>

					<button type="submit" name="submit" class="search-btn">
					<i class="fas fa-search"></i>
					</button>

				</div>


	<?php
			error_reporting(E_ALL);
 			ini_set('display_errors', '1');
			$gene_search = escapeshellcmd($_GET["search"]);
			echo $gene_search;

			// MySQL connection
			$mysqli = new mysqli("132.248.248.120:3306", "regulonuser", "ReguL1igh22#", "regulondb");
		?>
	</body>

</html>
