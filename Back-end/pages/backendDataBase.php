<?php

require("../accessoDB/accessoDB.php");

class backendDataBase
{
    private $page;
    private $size;
    private $connessione;
    private $accesso; 

     function __construct($page, $size)
    {
        $this->$page = $page;
        $this->$size = $size;
        //$this->$accesso = new accessoDB();
    }

    public function GET($page, $size)
    {
        $accesso = new accessoDB();
        $connessione = $accesso->OpenCon();

        $queryGet = "SELECT * FROM employees LIMIT 20";

        $risultato = $this->Test($connessione->query($queryGet));        

        return $risultato;

    }

    public function ContaPagine()
    {
        $contaQuery = "SELECT COUNT(id) FROM emplyees";

        $risultato = $connessione->query($contaQuery);

        $connessione->CloseCon($connessione);

        return $risultato;
    }

    public function Test($risultato)
    {

        $json = array();
    
        if($risultato->num_rows > 0)
        {
            $righe = $risultato->fetch_assoc();

            $json['_embedded'] = array();
            $json['_embedded']['_employees'] = array();

            for(;$righe = $risultato->fetch_assoc();)
            {
                $oggetto = array(array('id' => $righe["id"], 'birthDate' => $righe["birth_date"], 'firstName' => $righe["first_name"], 'lastName' => $righe["last_name"], 'gender' => $righe["gender"], 'hireDate' => $righe["hire_date"]),
                    array('_links' => array('self' =>array('href'=>'http://192.168.1.48:8081/backend.php/' . $righe['id']),
                        'employees' =>array('href'=>'http://192.168.1.48:8081/backend.php/' . $righe['id']))));
                array_push($json['_embedded']['_employees'], $oggetto);
            }

            $x = $page + 1;
            $json['_links']['self'] = array('href' => 'http://192.168.1.48:8081/backend.php{?page,size,sort}');
            $json['_links']['first'] = array('href' => 'http://192.168.1.48:8081/backend.php?page=0&size=20');
            $json['_links']['next'] = array('href' => 'http://192.168.1.48:8081/backend.php?page= 5 &size=20');
            //$json['_links']['last'] = array('href' => 'http://192.168.1.48:8081/backend.php?page='. ContaPagine()/20 .'&size=20');
            //$json['_links']['page'] = array('size' => 20, 'totalElements' => ContaPagine(), 'totalPages' => ContaPagine()/20);

            //$json += "]'_links':{'first':{'href': 'http://192.168.1.48:8081/backend.php?page=0&size=20'},'self':{'href':'http://192.168.1.48:8081/backend.php{?page,size,sort}','templated': true},'next':{'href': 'http://192.168.1.48:8081/backend.php?page=1&size=20'},'last':{'href':'http://192.168.1.48:8081/backend.php?page=15001&size=20'},'profile': {'href': ''}},'page':{'size': 20,'totalElements': 300024,'totalPages': 15002,'number': 0}}"; 
            
        }

        return $json;
    }


    
}

?>