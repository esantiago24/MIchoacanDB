<html>
  <head>
<title> Validate_mail </title>
  </head>
  <body>
<?php
error_reporting(E_ALL);
$mysqli = new mysqli("localhost:3306", "insertdb", "ReguL1igh22#","ecolidb");
      if ($mysqli->connect_errno) {
          header("Location: ./ErrorReg.html");
     }


  $mail = strtolower($_GET['email']);

     error_log("Correo: ".$mail,0);

//CREATE TABLE ecolidb_users(Name VARCHAR(100), Last_Name VARCHAR(100), Mail VARCHAR(100) PRIMARY KEY, Institution VARCHAR(100), uso ENUM("academic","private") ) ;

$result = $mysqli->query("SELECT Mail FROM ecolidb_users WHERE Mail='".$mail."' ");
  if($result->num_rows < 1){
    error_log("______ENTRA A RESULT_______".$result->num_rows, 0);
      $mysqli->close();
    header("Location: ./Notexist_user.html");
  }else{
    error_log("______ELSE RESULT_______", 0);
    $mysqli->close();
    header("Location: ./Dumpdownload.html");
  }

  ?>

  </body>
</html>
