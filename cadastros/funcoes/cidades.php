<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<?php

if ($consulta == 'sim') { 
  include "../../conexao.php"; 
}

$seluf = $_GET['seluf'];

?>
<div class="row">
    <div class="col-md-12">
          <label for="selcidade">CIDADE:</label>
          <select class="form-control" name="selcidade" id="selcidade" required>
            <option selected value=0>Selecione...</option>
            <?php
              $SQL = "SELECT cd_municipioibge, ds_municipioibge
                      FROM municipioibge
                      WHERE cd_estado = $seluf
                      ORDER BY ds_municipioibge";
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
