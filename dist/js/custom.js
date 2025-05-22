//ARQUIVO PARA FUNÇÕES JAVASCRIPT USADAS EM TODA A APLICAÇÃO
function CarregarLoad(link, local) {
    $.get(link, function (dataReturn) {
        $('#' + local).html(dataReturn);  //coloco na div o retorno da requisicao
    });
}

function AbrirModal(link) {
    CarregarLoad(link, "MeusDados");
    document.getElementById("ModalRs").click();
}

function FecharModal() {
    document.getElementById('fecharMd').click();
}

function setElemDisabled(element){
    element.setAttribute('disabled', true);
}

function unsetElemDisabled(element){
    element.removeAttribute('disabled');
}

function escapeSpecialChars(string) {
    return string.replace(/\\n/g, "\\n")
               .replace(/\\'/g, "\\'")
               .replace(/\\"/g, '\\"')
               .replace(/\\&/g, "\\&")
               .replace(/\\r/g, "\\r")
               .replace(/\\t/g, "\\t")
               .replace(/\\b/g, "\\b")
               .replace(/\\f/g, "\\f");
};

function setDisabledLoading(){
    var desabilitar = document.querySelectorAll('.disabledLoading');

    for(var i = 0; i < desabilitar.length; i++){
        desabilitar[i].setAttribute('disabled', true);
    }
}

function unsetDisabledLoading(){
    var desabilitar = document.querySelectorAll('.disabledLoading');

    for(var i = 0; i < desabilitar.length; i++){
        desabilitar[i].removeAttribute('disabled');
    }
}

function doApiLogin(){
    $.get('api/login.php');
}

function setContentWrapperHeight(){
    wrapper = document.getElementsByClassName('content-wrapper--custom-height')[0]

    wrapper.style = "min-height:" + (wrapper.clientHeight + 20).toString() + 'px'
}