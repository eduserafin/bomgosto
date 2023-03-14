<?php

class Funcoes {

    public function DirecionarTempo($tempo, $pagina) {
        echo "<meta http-equiv=refresh content= '$tempo;url=$pagina'>";
    }

    public function DataBR($data) {
        if ($data == "") {

            return "";
        }
        $dia = substr($data, 8, 2);
        $mes = substr($data, 5, 2);
        $ano = substr($data, 0, 4);
        return $dia . "/" . $mes . "/" . $ano;
    }

    public function MesAno($data) {
        if ($data == "") {
            return "";
        }
        $mes = substr($data, 5, 2);
        $ano = substr($data, 0, 4);
        return $mes . "/" . $ano;
    }

    public function DataHoraBR($data) {
        $dia = substr($data, 8, 2);
        $mes = substr($data, 5, 2);
        $ano = substr($data, 0, 4);
        $hora = substr($data, 11, 2);
        $min = substr($data, 14, 2);
        return $dia . "/" . $mes . "/" . $ano . " " . $hora . ":" . $min;
    }

    public function VoltaTexto($texto) {
        $testo = str_replace("'", "", strip_tags($texto));
        return $testo;
    }

    public function VoltaInteiro($texto) {
        return intval($texto);
    }

    public function VoltaFloat($texto) {
        return floatval($texto);
    }

    public function ValidaData($dat) {
        $data = explode("-", "$dat"); // fatia a string $dat em pedados, usando / como referência
        $d = $data[2];
        $m = $data[1];
        $y = $data[0];

        // verifica se a data é válida!
        // 1 = true (válida)
        // 0 = false (inválida)
        $res = checkdate($m, $d, $y);
        if ($res == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function FormatoReal($valor) {
        // $valor = floatval($valor);
        //return money_format('%n', $valor);
        return number_format($valor, 2, ',', '.');
    }

    public function FormatoDolar($valor) {
        return number_format($valor, 2, '.', ',');
    }

    public function MascararCGC($cgc) {
        $dado = "";

        if (strlen($cgc) == 11) {

            $dado = substr($cgc, 0, 3) . "." . substr($cgc, 3, 3) . "." . substr($cgc, 6, 3) . "-" . substr($cgc, 9, 2);
        } else {
            $dado = substr($cgc, 0, 2) . "." . substr($cgc, 2, 3) . "." . substr($cgc, 5, 3) . "/" . substr($cgc, 8, 4) . "-" . substr($cgc, 12, 2);
        }
        if (strlen($cgc) == 0) {
            $dado = "Sem CPF/CNPJ";
        }

        return $dado;
    }

    function Decriptografa($chave){
        return base64_decode($chave);
    }
    function Encriptografa($chave){
        return base64_encode($chave);
    }
    
    
}
