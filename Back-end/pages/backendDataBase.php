<?php

require("../accessoDB/accessoDB.php");

class backendDataBase
{
    private $page;
    private $size;
    private $connessione;
    private $accesso; 

     function __construct()
    {
        $this->accesso = new accessoDB();
    }

    public function GET($page, $size)
    {
        $this->page = $page;
        $this->size = $size;
        $this->connessione = $this->accesso->OpenCon();

        $queryGet = "SELECT * FROM employees LIMIT " .$page * $size.", ".$size;

        $risultato = $this->JSON($this->connessione->query($queryGet));        

        return $risultato;

    }

    public function ContaPagine()
    {
        $tot=0;
        $contaQuery = "SELECT COUNT(id) FROM employees";

        $risultato = $this->connessione->query($contaQuery);

        $this->accesso->CloseCon($this->connessione);
        for(;$righe = $risultato->fetch_assoc();)
        {
            $tot=$righe['COUNT(id)'];
        }
        return $tot;
    }

    public function JSON($risultato)
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
                    array('_links' => array('self' =>array('href'=>'http://localhost:8080/pages/backend.php/' . $righe['id']),
                        'employees' =>array('href'=>'http://localhost:8080/pages/backend.php/' . $righe['id']))));
                    array_push($json['_embedded']['_employees'], $oggetto);
            }

            $x = $this->page;
            $x1 = $this->page + 1;
            $conta = $this->ContaPagine();
            $conta1 = intval($conta/ 20);
            $json['_links']['self'] = array('href' => 'http://localhost:8080/pages/backend.php{?page,size,sort}');
            $json['_links']['first'] = array('href' => 'http://localhost:8080/pages/backend.php?page=0&size=20');
            $json['_links']['next'] = array('href' => 'http://localhost:8080/pages/backend.php?page='. $x1  .'&size=20');
            $json['_links']['last'] = array('href' => 'http://localhost:8080/pages/backend.php?page='. ($conta1 - 1) .'&size=20');
            $json['_links']['prev'] = array('href' => 'http://localhost:8080/pages/backend.php?page=' . ($x - 1) .'&size=20');
            $json['_links']['page'] = array('size' => 20, 'number' => intval($x), 'totalElements' => $conta, 'totalPages' => $conta1);
            
        }

        return $json;
    }


    
}

?>