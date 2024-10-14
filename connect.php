<?php 
define ("DBHOST", "localhost");
define ("DBUSER", "root");
define ("DBPASS", "");
define ("DBNAME", "hajos");

$dbconn = @mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Hiba");
mysqli_query($dbconn, "SET NAMES 'utf8'");

if ($dbconn->connect_error) {
    die("Connection failed: " . $dbconn->connect_error);
  }

  echo "Adatbázis kapcs. sikeres!";
?>