<html>
	<head>
		<title>
		<?php
		error_reporting(E_ALL);
 		ini_set('display_errors', '1');
		$gene=escapeshellcmd($_GET["search"]);
		echo $gene;
		$mysqli = new mysqli("132.248.120:3306", "regulonuser", "ReguL1igh22#", "regulondb");
		?>
		</title>
	</head>
	<body>
		
	</body>
</html>
