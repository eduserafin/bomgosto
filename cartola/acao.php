<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

session_start(); 
include "../conexao.php";
//=======================		CARREGA DADOS NO FORMULARIO
if ($Tipo == "D") {
    $SQL = "SELECT * 
		FROM cartola
		WHERE nr_sequencial=" . $Codigo;
    $RSS = mysqli_query($conexao, $SQL);
    $RS = mysqli_fetch_assoc($RSS);
    if ($RS["nr_sequencial"] == $Codigo) {
        echo "<script language='javascript'>window.parent.document.getElementById('cd_cartola').value='" . $RS["nr_sequencial"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtrodada').value='" . $RS["nr_rodada"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtvencedor').value='" . $RS["nr_seq_time_vencedor"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpontos').value='" . $RS["nr_pontos"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpagador1').value='" . $RS["nr_seq_time_pagador1"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpontos1').value='" . $RS["nr_pontos1"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpagador2').value='" . $RS["nr_seq_time_pagador2"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpontos2').value='" . $RS["nr_pontos2"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpagador3').value='" . $RS["nr_seq_time_pagador3"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpontos3').value='" . $RS["nr_pontos3"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpagador4').value='" . $RS["nr_seq_time_pagador4"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpontos4').value='" . $RS["nr_pontos4"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpagador5').value='" . $RS["nr_seq_time_pagador5"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtpontos5').value='" . $RS["nr_pontos5"] . "';</script>";
        echo "<script language='javascript'>window.parent.document.getElementById('txtrodada').focus();</script>";
    }
}
//=======================		INCLUSÃO DOS DADOS
if ($Tipo == "I") {
 
        $insert = "INSERT INTO cartola (nr_rodada, nr_seq_time_vencedor, nr_pontos, nr_seq_time_pagador1, nr_pontos1,
        nr_seq_time_pagador2, nr_pontos2, nr_seq_time_pagador3, nr_pontos3, nr_seq_time_pagador4, nr_pontos4, nr_seq_time_pagador5, nr_pontos5) 
            VALUES (" . $rodada . ", " . $vencedor . ", " . $pontos . ", " . $pagador1 . ", " . $pontos1 . ",
            " . $pagador2 . ", " . $pontos2 . "," . $pagador3 . ", " . $pontos3 . "," . $pagador4 . ", " . $pontos4 . ",
            " . $pagador5 . ", " . $pontos5 . " )";
        $rss_insert = mysqli_query($conexao, $insert); echo  $insert;

            echo "<script language='JavaScript'>
                    alert('Registro cadastrado com sucesso!');
                    window.parent.executafuncao('new');
                    window.parent.consultar(0);
                  </script>";
        } 

//=======================		ALTERACÃO DOS DADOS
if ($Tipo == "A") {
    
        $update = "UPDATE cartola
      SET nr_rodada=" . $rodada . ", nr_seq_time_vencedor=" . $vencedor . ", nr_pontos=" . $pontos . ",
      nr_seq_time_pagador1=" . $pagador1 . ", nr_pontos1=" . $pontos1 . ",  
      nr_seq_time_pagador2=" . $pagador2 . ", nr_pontos2=" . $pontos2 . ",  
      nr_seq_time_pagador3=" . $pagador3 . ", nr_pontos3=" . $pontos3 . ",
      nr_seq_time_pagador4=" . $pagador4 . ", nr_pontos4=" . $pontos4 . ", 
      nr_seq_time_pagador5=" . $pagador5 . ", nr_pontos5=" . $pontos5 . ", dt_alterado=CURRENT_TIMESTAMP   
      WHERE nr_sequencial=" . $codigo; echo $update;
        mysqli_query($conexao, $update);

        echo "<script language='JavaScript'>
                alert('Registro alterado com sucesso!');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
    }
//=======================		ATUALIZA STATUS DE RECEBIMENTO
if ($Tipo == "R") {

 $recebeu  = 'S';
 $update = "UPDATE cartola
SET st_recebeu='" . $recebeu . "', dt_recebimento=CURRENT_TIMESTAMP
WHERE nr_sequencial=" . $Codigo;
 //echo $update;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
          alert('Pagamento efetuado com sucesso!');
          window.parent.consultar(0);
        </script>";
}


//=======================  ATUALIZA STATUS DE PAGAMENTO 1
if ($Tipo == "P1") {

 $pagou1 = 'S';
 $update = "UPDATE cartola
SET st_pagou1='" . $pagou1 . "', dt_pagamento1=CURRENT_TIMESTAMP
WHERE nr_sequencial=" . $Codigo;
 //echo $update;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
          alert('Pagamento recebido com sucesso!');
          window.parent.consultar(0);
        </script>";
}

//=======================  ATUALIZA STATUS DE PAGAMENTO 2
if ($Tipo == "P2") {

 $pagou2 = 'S';
 $update = "UPDATE cartola
SET st_pagou2='" . $pagou2 . "', dt_pagamento2=CURRENT_TIMESTAMP
WHERE nr_sequencial=" . $Codigo;
 //echo $update;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
          alert('Pagamento recebido com sucesso!');
          window.parent.consultar(0);
        </script>";
}


//=======================  ATUALIZA STATUS DE PAGAMENTO 3
if ($Tipo == "P3") {

$pagou3= 'S';
 $update = "UPDATE cartola
SET st_pagou3='" . $pagou3 . "', dt_pagamento1=CURRENT_TIMESTAMP
WHERE nr_sequencial=" . $Codigo;
 //echo $update;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
          alert('Pagamento recebido com sucesso!');
          window.parent.consultar(0);
        </script>";
}


//=======================  ATUALIZA STATUS DE PAGAMENTO 4
if ($Tipo == "P4") {

 $pagou4 = 'S';
 $update = "UPDATE cartola
SET st_pagou4='" . $pagou4 . "', dt_pagamento4=CURRENT_TIMESTAMP
WHERE nr_sequencial=" . $Codigo;
 //echo $update;
 mysqli_query($conexao, $update);

 echo "<script language='JavaScript'>
          alert('Pagamento recebido com sucesso!');
          window.parent.consultar(0);
        </script>";
}

//=======================  ATUALIZA STATUS DE PAGAMENTO 5
if ($Tipo == "P5") {

  $pagou5 = 'S';
  $update = "UPDATE cartola
 SET st_pagou5='" . $pagou5 . "', dt_pagamento5=CURRENT_TIMESTAMP
 WHERE nr_sequencial=" . $Codigo;
  //echo $update;
  mysqli_query($conexao, $update);
 
  echo "<script language='JavaScript'>
           alert('Pagamento recebido com sucesso!');
           window.parent.consultar(0);
         </script>";
 }
 
//=======================		EXCLUSÃO DE DADOS
if ($Tipo == "E") {

 $update = "DELETE FROM cartola WHERE nr_sequencial=" . $Codigo;
 mysqli_query($conexao, $update); echo  $update;

 echo "<script language='JavaScript'>
                alert('Registro excluido com sucesso');
                window.parent.executafuncao('new');
                window.parent.consultar(0);
              </script>";
}

?>