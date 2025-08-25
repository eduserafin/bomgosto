<?php
    foreach($_GET as $key => $value){
    	$$key = $value;
    }
    
    $consulta = $_GET['consulta'];
    $empresa = $_GET['empresa'];
    $colaborador = $_GET['colaborador'];
    
    if ($consulta == 'sim') { 
      include "../../conexao.php"; 
    }

?>

<label for="txtnome">COLABORADOR:</label>                     
<select id="txtnome" class="form-control" style="background:#E0FFFF;">
    <option value='0'>Selecione um colaborador</option>
        <?php
            $sql = "SELECT nr_sequencial, ds_colaborador
                    FROM colaboradores
                    WHERE st_status = 'A'
                    AND nr_seq_empresa = $empresa
                    ORDER BY ds_colaborador";
            $res = mysqli_query($conexao, $sql);
            while($lin=mysqli_fetch_row($res)){
                $cdg = $lin[0];
                $desc = $lin[1];
    
                if($cdg == $colaborador){ $sel = "selected"; }
                else { $sel = ""; }

                echo "<option value=$cdg $sel>$desc</option>";
            }
            
        ?>
</select>
  