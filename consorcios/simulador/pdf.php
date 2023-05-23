<?php
require_once '../../config/servers.php';
foreach($_GET as $key => $value){
	$$key = $value;
}                    
session_start();
include "../../conexao.php";

setlocale (LC_TIME, "pt_BR", "ptb", "portuguese-brazil", "bra");
require_once("../../dompdf/dompdf_config.inc.php");

$sql_perfil = "SELECT COALESCE(tp_perfil,'N') FROM g_usuarios WHERE nr_sequencial = '" . $_SESSION["CD_USUARIO"] . "'";
$rss_perfil = pg_query($conexao, $sql_perfil);
while ($line_perfil = pg_fetch_row($rss_perfil)) {
    $perfil = $line_perfil[0];
}

$html = "<html>";
$html.= "<head>";
$html.= "<title>".$Titulo."</title>";
$html.= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
$html.= "<link rel='stylesheet' href='../../obj/estilo.css'>";
$html.= "</head>";
$html.= "<body style='#FFFFFF'>";

$SQL = "SELECT C.nr_sequencial,vl_inicial_bhoras,nr_cpf,ds_colaborador,nr_matricula,s.ds_filial,o.ds_descricao as ds_organograma,l.ds_descricao as ds_local,nr_seq_funcao,vl_salario,st_clifor,nr_rg,
              nr_promax,nr_seq_projeto,nr_seq_equipe,dt_admissao,dt_demissao,dt_nascimento,nr_ctps,nr_pis,
              ds_observacao,nr_seq_subprojeto,st_sexo,st_bateponto, st_jornada, nr_seq_cargoambev, ds_email, nr_seq_empresa, nr_armazem,
              pc_adtosalarial, nr_dependentes, st_escala, nr_telefone, nr_celular, dt_exameadmissao, C.ds_endereco,
              nr_cnh, st_catcnh, dt_venctocnh, c.ds_bairro, ds_cidade, uf_estado, c.nr_cep, nr_seq_escala, nr_id_planosaude,
              c.nr_endereco, c.ds_complemento, nm_mae, nm_pai,
              ds_nacionalidade, ds_localnascimento, ds_estadocivil, ds_tituloeleitor, ds_zona, ds_ufcnh, ds_grauescolaridade,
              dt_emissaoctps, dt_primeiracnh, dt_rg, dt_pis,
              CASE st_experiencia WHEN '1' THEN '45 DIAS' WHEN '2' THEN '45 DIAS + 45 DIAS' WHEN '3' THEN '90 DIAS' ELSE 'SEM' END st_experiencia, 
              CASE st_primeiroemprego WHEN 'S' THEN 'SIM' ELSE 'NAO' END AS st_primeiroemprego, 
              CASE st_sindicato WHEN 'S' THEN 'SIM' ELSE 'NAO' END AS st_sindicato,
              CASE tp_ctps WHEN 'D' THEN 'Digital' ELSE 'Papel' END AS tp_ctps,
              ds_funcao, dt_emissaocnh, q.ds_quadrohorario, c.ds_serie_ctps, c.uf_rg, c.uf_ctps, c.ds_orgao_rg, c.ds_secao,
              p.ds_projeto, sp.ds_subprojeto
        FROM g_clifor C inner join g_funcoes f on c.nr_seq_funcao = f.nr_sequencial
        inner join g_filiais s on c.nr_seq_filial = s.nr_sequencial
                        left join g_organograma o on c.nr_seq_organograma = o.nr_sequencial
                        left join g_localcontabil l on c.nr_seq_localcontabil = l.nr_sequencial
                        left join g_projetos p on c.nr_seq_projeto = p.nr_sequencial
                        left join g_subprojetos sp on c.nr_seq_subprojeto = sp.nr_sequencial
                        left join g_quadrohorarios q on c.nr_seq_escala = q.nr_sequencial
        WHERE c.nr_sequencial=" . $cdgo_clifor; //echo $SQL;

$RSS = pg_query($conexao, $SQL);
$RS = pg_fetch_assoc($RSS);
if ($RS["nr_sequencial"] == $cdgo_clifor) {
    $txtcpf = $RS["nr_cpf"];
    $txtnome = $RS["ds_colaborador"];
    $txtmatricula = $RS["nr_matricula"];
    $filial = $RS["ds_filial"];
    $organograma = $RS["ds_organograma"];
    $localcontabil = $RS["ds_local"];
    $nr_filial = $RS["nr_seq_filial"];
    $funcao = $RS["ds_funcao"];
    if ($perfil == 'RH' or $perfil == 'GE'){
      $txtsalario = number_format($RS["vl_salario"], 2, ",", ".");
    }
    else{
      $txtsalario = "";
    }
    $ativo = $RS["st_clifor"];
    $txtrg = $RS["nr_rg"];
    $txtpromax = $RS["nr_promax"];
    $bchoras = $hr_banco_horas . ":" . $hr_banco_minutos;
    $projeto = $RS["nr_seq_projeto"];
    $subprojeto = $RS["nr_seq_subprojeto"];
    $equipe = $RS["nr_seq_equipe"];
    $txtdataadm = date('d/m/Y',strtotime($RS["dt_admissao"]));
    $txtdatadem = date('d/m/Y',strtotime($RS["dt_demissao"]));
    $txtdatanasc = date('d/m/Y',strtotime($RS["dt_nascimento"]));
    $txtctps = $RS["nr_ctps"];
    $txtpis = $RS["nr_pis"];
    $observacao = $RS["ds_observacao"];
    $sexo = $RS["st_sexo"];
    $simenao = $RS["st_bateponto"];
    $cargoambev = $RS["nr_seq_cargoambev"];
    $seq_clifor = $RS["nr_sequencial"];
    $txtemail = $RS["ds_email"];
    $empresa = $RS["nr_seq_empresa"];
    $txtarmazem = $RS["nr_armazem"];
    $txtadto = number_format($RS["pc_adtosalarial"], 2, ",", ".");
    $txtdependentes = $RS["nr_dependentes"];
    $txttelefone = $RS["nr_telefone"];
    $txtcelular = $RS["nr_celular"];
    $txtendereco = $RS["ds_endereco"];
    $txtbairro = $RS["ds_bairro"];
    $txtcidade = $RS["ds_cidade"];
    $txtuf = $RS["uf_estado"];
    $txtcep = $RS["nr_cep"];
    $txtdataexame = $RS["dt_exameadmissao"];
    $txtcnh = $RS["nr_cnh"];
    $txtcatcnh = $RS["st_catcnh"];
    if ($RS["dt_venctocnh"] <> ""){
      $txtvctocnh = date('d/m/Y',strtotime($RS["dt_venctocnh"]));
    }
    else {
      $txtvctocnh = "";
    }
    $txtunimed = $RS["nr_id_planosaude"];
    $txtnomepai = $RS["nm_pai"];
    $txtnomemae = $RS["nm_mae"];
    $txtnrendereco = $RS["nr_endereco"];
    $txtdscomplemento = $RS["ds_complemento"];
    
    $horario = $RS["nr_seq_escala"];
    
    if ($RS["st_jornada"] == "S") {
        $selected1 = "selected";
        $selected2 = "";
    } else {
        $selected2 = "selected";
        $selected1 = "";
    }
    
    if ($RS["st_escala"] == "N") {
        $selescala2 = "selected";
        $selescala1 = "";
    } else {
        $selescala1 = "selected";
        $selescala2 = "";
    }

    $txtnacionalidade = $RS["ds_nacionalidade"];
    $txtlocalnascimento = $RS["ds_localnascimento"];
    $txtestadocivil = $RS["ds_estadocivil"];
    $st_experiencia = $RS["st_experiencia"];

    if ($RS["dt_emissaoctps"] <> ""){
      $txtemissaoctps = date('d/m/Y',strtotime($RS["dt_emissaoctps"]));
    }
    else{
      $txtemissaoctps = "";
    }
    $txttituloeleitor = $RS["ds_tituloeleitor"];
    $txtzona = $RS["ds_zona"];
    if ($RS["dt_primeiracnh"] <> ""){
      $txtprimeiracnh = date('d/m/Y',strtotime($RS["dt_primeiracnh"]));
    }
    else{
      $txtprimeiracnh = "";
    }
    $txtufcnh = $RS["ds_ufcnh"];
    $txtdatarg = $RS["dt_rg"];
    $txtgrauescolaridade = $RS["ds_grauescolaridade"];
    $st_primeiroemprego = $RS["st_primeiroemprego"];
    $st_sindicato = $RS["st_sindicato"];
    
    if ($RS["dt_pis"] <> ""){
      $txtdatapis = date('d/m/Y',strtotime($RS["dt_pis"]));
    }
    else{
      $txtdatapis = "";
    }

    if ($RS["dt_emissaocnh"] <> ""){
      $txtdataemissaocnh = date('d/m/Y',strtotime($RS["dt_emissaocnh"]));
    }

    if ($RS["dt_rg"] <> ""){
      $txtdatarg = date('d/m/Y',strtotime($RS["dt_rg"]));
    }

    $txtescala = $RS["ds_quadrohorario"];
    $txtseriectps = $RS["ds_serie_ctps"];
    $txtufrg = $RS["uf_rg"];
    $txtufctps = $RS["uf_ctps"];
    $txtorgaorg = $RS["ds_orgao_rg"];
    $txtsecao = $RS["ds_secao"];
    $txttpctps = $RS["tp_ctps"];
    $ds_projeto = $RS["ds_projeto"];
    $ds_subprojeto = $RS["ds_subprojeto"];

}
$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='25'>";
$html.= "<td align=left width=20%><img width='100' height='35' src='../../img/". LOGO_PADRAO ."'></td>";
$html.= "<td align=center width=80%><font face='Arial'><strong>REGISTRO DE COLABORADORES</strong></font></td>";
$html.= "</tr>";
$html.= "</table>";
$html.= "<br>";
$html.= "<fieldset><legend><font size=1>Colaborador</font></legend>";
$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Nome:</b></font></td>";
$html.= "<td colspan=3><font size=1>$txtnome</font></td>";
$html.= "</tr>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Nascimento:</b></font></td>";
$html.= "<td><font size=1>$txtdatanasc</font></td>";
$html.= "<td width=15%><font size=1><b>Nacionalidade:</b></font></td>";
$html.= "<td><font size=1>$txtnacionalidade</font></td>";
$html.= "</tr>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Local Nasc.:</b></font></td>";
$html.= "<td><font size=1>$txtlocalnascimento</font></td>";
$html.= "<td width=15%><font size=1><b>Estado Civil:</b></font></td>";
$html.= "<td><font size=1>$txtestadocivil</font></td>";
$html.= "</tr>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Endereço:</b></font></td>";
$html.= "<td colspan=3><font size=1>$txtendereco, n. $txtnrendereco - Compl. $txtdscomplemento, Bairro $txtbairro, Cidade $txtcidade/$txtuf, CEP $txtcep</font></td>";
$html.= "</tr>";
$html.= "</table>";
$html.= "</fieldset>";

$html .= "<br>";
$html .= "<fieldset><legend><font size=1>Filial</font></legend>";
$html .= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html .= "<tr height='25'>";
$html .= "<td width=15%><font size=1><b>Filial:</b></font></td>";
$html .= "<td><font size=1>$filial</font></td>";
$html .= "<td width=15%><font size=1><b>Projeto:</b></font></td>";
$html .= "<td><font size=1>$ds_projeto</font></td>";
$html .= "<td width=15%><font size=1><b>Sub-Projeto:</b></font></td>";
$html .= "<td><font size=1>$ds_subprojeto</font></td>";
$html .= "</table>";
$html .= "</fieldset>";


$html.= "<br>";
$html.= "<fieldset><legend><font size=1>Filia&ccedil;&atilde;o</font></legend>";
$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Pai:</b></font></td>";
$html.= "<td><font size=1>$txtnomepai</font></td>";
$html.= "</tr>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>M&atilde;e:</b></font></td>";
$html.= "<td><font size=1>$txtnomemae</font></td>";
$html.= "</tr>";
$html.= "</table>";
$html.= "</fieldset>";

if($txttpctps == "Papel"){

$html.= "<br>";
$html.= "<fieldset><legend><font size=1>Anota&ccedil;&otilde;es Especiais</font></legend>";
$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Tipo CTPS:</b></font></td>";
$html.= "<td><font size=1>$txttpctps</font></td>";
$html.= "<td width=15%><font size=1><b>CTPS/S&eacute;rie/UF:</b></font></td>";
$html.= "<td><font size=1>$txtctps - $txtseriectps - $txtufctps</font></td>";
$html.= "<td width=15%><font size=1><b>Emiss&atilde;o:</b></font></td>";
$html.= "<td colspan=3><font size=1>$txtemissaoctps</font></td>";
$html.= "</tr>";
} else if($txttpctps == "Digital"){
  $html.= "<br>";
$html.= "<fieldset><legend><font size=1>Anota&ccedil;&otilde;es Especiais</font></legend>";
$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Tipo CTPS:</b></font></td>";
$html.= "<td><font size=1>$txttpctps</font></td>";
}

$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>T&iacute;tulo de Eleitor:</b></font></td>";
$html.= "<td><font size=1>$txttituloeleitor</font></td>";
$html.= "<td width=15%><font size=1><b>Zona:</b></font></td>";
$html.= "<td colspan=3><font size=1>$txtzona</font></td>";
$html.= "<td width=15%><font size=1><b>Se&ccedil;&atilde;o:</b></font></td>";
$html.= "<td colspan=3><font size=1>$txtsecao</font></td>";
$html.= "</tr>";

$html.= "<tr height='25'>";
$html.= "<td width=10%><font size=1><b>CPF:</b></font></td>";
$html.= "<td><font size=1>$txtcpf</font></td>";
$html.= "<td width=10%><font size=1><b>RG/S&eacute;rie/UF:</b></font></td>";
$html.= "<td><font size=1>$txtrg - $txtorgaorg - $txtufrg</font></td>";
$html.= "<td width=10%><font size=1><b>Expedi&ccedil;&atilde;o (RG):</b></font></td>";
$html.= "<td><font size=1>$txtdatarg</font></td>";
$html.= "</tr>";

$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>CNH / Categoria:</b></font></td>";
$html.= "<td><font size=1>$txtcnh | $txtcatcnh</font></td>";
$html.= "<td width=15%><font size=1><b>Emiss&atilde;o CNH:</b></font></td>";
$html.= "<td><font size=1>$txtdataemissaocnh</font></td>";
$html.= "<td width=15%><font size=1><b>Validade CNH:</b></font></td>";
$html.= "<td><font size=1>$txtvctocnh</font></td>";
$html.= "</tr>";

$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Primeira CNH:</b></font></td>";
$html.= "<td><font size=1>$txtprimeiracnh</font></td>";
$html.= "<td width=15%><font size=1><b>UF CNH:</b></font></td>";
$html.= "<td colspan=3><font size=1>$txtufcnh</font></td>";
$html.= "</tr>";

$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Escolaridade:</b></font></td>";
$html.= "<td colspan=3><font size=1>$txtgrauescolaridade</font></td>";
$html.= "<td width=15%><font size=1><b>1 Emprego:</b></font></td>";
$html.= "<td><font size=1>$st_primeiroemprego</font></td>";
$html.= "</tr>";

$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Admiss&atilde;o:</b></font></td>";
$html.= "<td colspan=2><font size=1>$txtdataadm</font></td>";
$html.= "<td width=15%><font size=1><b>Experi&ecirc;ncia:</b></font></td>";
$html.= "<td colspan=2><font size=1>$st_experiencia</font></td>";
$html.= "</tr>";

$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Fun&ccedil;&atilde;o:</b></font></td>";
$html.= "<td colspan=2><font size=1>$funcao</font></td>";
$html.= "<td width=15%><font size=1><b>Opera&ccedil;&atilde;o:</b></font></td>";
$html.= "<td colspan=2><font size=1>$projeto</font></td>";
$html.= "</tr>";

$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Sal&aacute;rio:</b></font></td>";
$html.= "<td colspan=2><font size=1>$txtsalario</font></td>";
$html.= "<td width=15%><font size=1><b>Contrib. Sindical:</b></font></td>";
$html.= "<td colspan=2><font size=1>$st_sindicato</font></td>";

$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>Escala:</b></font></td>";
$html.= "<td colspan=4><font size=1>$txtescala</font></td>";
$html.= "</tr>";

$html.= "</table>";
$html.= "</fieldset>";

$html.= "<br>";
$html.= "<fieldset><legend><font size=1>FGTS</font></legend>";
$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='25'>";
$html.= "<td width=15%><font size=1><b>PIS:</b></font></td>";
$html.= "<td><font size=1>$txtpis</font></td>";
$html.= "<td width=15%><font size=1><b>Data Cadastro:</b></font></td>";
$html.= "<td><font size=1>$txtdatapis</font></td>";
$html.= "</tr>";
$html.= "</table>";

$html.= "</fieldset>";

$html.= "<br>";
$html.= "<fieldset><legend><font size=1>Conta Corrente</font></legend>";

$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='35'>";
$html.= "<td><font size=1><b>Banco</b></font></td>";
$html.= "<td><font size=1><b>Ag&ecirc;ncia</b></font></td>";
$html.= "<td><font size=1><b>Conta</b></font></td>";
$html.= "<td><font size=1><b>Tipo</b></font></td>";
$html.= "<td><font size=1><b>Principal</b></font></td>";
$html.= "</tr>";

$SQL = "SELECT c.nr_sequencial, b.ds_banco, c.nr_agencia, c.nr_conta, c.nm_titular, 
               CASE c.tp_conta WHEN 'CC' THEN 'Conta Corrente' WHEN 'CP' THEN 'Conta Poupanca' ELSE 'Conta Salario' end as tp_conta, 
               CASE c.st_principal WHEN 'S' THEN 'SIM' ELSE 'NÃO' END AS principal
          FROM g_clifor_conta c INNER JOIN g_bancos b ON c.nr_seq_banco = b.nr_sequencial
          WHERE c.st_ativo = 'S' AND c.nr_seq_clifor = " . $cdgo_clifor;
$RSS = pg_query($conexao, $SQL);
//echo $SQL;
while ($linha = pg_fetch_row($RSS)) {
    $nr_sequencial = $linha[0];
    $ds_banco = $linha[1];
    $nr_agencia = $linha[2];
    $nr_conta = $linha[3];
    $nm_tiular = $linha[4];
    $tp_conta = $linha[5];
    $st_conta_principal = $linha[6];
    $st_ativo = $linha[7];

    $html.= "<tr height='25'>";
    $html.= "<td><font size=1>$ds_banco</font></td>";
    $html.= "<td><font size=1>$nr_agencia</font></td>";
    $html.= "<td><font size=1>$nr_conta</font></td>";
    $html.= "<td><font size=1>$tp_conta</font></td>";
    $html.= "<td><font size=1>$st_conta_principal</font></td>";
    $html.= "</tr>";
}
$html.= "</table>";
$html.= "</fieldset>";

$html.= "<br>";
$html.= "<fieldset><legend><font size=1>Dependentes</font></legend>";

$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='35'>";
$html.= "<td><font size=1><b>Tipo:</b></font></td>";
$html.= "<td><font size=1><b>Nome:</b></font></td>";
$html.= "<td><font size=1><b>CPF:</b></font></td>";
$html.= "<td><font size=1><b>Nascimento:</b></font></td>";
$html.= "<td><font size=1><b>Cidade/UF:</b></font></td>";
$html.= "</tr>";

$SQL = "SELECT nr_sequencial, 
            CASE tp_dependente WHEN 'M' THEN 'CONJUGE' ELSE 'FILHO' END AS tipo, 
            nm_dependente, dt_nascimento, nr_cpf, ds_cidade

        FROM g_clifor_dependentes
        WHERE nr_seq_clifor = " . $cdgo_clifor;
$RSS = pg_query($conexao, $SQL);

while ($linha = pg_fetch_row($RSS)) {
    $nr_sequencial = $linha[0];
    $tp_dependente = $linha[1];
    $ds_nome = $linha[2];
    $dt_nascimento = date('d/m/Y',strtotime($linha[3]));
    $nr_cpf = $linha[4];
    $ds_cidade = $linha[5];

    $html.= "<tr height='35'>";
    $html.= "<td><font size=1>$tp_dependente</font></td>";
    $html.= "<td><font size=1>$ds_nome</font></td>";
    $html.= "<td><font size=1>$nr_cpf</font></td>";
    $html.= "<td><font size=1>$dt_nascimento</font></td>";
    $html.= "<td><font size=1>$ds_cidade</font></td>";
    $html.= "</tr>";
    
}
$html.= "</table>";
$html.= "</fieldset>";

$html.= "<br>";
$html.= "<fieldset><legend><font size=1>Benef&iacute;cios</font></legend>";

$html.= "<table width='100%' align='center' bgcolor='#FFFFFF' cellspacing='0' cellpadding='0'>";
$html.= "<tr height='35'>";
$html.= "<td><font size=1><b>Benef&iacute;cio:</b></font></td>";
$html.= "<td><font size=1><b>Tipo:</b></font></td>";
$html.= "<td><font size=1><b>Empresa:</b></font></td>";
$html.= "<td><font size=1><b>QT dia:</b></font></td>";
$html.= "<td><font size=1><b>R$ Unit:</b></font></td>";
$html.= "</tr>";
  
$SQL = "SELECT c.nr_sequencial, b.ds_beneficio, g.ds_empresa||' - '||e.ds_observacao as ds_empresa, 
               CASE e.tp_pagamento WHEN 'D' THEN 'DIARIO' WHEN 'M' THEN 'MENSAL' ELSE 'TABELADO' END as tp_pagamento, 
               e.vl_unitario, c.st_ativo, c.qt_dia, c.st_naoptante
          FROM beneficios_colab c INNER JOIN beneficios b ON c.nr_seq_beneficio = b.nr_sequencial
                                  LEFT JOIN beneficios_empresas e ON c.nr_seq_empresa_beneficio = e.nr_sequencial
                                  LEFT JOIN g_empresas_beneficios g ON e.nr_seq_empresa = g.nr_sequencial  
          WHERE c.nr_seq_clifor = " . $cdgo_clifor;
$RSS = pg_query($conexao, $SQL);

while ($linha = pg_fetch_row($RSS)) {
    $nr_sequencial = $linha[0];
    $ds_beneficio = $linha[1];
    $ds_empresa = $linha[2];
    $tp_pagamento = $linha[3];
    $vl_unitario = number_format($linha[4], 2, ",", ".");
    $st_ativo = $linha[5];
    $qt_dia = $linha[6];
    $st_naoptante = $linha[7];

    if ($st_naoptante == "N") {
      $html.= "<tr height='35'>";
      $html.= "<td colspan=5><font size=1>N&Atilde;O OPTANTE DO BENEF&Iacute;CIO</font></td>";
      $html.= "</tr>";
    }
    else{
      $html.= "<tr height='35'>";
      $html.= "<td><font size=1>$ds_beneficio</font></td>";
      $html.= "<td><font size=1>$tp_pagamento</font></td>";
      $html.= "<td><font size=1>$ds_empresa</font></td>";
      $html.= "<td align='rigth'><font size=1>$qt_dia</font></td>";
      $html.= "<td align='rigth'><font size=1>$vl_unitario</font></td>";
      $html.= "</tr>";
  }
}
$html.= "</table>";
$html.= "</fieldset>";

$html.= "</body>";
$html.= "</html>";

//echo "<pre>$html</pre>";
 
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$papel = array(0,0,613.16,850);
$dompdf->set_paper($papel, 'portrait');
$dompdf->render();
//$dompdf->stream("registro_colaboradores.pdf", array("Attachment" => 0));
$dompdf->stream("REL/registro_colaboradores.pdf");
?>   