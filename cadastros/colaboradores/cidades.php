<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php

if ($consulta == 'sim') { 
  include "../../conexao.php"; 
}

$estado = $_GET['estado'];

?>
<div class="row">
    <div class="col-md-12">
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
                echo "<option value=$nr_cdgo>$ds_munic</option>";
              }
            ?> 
          </select>
    </div>
</div>

<script type="text/javascript">

  $(document).ready(function() {
        $('#selcidade').select2();
    });
  
</script>
