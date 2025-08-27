<body onLoad="document.getElementById('txtempresa').focus();">
<input type="hidden" name="cd_chamado" id="cd_chamado" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-3">
            <label for="txtempresa">EMPRESA:</label>                     
                <select id="txtempresa" class="form-control" style="background:#E0FFFF;">
                    <option value='0'>Selecione uma empresa</option>
                    <?php
                        $sql = "SELECT nr_sequencial, ds_empresa
                                FROM empresas
                                WHERE st_status = 'A'
                                ORDER BY ds_empresa";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $cdg = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$cdg'>$desc</option>";
                        }
                    ?>
                </select>
        </div>
        <div class="col-md-2">
            <label for="txtabertura">DATA ABERTURA:</label>
            <input type="date" class="form-control" id="txtabertura" size="10" maxlength="10" style="background:#E0FFFF;">
        </div>
        <div class="col-md-2">
            <label for="txtfechamento">DATA FECHAMENTO:</label>
            <input type="date" class="form-control" id="txtfechamento" size="10" maxlength="10">
        </div>
        <div class="col-md-2">
            <label for="txtcategoria">CATEGORIA:</label>
            <select class="form-control" name="txtcategoria" id="txtcategoria" style="background:#E0FFFF;">
                <option value="">Selecione uma opção</option>
                <option value="I">Ideia</option>
                <option value="C">Correção</option>
                <option value="O">Solicitação</option>
                <option value="S">Suporte</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="txtprioridade">PRIORIDADE:</label>
            <select class="form-control" name="txtprioridade" id="txtprioridade" style="background:#E0FFFF;">
                <option value="">Selecione uma opção</option>
                <option value="A">Alta</option>
                <option value="M">Média</option>
                <option value="B">Baixa</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="txtstatus">STATUS:</label>
            <select class="form-control" name="txtstatus" id="txtstatus" style="background:#E0FFFF;">
                <option value="">Selecione uma opção</option>
                <option value="A">Aberto</option>
                <option value="E">Em Andamento</option>
                <option value="P">Parado</option>
                <option value="C">Concluído</option>
            </select>
        </div>
   
        <div class="col-md-9">
            <label for="txttitulo">TÍTULO:</label>
            <input type="text" class="form-control" name="txttitulo" id="txttitulo" size="10" maxlength="255" style="background:#E0FFFF;"> 
        </div>
        <div class="col-md-11">
            <label for="txtdescricao">DESCRIÇÃO:</label>
            <textarea class="form-control" id="txtdescricao" name="txtdescricao" rows="4" maxlength="2000" placeholder="Escreva a descrição..."></textarea>
        </div>
    </div>
</body>

<script type="text/javascript">

    function limparTexto(texto) {
        return texto.replace(/[^\p{L}\p{N}\s]/gu, '');
    }

    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_chamado').value = "";
            document.getElementById('txtempresa').value = "0";
            document.getElementById('txtabertura').value = "";
            document.getElementById('txtfechamento').value = "";
            document.getElementById('txtcategoria').value = "";
            document.getElementById('txtprioridade').value = "";
            document.getElementById('txtstatus').value = "";
            document.getElementById('txttitulo').value = "";
            document.getElementById('txtdescricao').value = "";
            document.getElementById('txtempresa').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_chamado').value;
            var empresa = document.getElementById('txtempresa').value;
            var abertura = document.getElementById('txtabertura').value;
            var fechamento = document.getElementById('txtfechamento').value;
            var categoria = document.getElementById('txtcategoria').value;
            var prioridade = document.getElementById('txtprioridade').value;
            var status = document.getElementById('txtstatus').value;
            var titulo = limparTexto(document.getElementById('txttitulo').value);
            var descricao = limparTexto(document.getElementById('txtdescricao').value);
            
            if (empresa == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma empresa!'
                });
                document.getElementById('txtempresa').focus();
            } else if (abertura == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe a data de abertura!'
                });
                document.getElementById('txtabertura').focus();
            } else if (categoria == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma categoria!'
                });
                document.getElementById('txtcategoria').focus();
            } else if (prioridade == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma prioridade!'
                });
                document.getElementById('txtprioridade').focus(); 
            } else if (status == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um status!'
                });
                document.getElementById('txtstatus').focus();
            } else if (titulo == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o titulo do chamado!'
                });
                document.getElementById('txttitulo').focus();
            } else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('chamados/chamados/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&empresa=' + empresa + '&abertura=' + abertura + '&fechamento=' + fechamento + '&categoria=' + categoria + '&prioridade=' + prioridade + '&status=' + status + '&titulo=' + titulo + '&descricao=' + descricao, "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_chamado').value;

            if(codigo==''){  

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Selecione um registro para realizar a exclusão!'
                }); 

            } else {

                Swal.fire({
                    title: 'Deseja excluir o registro selecionado?',
                    text: "Não tem como reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        window.open("chamados/chamados/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>