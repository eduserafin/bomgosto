<?php
function fileUpload($file, $folder, $renomeia = false, $extensions = ''){
    $retorno = array();
    $retorno['error'] = false;
    $retorno['message'] = null;

    $varimport = "";
    // Pasta onde o arquivo vai ser salvo
    $_UP['pasta'] = $folder;
    // Tamanho maximo do arquivo (em Bytes)
    $_UP['tamanho'] = 1024 * 1024 * 16; // 8Mb
    // Array com as extensoes permitidas
    if(is_array($extensions)){
      $_UP['extensoes'] = $extensions;
    }elseif(strlen($extensions) > 0){
      $_UP['extensoes'] = array($extensions);
    }else{
      $_UP['extensoes'] = array();
    }
    // Renomeia o arquivo? (Se true, o arquivo sera salvo como .jpg e um nome unico)
    $_UP['renomeia'] = $renomeia;
    // Array com os tipos de erros de upload do PHP
    $_UP['erros'][0] = 'Não houve erro.';
    $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP.';
    $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML.';
    $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente.';
    $_UP['erros'][4] = 'Não foi selecionado arquivo.';
    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if ($file['error'] != 0) {
      $retorno['error'] = true;
      $retorno['message'] = $_UP['erros'][$file['error']];
      return $retorno;
    }

    // Caso script chegue a esse ponto, n�o houve erro com o upload e o PHP pode continuar]
    if(sizeof($_UP['extensoes']) > 0){
      $extensao = strtolower(end(explode('.', $file['name'])));
      if (array_search($extensao, $_UP['extensoes']) === false) {
        $retorno['error'] = true;
        $retorno['message'] = 'Extensão inválida.';
        return $retorno;
      }
    }


    if ($_UP['tamanho'] < $file['size']){
      $retorno['error'] = true;
      $retorno['message'] = 'O arquivo excede o tamanho permitido de 8MBS';
      return $retorno;
    }
  
    // O arquivo passou em todas as verifica��es, hora de tentar mov�-lo para a pasta
    // Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
      // Cria um nome baseado no UNIX TIMESTAMP atual e com extens�o .csv
      $nome_final = $file['name'];
      $nome_final = mb_strstr($nome_final, '.', true)."_".time() . '.csv';
    } else {
      // Mant�m o nome original do arquivo
      $nome_final = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $file['name']);
      $nome_final = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", '_', $nome_final);
    }
    // Depois verifica se � poss�vel mover o arquivo para a pasta escolhida
    if (move_uploaded_file($file['tmp_name'], $_UP['pasta'] . $nome_final)) {
      $retorno['error'] = false;
      $retorno['message'] = 'Arquivo enviado com sucesso';
      $retorno['filename'] = $nome_final;
      return $retorno;
    }

    $retorno['error'] = true;
    $retorno['message'] = 'Falha ao mover o arquivo';
    return $retorno;
}