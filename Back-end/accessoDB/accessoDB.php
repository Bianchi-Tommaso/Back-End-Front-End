<?php

class accessoDB
{
      private $nomeServer;
      private $nomeUtente;
      private $password;
      private $nomeDatabase;
      private $dsn;
      private $connessione;

    public function __construct()
   {
      $nomeServer = "172.17.0.3";
      $nomeUtente = "root";
      $password = "1234";
      $nomeDatabase = "mydb";
   }
   
   public function OpenCon()
   {      
      //Connessione Con Il DataBase

      $nomeServer = "172.17.0.1";
      $nomeUtente = "root";
      $password = "1234";
      $nomeDatabase = "mydb";

      $connessione = mysqli_connect($nomeServer, $nomeUtente, $password, $nomeDatabase);
   
      return $connessione;
   }
   
   public function CloseCon($connessione)
   {
      $onnessione->close();
   }
}
?>