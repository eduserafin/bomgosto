
<?php 

    $mes = date('m'); 
    $ano = date('Y'); 

    if($_SESSION["ST_ADMIN"] == 'G'){
        $v_filtro_empresa = "AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $v_filtro_colaborador = "";
    } else if ($_SESSION["ST_ADMIN"] == 'C') {
        $v_filtro_empresa = "AND nr_seq_empresa = " . $_SESSION["CD_EMPRESA"] . "";
        $v_filtro_colaborador = "AND nr_seq_usercadastro = " . $_SESSION["CD_USUARIO"] . "";
    } else {
        $v_filtro_empresa = "";
        $v_filtro_colaborador = "";
    }

    if($_SESSION["ST_PERIODO"] == 'M'){
        $v_filtro_cadastro = "AND MONTH(dt_cadastro) = $mes";
    } else if ($_SESSION["ST_PERIODO"] == 'N') {
        $v_filtro_cadastro = "AND YEAR(dt_cadastro) = $ano";
    } else {
        $v_filtro_cadastro = "";
    }

    //ABERTA
    $leads_novas = 0;
    $SQL = "SELECT COUNT(*) FROM lead
            WHERE nr_seq_situacao = 2
            "  . $v_filtro_cadastro . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_row($RSS)){
        $leads_novas = $linha[0];
    }

    //AGENDADA
    $leads_contato = 0;
    $SQL = "SELECT COUNT(*) FROM lead
            WHERE nr_seq_situacao = 3
            "  . $v_filtro_cadastro . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_row($RSS)){
        $leads_contato = $linha[0];
    }

    //PERDIDA
    $leads_perdidas = 0;
    $SQL = "SELECT COUNT(*) FROM lead
            WHERE nr_seq_situacao = 4
            "  . $v_filtro_cadastro . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_row($RSS)){
        $leads_perdidas = $linha[0];
    }

    //EM ANDAMENTO
    $leads_andamento = 0;
    $SQL = "SELECT COUNT(*) FROM lead
            WHERE nr_seq_situacao = 5
            "  . $v_filtro_cadastro . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_row($RSS)){
        $leads_andamento = $linha[0];
    }

    //CONTRATADA
    $leads_contratadas = 0;
    $SQL = "SELECT COUNT(*) FROM lead
            WHERE nr_seq_situacao = 1
            "  . $v_filtro_cadastro . "
            "  . $v_filtro_empresa . "
            "  . $v_filtro_colaborador . "";
    $RSS = mysqli_query($conexao, $SQL);
    while($linha = mysqli_fetch_row($RSS)){
        $leads_contratadas = $linha[0];
    }

?>
<style>
    .panel {
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .panel:hover {
        transform: scale(1.01);
    }

    .panel-heading {
        font-size: 16px;
        font-weight: bold;
        background-color: #2c3e50 !important;
        color: #ecf0f1 !important;
    }

    .indicator {
        font-size: 36px;
        font-weight: bold;
        color: #2c3e50;
    }

    .chart-container {
        margin-top: 20px;
    }

    .small-box {
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        color: #fff;
        padding: 20px;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
    }

    .small-box .inner {
        z-index: 2;
        position: relative;
    }

    .small-box h1 {
        font-size: 2.5rem;
        margin: 0;
        font-weight: bold;
    }

    .small-box p {
        font-size: 1.5rem;
        margin: 5px 0 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .small-box .btn {
        padding: 8px 14px;
        font-size: 1.1rem;
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .small-box .btn:hover {
        background: #005bb5;
    }

    .small-box .icon {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 60px;
        opacity: 0.2;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .small-box {
            margin-bottom: 20px;
        }
    }
</style>

<div class="col-md-12">
    <div class="d-flex mx-auto" style="gap: 40px;">
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h1><?php echo number_format($leads_novas, 0, ",", "."); ?></h1>
                    <p>NOVAS</p>
                    <button type="button" class="btn btn-info" onclick="detalhar(2);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                </div>
                <div class="icon">
                    <i class="fa fa-group"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h1><?php echo number_format($leads_contato, 0, ",", "."); ?></h1>
                    <p>AGENDADAS</p>
                    <button type="button" class="btn btn-info" onclick="detalhar(3);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                </div>
                <div class="icon">
                    <i class="fa fa-phone"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h1><?php echo number_format($leads_andamento, 0, ",", "."); ?></h1>
                    <p>ANDAMENTO</p>
                    <button type="button" class="btn btn-info" onclick="detalhar(5);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                </div>
                <div class="icon">
                    <i class="fa fa-unlock"></i>
                </div>
            </div>
        </div>
        
         <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h1><?php echo number_format($leads_perdidas, 0, ",", "."); ?></h1>
                    <p>PERDIDAS</p>
                    <button type="button" class="btn btn-info" onclick="detalhar(4);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h1><?php echo number_format($leads_contratadas, 0, ",", "."); ?></h1>
                    <p>CONTRATADAS</p>
                    <button type="button" class="btn btn-info" onclick="detalhar(1);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                </div>
                <div class="icon">
                    <i class="fa fa-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>