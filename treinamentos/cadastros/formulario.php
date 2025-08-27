<body onLoad="document.getElementById('txtmenu').focus();">
<input type="hidden" name="cd_treinamento" id="cd_treinamento" value="">
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>
    <div class="row">
        <div class="col-md-3">
            <label for="txtmenu">MENU:</label>                     
                <select id="txtmenu" class="form-control" style="background:#E0FFFF;"
                onchange="javascript: submenus(this.value, '');">
                    <option value='0'>Selecione um menu</option>
                    <?php
                        $sql = "SELECT nr_sequencial, ds_menu
                                FROM menus
                                ORDER BY ds_menu";
                        $res = mysqli_query($conexao, $sql);
                        while($lin=mysqli_fetch_row($res)){
                            $cdg = $lin[0];
                            $desc = $lin[1];

                            echo "<option value='$cdg'>$desc</option>";
                        }
                    ?>
                </select>
        </div>
        <div class="col-md-3" id="divsmenu">
            <?php include 'smenus.php'; ?>
        </div>
    
        <div class="col-md-5">
            <label for="txtlink">LINK:</label>
            <input type="text" class="form-control" name="txtlink" id="txtlink" size="10" maxlength="500"> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-11">
            <label for="txtdescricao">DESCRIÇÃO:</label>
            <textarea class="form-control" id="txtdescricao" name="txtdescricao" rows="10" maxlength="2000" placeholder="Escreva a descrição..."></textarea>
        </div>
    </div>
</body>

<script type="text/javascript">

    function submenus(menu, smenus){
        var url = 'treinamentos/cadastros/smenus.php?consulta=sim&menu=' + menu + '&smenus=' + smenus;
        $.get(url, function(dataReturn) {
            $('#divsmenu').html(dataReturn);
        });
    }

    function limparTexto(texto) {
        return texto.replace(/[^\p{L}\p{N}\s]/gu, '');
    }

    function executafuncao(id){

        if (id=='new'){
            document.getElementById('cd_treinamento').value = "";
            document.getElementById('txtmenu').value = "0";
            document.getElementById('txtsmenu').value = "0";
            document.getElementById('txtlink').value = "";
            document.getElementById('txtdescricao').value = "";
            document.getElementById('txtmenu').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_treinamento').value;
            var menu = document.getElementById('txtmenu').value;
            var smenu = document.getElementById('txtsmenu').value;
            var link = document.getElementById('txtlink').value;
            var descricao = document.getElementById('txtdescricao').value;
            //var descricao = limparTexto(document.getElementById('txtdescricao').value);

            // Codifica o HTML para envio via GET sem quebrar a URL
            descricao = encodeURIComponent(descricao);
            
            if (menu == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe um menu!'
                });
                document.getElementById('txtmenu').focus();
            } else if (smenu == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o submenu!'
                });
                document.getElementById('txtsmenu').focus();
            }  else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('treinamentos/cadastros/acao.php?' + 'Tipo=' + Tipo + '&codigo=' + codigo + '&menu=' + menu + '&smenu=' + smenu + '&link=' + link + '&descricao=' + descricao, "acao");

            }
        } else if (id == "delete") {

            var codigo = document.getElementById('cd_treinamento').value;

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
                        
                        window.open("treinamentos/cadastros/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }
</script>