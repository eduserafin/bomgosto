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
        <body onLoad="document.getElementById('txtredes').focus();">
            <input type="hidden" name="cd_configuracao_contato" id="cd_configuracao_contato" value="<?php echo $codigo; ?>">
            <div class="row"><br>         
                <div class="col-md-3">  
                    <label>REDE SOCIAL:</label>        
                    <select id="txtredes" class="form-control">
                        <option value='0'>Selecione uma rede social</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_rede
                                FROM redes_sociais
                                WHERE st_ativo = 'A'
                                ORDER BY ds_rede;";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $cdg = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$cdg'>$desc</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="txtredeslink">LINK:</label>                    
                    <input type="text" name="txtredeslink" id="txtredeslink" size="15" maxlength="200" class="form-control" placeholder="Link da rede social">
                </div>
                <div class="col-md-2">
                    <label for="txtstatusredes">STATUS:</label>                    
                    <select id="txtstatusredes" class="form-control">
                        <option value='A'>ATIVO</option>
                        <option value='I'>INATIVO</option>
                    </select>
                </div>
                <div class="col-md-1"><br>
                    <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: SalvarRede(<?php echo $codigo; ?>);"><span class="glyphicon glyphicon-ok"></span> SALVAR</button>
                </div>
            </div>

            <hr class="linha-divisoria"> <!-- Linha divisória -->

            <div class="row-100">
                <table width="100%" class="table table-bordered table-striped">
                    <tr>
                        <th style="vertical-align:middle;">REDE SOCIAL</th>
                        <th style="vertical-align:middle;">LINK</th>
                        <th style="vertical-align:middle;">STATUS</th>
                        <th style="vertical-align:middle; text-align:center">A&Ccedil;&Otilde;ES</th>
                    </tr>

                    <?php
                    
                        $SQL = "SELECT r.nr_sequencial, rs.ds_rede, r.ds_link, r.st_ativo
                                    FROM redes_site r
                                    INNER JOIN redes_sociais rs ON rs.nr_sequencial = r.nr_seq_rede
                                WHERE nr_seq_configuracao = $codigo
                                ORDER BY rs.ds_rede ASC";
                        //echo $SQL;
                        $RSS = mysqli_query($conexao, $SQL);
                        while ($linha = mysqli_fetch_row($RSS)) {
                            $nr_sequencial = $linha[0];
                            $ds_rede = $linha[1];
                            $ds_link = $linha[2];
                            $st_ativo = $linha[3];

                            if( $st_ativo == "A"){$status = 'ATIVO';}
                            else {$status = 'INATIVO';}

                            ?>

                            <tr>
                            <td><?php echo $ds_rede; ?></td>
                            <td><?php echo $ds_link; ?></td>
                            <td><?php echo $status; ?></td>
                            <td width="3%" align="center"><button type=button name="btexcluir" id="btexcluir" class="btn btn-danger" onClick="javascript: ExcluirRede(<?php echo $nr_sequencial; ?>);"><span class="glyphicon glyphicon-remove"></span></button></td>
                            </tr>

                            <?php
                        }
                    ?>

                </table>

            </div>
        </body>
    <?php } ?>

<script type="text/javascript">

    function SalvarRede(id){

        var rede = document.getElementById('txtredes').value;
        var link = document.getElementById("txtredeslink").value;
        var status = document.getElementById('txtstatusredes').value;

        if (rede == 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe uma rede social!'
            });
            document.getElementById('txtredes').focus();

        } else if (link == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Informe o link da rede social!'
            });
            document.getElementById('txtredeslink').focus();

        } else {

            window.open('gerenciador/site/acao.php?Tipo=R&codigo=' + id + '&rede=' + rede + '&link=' + link + '&status=' + status, "acao");
    
        }

    }

    function ExcluirRede(id){

        var codigo = document.getElementById('cd_configuracao_contato').value;
        window.open('gerenciador/site/acao.php?Tipo=ER&codigo=' + id + '&configuracao=' + codigo, "acao");
    }

</script>
