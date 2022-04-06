<?php

class accessoDB
{
      private $nomeServer;
      private $nomeUtente;
      private $password;
      private $nomeDatabase;
      private $Connessione;

   function __construct()
   {
      $nomeServer = "172.17.0.1:3306";
      $nomeUtente = "root";
      $password = "1234";
      $nomeDatabase = "mydb";
   }
   
   public function OpenCon()
   {      
      //Connessione Con Il DataBase
      
      $Connessione = new mysqli_connect($nomeServer, $nomeUtente, $password, $nomeDatabase);
   
      return $Connessione;
   }
   
   public function CloseCon($Connessione)
   {
      $Connessione->close();
   }
}
?>