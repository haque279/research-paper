<!doctype html>
<html class="no-js" lang="">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo basename($_SERVER['PHP_SELF']);?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="images/favicon.png">
        <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic' rel='stylesheet' type='text/css'>


        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/slicknav.css" />
        <link rel="stylesheet" href="css/data_table.css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/admin_style.css">
        <link rel="stylesheet" href="css/style.css">
        <link href="dist/css/select2.min.css" rel="stylesheet" />
        <link  href="jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link  href="jquery-ui/jquery-ui.theme.min.css" rel="stylesheet">


    </head>

    <body>
        <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
        <section class="header-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3">
                        <a href="index.php">
                            <div class="logo">Welcome
                                <?php
                                if (isset($_SESSION['admin'])) {
                                    echo $_SESSION['admin'];
                                }
                                ?>
                                <?php
                                if (isset($_SESSION['reviewer_name'])) {
                                    echo $_SESSION['reviewer_name'];
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <ul>
    <!--                        <li><a href=""><span class="fa fa-envelope-o"></span>120</a></li>-->
    <!--                        <li><a href=""><span class="fa fa-star-o"></span>58</a></li>-->
                            <li><a href="http://journal.bibm.org.bd/" target='_blank' style='margin-top: -1px;margin-right: -20px'><span class="fa fa-home"></span></a></li>
                            <li>
                                <div class="btn-group">
                                    <div class=" dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       
                                        <span class="fa fa-user"></span>  <?php
                                        if (isset($_SESSION['admin'])) {
                                            echo $_SESSION['admin'];
                                        }
                                        ?> <span class="caret"></span>
                                    </div>
                                    <ul class="dropdown-menu">
                                        
                                                <?php if (isset($_SESSION['admin'])) { ?>
                                            <li><a href="logout.php">logout</a></li>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['reviewer_name'])) { ?>
                                            <li><a href="logout_reviewer.php">logout</a></li>
                                            <li><a href="reviewer_change_password.php">Change Password</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </section>