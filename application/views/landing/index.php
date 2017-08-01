<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Adroit Apps Service</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!-- Fonts -->
    <!-- Lato -->
    <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/main/') ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/main/') ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/main/') ?>css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/main/') ?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/main/') ?>css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css"/>
    <!-- Responsive Stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url('assets/main/') ?>css/responsive.css">
</head>

<body id="body">


<div class="navbar-default navbar-fixed-top" id="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url() ?>">
                <img class="logo-1" src="<?php echo base_url('assets/main/') ?>images/logo.png" alt="LOGO">
                <img class="logo-2" src="<?php echo base_url('assets/main/') ?>images/logo-2.png" alt="LOGO">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <nav class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right" id="top-nav">
                <li class="current"><a href="#body">Home</a></li>
                <li><a href="#service">Services</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</div>

<section id="hero-area">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <h1 class="wow fadeInDown">ADROIT APPS SERVICE</h1>
                    <p class="wow fadeInDown" data-wow-delay="0.3s">Adroit Apps Services membantu anda untuk terkoneksi
                        dengan berbagai perangkat IoT milik AdroitDevs dengan berbagai fitur yang tersedia dengan
                        berbagai kemudahan</p>
                    <div class="wow fadeInDown" data-wow-delay="0.3s">
                        <a class="btn btn-default btn-home" href="#" onclick="get_started()">Daftar</a>
                    </div>
                </div>
            </div>
        </div><!-- .row close -->
    </div><!-- .container close -->
</section><!-- header close -->

<!--
Service start
==================== -->
<section id="service" class="section">
    <div class="container">
        <div class="row">
            <div class="heading wow fadeInUp">
                <h2>Our service</h2>
                <p>Segala perangkat dari Adroit Devs dapat diaktifkan melalui aplikasi Adroit Apps Service yang sudah
                    terintegrasikan satu sama lain. Maka untuk menikmati segala fitur dari Adroit Apps Service, aktifkan
                    melalui aplikasi Adroit Apps Service pada halaman beranda. Anda dapat mengendalikan segala produk
                    dari AdroitDevs secara online sesuai kedaan cuaca</p>
            </div>
            <div class="col-sm-6 col-md-3 wow fadeInLeft">
                <div class="service">
                    <div class="icon-box">
                            	<span class="icon">
                                    <i class="ion-android-desktop"></i>
                                </span>
                    </div>
                    <div class="caption">
                        <h3>Fully Responsive</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow fadeInLeft" data-wow-delay="0.3s">
                <div class="service">
                    <div class="icon-box">
                            	<span class="icon">
                                    <i class="ion-speedometer"></i>
                                </span>
                    </div>
                    <div class="caption">
                        <h3>Speed Optimized</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow fadeInLeft" data-wow-delay="0.6s">
                <div class="service">
                    <div class="icon-box">
                            	<span class="icon">
                                    <i class="ion-ios-infinite-outline"></i>
                                </span>
                    </div>
                    <div class="caption">
                        <h3>Tons of Feature</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow fadeInLeft" data-wow-delay="0.9s">
                <div class="service">
                    <div class="icon-box">
                            	<span class="icon">
                                    <i class="ion-ios-cloud-outline"></i>
                                </span>
                    </div>
                    <div class="caption">
                        <h3>Cloud Option</h3>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .container close -->
</section><!-- #service close -->

<section id="call-to-action" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow text-center">
                <div class="block">
                    <h2>Subscribe</h2>
                    <div class="form-group">
                        <form method="post" action="#" id="subscribe">
                            <input class="form-control" placeholder="Enter Your Email Address" name="email" type="email"
                                   required>
                            <input style="vertical-align: middle;width: 10%" name="submit"
                                   class="text-center btn btn-default btn-submit" type="submit" value="Get Notified">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- #call-to-action close -->

<!--
Contact start
==================== -->
<section id="contact" class="section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="block">
                    <div class="heading wow fadeInUp">
                        <h2>Get In Touch</h2>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 wow fadeInUp">
                <div class="block text-left">
                    <div class="sub-heading">
                        <h4>Let us know</h4>
                    </div>
                    <address class="address">
                        <hr>
                        <p>Adroit Devs,<br> Malang,<br> Indonesia</p>
                        <hr>
                        <p><strong>E:</strong>&nbsp;adroitdevs@gmail.com<br>
                            <strong>P:</strong>&nbsp;+62 822 5768 4278</p>


                    </address>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-5 col-md-offset-1 wow fadeInUp" data-wow-delay="0.3s">
                <div class="form-group">
                    <form action="#" method="post" id="contact-form">
                        <div class="input-field">
                            <input class="form-control" placeholder="Your Name" name="name">
                        </div>
                        <div class="input-field">
                            <input type="email" class="form-control" placeholder="Email Address" name="email">
                        </div>
                        <div class="input-field">
                            <textarea class="form-control" placeholder="Your Message" rows="3"
                                      name="message"></textarea>
                        </div>
                        <input class="btn btn-send" type="submit" name="submit" value="Send me">
                    </form>

                    <div id="success">
                        <p>Your Message was sent successfully</p>
                    </div>
                    <div id="error">
                        <p>Your Message was not sent successfully</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <p>Copyright &copy; <a href="http://www.adroitdevs.com">AdroitDevs</a>| All right reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- Js -->
<script src="<?php echo base_url('assets/main/') ?>js/vendor/modernizr-2.6.2.min.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/vendor/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/jquery.lwtCountdown-1.0.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/owl.carousel.min.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/jquery.validate.min.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/jquery.form.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/jquery.nav.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/jquery.sticky.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/plugins.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/wow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/main.js"></script>
<?php
if (!empty($message)) {
    echo '
    <script>
    swal("Thanks!", "' . $message . '", "success")
    </script>
    ';
}
if (!empty($messagef)) {
    echo '
    <script>
    swal("Sorry!", "' . $messagef . '", "error")
    </script>
    ';
}
?>

</body>
</html>