<?php

    //error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    //ini_set('display_errors', '0');

    session_start();

    @$txtmenu = '';
    @$form = '';
    @$id_menu = '';
    @$ds_mod = '';
    $v_smenu = '';
    $tar = 0;

    if (isset($_GET['txtmenu'])) {
        @$txtmenu = $_GET['txtmenu'];
    }
    if (isset($_GET['form'])) {
        @$form = $_GET['form'];
    }
    if (isset($_GET['id_menu'])) {
        @$id_menu = $_GET['id_menu'];
    }
    if (isset($_GET['ds_mod'])) {
        @$ds_mod = $_GET['ds_mod'];
    }

    $cor_barra = "hold-transition skin-blue sidebar-mini";

    include "conexao.php";
    require_once 'class.funcoes.php';
    require_once 'class.erros.php';
    require_once 'validar.php';
    require_once 'funcoesgerais.php';
    require_once("Mobile_Detect.php");
    $detect = new Mobile_Detect;
    $AtivaMenu = true;
    if ($detect->isMobile() or $detect->isTablet()) {
        $AtivaMenu = false;
    }

    $SQLF = "SELECT  nr_sequencial
            FROM usuarios 
            WHERE nr_sequencial = " . $_SESSION["CD_USUARIO"];
    $RSF = mysqli_query($conexao, $SQLF);
    while ($RSSF = mysqli_fetch_array($RSF)){
        $id_usuario = $RSSF[0];
    }

    $TxUsuario = $_SESSION["DS_USUARIO"];
    $usuario = $_SESSION["CD_USUARIO"];
    $NmUsuario = $_SESSION["NM_USUARIO"];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/png" href="img/icone.png">
        <title>ConectaSys | Sistema</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/custom.css?v=0.02.1">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script type='text/javascript' src="obj/jquery.autocomplete.js"></script>
        <link rel="stylesheet" type="text/css" href="obj/jquery.autocomplete.css" />
        <script type="text/javascript" src="dist/typeahead.jquery.js"></script>
        <script type="text/javascript" src="dist/typeahead.bundle.js"></script>
        <!-- sweetalert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- CSS do Toastr -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <!-- JS do Toastr -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link href="plugins/select2/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        
        <style>
            .ui-autocomplete {
                height: 180px;
                overflow-x: auto;
            }

            .select2 {
                width: 100% !important
            }  
            
             html, body {
                margin: 0;
                padding: 0;
                width: 100%;
                min-height: 100vh;
            }

            body {
                display: flex;
                flex-direction: column;
                background-color: #f4f6f9;
            }

            .main-sidebar {
                background-color: #1e1e2f;
                color: #ffffff;
                min-height: 100vh;
                width: 230px;
                position: fixed;
            }

            .sidebar-menu > li.header {
                font-size: 12px;
                color: #bbb;
                padding: 15px 20px;
                text-transform: uppercase;
                border-bottom: 1px solid #333;
            }

            .sidebar-menu li a {
                color: #ccc;
                font-size: 12px; /* ou menor, se preferir, ex: 11px */
                padding: 12px 20px;
                display: flex;
                align-items: center;
                transition: background-color 0.3s ease;
                text-decoration: none;
            }

            .sidebar-menu li a:hover {
                background-color: #343454;
                color: #fff;
            }

            .sidebar-menu li.active > a,
            .sidebar-menu li.menu-open > a {
                background-color: #343454;
                font-weight: bold;
                color: #fff;
            }

            .sidebar-menu i {
                margin-right: 10px;
                font-size: 12px;
            }

            .treeview-menu {
                background-color: #2b2b3d;
                padding-left: 20px;
            }

            .treeview-menu li a {
                font-size: 12px;
                padding: 10px 20px;
            }

            .sidebar-menu li.menu-open > a {
                border-left: 4px solid #00c0ef;
            }

            .sidebar-menu li a {
                transition: all 0.3s ease;
            }

           .main-sidebar {
                background-color: #1e1e2f;
                color: #ffffff;
                min-height: 100vh;
                width: 230px;
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
            }

            .sidebar-menu li a {
                border-radius: 6px;
            }
            
            .wrapper {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

           .content-wrapper {
                flex: 1;
                margin-left: 230px;
                padding: 10px;
            }

             .main-footer {
                background-color: #f8f9fa;
                border-top: 1px solid #dee2e6;
                color: rgb(91, 96, 100);
                font-size: 1.2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 20px;
                margin-left: 230px; /* alinhamento com o conteúdo */
            }

            @media (max-width: 768px) {
                .main-footer {
                    flex-direction: column;
                    text-align: center;
                    gap: 8px;
                    margin-left: 0;
                }
    
                .content-wrapper {
                    margin-left: 0;
                }
    
                .main-sidebar {
                    position: static;
                    width: 100%;
                    min-height: auto;
                }
            }
            
            /* Aumenta a altura da barra para comportar logo maior */
            .main-header {
                height: 60px; /* ou 80px se preferir menor */
                padding: 0;
            }
            
            .main-header .logo {
                height: 60px; /* igual ao .main-header */
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 10px;
            }
            
            .main-header .navbar {
                margin-left: 230px; /* manter alinhamento do sidebar */
                height: 60px;      /* igual ao .main-header */
                min-height: 60px;
                display: flex;
                align-items: center;
            }
            
            .logo img {
                max-height: 150px; /* utilize ~80px para evitar corte */
                height: auto;
                width: auto;
            }
            .navbar-custom-menu {
                margin-left: auto; /* empurra para a direita no flex container */
            }
            .dropdown-menu {
                padding: 15px;
            }
            .user-footer .btn {
                margin-bottom: 10px;
            }
            .mt-2 {
                margin-top: 5px;
            }
            .form-control {
                margin-top: 5px;
            }

            /* Painel exclusivo do dashboard */
            .dashboard-panel {
                border-radius: 12px;
                border: none;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                margin-bottom: 20px;
                background: #fff;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .dashboard-panel:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            }

            /* Cabeçalho exclusivo */
            .dashboard-panel .panel-heading-custom {
                background: linear-gradient(135deg, #007bff, #0056b3);
                color: #fff !important;
                font-size: 16px;
                font-weight: bold;
                padding: 12px 15px;
                border: none;
                transition: background 0.3s ease;
            }

            .dashboard-panel .panel-heading-custom:hover {
                background: linear-gradient(135deg, #0056b3, #004494);
            }

            /* Ícones no cabeçalho */
            .dashboard-panel .panel-heading-custom .glyphicon {
                font-size: 16px;
            }

            /* Corpo do painel */
            .dashboard-panel .panel-body {
                padding: 15px;
                background-color: #f9f9f9;
                transition: all 0.3s ease;
            }

            /* Ícone de seta animado */
            .dashboard-panel .glyphicon-chevron-down,
            .dashboard-panel .glyphicon-chevron-up {
                transition: transform 0.3s ease;
            }

            .dashboard-panel .collapsed .glyphicon-chevron-down {
                transform: rotate(-90deg);
            }
                        
        </style>

    </head>
    <body class="<?php echo $cor_barra;?>">
        <div class="wrapper">
            <header class="main-header">

                <?php if ($AtivaMenu == true) { ?>

                    <a href="dashboard.php" class="logo">
                        <span class="logo-lg">
                            <b>
                                <img src="img/logo_semfundo.png" alt="Logo ConectaSys">
                            </b>
                        </span>
                    </a>

                <?php } ?>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" title="AJUSTAR MENU">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <!-- Toggle do dropdown -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="img/perfil-de-usuario.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><b><?php echo $NmUsuario; ?></b></span>
                                </a>
                    
                                <!-- Dropdown -->
                                <ul class="dropdown-menu">
                                    <li class="user-footer">
                                        <div style="display:flex; flex-direction:column; gap:8px;">
                                            <!-- Alterar Senha -->
                                            <a href="dashboard.php?form=admin/senha/index.php" class="btn btn-default btn-flat btn-block">
                                                <i class="fa fa-key"></i> Alterar Senha
                                            </a>
                                            <!-- Sair -->
                                            <a href="logout.php" class="btn btn-default btn-flat btn-block">
                                                <i class="fa fa-close"></i> Sair
                                            </a>
                                            <!-- Filtro periodo -->
                                            <div class="mt-2">
                                                <select id="txtperiododashboard" name="txtperiododashboard" class="form-control"  onchange="atualizaSession(this.value, <?php echo $_SESSION['CD_USUARIO']; ?>)">
                                                    <option value=""></option>
                                                    <option value="M">Mensal</option>
                                                    <option value="N">Anual</option>
                                                    <option value="A">Acumulado</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <script>
                                        $(document).ready(function(){
                                            $('#txtperiododashboard').on('click', function(event){
                                                event.stopPropagation();
                                            });
                                        });
                                    </script>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header">MENUS</li>
                        <li class="treeview" id="m<?php echo $tar; ?>">
                        </li>
            
                        <?php
            
                        $tar = 1;
                        $SQL0 = "SELECT distinct(gmu.nr_sequencial), gmu.ds_menu, gmu.ic_menu 
                                    FROM menus_user s 
                                    INNER JOIN submenus m ON s.nr_seq_smenu = m.nr_sequencial 
                                    INNER JOIN menus gmu ON m.nr_seq_menu = gmu.nr_sequencial 
                                    INNER JOIN submenus gm ON s.nr_seq_smenu = gm.nr_sequencial
                                WHERE s.st_liberado = 'S' 
                                AND s.nr_seq_user = " . $usuario . " 
                                $v_smenu 
                                ORDER BY gmu.ds_menu ASC";
                        $seqmen = 1;
                        $RSS0 = mysqli_query($conexao, $SQL0);
                        while ($RS0 = mysqli_fetch_array($RSS0)) {
                            $nr_menu = $RS0[0];
                            $ds_menu = $RS0[1];
                            $ic_menu = $RS0[2];
                        ?>
            
                            <li class="treeview" id="m<?php echo $tar; ?>">
                                <a href="#">
                                    <i class="<?php echo $ic_menu; ?>"></i>
                                    <span><?php echo $ds_menu; ?></span>
                                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                </a>
            
                                <?php
                                // GERAL
                                $SQL1 = "SELECT gmu.nr_sequencial, gmu.nr_seq_smenu, gm.ds_smenu, gm.lk_smenu, gm.ic_smenu 
                                            FROM menus_user gmu, submenus gm
                                        WHERE gmu.nr_seq_smenu=gm.nr_sequencial 
                                        AND gmu.st_liberado = 'S'
                                        AND gmu.nr_seq_user = " . $usuario . "
                                        AND gm.nr_seq_menu = " . $nr_menu . "
                                        $v_smenu
                                        AND gm.tp_smenu = 1
                                        ORDER BY gm.ds_smenu ASC";
                                $RSS1 = mysqli_query($conexao, $SQL1);
                                $reggeral = mysqli_num_rows($RSS1);
            
                                if ($reggeral > 0) { ?>
                                    <ul class="treeview-menu">
                                        <li class="treeview menu-open" id="geral<?php echo $seqmen; ?>">
                                            <a href="#"><i class="fa fa-pencil-square-o"></i> GERAL
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <?php
                                                $RSS1 = mysqli_query($conexao, $SQL1);
                                                while ($RS1 = mysqli_fetch_array($RSS1)) {
                                                    $nr_smenu = $RS1[1];
                                                    $ds_smenu = $RS1[2];
                                                    $lk_smenu = $RS1[3];
                                                    $ic_smenu = $RS1[4];
            
                                                    if (@$_GET['form'] == $lk_smenu) {
                                                        AtivaMenu("geral", $seqmen, $tar);
                                                    }
                                                ?>
                                                    <li>
                                                        <a href="dashboard.php?form=<?php echo $lk_smenu; ?>&id_menu=<?php echo $nr_menu; ?>&ds_men=<?php echo $ds_smenu; ?>&ds_mod=<?php echo $ds_menu; ?>&id_smenu=<?php echo $nr_smenu; ?>">
                                                            <i class="<?php echo $ic_smenu; ?>"></i>
                                                            <?php echo $ds_smenu; ?>
                                                        </a>
                                                    </li>
                                                <?php
                                                }
                                                $seqmen += 1;
                                                ?>
                                            </ul>
                                        </li>
                                    </ul>
                                <?php } ?>
            
                                <?php
                                // MOVIMENTOS
                                $SQL1 = "SELECT gmu.nr_sequencial, gmu.nr_seq_smenu, gm.ds_smenu, gm.lk_smenu, gm.ic_smenu 
                                            FROM menus_user gmu, submenus gm
                                        WHERE gmu.nr_seq_smenu=gm.nr_sequencial 
                                        AND gmu.st_liberado = 'S'
                                        AND gmu.nr_seq_user = " . $usuario . "
                                        AND gm.nr_seq_menu = " . $nr_menu . "
                                        $v_smenu
                                        AND gm.tp_smenu = 2
                                        ORDER BY gm.ds_smenu ASC";
                                $RSS1 = mysqli_query($conexao, $SQL1);
                                $regmov = mysqli_num_rows($RSS1);
            
                                if ($regmov > 0) { ?>
                                    <ul class="treeview-menu">
                                        <li class="treeview menu-open" id="movimentos<?php echo $seqmen; ?>">
                                            <a href="#"><i class="fa fa-exchange"></i> MOVIMENTOS
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <?php
                                                $RSS1 = mysqli_query($conexao, $SQL1);
                                                while ($RS1 = mysqli_fetch_array($RSS1)) {
                                                    $nr_smenu = $RS1[1];
                                                    $ds_smenu = $RS1[2];
                                                    $lk_smenu = $RS1[3];
                                                    $ic_smenu = $RS1[4];
            
                                                    if (@$_GET['form'] == $lk_smenu) {
                                                        AtivaMenu("movimentos", $seqmen, $tar);
                                                    }
                                                ?>
                                                    <li>
                                                        <a href="dashboard.php?form=<?php echo $lk_smenu; ?>&id_menu=<?php echo $nr_menu; ?>&ds_men=<?php echo $ds_smenu; ?>&ds_mod=<?php echo $ds_menu; ?>&id_smenu=<?php echo $nr_smenu; ?>">
                                                            <i class="<?php echo $ic_smenu; ?>"></i>
                                                            <?php echo $ds_smenu; ?>
                                                        </a>
                                                    </li>
                                                <?php
                                                }
                                                $seqmen += 1;
                                                ?>
                                            </ul>
                                        </li>
                                    </ul>
                                <?php } ?>
            
                                <?php
                                // RELATÓRIO
                                $SQL1 = "SELECT gmu.nr_sequencial, gmu.nr_seq_smenu, gm.ds_smenu, gm.lk_smenu, gm.ic_smenu 
                                            FROM menus_user gmu, submenus gm
                                        WHERE gmu.nr_seq_smenu=gm.nr_sequencial 
                                        AND gmu.st_liberado = 'S'
                                        AND gmu.nr_seq_user = " . $usuario . "
                                        AND gm.nr_seq_menu = " . $nr_menu . "
                                        $v_smenu
                                        AND gm.tp_smenu = 3
                                        ORDER BY gm.ds_smenu ASC";
                                $RSS1 = mysqli_query($conexao, $SQL1);
                                $RSS1 = mysqli_fetch_assoc($RSS1);
            
                                if ($RSS1["nr_sequencial"] > 0) { ?>
                                    <ul class="treeview-menu">
                                        <li class="treeview menu-open" id="relatorios<?php echo $seqmen; ?>">
                                            <a href="#"><i class="fa fa-file-text-o"></i> RELATÓRIO
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <?php
                                                $RSS1 = mysqli_query($conexao, $SQL1);
                                                while ($RS1 = mysqli_fetch_array($RSS1)) {
                                                    $nr_smenu = $RS1[1];
                                                    $ds_smenu = $RS1[2];
                                                    $lk_smenu = $RS1[3];
                                                    $ic_smenu = $RS1[4];
            
                                                    if (@$_GET['form'] == $lk_smenu) {
                                                        AtivaMenu("relatorios", $seqmen, $tar);
                                                    }
                                                ?>
                                                    <li>
                                                        <a href="dashboard.php?form=<?php echo $lk_smenu; ?>&id_menu=<?php echo $nr_menu; ?>&ds_men=<?php echo $ds_smenu; ?>&ds_mod=<?php echo $ds_menu; ?>&id_smenu=<?php echo $nr_smenu; ?>">
                                                            <i class="<?php echo $ic_smenu; ?>"></i>
                                                            <?php echo $ds_smenu; ?>
                                                        </a>
                                                    </li>
                                                <?php
                                                }
                                                $seqmen += 1;
                                                ?>
                                            </ul>
                                        </li>
                                    </ul>
                                <?php } ?>
            
                            </li>
                        <?php
                            $tar += 1;
                        }
                        ?>
                    </ul>
                </section>
            </aside>

            <div class="content-wrapper">
                <section class="content-header">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo @$_GET['ds_mod']; ?></a></li>
                        <li class="active"><?php echo @$_GET['ds_men']; ?></li>
                    </ol>
                </section>
                <BR>
                <!-- Content Header (Page header) -->
                <!-- Main content -->
                <section class="content">

                    <?php if ($form == "") { ?>
                        <!-- KPIs -->
                        <div class="panel panel-primary dashboard-panel">
                            <div class="panel-heading panel-heading-custom text-center" style="cursor: pointer;" onclick="togglePanelDashboard(this)">
                                <span class="glyphicon glyphicon-stats" style="margin-right: 5px;"></span> Status
                                <span class="pull-right glyphicon glyphicon-chevron-down" style="margin-top: 3px;"></span>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <?php include "kpis.php"; ?>
                            </div>
                        </div>

                        <!-- Calendário -->
                        <div class="panel panel-primary dashboard-panel">
                            <div class="panel-heading panel-heading-custom text-center" style="cursor: pointer;" onclick="togglePanelDashboard(this)">
                                <span class="glyphicon glyphicon-calendar" style="margin-right: 5px;"></span> Calendário
                                <span class="pull-right glyphicon glyphicon-chevron-down" style="margin-top: 3px;"></span>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <?php include "calendario.php"; ?>
                            </div>
                        </div>

                        <!-- Gráficos -->
                        <div class="panel panel-primary dashboard-panel">
                            <div class="panel-heading panel-heading-custom text-center" style="cursor: pointer;" onclick="togglePanelDashboard(this)">
                                <span class="glyphicon glyphicon-signal" style="margin-right: 5px;"></span> Gráficos
                                <span class="pull-right glyphicon glyphicon-chevron-down" style="margin-top: 3px;"></span>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <?php include "graficos.php"; ?>
                                <?php include "graficos2.php"; ?>
                            </div>
                        </div>

                        <?php
                    } else {

                        $_SESSION["id_menu"] = $_GET['id_menu'];
                        @$esta = false;
                        if (!isset($form) or ( $form == "")) {
                            $fu->DirecionarTempo(10, "dashboard.php?form=resumo");
                            echo "P&aacute;gina n&atilde;o encontrada! Verifique com o suporte!";
                        }
                        if (file_exists($form)) {
                            $esta = true;
                        } else {
                            $esta = false;
                        }
                        if ($esta) {
                            include $form;
                        } else {
                            //  $fu->DirecionarTempo(10, "dashboard.php?form=resumo");
                            echo "P&aacute;gina n&atilde;o encontrada! Verifique com o suporte!";
                        }

                    }

                    ?>

                </section>
            </div>

            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

            <link rel="stylesheet" href="dist/css/Modal.css">
            <a href="#ModalRel" id="clickModal"></a>
            <div id="ModalRel" class="modalDialog">
                <div style="width: 90%; height: 500px;">
                    <a href="#close" title="Close" class="close">X</a>
                    <iframe name="mensagemrel" id="mensagemrel" width="98%" height="98%" src="" frameborder="0"></iframe>
                </div>
            </div>
            <a href="#ModalDados" id="ModalRs"></a>
            <div id="ModalDados" class="modalDialog">
                <div style="width: 90%; height: 500px;">
                    <a href="#close" title="Close" class="close" id="fecharMd">X</a>
                    <div id="MeusDados" class="table-responsive" style="overflow-y: scroll; height: 450px;"></div>
                </div>
            </div>

            <script language="JavaScript" type="text/javascript">

                document.querySelector('#toggleSidebar').addEventListener('click', function () {
                    document.querySelector('.main-sidebar').classList.toggle('open');
                });

                function togglePanelDashboard(header) {
                    const panelBody = $(header).next(".panel-body");
                    const icon = $(header).find(".glyphicon-chevron-down, .glyphicon-chevron-up");

                    panelBody.slideToggle(200);

                    if (icon.hasClass("glyphicon-chevron-up")) {
                        icon.removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
                    } else {
                        icon.removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
                    }
                }

                function atualizaSession(periodo, usuario) {
                    $.ajax({
                        type: 'POST',
                        url: 'atualiza_session.php',
                        data: { 
                            periodo: periodo,
                            usuario: usuario 
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert("Erro ao atualizar o período");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Erro na requisição:', textStatus, errorThrown); 
                            console.log(jqXHR.responseText);
                            alert("Erro na requisição");
                        }
                    });
                }

                function CarregarLoad(link, local) {
                    $.get(link, function (dataReturn) {
                        $('#' + local).html(dataReturn);  //coloco na div o retorno da requisicao
                    });
                }

                function AbrirModal(link) {
                    CarregarLoad(link, "MeusDados");
                    document.getElementById("ModalRs").click();
                }

                function detalhar(status) {
                    const url = "https://conectasys.com/dashboard.php?form=crm/leads/index.php&id_menu=3&ds_men=Leads&ds_mod=CRM&id_smenu=11&status=" 
                        + encodeURIComponent(status) + "&tab=lista";
                    window.open(url, '_blank');
                }

            </script>

            <footer class="main-footer d-flex justify-content-between align-items-center p-2">
                <div class="text-muted">
                    <strong>ConectaSys</strong>
                </div>
                <div class="text-muted">
                    <span><strong>Versão:</strong> 1.0</span>
                </div>
                <input type="hidden" name="pgatual" id="pgatual" value="2">
            </footer>
            <div class="control-sidebar-bg"></div>
        </div>
        
        <a href="https://wa.me/554998098805?text=Ol%C3%A1%20preciso%20de%20suporte%20no%20ConectaSys"
            target="_blank"
            style="position: fixed;
                    bottom: 20px;
                    right: 20px;
                    width: 60px;
                    height: 60px;
                    background-color: #25D366;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
                    z-index: 1000;
                    text-decoration: none;">
                <i class="fa fa-whatsapp" style="font-size: 36px; color: white;"></i>
        </a>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <a href="https://api.whatsapp.com/send?phone=554991698966" class="float" target="_blank">
            <i class="fa fa-whatsapp my-float"></i>
        </a>

        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="plugins/knob/jquery.knob.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/pages/dashboard.js"></script>
        <script type="text/javascript" src="plugins/sweetalert/sweetalert2.all.min.js"></script>
        <script src="dist/js/custom.js?v=0.25"></script>
        <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script type="text/javascript" src="plugins/select2/select2.full.min.js"></script>  
        
        <?php include "alerta.php";?>
    </body>
</html>