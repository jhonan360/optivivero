<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>Opti vivero</title>

        <!--    Google Fonts-->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

        <!--Fontawesom-->
        <link rel="stylesheet" href="css/font-awesome.min.css">

        <!--Animated CSS-->
        <link rel="stylesheet" type="text/css" href="css/animate.min.css">

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!--Bootstrap Carousel-->
        <link type="text/css" rel="stylesheet" href="css/carousel.css" />

        <link rel="stylesheet" href="css/isotope/style.css">

        <!--Main Stylesheet-->
        <link href="css/style.css" rel="stylesheet">
        <!--Responsive Framework-->
        <link href="css/responsive.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body data-spy="scroll" data-target="#header">

        <!--Start Hedaer Section-->
        <section id="header">
            <div class="header-area">
                <div class="header_menu text-center" data-spy="affix" data-offset-top="50" id="nav">
                    <div class="container">
                        <nav class="navbar navbar-default zero_mp ">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand custom_navbar-brand" href="#"><img src="/source/img/home/logo.png" alt=""></a>
                            </div>
                            <!--End of navbar-header-->

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse zero_mp" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav navbar-right main_menu">
                                    <li class="active"><a href="#header">Inicio<span class="sr-only">(current)</span></a></li>
                                    <li><a href="#welcome">¿Quienes somos?</a></li>
                                    <li><a href="#volunteer">Mision</a></li>
                                    <li><a href="#blog">Vision</a></li>
                                    <li><a href="{{ route('login') }}">iniciar sesion</a></li>
                                </ul>
                            </div>
                            <!-- /.navbar-collapse -->
                        </nav>
                        <!--End of nav-->
                    </div>
                    <!--End of container-->
                </div>
                <!--End of header menu-->
            </div>
            <!--end of header area-->
        </section>
        <!--End of Hedaer Section-->



        <!--Start of slider section-->
        <section id="slider">
            <div id="carousel-example-generic" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div class="slider_overlay">
                            <img src="/source/img/home/carro1.png" alt="...">
                            <div class="carousel-caption">
                                <div class="slider_text">
                                    <h3>OPTI VIVERO</h3>
                                    <h2>SOLUCIÓN A LA MANO</h2>
                                    <p>Con tecnologias alternativas.</p>
                                    <a href="{{ route('login') }}" class="custom_btn">Iniciar sesion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of item With Active-->
                    <div class="item">
                        <div class="slider_overlay">
                            <img src="/source/img/home/carro2.png" alt="...">
                            <div class="carousel-caption">
                                <div class="slider_text">
                                    <h3>OPTI VIVERO</h3>
                                    <h2>Mejora de procesos</h2>
                                    <p>En base a las variables ambientales recolectadas</p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Item-->
                    <div class="item">
                        <div class="slider_overlay">
                            <img src="/source/img/home/carro3.png" alt="...">
                            <div class="carousel-caption">
                                <div class="slider_text">
                                    <h3>Opti vivero</h3>
                                    <h2>Adaptabilidad a su vivero</h2>
                                    <p>Parametrizable segun la cantidad de secciones y plantas en el predio</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of item-->
                </div>
                <!--End of Carousel Inner-->
            </div>
        </section>
        <!--end of slider section-->



        <!--Start of welcome section-->
        <section id="welcome">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="wel_header">
                            <h2>¿ Quienes somos?</h2>
                            <p>Somos un grupo de investigacion para la mejora de procesos en minorias con enfoque en agroecologia</p>
                        </div>
                    </div>
                </div>
                <!--End of row-->
                <div class="row">
                    <div class="col-md-4">
                        <div class="item">
                            <div class="single_item">
                                <div class="item_list">
                                    <div class="welcome_icon">
                                        <i class="fa fa-leaf"></i>
                                    </div>
                                    <h4>ecosistema</h4>
                                    <p>Comprometidos con el cuidado del medio ambiente y la inclusion de nuevas tecnologias de bajo costo para aquellos que se les dificulta obtenerlas de ultima generacion.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of col-md-3-->
                    <div class="col-md-4">
                        <div class="item">
                            <div class="single_item">
                                <div class="item_list">
                                    <div class="welcome_icon">
                                        <i class="fa fa-refresh"></i>
                                    </div>
                                    <h4>Retroalimentacion</h4>
                                    <p>"El cliente siempre tiene la razon", basados en esta frase celebre es importante la experiencia que tienen con nuestro sistema para mejorar y brindar un mejor servicio.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of col-md-3-->
                    
                    <!--End of col-md-3-->
                    <div class="col-md-4">
                        <div class="item">
                            <div class="single_item">
                                <div class="item_list">
                                    <div class="welcome_icon">
                                        <i class="fa fa-cog"></i>
                                    </div>
                                    <h4>Configuracion</h4>
                                    <p>Cada cliente tiene un tipo de vivero diferente, por lo tanto se parametrizara de acuerdo al producto que se maneja y segun las variables ambientales que se pueden observar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of col-md-3-->
                </div>
                <!--End of row-->
            </div>
            <!--End of container-->
        </section>
        <!--end of welcome section-->



        <!--Start of volunteer-->
        <section id="volunteer">
            <div class="container">
                <div class="row vol_area">
                    <div class="col-md-10">
                        <div  class="volunteer_content" >
                            <h3 >vi<span>sión</span></h3>
                            <p>Ser una organizacion lider de innovacion, soluciones, productos y servicios agroecologicos a nivel nacional. siendo reconocida por la calidad de nuestros productos y contribucion hacia la comunidad brindando atencion personalizada. </p>
                        </div>
                    </div>
                    <!--End of col-md-8-->
                    <!--End of col-md-3-->
                </div>
                <!--End of row and vol_area-->
            </div>
            <!--End of container-->
        </section>
        <!--end of volunteer-->


        <!--start of event-->

        <!--end of event-->



        <!--Start of blog-->
        <section id="blog">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="latest_blog text-center">
                            <h2>MISION</h2>
                            <p>Innovar para todas aquellas minorias dedicadas a la produccion de flora que no tienen acceso a tecnologias de ultima generacion, con el compromiso de crear elementos alternativos y altamente eficientes ayudando a la mejora de la calidad, un sitio web acorde a la especialidad, adaptacion de los usuarios a la tecnologia.
                            </p>
                            <a class=" text-center" href="#"><img src="/source/img/home/logo.png" alt=""></a>
                        </div>
                    </div>
                </div>
                <!--End of row-->
                </div>
                <!--End of row-->
            </div>
            <!--End of container-->
        </section>
        <!-- end of blog-->

        <!--Start of Market-->
        

        <!--Start of footer-->
        <section id="footer">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="copyright">
                            <p>@ 2018 - Optivivero <span><a href=""></a></span></p>
                        </div>
                    </div>
                    
                </div>
                <!--End of row-->
            </div>
            <!--End of container-->
        </section>
        <!--End of footer-->



        <!--Scroll to top-->
        <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
        <!--End of Scroll to top-->


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <!-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>-->
        <script src="js/jquery-1.12.3.min.js"></script>

        <!--Counter UP Waypoint-->
        <script src="js/waypoints.min.js"></script>
        <!--Counter UP-->
        <script src="js/jquery.counterup.min.js"></script>

        <script>
            //for counter up
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        </script>

        <!--Gmaps-->
        
        <!--Google Maps API-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjxvF9oTfcziZWw--3phPVx1ztAsyhXL4"></script>


        <!--Isotope-->
        <script src="js/isotope/min/scripts-min.js"></script>
        <script src="js/isotope/cells-by-row.js"></script>
        <script src="js/isotope/isotope.pkgd.min.js"></script>
        <script src="js/isotope/packery-mode.pkgd.min.js"></script>
        <script src="js/isotope/scripts.js"></script>


        <!--Back To Top-->
        <script src="js/backtotop.js"></script>


        <!--JQuery Click to Scroll down with Menu-->
        <script src="js/jquery.localScroll.min.js"></script>
        <script src="js/jquery.scrollTo.min.js"></script>
        <!--WOW With Animation-->
        <script src="js/wow.min.js"></script>
        <!--WOW Activated-->
        <script>
            new WOW().init();
        </script>


        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Custom JavaScript-->
        <script src="js/main.js"></script>
    </body>

</html>