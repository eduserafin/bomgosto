<?php
$codigo = '';
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<input type="hidden" name="cd_menu" id="cd_menu" value="<?php echo $codigo; ?>"> 
<div class="form-group col-md-12">
    <div class="row">
        <?php include "inc/botao_novo.php"; ?>
        <?php include "inc/botao_salvar.php"; ?>
        <?php include "inc/botao_excluir.php"; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label for="txtnome">DESCRIÇÃO:</label>
        <input type="text" name="txtnome" id="txtnome" placeholder="Descrição" size="45" maxlength="60" class="form-control" style="background:#E0FFFF;">
    </div>
    <div class="col-md-4">
        <label for="txtlink">LINK:</label>
        <input type="text" name="txtlink" id="txtlink"  maxlength="35" class="form-control" style="background:#E0FFFF;">
    </div>
    <div class="col-md-2">
        <label for="txticone">ICONE:</label>
        <input type="text" name="txticone" id="txticone" maxlength="25" class="form-control" style="background:#E0FFFF;">
    </div>
</div>

<script language="JavaScript">

    function executafuncao(id){
        if (id=='new'){
            document.getElementById('cd_menu').value = "";
            document.getElementById('txtnome').value = "";
            document.getElementById('txtlink').value = "";
            document.getElementById('txticone').value = "";
            document.getElementById('txtnome').focus();
        }
        else if (id=="save"){  
            var codigo = document.getElementById('cd_menu').value;
            var nome = document.getElementById('txtnome').value;
            var link = document.getElementById('txtlink').value;
            var icone = document.getElementById('txticone').value;

            if (nome != '') {
                nome = nome.replace("'", "");
            }
            if (link != '') {
                link = link.replace("'", "");
            }
            if (icone != '') {
                icone = icone.replace("'", "");
            }

            if (nome == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o nome do Menu!'
                });
                document.getElementById('txtnome').focus();
            } else if (link == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o link de acesso!'
                });
                document.getElementById('txtlink').focus();
            } else if (icone == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Informe o icone do Menu!'
                });
                document.getElementById('txticone').focus();
            } else {
                if (codigo == '') {
                    Tipo = "I"
                } else {
                    Tipo = "A";
                }

                window.open('admin/menus/acao.php?Tipo=' + Tipo + '&codigo=' + codigo + '&nome=' + nome + '&link=' + link + '&icone=' + icone, "acao");
            }
        }
        else if (id == "delete") {

            var codigo = document.getElementById('cd_menu').value;

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
                        
                        window.open("admin/menus/acao.php?Tipo=E&codigo="+codigo, "acao");

                    } else {

                        return false;

                    }
                });

            }
        }
    }

</script>