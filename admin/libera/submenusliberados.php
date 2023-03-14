<?php
foreach($_GET as $key => $value){
	$$key = $value;
}

$v_tp_menu = '';

if ($codigo != 0 and $codigo != "") {
  require_once '../../conexao.php';
  
  if ($cd_modulo != 0){ $v_tp_menu = "AND tipo_menu=$cd_modulo"; }
  ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    </head>
    <body style="background-color: rgb(236,240,245);">
    <table width="100%" class="table table-bordered table-striped">
  <?php
  $SQL = "SELECT DISTINCT(m.nr_sequencial), ds_smenu, tipo_menu 
    FROM g_smenus m INNER JOIN g_smenu_user u ON m.nr_sequencial = u.nr_seq_smenu 
    WHERE u.nr_seq_user=".$cd_usuario." 
      AND nr_seq_menu=".$codigo."
      $v_tp_menu 
    ORDER BY ds_smenu ASC";
  	$i = 0;
  	$RSS = mysqli_query($conexao, $SQL);
  	while($linha = mysqli_fetch_row($RSS)){
  			$cdgo = $linha[0];
  			$desc = $linha[1];
        $tipo = $linha[2];
        
        if ($tipo == "1") { $desc .= " [GERAL] "; }
        else if ($tipo == "2") { $desc .= " [MOVIMENTOS] "; }
        else if ($tipo == "3") { $desc .= " [RELAT&Oacute;RIOS] "; }
  
  			$i = $i + 1;

  			?>
<tr>
  <input type="hidden" name="cdgo_smenu<?php echo $i;?>" id="cdgo_smenu<?php echo $i;?>" value="<?php echo $cdgo;?>">
  <td width="8%"><input type="checkbox" name="chk<?php echo $i;?>" id="chk<?php echo $i;?>"></td>
  <td><label for="chk<?php echo $i;?>"><?php echo $desc;?></label></td>
</tr>
  			<?php
  	}
  	?>
</table>
<input type="hidden" name="total" id="total" value="<?php echo $i;?>">
</body>
</html>
  <?php
}
?>