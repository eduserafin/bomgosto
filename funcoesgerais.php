<script language="javascript" type="text/javascript">
var myWidth = 0, myHeight = 0;
if( typeof( window.innerWidth ) == 'number' ) {
	//Non-IE
	myWidth = window.innerWidth;
	myHeight = window.innerHeight;
} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
	//IE 6+ in 'standards compliant mode'
	myWidth = document.documentElement.clientWidth;
	myHeight = document.documentElement.clientHeight;
} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
	//IE 4 compatible
	myWidth = document.body.clientWidth;
	myHeight = document.body.clientHeight;
}
//function click()
//{if (event.button==2||event.button==3) {oncontextmenu='return false';}}
//document.onmousedown=click
//document.oncontextmenu = new Function("return false;")

function FormataCpf(campo, teclapres) {
	var tecla = teclapres.keyCode;
	var vr = new String(campo.value);
	if (tecla!=8 && tecla!=46){
		vr = vr.replace(".", "");
		vr = vr.replace("/", "");
		vr = vr.replace("-", "");
		tam = vr.length + 1;
		if (tecla != 14) {
			if (tam == 4)
				campo.value = vr.substr(0, 3) + '.';
			if (tam == 7)
				campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 6) + '.';
			if (tam == 11)
				campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(7, 3) + '-' + vr.substr(11, 2);
		}
	}
}

function FormataCnpj(campo, teclapres) {
	var tecla = teclapres.keyCode;
	var vr = new String(campo.value);
	if (tecla!=8 && tecla!=46){
		vr = vr.replace(".", "");
		vr = vr.replace("/", "");
		vr = vr.replace("-", "");
		tam = vr.length + 1;
		if (tecla != 18) {
			if (tam == 3)
				campo.value = vr.substr(0, 2) + '.';
			if (tam == 6)
				campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 5) + '.';
			if (tam == 8)
				campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 5) + '.' + vr.substr(5, 8) + '/';
      if (tam == 12)
				campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(5, 3) + '/' + vr.substr(8, 4) + '-' + vr.substr(12, 2);
		}
	}
}

function Formata(src, mask, teclapres){
	var i = src.value.length;
	var saida = mask.substring(0,1);
	var tecla = teclapres.keyCode;
	if (tecla!=8 && tecla!=46){
		var texto = mask.substring(i)
		if (texto.substring(0,1) != saida){
			src.value += texto.substring(0,1);
		}
	}
}

// VALIDA UM CAMPO PARA ACEITAR APENAS NUMEROS
function validanumeros(){
	var tecla = window.event.keyCode ? window.event.keyCode : window.event.which ? window.event.which : window.event.charCode;
//	var tecla = (window.event.which) ? window.event.which : window.event.keyCode;	
	if(tecla >= 48 && tecla <= 57){
		return true;
	} else {
		if(tecla == 46 || tecla == 44){ 
			return true; 
		} else {
      alert("Este campo s� recebe n�meros. Tente novamente!");
			return false;
		}
	}
}

/*function Formata(src, mask){
// MASCARA
	var i = src.value.length;
	var saida = mask.substring(0,1);
	var texto = mask.substring(i)
	if (texto.substring(0,1) != saida)
	{src.value += texto.substring(0,1);}
}*/

function validacpf(cpf){
	// VALIDA CPF
	cpf = cpf.replace('.', '');
	cpf = cpf.replace('.', '');
	cpf = cpf.replace('-', '');
	cpf = cpf.replace('/', '');

  if(cpf.length == 14){
    validacnpj(cpf);
  }
  else {
  	var i;
  	s = cpf;
  	var Estrangeiro = String(cpf).substring(0,2).toUpperCase();
  	if(Estrangeiro == 'AR' || Estrangeiro == 'UR' || Estrangeiro == 'CL' || Estrangeiro == 'PR' || Estrangeiro == 'BO'){
  		alert("DOCUMENTO ESTRANGEIRO Prossiga...");
  		return true;
  	}
  	if(cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999"){
  		alert("CPF Inv�lido");
  		return false;
  	}
  	var c = s.substr(0,9);
  	var dv = s.substr(9,2);
  	var d1 = 0;
  	for (i = 0; i < 9; i++){
  		d1 += c.charAt(i)*(10-i);
  	}
  	if (d1 == 0){
  		alert("CPF Inv�lido");
  		return false;
  	}
  	d1 = 11 - (d1 % 11);
  	if (d1 > 9) d1 = 0;
  	if (dv.charAt(0) != d1) {
  		alert("CPF Inv�lido");
  		return false;
  	}
  	d1 *= 2;
  	for (i = 0; i < 9; i++){
  		d1 += c.charAt(i)*(11-i);
  	}
  	d1 = 11 - (d1 % 11);
  	if (d1 > 9) d1 = 0;
  	if (dv.charAt(1) != d1){
  		alert("CPF Inv�lido");
  		return false;
  	}
  	return true;
  }
}

function validacnpj(vercnpj){
	// VALIDA CNPJ
	var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais, cnpj = vercnpj.replace(/\D+/g, '');
	digitos_iguais = 1;
	if (cnpj.length != 14){
		alert('CNPJ Inv�lido');return false;
	}

	for (i = 0; i < cnpj.length - 1; i++)
	if (cnpj.charAt(i) != cnpj.charAt(i + 1)){ digitos_iguais = 0;break; }
	if (!digitos_iguais){
		tamanho = cnpj.length - 2
		numeros = cnpj.substring(0,tamanho);
		digitos = cnpj.substring(tamanho);
		soma = 0;
		pos = tamanho - 7;
		for (i = tamanho; i >= 1; i--){
			soma += numeros.charAt(tamanho - i) * pos--;
			if (pos < 2)
			pos = 9;
		}
		resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		if (resultado != digitos.charAt(0)){
			alert('CNPJ Inv�lido');
			return false;
		}
		tamanho = tamanho + 1;
		numeros = cnpj.substring(0,tamanho);
		soma = 0;
		pos = tamanho - 7;
		for (i = tamanho; i >= 1; i--){
			soma += numeros.charAt(tamanho - i) * pos--;
			if (pos < 2)
			pos = 9;
		}
		resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		if (resultado != digitos.charAt(1)){
			alert('CNPJ Inv�lido');return false;
		} else { 
			return true; 
		}
	}	else {
		alert('CNPJ Inv�lido');
		return false;
	}
}

function validaDat(campo,valor) {
	alert(campo+"-"+valor);
	if(valor!=''){
		var date=valor;
		var ardt=new Array;
		var ExpReg=new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
		ardt=date.split("/");
		erro=false;
		if (date.search(ExpReg)==-1){
			erro = true;
		} else if (((ardt[1]==4)||(ardt[1]==6)||(ardt[1]==9)||(ardt[1]==11))&&(ardt[0]>30)){
			erro = true;
		} else if ( ardt[1]==2){
			if ((ardt[0]>28)&&((ardt[2]%4)!=0)){
				erro = true;
			}
			if ((ardt[0]>29)&&((ardt[2]%4)==0)){
				erro = true;
			}
		}
		if (erro) {
			alert("'"+valor+"' n�o � uma data v�lida!!!");
			campo.focus();
			campo.value = "";
			return false;
		}
		return true;
	}
}

function number_format(numero, decimal, decimal_separador, milhar_separador){	
	numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+numero) ? 0 : +numero,
	prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
	sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
	dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
	s = '',
	toFixedFix = function (n, prec) {
		var k = Math.pow(10, prec);
		return '' + Math.round(n * k) / k;
	};
    // Fix para IE: parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}

	return s.join(dec);
}

function formatar_moeda(campo, separador_milhar, separador_decimal, tecla) {
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var whichCode = (window.Event) ? tecla.which : tecla.keyCode;

	if (whichCode == 13) return true; // Tecla Enter
	if (whichCode == 8) return true; // Tecla Delete
	key = String.fromCharCode(whichCode); // Pegando o valor digitado
	if (strCheck.indexOf(key) == -1) return false; // Valor inv�lido (n�o inteiro)
	len = campo.value.length;
	for(i = 0; i < len; i++)
	if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != separador_decimal)) break;
	aux = '';
	for(; i < len; i++)
	if (strCheck.indexOf(campo.value.charAt(i))!=-1) aux += campo.value.charAt(i);
	aux += key;
	len = aux.length;
	if (len == 0) campo.value = '';
	if (len == 1) campo.value = '0'+ separador_decimal + '0' + aux;
	if (len == 2) campo.value = '0'+ separador_decimal + aux;

	if (len > 2) {
		aux2 = '';

		for (j = 0, i = len - 3; i >= 0; i--) {
			if (j == 3) {
				aux2 += separador_milhar;
				j = 0;
			}
			aux2 += aux.charAt(i);
			j++;
		}

		campo.value = '';
		len2 = aux2.length;
		for (i = len2 - 1; i >= 0; i--)
		campo.value += aux2.charAt(i);
		campo.value += separador_decimal + aux.substr(len - 2, len);
	}

	return false;
}

</script>
<?php
function removerCaracter($string){
	$newstring = preg_replace("/[^a-zA-Z0-9_.]/", "", strtr($string, "�������������������������� ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
  $newstring = str_replace("_", " ", $newstring);
	return $newstring;
}

function removerCaractercomEspaco($string){
	$newstring = preg_replace("/[^a-zA-Z0-9_. ]/", "", strtr($string, "�������������������������� ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
  $newstring = str_replace("_", " ", $newstring);
	return $newstring;
}

function DtBrToDtEua($DT, $TP)
{
	if($TP == 1)
	{
		$Dia = substr($DT,0,2);
		$Mes = substr($DT,3,2);
		$Ano = substr($DT,6,4);
		$DtConvert = $Mes."/".$Dia."/".$Ano;
	}
	if($TP == 2)
	{
		$Dia = substr($DT,0,2);
		$Mes = substr($DT,3,2);
		$Ano = substr($DT,6,4);
		$Horas = substr($DT,10,7);
		$DtConvert = $Mes."/".$Dia."/".$Ano.$Horas;
	}
	if($TP == 3)
	{
		$Dia = substr($DT,0,2);
		$Mes = substr($DT,3,2);
		$Ano = substr($DT,6,4);
		$Horas = substr($DT,10,7);
		$DtConvert = $Ano."/".$Mes."/".$Dia;
	}
	if($TP == 4)
	{
		$Dia = substr($DT,0,2);
		$Mes = substr($DT,3,2);
		$Ano = substr($DT,6,4);
		$Horas = substr($DT,10,7);
		$DtConvert = $Ano."/".$Mes."/".$Dia.$Horas;
	}
	if($TP == 5)
	{
		$Dia = substr($DT,0,2);
		$Mes = substr($DT,3,2);
		$Ano = substr($DT,6,4);
		$Horas = substr($DT,10,7);
		$DtConvert = $Ano."-".$Mes."-".$Dia;
	}
	return $DtConvert;
}

function MinToHrMin($CAMPO)
{
	if($CAMPO != ""){
		$mm = "00"; $hh = "00"; $ResultaMTHM="";
	    if(number_format(($CAMPO/60),1)-substr(number_format(($CAMPO/60),1),-2) != "")
			{$hh = number_format(($CAMPO/60),1)-substr(number_format(($CAMPO/60),1),-2);}

		if(number_format((substr(number_format($CAMPO/60,2),-2)*60)/100,0) != "")
			{$mm = number_format((substr(number_format($CAMPO/60,2),-2)*60)/100,0); }

		if($hh > 24){
			$Dias = number_format($hh/24,1)-substr(number_format($hh/24,1),-2);
			$hh = $hh - ($Dias*24);
			if ($hh < 10 && $mm < 10){	$ResultaMTHM = $Dias . "d 0". $hh . "h 0". $mm . "m";}
			if ($hh >= 10 && $mm >= 10){$ResultaMTHM = $Dias . "d " . $hh . "h " . $mm . "m";}
			if ($hh < 10 && $mm >= 10){ $ResultaMTHM = $Dias . "d 0". $hh . "h " . $mm . "m";}
			if ($hh >= 10 && $mm < 10){ $ResultaMTHM = $Dias . "d " . $hh . "h 0". $mm . "m";}
		}else{
			if ($hh < 10 && $mm < 10){ 	$ResultaMTHM = "0d " . $hh  . "h 0". $mm . "m";}
			if ($hh >= 10 && $mm >= 10){$ResultaMTHM = $hh . "h " . $mm  . "m";}
			if ($hh < 10 && $mm >= 10){ $ResultaMTHM = "0d " . $hh  . "h " . $mm . "m";}
			if ($hh >= 10 && $mm < 10){ $ResultaMTHM = $hh . "h 0". $mm  . "m";}
		}
	}
	return $ResultaMTHM;
}

function retira_acentos($texto){ 
$array1 = array( "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�" 
, "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�" ); 
$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c" 
, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "" ); 
return str_replace($array1, $array2, $texto); 
}

function dateAdd($data_,$dias_)
{
    if(strstr($data_, "/")){
        $vetData    =   explode ("/", $data_);
        $dataFinal  =   mktime(0,0,0,$vetData[1],$vetData[0]+$dias_,$vetData[2]);
        return date("d/m/Y", $dataFinal);
    }else{
        return $data_;
    }
}

function datediff($tipo, $data1, $data2){
	list($dia_inicial, $mes_inicial, $ano_inicial) = explode("/",$data1);
	list($dia_final, $mes_final, $ano_final) = explode("/", $data2);
	
	$data_inicial2 = mktime(0,0,0,$mes_inicial,$dia_inicial,$ano_inicial);
	$data_final2 = mktime(0,0,0,$mes_final,$dia_final,$ano_final);
	$dias = ($data_final2 - $data_inicial2)/86400;
	//Dias
	if($tipo == "d"){$total = $dias;}

	//Horas - Formato ex: 30/12/2012
	if($tipo == "h"){
		$h1 = substr($data1,11,2);
		$m1 = substr($data1,14,2);
		$h2 = substr($data2,11,2);
		$m2 = substr($data2,14,2);
		$total = floor(((($dias*24)*60)+(1440-(($h1*60)+$m1))-(1440-(($h2*60)+$m2))) / 60)+1;
	}
	
	//Minutos
	if($tipo == "n"){
		if($dias > 0){
			$minutos1 = (((24 - substr($data1,11,2))*60)+(substr($data1,14,2)));
			$minutos2 = (substr($data2,11,2)*60)+(substr($data2,14,2));
			$minutos3 = ((($dias-1) * 24)*60);
		}else{
			$minutos1 = ((substr($data2,11,2) - substr($data1,11,2))*60) + (substr($data2,14,2) - substr($data1,14,2));
			$minutos2 = 0;
			$minutos3 = 0;
		}	
		$total = ($minutos1 + $minutos2 + $minutos3);
	}
	return $total;
}

function DtfimMAIORdtini($dataIni, $dataFim)
{	
	//Formato ex: 30/12/2012 19:43
	$dataFim = date("YmdHi", strtotime($dataFim));
	$dataIni = date("YmdHi", strtotime($dataIni));
	if(($dataFim-$dataIni) <= 0)
		{echo "<script language='javascript'>alert('A Data Final n�o pode ser menor que a Data Inicial.');</script>";exit;}

}

function LimpaDados($dados){
	if (substr($dados, -1) == "'"){
		$dados = substr($dados, 0, strlen($dados)-2);
	}
	$dadolimpo = str_replace("'", "", $dados);
	$dadonumber = str_replace(",", ".", str_replace(".", "", $dadolimpo));
	
	if (is_numeric($dadonumber)){
		$dadolimpo = str_replace(",", ".", str_replace(".", "", $dados));
	}
	return $dadolimpo;
}

function CalculaDias($xDataInicial, $xDataFinal) {
    $time_inicial = geraTimestamp($xDataInicial);
    $time_final = geraTimestamp($xDataFinal);
    $diferenca = $time_final - $time_inicial;
    $numDias = (int) floor($diferenca / (60 * 60 * 24));
    return $numDias;
}

function geraTimestamp($data) {
    $partes = explode('/', $data);
    return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}

function AtivaMenu($tipo, $idmen, $tar) {
    echo "<script type='text/javascript'>";
    if ($tipo == 'geral') {
        //echo "cliente ativo";
        echo "document.getElementById('m$tar').className = 'active';";
        echo "document.getElementById('geral$idmen').className = 'active';";
        //echo "alert('teste1');";
    }
    if ($tipo == 'mov') {
        //echo "cliente ativo";
        echo "document.getElementById('m$tar').className = 'active';";
        echo "document.getElementById('mov$idmen').className = 'active';";
        //echo "alert('teste2');";
    }
    if ($tipo == 'rel') {
        //echo "cliente ativo";
        echo "document.getElementById('m$tar').className = 'active';";
        echo "document.getElementById('rel$idmen').className = 'active';";
        //echo "alert('teste3');";
    }


    echo "</script>";
}
?>