<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    if ($consultar == "sim") {
        $ant = "../../";
        require_once $ant.'conexao.php';
    }

    if($codigo != ""){

        ?>

        <!DOCTYPE html>
        <html>
            <head>
                <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
                <style>
                    .icon {
                        display: none;
                        font-size: 3rem;
                    }
                    
                    .icon.selected {
                        display: inline;
                    }

                    .linha-divisoria {
                        border-top: 1px solid black; /* Define a cor e a espessura da linha */
                    }
                </style>
            </head>

            <body onLoad="document.getElementById('txtnomecampanha').focus();">
                <input type="hidden" name="cd_configuracao_campanha" id="cd_configuracao_campanha" value="<?php echo $codigo; ?>">
                <div class="row"><br>   
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <label for="txtnomecampanha">NOME:</label>                    
                            <input type="text" name="txtnomecampanha" id="txtnomecampanha" size="15" maxlength="200" class="form-control" placeholder="Nome da campanha">
                        </div>
                        <div class="col-md-6">  
                            <label>IMAGEM:</label>        
                            <select id="txtimagemcampanha" class="form-control">
                                <option value='0'>Selecione uma imagem</option>
                                <?php
                                $sql = "SELECT u.nr_sequencial, u.ds_arquivo
                                            FROM upload u
                                            INNER JOIN categorias_upload cu ON u.nr_seq_categoria = cu.nr_sequencial
                                        WHERE cu.st_ativo = 'A'
                                        AND cu.ds_categoria LIKE '%CAMPANHA%'
                                        ORDER BY u.ds_arquivo;";
                                $res = mysqli_query($conexao, $sql);
                                while($lin=mysqli_fetch_row($res)){
                                    $cdg = $lin[0];
                                    $desc = $lin[1];

                                    echo "<option value='$desc'>$desc</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">  
                            <label>ICONE:</label>        
                            <select id="txticonecampanha" class="form-control" onchange="iconesCampanha()">
                                <option value='0'>Selecione um icone</option>
                                <?php
                                $sql = "SELECT nr_sequencial, ds_icone
                                            FROM icones
                                        WHERE st_status = 'A'
                                        ORDER BY ds_icone ASC";
                                $res = mysqli_query($conexao, $sql);
                                while($lin=mysqli_fetch_row($res)){
                                    $cdg = $lin[0];
                                    $desc = $lin[1];

                                    echo "<option value='$desc'>$desc</option>";
                                }
                                ?>
                            </select>
                            <i id="iconselecionado" class="icon"></i>
                        </div>
                        <div class="col-md-6">
                            <label for="txtstatuscampamha">STATUS:</label>                    
                            <select id="txtstatuscampamha" class="form-control">
                                <option value='A'>ATIVO</option>
                                <option value='I'>INATIVO</option>
                            </select>
                        </div>
                        <div class="col-md-3"><br>
                            <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: SalvarCampanha(<?php echo $codigo; ?>);"><span class="glyphicon glyphicon-ok"></span> SALVAR</button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-12">
                            <label for="txtdetalhamentocampanha">DETALHAMENTO:</label>    
                            <textarea id="txtdetalhamentocampanha" rows="7" class="form-control" maxlength="1000" placeholder="Descreva sobre a campanha"></textarea>
                        </div>
                    </div>
                </div>  

                <hr class="linha-divisoria"> <!-- Linha divisória -->

                <div class="row-100">
                    <table width="100%" class="table table-bordered table-striped">
                        <tr>
                            <th style="vertical-align:middle;">CAMPANHA</th>
                            <th style="vertical-align:middle;">IMAGEM</th>
                            <th style="vertical-align:middle;">ICONE</th>
                            <th style="vertical-align:middle;">STATUS</th>
                            <th style="vertical-align:middle; text-align:center" colspan=2>A&Ccedil;&Otilde;ES</th>
                        </tr>

                        <?php
                        
                            $SQL = "SELECT nr_sequencial, ds_campanha, ds_imagem, ds_icone, st_ativo
                                        FROM campanhas_site 
                                    WHERE nr_seq_configuracao = $codigo
                                    ORDER BY ds_campanha ASC";
                            //echo $SQL;
                            $RSS = mysqli_query($conexao, $SQL);
                            while ($linha = mysqli_fetch_row($RSS)) {
                                $nr_sequencial = $linha[0];
                                $ds_campanha = $linha[1];
                                $ds_imagem = $linha[2];
                                $ds_icone = $linha[3];
                                $st_ativo = $linha[4];

                                if( $st_ativo == "A"){$status = 'ATIVO';}
                                else {$status = 'INATIVO';}

                                $SQL0 = "SELECT nr_sequencial
                                            FROM upload 
                                        WHERE nr_seq_configuracao = $codigo
                                        AND ds_arquivo = '$ds_imagem'";
                                //echo $SQL0;
                                $RSS0 = mysqli_query($conexao, $SQL0);
                                while ($linha0 = mysqli_fetch_row($RSS0)) {
                                    $nr_arquivo = $linha0[0];
                                }

                                ?>

                                <tr>
                                    <td><?php echo $ds_campanha; ?></td>
                                    <td><?php echo $ds_imagem; ?></td>
                                    <td>
                                        <?php if (!empty($ds_icone)): ?>
                                            <i class="<?php echo $ds_icone; ?>"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $status; ?></td>
                                    <td width='3%' align='center'><button type=button class='btn btn-info' title='Visualizar' id="<?php echo $nr_arquivo; ?>" value="<?php echo $ds_imagem; ?>" onclick='javascript: ClicaCampanha(this.id);'><span class='glyphicon glyphicon-search'></span></button></td>
                                    <td width="3%" align="center"><button type=button name="btexcluir" id="btexcluir" class="btn btn-danger" onClick="javascript: ExcluirCampanha(<?php echo $nr_sequencial; ?>);"><span class="glyphicon glyphicon-remove"></span></button></td>
                                </tr>

                                <?php
                            }
                        ?>

                    </table>
                </div>
            </body>
        </html>
    <?php } ?>

<script type="text/javascript">

    function iconesCampanha() {

        var selectElement = document.getElementById("txticonecampanha");
        var selectedIcon = selectElement.options[selectElement.selectedIndex].value;
        var iconElement = document.getElementById("iconselecionado");

        if (selectedIcon !== "") {
            iconElement.className = "icon selected";
            iconElement.innerHTML = "<i class='" + selectedIcon + "'></i>";
        } else {
            iconElement.className = "icon";
            iconElement.innerHTML = "";
        }
    }

    function SalvarCampanha(id){

        var nome = document.getElementById('txtnomecampanha').value;
        var imagem = document.getElementById("txtimagemcampanha").value;
        var icone = document.getElementById("txticonecampanha").value;
        var status = document.getElementById('txtstatuscampamha').value;
        var detalhamento = document.getElementById('txtdetalhamentocampanha').value;

        if (nome == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe o nome da campanha!'
            });
            document.getElementById('txtnomecampanha').focus();

        } else if (imagem == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione uma imagem!'
            });
            document.getElementById('txtimagemcampanha').focus();

        }  else if (icone == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Selecione um icone!'
            });
            document.getElementById('txticonecampanha').focus();

        } else {

            window.open('gerenciador/site/acao.php?Tipo=CA&codigo=' + id + '&nome=' + nome + '&imagem=' + imagem + '&icone=' + icone + '&status=' + status + '&detalhamento=' + detalhamento, "acao");
    
        }

    }

    function ExcluirCampanha(id){
        var codigo = document.getElementById('cd_configuracao_campanha').value;
        window.open('gerenciador/site/acao.php?Tipo=ECA&codigo=' + id + '&configuracao=' + codigo, "acao");
    }

    function ClicaCampanha(id) {
        var codigo = document.getElementById('cd_configuracao_campanha').value;
        window.open('gerenciador/site/imagens.php?cdarquivo=' + id + '&codigo=' + codigo, "mensagemrel");
        document.getElementById("clickModal").click();
    }

</script>
