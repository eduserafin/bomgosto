<?php

foreach($_GET as $key => $value){
	$$key = $value;
}                    

include "../../conexao.php";

setlocale (LC_TIME, "pt_BR", "ptb", "portuguese-brazil", "bra");
require_once("../../dompdf/dompdf_config.inc.php");

    if($credito == "") { $credito = 0; }

    $SQL = "SELECT nr_quantidade
              FROM consorcio_quantidade_mes
            WHERE nr_sequencial = $mes";  //echo "<pre>$SQL</pre>";
    $RES = mysqli_query($conexao, $SQL);
    while($linhames=mysqli_fetch_row($RES)){
      $qtd_mes = $linhames[0];

    }

    $ds_parcela1 = $qtd_mes / 2; //Obtem o numero do primeiro grupo de parcelas
    $ds_parcela2 = $ds_parcela1 + 1; //Obtem o numero do segundo grupo de parcelas
    $credito_total = $credito * $quantidade;
  

  $html = "<html>";
  $html.= "<head>";
  $html.= "<title>SIMULAÇÃO CONSÓRCIO</title>";
  $html.= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
  $html.= "<link rel='stylesheet' href='../../obj/estilo.css'>";
  $html.= "</head>";
  $html.= "<body style='#FFFFFF'>";

  $html.= "<fildset>";  
  $html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='10' class='tabelas' border=1>";
  $html.= "<tr height='25'>";
  $html.= "<td align=left width=40%><img width='300' height='80' src='../../img/logo_rodobens.jpg'></td>";
  $html.= "<td align=left width=60%><font size=4 face='Arial'>OPORTUNIDADE DE NEGÓCIO</td>";
  $html.= "</tr>";
  $html.= "</table>";
  $html.= "</fildset>";

  $html.= "<br>";
  $html.= "<fildset>";
  $html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='1' class='tabelas' border=1>";
  $html.= "<tr height='25'>";
  $html.= "<td width='100%' align='center' bgcolor='191970'><font color='F8F8FF'><strong>SIMULAÇÃO $nome</strong></font></td>";
  $html.= "</tr>";
  $html.="</table>";
  $html.= "</fildset>";
  $html.= "<br>";

  $pc_lance = $lance / 100; // Transforma o lance em porcentagem 
  $lance_embutido_proposta = $credito * $pc_lance; //Calcula lance embutido
  $credito_liquido = $credito - $lance_embutido_proposta; //Calcula credito liquido

  if($plano == 1) { // Se for plano DEGRAU

    if($convertidada <= 60) { // Se as parcelas convertidas for < 60

      //Calcula o valor de recurso proprio necessario
      $vl_proprio = $convertidada * $parcela2; 
      $vl_proprio_final = $vl_proprio - $lance_embutido_proposta;

    } else if ($convertidada > 60) { // Se as parcelas convertidas for > 60

      //Calcula a soma das parcelas de ambos grupos
      $vl_proprio1 = 60 * $parcela2;
      $diferenca = $convertidada - 60;
      $vl_proprio2 = $diferenca * $parcela1;

      //Calcula o valor de recurso proprio necessario
      $vl_proprio = $vl_proprio1 + $vl_proprio2;
      $vl_proprio_final = $vl_proprio - $lance_embutido_proposta;

    }

  } else if($plano == 2) { // Se for plano LINEAR

    //Calcula o valor de recurso proprio necessario
    $vl_proprio = $convertidada * $parcela1;
    $vl_proprio_final = $vl_proprio - $lance_embutido_proposta;
    $parcela2 = 0;

  }

  $pc_taxa = $taxa / 100; // Converte taxa em porcentagem
  $taxa_adm = $pc_taxa * $credito; // calcula o valor da taxa

  $seguro_prestamista = $seguro * $qtd_mes; // calcula o seguro conforme a quantidade de meses

  $credito_taxa = $credito + $taxa_adm; // Soma o credito + a taxa calculada

  $seguro_operacao = ($seguro_prestamista / 100) * $credito_taxa; // calcula o seguro da operação
  
  $taxa_seguro_proposta = $taxa_adm + $seguro_operacao;

  $saldo_devedor = $lance_embutido_proposta + $vl_proprio_final; // Calcula o saldo devedor + lance embutido + recurso proprio

  $html.= "<fildset>";
  $html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0' class='tabelas' border=1>";
  $html.= "<tr height='25'>";
  $html.= "<td width='10%' align='center'><font size=1></font></td>";
  $html.= "<td width='50%' align='center'><font size=1></font></td>";
  $html.= "</tr>";
  $html.= "<tr height='25'>";
  $html.= "<td width=70%><font size=4><b>Crédito Contratado:</b></font></td>";
  $html.= "<td width=30%><font size=4>".number_format($credito_total, 2, ",", ".")." R$</font></td>";
  $html.= "</tr>";
  $html.= "<tr height='25'>";
  $html.= "<td width=70%><font size=4><b>Prazo Contrado:</b></font></td>";
  $html.= "<td width=30%><font size=4>$qtd_mes</font></td>";
  $html.= "</tr>";
  $html.= "<tr height='25'>";
  $html.= "<td width=70%><font size=4><b>Taxa Administrativa  + Seguro prestamista Total  :</b></font></td>";
  $html.= "<td width=30%><font size=4>".number_format($taxa_seguro_proposta, 2, ",", ".")." R$</font></td>";
  $html.= "</tr>";
  $html.= "<tr height='25'>";
  $html.= "<td width=70%><font size=4><b>Lance Recursos próprios:</b></font></td>";
  $html.= "<td width=30%><font size=4>".number_format($vl_proprio, 2, ",", ".")." R$</font></td>";
  $html.= "</tr>";
  $html.= "<tr height='25'>";
  $html.= "<td width=70%><font size=4><b>Embutido Total:</b></font></td>";
  $html.= "<td width=30%><font size=4>".number_format($lance_embutido_proposta, 2, ",", ".")." R$</font></td>";
  $html.= "</tr>";
  $html.= "<tr height='25'>";
  $html.= "<td width=70%><font size=4><b>Crédito disponível:</b></font></td>";
  $html.= "<td width=30%><font size=4>".number_format($lance_embutido, 2, ",", ".")." R$</font></td>";
  $html.= "</tr>";
  $html.= "<tr height='25'>";
  $html.= "<td width=70%><font size=4><b></b></font></td>";
  $html.= "<td width=30%><font size=4></font></td>";
  $html.= "</tr>";
  $html.= "</table>";
  $html.= "</fieldset>";

  $html.= "<br>";
  $html.= "<fildset>";
  $html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='1' class='tabelas' border=1>";
  $html.= "<tr height='25'>";
  $html.= "<td width='100%' align='center' bgcolor='191970'><font color='F8F8FF'><strong>COTAS</strong></font></td>";
  $html.= "</tr>";
  $html.="</table>";
  $html.= "</fildset>";
  $html.= "<br>";

  $html.= "<fildset>";
  $html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='1' class='tabelas' border=1>";
  $html.= "<tr height='25'>";
  $html.= "<th><font size=1><b>COTA</b></font></th>";
  $html.= "<th><font size=1><b>CREDITO</b></font></th>";
  $html.= "<th><font size=1><b>LANCE EMBUTIDO</b></font></th>";
  $html.= "<th><font size=1><b>CREDITO LIQUIDO</b></font></th>";
  $html.= "<th><font size=1><b>VL R.PROPRÍO</b></font></th>";
  $html.= "<th><font size=1><b>VL PARCELAS 1º - $ds_parcela1 º</b></font></th>";
  $html.= "<th><font size=1><b>VL PARCELAS $ds_parcela2 º - $qtd_mes º</b></font></th>";  
  $html.= "<th><font size=1><b>APÓS CONTEMPLAÇÃO 1º - $ds_parcela1 º</b></font></th>";
  $html.= "<th><font size=1><b>APÓS CONTEMPLAÇÃO $ds_parcela2 º - $qtd_mes º</b></font></th>";
  $html.= "<th><font size=1><b>CUSTO</b></font></th>";
  $html.= "</tr>";

  $count = 0;
  for($i=1; $i<=$quantidade; $i++) { 
  
    $pc_lance = $lance / 100; // Transforma o lance em porcentagem 
    $lance_embutido = $credito * $pc_lance; //Calcula lance embutido
    $credito_liquido = $credito - $lance_embutido; //Calcula credito liquido

    if($plano == 1) { // Se for plano DEGRAU

      if($convertidada <= 60) { // Se as parcelas convertidas for < 60

        //Calcula o valor de recurso proprio necessario
        $vl_proprio = $convertidada * $parcela2; 
        $vl_proprio_final = $vl_proprio - $lance_embutido;

      } else if ($convertidada > 60) { // Se as parcelas convertidas for > 60

        //Calcula a soma das parcelas de ambos grupos
        $vl_proprio1 = 60 * $parcela2;
        $diferenca = $convertidada - 60;
        $vl_proprio2 = $diferenca * $parcela1;

        //Calcula o valor de recurso proprio necessario
        $vl_proprio = $vl_proprio1 + $vl_proprio2;
        $vl_proprio_final = $vl_proprio - $lance_embutido;

      }

    } else if($plano == 2) { // Se for plano LINEAR

      //Calcula o valor de recurso proprio necessario
      $vl_proprio = $convertidada * $parcela1;
      $vl_proprio_final = $vl_proprio - $lance_embutido;
      $parcela2 = 0;

    }

    $pc_taxa = $taxa / 100; // Converte taxa em porcentagem
    $taxa_adm = $pc_taxa * $credito; // calcula o valor da taxa

    $seguro_prestamista = $seguro * $qtd_mes; // calcula o seguro conforme a quantidade de meses

    $credito_taxa = $credito + $taxa_adm; // Soma o credito + a taxa calculada

    $seguro_operacao = ($seguro_prestamista / 100) * $credito_taxa; // calcula o seguro da operação 

    $credito_taxa_seguro = $credito_taxa + $seguro_operacao; // Calcula o valor da operação, credito + taxa calculada + seguro da operação

    $vl_saldo_devedor = $lance_embutido + $vl_proprio_final; // Calcula o saldo devedor + lance embutido + recurso proprio

    $parcela_apos1 = $credito_taxa_seguro - $vl_saldo_devedor; // Calcula a soma da operação - saldo devedor 

    $parcelas_finais1 = $parcela_apos1 / $qtd_mes - 1; // Calcula o valor da parcela apos contemplação - primeiro grupo

    $dif_parcela = $parcela1 - $parcelas_finais1;  // calcula a diferença de valor do grupo 1 para aplicar no grupo 2

    $parcelas_finais2=  $parcela2 - $dif_parcela; // Calcula o valor da parcela apos contemplação - Segundo grupo

    $html.= "<tr height='25'>";
    $html.= "<td align='center'> $i </td>";
    $html.= "<td align='center'>". number_format($credito, 2, ',', '.') ."</td>";
    $html.= "<td align='center'>". number_format($lance_embutido, 2, ',', '.') ."</td>";
    $html.= "<td align='center'>". number_format($credito_liquido, 2, ',', '.') ." </td>";
    $html.= "<td align='center'>". number_format($vl_proprio_final, 2, ',', '.') ." </td>";
    $html.= "<td align='center'>". number_format($parcela1, 2, ',', '.') ." </td>";
    $html.= "<td align='center'>". number_format($parcela2, 2, ',', '.') ." </td>";
    $html.= "<td align='center'>". number_format($parcelas_finais1, 2, ',', '.') ." </td>";
    $html.= "<td align='center'>". number_format($parcelas_finais2, 2, ',', '.') ." </td>";
    $html.= "<td align='center'></td>";
    $html.= "</tr>";

    $count++;

} 

 //Soma de totais
 $vl_total = $credito * $count; //Credito total
 $vl_lance_total = $lance_embutido * $count; //Lance embutido total
 $vl_liquido_total = $credito_liquido * $count; //valor liquido total
 $vl_proprio_total = $vl_proprio_final * $count; //valor recurso proprio total
 $vl_parcela1_total = $parcela1 * $count; //primeiro grupo de parcelas total
 $vl_parcela2_total = $parcela2 * $count; //Segundo grupo de parcelas total
 $parcelas_finais1_total = $parcelas_finais1 * $count; //primeiro grupo de parcelas apos contemplação total
 $parcelas_finais2_total = $parcelas_finais2 * $count; //Segundo grupo de parcelas apos contemplação total


$html.= "<tr height='25'>";
$html.= "<th align='center'> $count </th>";
$html.= "<th align='center'>". number_format($vl_total, 2, ',', '.') ."</th>";
$html.= "<th align='center'>". number_format($vl_lance_total, 2, ',', '.') ."</th>";
$html.= "<th align='center'>". number_format($vl_liquido_total, 2, ',', '.') ." </th>";
$html.= "<th align='center'>". number_format($vl_proprio_total, 2, ',', '.') ." </th>";
$html.= "<th align='center'>". number_format($vl_parcela1_total, 2, ',', '.') ." </th>";
$html.= "<th align='center'>". number_format($vl_parcela2_total, 2, ',', '.') ." </th>";
$html.= "<th align='center'>". number_format($parcelas_finais1_total, 2, ',', '.') ." </th>";
$html.= "<th align='center'>". number_format($parcelas_finais2_total, 2, ',', '.') ." </th>";
$html.= "<th align='center'></th>";
$html.= "</tr>";
$html.= "</table>";
$html.= "</fildset>";

$html.= "</body>";
$html.= "</html>";

//echo "<pre>$html</pre>";
 

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$papel = array(0,0,613.16,850);
$dompdf->set_paper($papel, 'portrait');
$dompdf->render();
$dompdf->stream("simulacao_$nome.pdf", array("Attachment" => 0));
//$dompdf->stream("REL/simulacao_$nome.pdf");


?>   