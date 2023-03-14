<?php
foreach($_GET as $key => $value){
	$$key = $value;
}
?>
<iframe name="acao" width="0%" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"></iframe>
<body onLoad="document.getElementById('txtsenhaa').focus();">

<div class="form-group col-md-12">
  <div class="row">
    <div class="form-group form-inline col-md-1">
      <button type=button name="btsalvar" id="btsalvar" class="btn btn-success" onClick="javascript: executafuncao('save');"><span class="glyphicon glyphicon-refresh"></span> SALVAR</button>
    </div>
  </div>
</div>

<div class="form-group col-md-12">
<div class="row">
    <div class="form-group form-inline col-md-4">
      <label for="menu">NOME:</label>
      <?php echo $_SESSION["DS_USUARIO"];?>
    </div>
</div>
<div class="row">
    <div class="form-group form-inline col-md-4">
      <label for="menu">SENHA ATUAL:</label>
      <input type="password" class="form-control" name="txtsenhaa" id="txtsenhaa" size="20" maxlength="20" style="background:#E0FFFF;">
    </div>
</div>
<div class="row">
    <div class="form-group form-inline col-md-4">
      <label for="menu">SENHA NOVA:</label>
      <input type="password" class="form-control" name="txtsenhan" id="txtsenhan" size="20" maxlength="20" style="background:#E0FFFF;">
    </div>
</div>

<script language="javascript">
function executafuncao(id){
  if (id=='save'){
  	var senhaa = document.getElementById('txtsenhaa').value;
  	var senhan = document.getElementById('txtsenhan').value;
  
  	if (senhaa!=''){ senhaa = senhaa.replace("'",""); }
  	if (senhan!=''){ senhan = senhan.replace("'",""); }
  
  	if(senhaa==''){ alert("Informe a senha atual!"); document.getElementById('txtsenhaa').focus();} 
    else if(senhan==''){ alert("Informe a nova senha!"); document.getElementById('txtsenhan').focus();} 
    else if(senhaa == senhan){ alert("A NOVA SENHA esta igual a SENHA ANTIGA!"); document.getElementById('txtsenhaa').focus(); } 
    else {
  		window.open("admin/senha/acao.php?Alterar=OK&TxSenhaA="+senhaa+"&TxSenhaN="+senhan, "acao");
  	}
  }
}
</script>