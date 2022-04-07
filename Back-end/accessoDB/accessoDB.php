<?php

class accessoDB
{
      private $nomeServer;
      private $nomeUtente;
      private $password;
      private $nomeDatabase;
      private $dsn;
      private $connessione;

    function __construct()
   {
      $nomeServer = "localhost";
      $nomeUtente = "root";
      $password = "1234";
      $nomeDatabase = "mydb";
      $dsn = 'mysql:host='. $nomeServer . '; dbname=' . $nomeDatabase;
   }
   
   public function OpenCon()
   {      
      //Connessione Con Il DataBase

      $nomeServer = "localhost";
      $nomeUtente = "root";
      $password = "1234";
      $nomeDatabase = "mydb";
      $dsn = 'mysql:host='. $nomeServer . '; dbname=' . $nomeDatabase;

      //$connessione = new mysqli_connect($nomeServer, $nomeUtente, $password, $nomeDatabase);
      
      $connessione = new PDO($dsn, $nomeUtente, $password);
   
      return $connessione;
   }
   
   public function CloseCon($connessione)
   {
      $onnessione->close();
   }
}
?>