<div class="row"><br>

<div class="col-md-12">
    <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
        <span class="glyphicon glyphicon-pencil"></span> Cards de produtos
    </div>
</div>

<div class="row-100">
    <div class="col-md-2">
        <label for="txtquantidadeprodutos">QUANTIDADE:</label>                    
        <input type="number" name="txtquantidadeprodutos" id="txtquantidadeprodutos" size="15" maxlength="10" class="form-control" onchange="javascript: BuscaProdutos(this.value, document.getElementById('cd_configuracao').value);">
    </div>
</div>

<div class="row-100">
    <div class="row-100" id="divProdutos">
    
    </div>
</div>  

</div>

<div class="row"><br>

<div class="col-md-12">
    <div id="msgexibe" class="alert alert-info fade in alert-dismissable" >
        <span class="glyphicon glyphicon-pencil"></span> Cards de Campanhas
    </div>
</div>

<div class="row-100">
    <div class="col-md-2">
        <label for="txtquantidadecampanhas">QUANTIDADE:</label>                    
        <input type="number" name="txtquantidadecampanhas" id="txtquantidadecampanhas" size="15" maxlength="10" class="form-control" onchange="javascript: BuscaCampanhas(this.value, document.getElementById('cd_configuracao').value);">
    </div>
</div>

<div class="row-100">
    <div class="row-100" id="divCampanhas">
    
    </div>
</div>  

</div>

<script type="text/javascript">

var produtos = "";
            for (p = 1; p <= qtdprodutos; p++) {
                if(produtos == ""){

                    produtos = document.getElementById("txtproduto"+p).value + ";" + document.getElementById("seliconproduto"+p).value + ";" + document.getElementById("txtdescricaoproduto"+p).value;

                } else {

                    produtos = produtos + "|" + document.getElementById("txtproduto"+p).value + ";" + document.getElementById("seliconproduto"+p).value + ";" + document.getElementById("txtdescricaoproduto"+p).value;
                }

                   
            }

            var campanhas = "";
            for (c = 1; c <= qtdcampanhas; c++) {
                if(campanhas == ""){

                    campanhas = document.getElementById("txtcampanha"+c).value + ";" + document.getElementById("seliconcampanha"+c).value;

                } else {

                    campanhas = campanhas + "|" + document.getElementById("txtcampanha"+c).value + ";" + document.getElementById("seliconcampanha"+c).value;
                }
                   
            }

            </script>