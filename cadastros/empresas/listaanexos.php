<?php

    session_start();
    foreach($_GET as $key => $value){
    	$$key = $value;
    }

    require_once '../../conexao.php';
    
    $SQL = "SELECT nr_sequencial, ds_arquivo
            FROM anexos_empresa
            WHERE nr_seq_empresa = $codigo";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_assoc($RSS)){ 
        $arquivo = $linha['ds_arquivo'];
        $caminho = "cadastros/empresas/arquivos/$arquivo";
        $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
    
        // Ícones por tipo de arquivo (você pode expandir a lógica abaixo conforme necessário)
        switch ($extensao) {
            case 'pdf':
                $icone = 'fa-file-pdf text-danger';
                break;
            case 'doc':
            case 'docx':
                $icone = 'fa-file-word text-primary';
                break;
            case 'xls':
            case 'xlsx':
                $icone = 'fa-file-excel text-success';
                break;
            case 'zip':
            case 'rar':
                $icone = 'fa-file-archive text-muted';
                break;
            case 'txt':
                $icone = 'fa-file-alt text-secondary';
                break;
            default:
                $icone = 'fa-file text-dark';
                break;
        }
        ?>
        <div class=" col-sm-6 col-md-4 col-lg-3 col-xl-2 col-xs-12 " style="padding-bottom: 15px;">
            <div class="w-100" style="border:1px solid #ccc; padding: 10px; border-radius: 5px;" class="bg-light">
                
                <div class="text-center mb-2">
                    <a href="<?php echo $caminho ?>" target="_blank">
                        <i class="fas <?php echo $icone ?> fa-4x"></i>
                    </a>
                </div>
                
                <div class="w-100" style="padding-top: 10px;">
                    <span style="width: 80%; text-overflow: ellipsis; overflow: hidden;  display:inline-block; padding-top:5px;" title="<?php echo $arquivo ?>"><?php echo $arquivo ?></span>
                    <a class="btn btn-sm btn-danger" <?php echo $disanexo;?> style="margin-top: -15px;" onclick="removerArquivo('<?php echo $arquivo ?>', '<?php echo $linha['nr_sequencial'] ?>')" class="text-danger cursor-pointer"><i class="fa fa-trash" data-toggle='tooltip' title="Excluir arquivo"></i></a>
                    <i class="fa fa-pulse fa-spinner hidden" id="excluindo<?php echo $linha['nr_sequencial'] ?>"></i>
                </div>                
            </div>
        </div>&nbsp;
<?php } ?>
