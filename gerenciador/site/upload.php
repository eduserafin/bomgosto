<?php
foreach($_GET as $key => $value){
    $$key = $value;
}

if ($consultar == "sim") {
    $ant = "../../";
    require_once $ant.'conexao.php';
}

if ($codigo != "") {  ?>

    <style>
        .linha-divisoria {
            border-top: 1px solid black; /* Define a cor e a espessura da linha */
        }
    </style>
    <input type="hidden" name="cd_configuracao_upload" id="cd_configuracao_upload" value="<?php echo $codigo; ?>">     
        <div class="row-100"><br>
            <div class="row text-center">
                <div class="col-md-4 text-left">
                    <label>CATEGORIA DE IMAGENS</label>
                    <select id="txtcategoriaupload" name="txtcategoriaupload" class="form-control" style="background:#E0FFFF;">
                        <option value="0">Selecione uma categoria</option>
                        <?php
                        $sql = "SELECT nr_sequencial, ds_categoria
                                FROM categorias_upload
                                WHERE st_ativo = 'A'
                                ORDER BY ds_categoria";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $nr_docto = $lin[0];
                            $ds_categoria = $lin[1];
                            echo "<option value=$nr_docto>$ds_categoria</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-8 text-left">
                    <label for="txtdescricaoupload">DESCRIÇÃO:</label>
                    <textarea name="txtdescricaoupload" id="txtdescricaoupload" class="form-control" rows="1" cols="50" maxlength="200"></textarea>
                </div>

                <div class="col-md-10 text-left">
                    <label>IMAGENS</label>
                    <input type="file" id="campoImagem" onchange="verificaExtensao(this)" class="bloqueia_carregando form-control" required>
                    <span class="help-block">Selecione uma imagem JPG, JPEG, PNG</span>
                    <label style="width:100%">
                        <span class="hidden" id="carregando_imagem">  <i class="fa fa-spinner fa-pulse"></i> Carregando...</span>&nbsp;
                    </label>
                </div>

                <div class="col-md-2 text-left"><br>
                    <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: salvarImagem();"><span class="glyphicon glyphicon-ok"></span> SALVAR IMAGEM</button>
                </div>
            </div>

            <hr class="linha-divisoria"> <!-- Linha divisória -->

            <div class="row">
                <div class="col-md-12 text-left">
                    <table width="100%" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="vertical-align:middle;">IMAGEM</th>
                            <th style="vertical-align:middle;">CADASTRO</th>
                            <th style="vertical-align:middle;">DESCRIÇÃO</th>
                            <th style="vertical-align:middle;">#</th>
                            <th style="vertical-align:middle;">#</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php

                                $sql = "SELECT u.nr_sequencial, cu.ds_categoria, u.ds_descricao, 
                                            u.dt_cadastro, u.ds_arquivo, u.nr_seq_usuario
                                            FROM upload u
                                            INNER JOIN categorias_upload cu ON u.nr_seq_categoria = cu.nr_sequencial
                                        WHERE u.nr_seq_configuracao = $codigo
                                        ORDER BY u.dt_cadastro DESC, cu.ds_categoria";
                                //echo "<pre>$sql</pre>";
                                $res = mysqli_query($conexao, $sql);
                                while($lin = mysqli_fetch_row($res)){
                                    $nr_arquivo = $lin[0];
                                    $ds_categoria = $lin[1];
                                    $ds_descricao = $lin[2];
                                    $dt_cadastro = date('d/m/Y H:i',strtotime($lin[3]));
                                    $ds_arquivo = $lin[4];
                                    $usuario = $lin[5];

                                    ?>
                                
                                    <tr>
                                        <td><?php echo $ds_categoria; ?></td>
                                        <td><?php echo $dt_cadastro; ?></td>
                                        <td><?php echo $ds_descricao; ?></td>
                                        <?php
                                            echo "<td width='5%' align='center'><button type='button' class='btn btn-info' title='Visualizar' id='".$nr_arquivo."' value='".$ds_arquivo."' onclick='javascript: Clica(this.id);'><span class='glyphicon glyphicon-search'></span></button></td>";
                                        ?>
                                        <td width='5%' align='center'><button type="button" name="btexcluir" id="btexcluir" class="btn btn-danger" onclick="javascript: excluirImagem(<?php echo $nr_arquivo; ?>);" title="EXCLUIR" alt="EXCLUIR"><span class="glyphicon glyphicon-remove"></span></button></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php
}
?>

<script language="javascript">


    function Clica(id) {
        var codigo = document.getElementById('cd_configuracao_upload').value;
        window.open('gerenciador/site/imagens.php?cdarquivo=' + id + '&codigo=' + codigo, "mensagemrel");
        document.getElementById("clickModal").click();
    }


    function excluirImagem(id){
        if (!confirm("Deseja excluir o registro selecionado?")) {
          return false;
        } 
        else {
            var codigo = document.getElementById('cd_configuracao_upload').value;
            window.open('gerenciador/site/acao.php?Tipo=ExcluirImagem&cdarquivo=' + id + '&codigo=' + codigo, 'acao');
        }
    }

    function salvarImagem() {

        var codigo = document.getElementById('cd_configuracao_upload').value;
        var categoria = document.getElementById('txtcategoriaupload').value;
        var descricao = document.getElementById('txtdescricaoupload').value;

        var campoImagem = document.getElementById("carregando_imagem").value;

        var arquivo = $('#campoImagem')[0].files[0]; //Pega o primeiro arquivo do campo campoContrato (tipo file) e joga na variavel arquivoContrato

        var formData = new FormData(); //Instancia um formData vazio
        formData.append('imagem', arquivo); //Adiciona ao formData o arquivo capturado

        if (categoria == "0") {
            Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: 'Informe a categoria da imagem!'
			});
            document.getElementById('txtcategoriaupload').focus();
            return;
        } 
            
        var url = 'gerenciador/site/acao.php?Tipo=AdicionarImagem&categoria=' + categoria + '&descricao=' + descricao + '&codigo=' + codigo;

        $.ajax({ 
            url: url, //Url que será requisitada
            type: 'post',  //Tipo da requisição (como estamos trabalhando com upload, precisa ser via POST)
            data: formData, //Manda o formData que definimos
            contentType: false, 
            processData: false, 
            success: function(response){ //Função que será executada quando a requisição obtiver sucesso, o parâmetro RESPONSE corresponde ao resultado da requisição
                document.getElementById('campoImagem').value = "";
                alert('Imagem gravada com sucesso!');
                CarregarLoad("gerenciador/site/upload.php?consultar=sim&codigo=" + codigo, "upload");
                consultar(0);
            },
            error: function (response) { //Função que será executada quando a requisição obtiver erro
                if(response.responseJSON && response.responseJSON.message){
                    alert(response.responseJSON.message);
                }else{
                    alert('Falha ao gravar a imagem');
                }
                console.log("erro", response)
            }
        });
    }

    $('#campoImagem').change(function () {
        var files = this.files; // SELECIONA OS ARQUIVOS
        var tamanho = 0;

        tamanho = files[0].size/1024;
        console.log(tamanho);
        if (tamanho >= 8000) {
            alert("Arquivo não pode exceder o tamanho máximo de 8mb!")
            document.getElementById('campoImagem').value = "";
            return false;            
        } else {
            return true;
        }
    });

    function verificaExtensao($input) {
        var extPermitidas = ['jpg', 'png', 'jpeg'];
        var extArquivo = $input.value.split('.').pop();

        if(typeof extPermitidas.find(function(ext){ return extArquivo == ext; }) == 'undefined') {
        alert('Extensão "' + extArquivo + '" não permitida!');
        document.getElementById('campoImagem').value = "";
        }
    }
</script>