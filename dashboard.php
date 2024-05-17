<?php

    session_start();

    @$txtmenu = '';
    @$form = '';
    @$id_menu = '';
    @$ds_mod = '';
    $ds_filialv = '';
    $ds_filialp = '';
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

    session_start();
    include "conexao.php";

    $SQLF = "SELECT  idusuario
        FROM tb_usuarios 
        WHERE idusuario = " . $_SESSION["CD_USUARIO"];
    $RSF = mysqli_query($conexao, $SQLF);
    while ($RSSF = mysqli_fetch_array($RSF)){
        $id_usuario = $RSSF[0];

    }

    require_once 'class.funcoes.php';
    require_once 'class.erros.php';
    require_once 'validar.php';
    require_once 'funcoesgerais.php';
    $TxUsuario = $_SESSION["DS_USUARIO"];
    $usuario = $_SESSION["CD_USUARIO"];
    $NmUsuario = $_SESSION["NM_USUARIO"];

    require_once("Mobile_Detect.php");
    $detect = new Mobile_Detect;
    $AtivaMenu = true;
    if ($detect->isMobile() or $detect->isTablet()) {
        $AtivaMenu = false;
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Csimulador</title>
        <!--<link rel="icon" href="https://ginfo.i9ss.com.br/favicon.ico">-->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/custom.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <script type="text/javascript" src="obj/jquery-1.4.2.js"></script>
        <script type="text/javascript" src="plugins/sweetalert/sweetalert2.all.min.js"></script>
        
        <script type='text/javascript' src="obj/jquery.autocomplete.js"></script>
        <link rel="stylesheet" type="text/css" href="obj/jquery.autocomplete.css" />

        <script type="text/javascript" src="dist/typeahead.jquery.js"></script>
        <script type="text/javascript" src="dist/typeahead.bundle.js"></script>

    </head>
    <body class="<?php echo $cor_barra;?>">
        <div class="wrapper">
            <header class="main-header">

                <?php if ($AtivaMenu == true) { ?>

                    <a href="dashboard.php" class="logo">
                        <span class="logo-lg"><b>SIMULADOR</b></span>
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
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="img/perfil-de-usuario.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><b><?php echo $NmUsuario; ?></b></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="dashboard.php?form=admin/senha/index.php" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Alterar Senha</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat"><i class="fa fa-close"></i> Sair</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="txtmenu" class="form-control" placeholder="Procurar acessos...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header">MENUS</li>
                        <li class="treeview" id="m<?php echo $tar; ?>">
                            <a href="dashboard.php">
                                <i class="fa fa-dashboard"></i>
                                <span>RESUMO</span>
                            </a>
                        </li>

                        <?php

                            $tar = 1;
                            $SQL0 = "SELECT distinct(gmu.nr_sequencial), gmu.ds_menu, gmu.ic_menu 
                                        FROM g_smenu_user s inner join g_smenus m on s.nr_seq_smenu = m.nr_sequencial 
                                        INNER JOIN g_menus gmu on m.nr_seq_menu = gmu.nr_sequencial 
                                        INNER JOIN g_smenus gm on s.nr_seq_smenu = gm.nr_sequencial
                                    WHERE s.cd_liberado=1 
                                    AND s.nr_seq_user=" . $usuario . " 
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
                                        <i class="<?php echo $ic_menu;?>"></i>
                                        <span><?php echo $ds_menu; ?></span>
                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                    </a>

                                    <?php  

                                        $SQL1 = "SELECT gmu.nr_sequencial, gmu.nr_seq_smenu, gm.ds_smenu, gm.lk_smenu, gm.ic_smenu 
                                                    FROM g_smenu_user gmu, g_smenus gm
                                                WHERE gmu.nr_seq_smenu=gm.nr_sequencial 
                                                AND gmu.cd_liberado=1
                                                AND gmu.nr_seq_user=" . $usuario . "
                                                AND gm.nr_seq_menu=" . $nr_menu . "
                                                $v_smenu
                                                AND gm.tipo_menu = 1
                                                ORDER BY gm.ds_smenu ASC";
                                        $RSS1 = mysqli_query($conexao, $SQL1);
                                        $reggeral = mysqli_num_rows($RSS1);

                                    if($reggeral>0) { ?>

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
                                        <?php
                                    }
     
                                    $SQL1 = "SELECT gmu.nr_sequencial, gmu.nr_seq_smenu, gm.ds_smenu, gm.lk_smenu, gm.ic_smenu 
                                                FROM g_smenu_user gmu, g_smenus gm
                                            WHERE gmu.nr_seq_smenu=gm.nr_sequencial 
                                            AND gmu.cd_liberado=1
                                            AND gmu.nr_seq_user=" . $usuario . "
                                            AND gm.nr_seq_menu=" . $nr_menu . "
                                            $v_smenu
                                            AND gm.tipo_menu = 3
                                            ORDER BY gm.ds_smenu ASC";
                                    $RSS1 = mysqli_query($conexao, $SQL1);
                                    $RSS1 = mysqli_fetch_assoc($RSS1);

                                    if ($RSS1["nr_sequencial"] >0) { ?>

                                        <ul class="treeview-menu">
                                            <li class="treeview menu-open" id="relatorios<?php echo $seqmen; ?>">
                                                <a href="#"><i class="fa fa-pencil-square-o"></i> RELAT&Oacute;RIO
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
                                        <?php
                                    } ?>                    
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

                    <?php

                        if ($form == "") { 
                            
                            $leads_novas = 0;
                            $SQL = "SELECT COUNT(*) FROM lead_site
                                    WHERE st_situacao = 'P'";
                            $RSS = mysqli_query($conexao, $SQL);
                            while($linha = mysqli_fetch_row($RSS)){
                                $leads_novas = $linha[0];
                            }

                            $leads_contato = 0;
                            $SQL = "SELECT COUNT(*) FROM lead_site
                                    WHERE st_situacao = 'C'";
                            $RSS = mysqli_query($conexao, $SQL);
                            while($linha = mysqli_fetch_row($RSS)){
                                $leads_contato = $linha[0];
                            }

                            $leads_fria = 0;
                            $SQL = "SELECT COUNT(*) FROM lead_site
                                    WHERE st_situacao = 'F'";
                            $RSS = mysqli_query($conexao, $SQL);
                            while($linha = mysqli_fetch_row($RSS)){
                                $leads_fria = $linha[0];
                            }

                            $leads_quente = 0;
                            $SQL = "SELECT COUNT(*) FROM lead_site
                                    WHERE st_situacao = 'F'";
                            $RSS = mysqli_query($conexao, $SQL);
                            while($linha = mysqli_fetch_row($RSS)){
                                $leads_quente = $linha[0];
                            }

                            ?>

                            <div class="col-lg-6 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h1><?php echo number_format($leads_novas, 0, ",", "."); ?></h1>
                                        <p>NOVAS LEADS</p>
                                        <button type="button" class="btn btn-info" onclick="detalhar(<?php echo $nr_seq_exame; ?>);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-group"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h1><?php echo number_format($leads_contato, 0, ",", "."); ?></h1>
                                        <p>ENTRAR EM CONTATO COM O CLIENTE</p>
                                        <button type="button" class="btn btn-info" onclick="detalhar(<?php echo $nr_seq_exame; ?>);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h1><?php echo number_format($leads_fria, 0, ",", "."); ?></h1>
                                        <p>LEADS PARADAS</p>
                                        <button type="button" class="btn btn-info" onclick="detalhar(<?php echo $nr_seq_exame; ?>);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h1><?php echo number_format($leads_quente, 0, ",", "."); ?></h1>
                                        <p>LEADS EM ANDAMENTO</p>
                                        <button type="button" class="btn btn-info" onclick="detalhar(<?php echo $nr_seq_exame; ?>);"><span class="glyphicon glyphicon-filter"></span> CONSULTAR</button>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-unlock"></i>
                                    </div>
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

                function CarregarLoad(link, local) {
                    $.get(link, function (dataReturn) {
                        $('#' + local).html(dataReturn);  //coloco na div o retorno da requisicao
                    });
                }

                function AbrirModal(link) {
                    CarregarLoad(link, "MeusDados");
                    document.getElementById("ModalRs").click();
                }

            </script>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                <b>Vers&atilde;o</b> 1.0
                </div>
                <strong>Viveiro Florestal Dois Irmãos.</strong>
                <input type="hidden" name="pgatual" id="pgatual" value="2">
            </footer>
            <div class="control-sidebar-bg"></div>
        </div>

        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="plugins/knob/jquery.knob.js"></script>

        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/pages/dashboard.js"></script>

    </body>
</html>