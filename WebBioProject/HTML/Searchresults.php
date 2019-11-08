<html>

	<head>

		<meta charset="utf-8">
		<title> E. Coli Gene Database </title>
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
						<li><a href="#" class="has-sub">Users</a>
							<ul>
							<li><a href="./Login.html">Login</a></li>
							<li><a href="./Register.html">Register</a></li>
							</ul>
						</li>
						<li><a href="#">About us</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
				</div> <!--End Menu-->

				<div id="SideBar"></div>

				<div id="MainBody"> <!--MainBody contains the search bar-->

					<form id="form1" name="form1" method="get" action="Searchresults.php">

					<div class="search-box">
						<input class="search-txt" type="text" name="search" placeholder="Type to search">
						<div class="Checkboxes"> <!--Search Parameters-->
							<input type="checkbox" name="gene" id="gene" checked="checked"> Gene
							<input type="checkbox" name="promoter" id="promoter" checked="checked"> Promoter
							<input type="checkbox" name="tu" id="tu" checked="checked"> Transcriptional Unit
						</div>
						<button type="submit" name="submit" class="search-btn">
						<i class="fas fa-search"></i>
						</button>
					</div>
					</form><!--End Form-->

				</div> <!--End MainBody-->
			</div> <!--End Content Wrap-->
		</div> <!--End Container-->
	</body>

</html>
