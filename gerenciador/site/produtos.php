<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    echo "<pre><center>PRODUTOS</center></pre>";

    $consulta = "";
    if (isset($_GET["consulta"])) {
        $consulta = $_GET["consulta"];
    }
    $quantidade = "";
    if (isset($_GET["quantidade"])) {
        $quantidade = $_GET["quantidade"];
    }

    if ($consulta == "sim") {
        $ant = "../../";
        require_once $ant.'conexao.php';
    }
    
    
    if($configuracao != "") {

        $i = 1;
        $SQL = "SELECT nr_sequencial, ds_produto, ds_descricao
                        FROM conconsorcio_produtos
                    WHERE nr_seq_configuracao = $configuracao
                    ORDER BY nr_ordem ASC";
                    //echo "<pre> $SQL</pre>";
        $RES = pg_query($conexao, $SQL);
        while($linha=pg_fetch_row($RES)){
            $nr_sequencial[$i] = $linha[0];
            $ds_produto[$i] = $linha[1];
            $ds_descricao[$i] = $linha[2];
            $i++;
        }

    }

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <style>
    .icon {
      display: none;
    }
    
    .icon.selected {
      display: inline;
    }
  </style>
</head>
<body>


    <div class="table-responsive">
        <table width="100%" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="vertical-align:middle;"><font size=2>ORDEM:</font></th>
                    <th style="vertical-align:middle;"><font size=2>PRODUTO:</font></th>
                    <th style="vertical-align:middle;"><font size=2>ÍCONE:</font></th>
                    <th style="vertical-align:middle;"><font size=2>DESCRIÇÃO:</font></th>
                </tr>
            </thead>
            <tbody>

                <?php for($i=1;$i<=$quantidade;$i++){  ?>

                    <tr>
                        <td width="10%"><?php echo $i;?></td>
                        <td width="30%"><input type="text" class="form-control" name="txtproduto<?php echo $i;?>" id="txtproduto<?php echo $i;?>" value="<?php echo $ds_produto[$i]; ?>"></td>
                        <td width="20%">  
                            <select id="selicon<?php echo $i;?>" onchange="iconProdutos(<?php echo $i;?>)">
                                <option value="">Selecione um ícone</option>
                                <option value="ion-ios-home">Casa</option>
                                <option value="ion-ios-mail">E-mail</option>
                                <option value="ion-ios-star">Estrela</option>
                            </select>
                            
                            <i id="iconsel<?php echo $i;?>" class="icon"></i>
                        </td>
                        <td width="40%"><textarea id="txtdescricaoproduto<?php echo $i;?>" rows="3" class="form-control" maxlength="500" placeholder="Descreva informações do produto."></textarea></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

    <script>

        function iconProdutos(i) {

            var selectElement = document.getElementById("selicon"+i);
            var selectedIcon = selectElement.options[selectElement.selectedIndex].value;
            
            var iconElement = document.getElementById("iconsel"+i);
            
            if (selectedIcon !== "") {
                iconElement.className = "icon selected";
                iconElement.innerHTML = "<i class='" + selectedIcon + "'></i>";
            } else {
                iconElement.className = "icon";
                iconElement.innerHTML = "";
            }
        }

  </script>

</body>
</html>









