  
<?php

function OpenCon()
 {
    $nomeServer = "localhost";
      $nomeUtente = "root";
      $password = "1234";
      $nomeDatabase = "mydb";
      $dsn = 'mysql:host='. $nomeServer . '; dbname=' . $nomeDatabase;
    
    //Connessione Con Il DataBase
    
    $Connessione = new PDO($dsn, $nomeUtente, $password);
   
      return $Connessione;
 }
 
function CloseCon($Connessione)
 {
    $Connessione -> close();
 }

?>