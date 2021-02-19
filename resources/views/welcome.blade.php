<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Toolpsico</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="template/img/favicon.png" rel="icon">
  <link href="template/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700"
    rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="template/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="template/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="template/lib/animate/animate.min.css" rel="stylesheet">
  <link href="template/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="template/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="template/lib/magnific-popup/magnific-popup.css" rel="stylesheet">
  <link href="template/lib/ionicons/css/ionicons.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="template/css/style.css" rel="stylesheet">

  <!-- =======================================================
    Theme Name: Reveal
    Theme URL: https://bootstrapmade.com/reveal-bootstrap-corporate-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body id="body">

  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <img src="template/logo.png">
        <!-- Uncommesnt below if you prefer to use an image logo -->
        <!-- <a href="#body"><img src="template/img/logo.png" alt="" title="" /></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#body">Inicio</a></li>
          <li><a href="#about">Módulos</a></li>
          <li><a href="#services">Beneficios y utilidades</a></li>
          <li><a href="#portfolio"> ¿Quiénes somos?</a></li>
          <li><a href="#contact"> Contáctanos</a></li>
          <li><a href="#team">Equipo de trabajo</a></li>
          <li><a href="{{url('/legal')}}">Legal</a></li>
          <li><a href="{{url('/login')}}">Ingresar</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->

    </div>

  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">

    <div class="intro-content">
      <h2>Monitoreo de comportamiento <br> estudiantil <br>¡Un apoyo al psicoorientador!</h2>
      <div>
        <a href="{{url('/login')}}" class="btn-get-started scrollto">Ingresar</a>
      </div>
    </div>

    <div id="intro-carousel" class="owl-carousel">
      <div class="item" style="background-image: url('template/img/intro-carousel/1.jpg');"></div>
      <div class="item" style="background-image: url('template/img/intro-carousel/2.jpg');"></div>
      <!--   <div class="item" style="background-image: url('template/img/intro-carousel/3.jpg');"></div>
      <div class="item" style="background-image: url('template/img/intro-carousel/4.jpg');"></div>
      <div class="item" style="background-image: url('template/img/intro-carousel/5.jpg');"></div> -->
    </div>

  </section><!-- #intro -->

  <main id="main">

    <!--==========================
      About Section
    ============================-->
    <section id="about" class="wow fadeInUp">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 about-img">
            <img src="template/img/about-img.jpg" alt="">
          </div>

          <div class="col-lg-6 content">
            <h2>ToolPsico</h2>
            <h3>Es una herramienta diseñada para dar apoyo a los pscoorientadores, a los padres de familia y a los
              estudiantes de instituciones educativas públicas en el monitoreo del comportamiento. ToolPsico cuenta con
              las siguientes funcionalidades: </h3>

            <ul>
              <li><i class="ion-android-checkmark-circle"></i> Gestión de comportamientos.</li>
              <li><i class="ion-android-checkmark-circle"></i> Gestión de usuarios.</li>
              <li><i class="ion-android-checkmark-circle"></i> Gestión de actividades.</li>
              <li><i class="ion-android-checkmark-circle"></i> Gestión de seguimientos.</li>
              <li><i class="ion-android-checkmark-circle"></i> Reportes con estándares locales.</li>
            </ul>

          </div>
        </div>

      </div>
    </section><!-- #about -->

    <!--==========================
      Services Section
    ============================-->
    <section id="services">
      <div class="container">
        <div class="section-header">
          <h2>Beneficios y utilidades</h2>
          <p>El apoyo de las TIC ha falicitado los procesos en muchos ámbitos, y este no es una excepción. Esta
            herramienta nos permitirá llevar un control de los estudiantes de una manera más ágil.</p>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="box wow fadeInLeft">
              <div class="icon"><i class="fa fa-bar-chart"></i></div>
              <h4 class="title"><a href="">Estadísticas a un clic </a></h4>
              <p class="description">Podrás visualizar o exportar toda la información de los comportamientos registrados
                mediante un reporte.</p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="box wow fadeInRight">
              <div class="icon"><i class="fa fa-bell-o"></i></div>
              <h4 class="title"><a href="">Notificaciones SMS</a></h4>
              <p class="description">Podrás recibir notificaciones mediante mensajes de textos de las novedades de los
                comportamientos de los usuarios o de las actividades registradas.</p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="box wow fadeInLeft" data-wow-delay="0.2s">
              <div class="icon"><i class="fa fa-calendar"></i></div>
              <h4 class="title"><a href="">Agendamiento de actividades</a></h4>
              <p class="description"> Podrás agregar citas o tareas como actividades que se podrán visualizar en un
                calendario diario, mensual o semanal.</p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="box wow fadeInRight" data-wow-delay="0.2s">
              <div class="icon"><i class="fa fa-mobile"></i></div>
              <h4 class="title"><a href="">Plataforma Responsive</a></h4>
              <p class="description">Podrás usar ToolPsico desde cualquier dispositivo con acceso a un navegador web sin
                problemas, pues su interfaz se adaptara al dispositivos.</p>
            </div>
          </div>

        </div>

      </div>


    </section><!-- #services -->

    <section id="portfolio" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
          <h2>¿Quiénes somos?</h2>
          <p>Somos estudiantes de ingeniería de sistemas de la Universidad de Córdoba, que junto con el apoyo de todos
            los profesores del departamento de Ingeniería decidimos darle una herramienta de apoyo a todos los psicoorientadores de las 
            instituciones públicas.</p>
        </div>
        <div align="center"> <a href="https://www.unicordoba.edu.co/"><img src="template/img/acreditada.jpg"></a> </div>
      </div>
      <br>
      <br>
      <br>

      <section id="contact" class="wow fadeInUp">
        <div class="container">
          <div class="section-header">
            <h2>Contáctanos</h2>
            <!--   <p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet veniam enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute nulla ipsum velit export irure minim illum fore</p>
        </div> -->

            <div class="row contact-info">

              <div class="col-md-4">
                <div class="contact-address">
                  <i class="ion-ios-location-outline"></i>
                  <h3>Dirección</h3>
                  <address>Calle 33 #4-27 - Centro, Montería - Córdoba, Colombia</address>
                </div>
              </div>

              <div class="col-md-4">
                <div class="contact-phone">
                  <i class="ion-ios-telephone-outline"></i>
                  <h3>Números de celular</h3>
                  <p><a href="tel:+573177765722">+57 3177765722</a></p>
                  <p><a href="tel:+573012546886">+57 3012546886</a></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="contact-email">
                  <i class="ion-ios-email-outline"></i>
                  <h3>Correo Electrónico</h3>
                  <p><a href="mailto:info@example.com">info@toolpsico.com</a></p>
                </div>
              </div>

            </div>
          </div>
      </section>
      <!-- secion del equipo o team -->
      <section id="team" class="wow fadeInUp">
        <div class="container">
          <div class="section-header">
            <h2>Equipo de trabajo</h2>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6">
              <div class="member">
                <div class="details">
                  <h4>Camilo Parra</h4>
                  <span>Estudiante de ingeniería de sistemas</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6">
              <div class="member">
                          <div class="details">
                  <h4>Andrés Calderon</h4>
                  <span>Estudiante de ingeniería de sistemas</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6">
              <div class="member">
                <div class="details">
                  <h4>Santiago Enoc</h4>
                  <span>Estudiante asesor universitario</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6">
              <div class="member">
                <div class="details">
                  <h4>Daniel Salas</h4>
                  <span>Tutor universitario</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>

      <!--==========================
    Footer
  ============================-->


      <footer id="footer">
        <div class="container">
          <div class="copyright">
            &copy; Copyright <strong>Toolpsico</strong>. Todos los derechos reservados
          </div>
          <div class="credits">

          </div>
        </div>
      </footer><!-- #footer -->

      <!-- Footer -->

      <!-- Footer -->

      <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

      <!-- JavaScript Libraries -->
      <script src="template/lib/jquery/jquery.min.js"></script>
      <script src="template/lib/jquery/jquery-migrate.min.js"></script>
      <script src="template/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="template/lib/easing/easing.min.js"></script>
      <script src="template/lib/superfish/hoverIntent.js"></script>
      <script src="template/lib/superfish/superfish.min.js"></script>
      <script src="template/lib/wow/wow.min.js"></script>
      <script src="template/lib/owlcarousel/owl.carousel.min.js"></script>
      <script src="template/lib/magnific-popup/magnific-popup.min.js"></script>
      <script src="template/lib/sticky/sticky.js"></script>

      <!-- Contact Form JavaScript File -->
      <script src="template/contactform/contactform.js"></script>

      <!-- Template Main Javascript File -->
      <script src="template/js/main.js"></script>

</body>

</html>