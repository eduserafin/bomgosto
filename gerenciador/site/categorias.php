<?php

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    if ($consultar == "sim") {
        $ant = "../../";
        require_once $ant.'conexao.php';
    }

    if($codigo != ""){ ?>

        <style>
            .linha-divisoria {
                border-top: 1px solid black; /* Define a cor e a espessura da linha */
            }
        </style>
        <body onLoad="document.getElementById('txtcategoria').focus();">
            <input type="hidden" name="cd_configuracao_categoria" id="cd_configuracao_categoria" value="<?php echo $codigo; ?>">
            <div class="row"><br>         
                <div class="col-md-5">
                    <label for="txtcategoria">CATEGORIA:</label>                    
                    <input type="text" name="txtcategoria" id="txtcategoria" size="15" maxlength="200" class="form-control" placeholder="Nome da categoria">
                </div>
                <div class="col-md-2">
                    <label for="txtstatuscategoria">STATUS:</label>                    
                    <select id="txtstatuscategoria" class="form-control">
                        <option value='A'>ATIVO</option>
                        <option value='I'>INATIVO</option>
                    </select>
                </div>
                <div class="col-md-1"><br>
                    <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: SalvarCategoria(<?php echo $codigo; ?>);"><span class="glyphicon glyphicon-ok"></span> SALVAR</button>
                </div>
            </div>

            <hr class="linha-divisoria"> <!-- Linha divisória -->

            <div class="row-100">
                <table width="100%" class="table table-bordered table-striped">
                    <tr>
                        <th style="vertical-align:middle;">CATEGORIA</th>
                        <th style="vertical-align:middle;">STATUS</th>
                        <th style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
                    </tr>

                    <?php
                    
                        $SQL = "SELECT nr_sequencial, ds_categoria, st_ativo
                                    FROM categoria_produtos
                                WHERE nr_seq_configuracao = $codigo
                                ORDER BY nr_sequencial ASC";
                        //echo $SQL;
                        $RSS = mysqli_query($conexao, $SQL);
                        while ($linha = mysqli_fetch_row($RSS)) {
                            $nr_sequencial = $linha[0];
                            $ds_categoria = $linha[1];
                            $st_ativo = $linha[2];

                            if( $st_ativo == "A"){$status = 'ATIVO';}
                            else {$status = 'INATIVO';}

                            ?>

                            <tr>
                            <td><?php echo $ds_categoria; ?></td>
                            <td><?php echo $status; ?></td>
                            <td width="3%" align="center"><button type=button name="btexcluir" id="btexcluir" class="btn btn-danger" onClick="javascript: ExcluirCategoria(<?php echo $nr_sequencial; ?>);"><span class="glyphicon glyphicon-remove"></span></button></td>
                            </tr>

                            <?php
                        }
                    ?>

                </table>

            </div>
        </body>
    <?php } ?>

<script type="text/javascript">

    function SalvarCategoria(id){

        var categoria = document.getElementById('txtcategoria').value;
        var status = document.getElementById('txtstatuscategoria').value;

        if (categoria == 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe o nome da categoria!'
            });
            document.getElementById('txtcategoria').focus();

        } else {

            window.open('gerenciador/site/acao.php?Tipo=CAT&codigo=' + id + '&categoria=' + categoria + '&status=' + status, "acao");
    
        }

    }

    function ExcluirCategoria(id){

        var codigo = document.getElementById('cd_configuracao_categoria').value;
        window.open('gerenciador/site/acao.php?Tipo=ECAT&codigo=' + id + '&configuracao=' + codigo, "acao");
    }

</script>
