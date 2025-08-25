<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php

$consulta = isset($_GET['consulta']) ? $_GET['consulta'] : '';
$estado = isset($_GET['estado']) ? (int)$_GET['estado'] : 0;
$cidade = isset($_GET['cidade']) ? (int)$_GET['cidade'] : 0;

if ($consulta == 'sim') { 
  include "../../conexao.php"; 
}


?>

<label for="selcidade">CIDADE:</label>
<select class="form-control" name="selcidade" id="selcidade" required>
  <option selected value=0>Selecione...</option>
  <?php
    $SQL = "SELECT nr_sequencial, ds_municipio
            FROM cidades
            WHERE nr_seq_estado = $estado
            ORDER BY ds_municipio";
    $RES = mysqli_query($conexao, $SQL);
    while($lin=mysqli_fetch_row($RES)){
        $nr_cdgo = $lin[0];
        $ds_munic = $lin[1];
      
        if($nr_cdgo == $cidade){ $sel = "selected"; }
        else { $sel = ""; }

        echo "<option value=$nr_cdgo $sel>$ds_munic</option>";
                
    }
  ?> 
</select>
  
<script type="text/javascript">

  $(document).ready(function() {
        $('#selcidade').select2();
    });
  
</script>
