<html>
  <head>
<title> Validate_mail </title>
  </head>
  <body>
<?php
error_reporting(E_ALL);
$mysqli = new mysqli("localhost:3306", "esantiago", "M1n0mbr3","Erick");
      if ($mysqli->connect_errno) {
          header("Location: ./Reg_failure.html");
     }

     $name = strtolower($_GET['Name']);
     $last_name=strtolower($_GET['Last_name']);
     $mail = strtolower($_GET['email']);
     $inst=strtolower($_GET['Ins']);
     $uso=strtolower($_GET["use"]);

     error_log("Correo: ".$mail,0);

//CREATE TABLE ecolidb_users(Name VARCHAR(100), Last_Name VARCHAR(100), Mail VARCHAR(100) PRIMARY KEY, Institution VARCHAR(100), uso ENUM("academic","private") ) ;

$result = $mysqli->query("SELECT Mail FROM ecolidb_users WHERE Mail='".$mail."' ");
error_log("______ROWS:_______".$result->num_rows, 0);
  if($result->num_rows < 1){
    error_log("______ENTRA A RESULT_______", 0);
    $query = "INSERT INTO ecolidb_users (Name,Last_Name, Mail, Institution, Uso) VALUES ('$name', '$last_name', '$mail','$inst','$uso')";
    $success= $mysqli->query($query);
    error_log("______SUCCESS:_______".$success, 0);
    if($success){
      error_log("______ENTRA A SUCCESS_______", 0);
      $mysqli->close();
      header("Location: ./Sucregister.html");

    } else {
      error_log("______ELSE SUCCESS_______", 0);
      $mysqli->close();
       header("Location: ./ErrorReg.html");
    }
  }else{
    error_log("______ELSE RESULT_______", 0);
    $mysqli->close();
    header("Location: ./Existuser.html");
  }

  ?>

  </body>
</html>
