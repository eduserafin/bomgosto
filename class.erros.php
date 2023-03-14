<?php

class Erros {

    public function Sucesso($sms) {
        $pag = "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
  <strong>Concluido!</strong> {$sms}
</div>
";
        return $pag;
    }

    public function Aviso($sms, $teste = null) {
        $pag = "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
  <strong>Aviso!</strong> {$sms}
</div>
";
        return $pag;
    }

    public function Erro($sms) {
        $pag = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
  <strong>Erro!</strong> {$sms}
</div>
";
        return $pag;
    }

    public function Info($sms) {
        $pag = "<div class=\"alert alert-info alert-dismissible\" role=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
<strong>Aviso!</strong> {$sms}
</div>
";
        return $pag;
    }

}

?>