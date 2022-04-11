//var index = "http://192.168.1.48:8081/pages/backend.php";
var index = "http://localhost:8080/pages/backend.php";
var self, next, last, prev, page, json, totalPages, idModifica;

$(document).ready(function() 
{

  $("body").ready(function () 
  {
    prendiDati(index + "?page=0&size=20");
  });

  function prendiDati(link)   //prende i dati e stampa i dipendeti
  { 
      $.get(link, function(data)
      {
          first = data['_links']['first']['href']; 
          self = data['_links']['self']['href'];      //Link self
          last = data['_links']['last']['href'];      //Link last
          page = data['_links']['page']['number'];              //pagina
          totalPages = data['_links']['page']['totalPages'];    //pagine totali  
          json = data;                                //savo data in una variabile
          console.log(data);

          if(page != totalPages - 1)           //controllo se c'è un link next
          {
            next = data['_links']['next']['href'];
          }

          if(page != 0)                       //controllo se c'è un link prev
          {
            prev = data['_links']['prev']['href'];
          }

          page++;

          $("p").html(page);            //stampo il numero della pagina
          //console.log("pippo");
          disegnaRighe(data['_embedded']['_employees']);   //stampo la tabella
      });
  }

    $("body").on('click', '.prossimaPagina', function (e)   //evento per andare nella pagina successiva
    {
        prendiDati(next);
    });

    $("body").on('click', '.precedentePagina', function (e) //evento per andare nella pagina precedente 
    {
          if(page != 0)
              prendiDati(prev);
    
    });

    $("body").on('click', '.ultimaPagina', function (e)   ////evento per andare all'ultima pagina
    { 
            prendiDati(last);

    });

    $("body").on('click', '.primaPagina', function (e)    ////evento per andare alla prima pagina
    {      
            prendiDati(first); 
    });

    $("body").on('click', '.elimina', function (e)
    {
        var idElimina = $(this).parent("td").data("id");
        
        deleteDati(idElimina);
    });

    $(".aggiungi").click(function (e)
    {
        var nome = $("#recipient-name").val();
        var cognome = $("#recipient-lastname").val();
        
        var dipendente =              //Oggetto JS
        {
          "birthDate": "1952-12-24",
          "firstName": nome,
          "lastName": cognome,
          "gender": "M",
          "hireDate": "1991-01-26",
        };

        $("#exampleModal").modal('hide');

        postDati(dipendente);
    });

    $("body").on('click', '.apri', function (e) 
    {
      $("#modalModifica").modal('show');
      idModifica = $(this).parent("td").data("id");
    });

    $("body").on('click', '.modifica', function (e)
    {
        var nome = $("#name").val();
        var cognome = $("#lastname").val();

        var dipendente =      //Oggetto JS
        {
          "id": idModifica,
          "birthDate": "1952-12-24",
          "firstName": nome,
          "lastName": cognome,
          "gender": "M",
          "hireDate": "1991-01-26",
        };

        putDati(dipendente)

        $("#modalModifica").modal('hide');

    });

    function putDati(dipendente)          //Metodo per aggiornare i dati
    {
      $.ajax({
        type: "PUT",
        url: index + "/" + idModifica,
        data: JSON.stringify(dipendente),
        contentType: "application/json",
        dataType: "json",
        success: function(data){prendiDati(index + "?page=" + page + "&size=20")},
        error: function(data){console.log("errore");}
      });
    }

    function postDati(dipendente)               //Metodo per aggiungere i dipendenti
    {
      $.ajax({
        type: "POST",
        url: index,
        data: JSON.stringify(dipendente),
        contentType: "application/json",
        dataType: "json",
        success: function(data){console.log(data);/*prendiDati(data['_links']['last']['href'])*/},
        error: function(json){console.log("errore");}
      });
    };

    function deleteDati(idElimina) //Metodo per eliminare i dipendenti
    {
      $.ajax({
        type: "DELETE",
        url: index + "/" + idElimina,
        success: function(data){prendiDati(index + "?page=" + page + "&size=20")},
        error: function(data){console.log("errore");}
      });
    }

    function disegnaRighe(data)     //Metodo per stampare i dati
    {
        var riga = "";

        console.log(data);
        console.log(data.length);
        
        for(var i = 0; i < data.length; i++)
        {
            riga += "<tr> <th scope='row'>" + data[i][0].id + "</th> " + " <td>" + data[i][0].firstName + "</td> " +
            " <td>" + data[i][0].lastName + "</td> " + " <td data-id = " + data[i][0].id + ">" + " <button type='button' class='btn btn-danger btn-sm px-3 elimina '> Elimina </button> <button type='button' class='btn btn-warning btn-sm px-3 apri'> Modifica </button></td> </tr>";
        }

        $("tbody").html(riga);
    };
});