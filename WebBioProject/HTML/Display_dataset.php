<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="../Ima/LF.ico"> <!--Webpage Icon -->
		<link href="../CSS/Mainbodyres.css" rel="stylesheet" type="text/css" /> <!--Link to css file-->
		<link href="../CSS/MenuRes.css" rel="stylesheet" type="text/css" />
		<link href="../CSS/Searchresultsbar.css" rel="stylesheet" type="text/css" />
		<link href="../CSS/Display_dataset.css" rel="stylesheet" type="text/css" />
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

		<title>MDB Display Dataset</title>
		<script language="JavaScript">


			function validate_gene(nombre){
				var cadena=nombre.value.trim();
				if(cadena == null || cadena.length <=1){
					return 0;
				} else{return 1;}
			 }

			function myFunction(){
				var x = document.getElementById("msg");
				x.className  = "show";
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
			}

			function validate_form(){
				var flag=1;
				if(!validate_gene(document.getElementById("Gene"))){
					flag=0;
				}

				if(!flag){
					myFunction();
					return false;
				}
			}


				</script>
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
					<form id="form1" name="form1" method="get" onsubmit="validate_form()" action="Searchresults.php">
					<div class="search-box">
						<input class="search-txt" type="text" id="Gene" name="search" placeholder="Type to search">
						<div class="Checkboxes"> <!--Search Parameters-->
							<input type="checkbox" name="gene" id="gene" checked="checked"> Gene
							<input type="checkbox" name="promoter" id="promoter" checked="checked"> Product

						</div>
						<button type="submit" name="submit"  class="search-btn">
						<i class="fas fa-search"></i>
						</button>
					</div>
				</form>

				<iframe src="Dataset.txt" style="height:300px;width:400px;"></iframe> <br><br><br>

				<div class="Download-dataset">
<div id="msg">Please make sure to check your input!</div>

					<a href="./Dataset.txt" download= "ecolidb_dataset.tsv">
						<button type="submit" name="download" class="download-txt">.txt Format
					</a>
					<a href="./Dataset.txt" download= "ecolidb_dataset.tsv">
						<button type="submit" name="download" class="download-TSV">.TSV Format
					</a>
				</div>


				<div class="Title">
                                        <h1> Current dataset </h1>
                                </div>

                                <div class="red-rectangle">
					<h1>Download dataset</h1>
				</div>


				</div> <!--End MainBody-->
			</div> <!--End Content Wrap-->
		</div> <!--End Container-->
	</body>
</html>
