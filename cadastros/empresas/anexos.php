<?php
    foreach($_GET as $key => $value){
        $$key = pg_escape_string($value);
    }
?>

<style>
    .upload-card {
        background: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .upload-label {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .upload-input {
        width: 100%;
        border-radius: 6px;
        padding: 8px;
        border: 1px solid #ced4da;
        background-color: #fff;
    }

    .upload-btn {
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .upload-btn:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    #enviandoArquivo {
        font-weight: 500;
        margin-left: 15px;
        display: none;
    }
</style>

<div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
    <span class="glyphicon glyphicon-pencil"></span> ANEXOS
</div>

<div class="col-md-12">
    <div class="upload-card">
        <label for="campoAnexo" class="upload-label">ARQUIVO:</label>
        <input type="file" accept="image/*" multiple id="campoAnexo" class="form-control upload-input">

        <input type="hidden" id="nr_seq_empresa" value="<?php echo $codigo ?>">

        <button class="btn btn-primary upload-btn" id="btnEnviar" onclick="
            enviaAnexo(document.getElementById('campoAnexo'));
            anulacampo(document.getElementById('campoAnexo'));">
            <i class="fa fa-upload"></i> Enviar
        </button>

        <span id="enviandoArquivo">
            <i class="fa fa-spinner fa-pulse"></i> Enviando arquivo...
        </span>
    </div>

    <div class="row">
        <div class="col-md-12" id="listaArquivos">
            <?php include 'listaanexos.php'; ?>
        </div>
    </div>
</div>
<script>
    function enviaAnexo(campo) {
        var codigo = document.getElementById("nr_seq_empresa").value;
        var files = campo.files; 
    
        if(!files){
            return false;
        }
    
        var formData = new FormData(); 

        var ins = files.length;
        
        for (var x = 0; x < ins; x++) {
            formData.append("file_"+x+"", files[x]);
        }

        formData.append("totalFiles", ins);

        var url = `cadastros/empresas/acao.php?Tipo=enviarArquivo&codigo=${codigo}`;

        document.getElementById('enviandoArquivo').classList.remove('hidden');
        document.getElementById('btnEnviar').setAttribute('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(data) {
                carregarAnexos()
            },
            error: function (response) {
                if(response.responseJSON && response.responseJSON.message){
                    alert(response.responseJSON.message)
                }else{
                    alert('Oops! Falha ao enviar os arquivos.');
                }
                
                return false;
            },
            complete: function () {
                campo.value = '';
                document.getElementById('enviandoArquivo').classList.add('hidden');
                document.getElementById('btnEnviar').removeAttribute('disabled');
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    }

function carregarAnexos(){
    var codigo = document.getElementById("nr_seq_empresa").value;

    var url = `cadastros/empresas/listaanexos.php?consultaAnexos=sim&codigo=${codigo}`;
    document.getElementById('listaArquivos').innerHTML = 'Aguarde, carregando...';
    $.get(url, function (htmlRetorno) {
        document.getElementById('listaArquivos').innerHTML = htmlRetorno;
    })
}

function removerArquivo(arquivo, nr_sequencial){
    if(!confirm('Deseja realmente excluir o arquivo?')){
        return false;
    }

    var url = `cadastros/empresas/acao.php?Tipo=removerArquivo&arquivo=${arquivo}&nr_sequencial=${nr_sequencial}`;
    document.getElementById('excluindo'+nr_sequencial).classList.remove('hidden')
    $.get(url, function (htmlRetorno) {
        carregarAnexos()
        $(".tooltip").tooltip("hide");
    })

    document.getElementById('btnEnviar').removeAttribute('disabled');
}
</script>
