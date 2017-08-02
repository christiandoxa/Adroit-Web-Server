<!DOCTYPE html>
<html>
<head>
    <title>Sorry! The page you requested was not found!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <!-- Custom Theme files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css"/>
    <link href="<?php echo base_url('assets/error/') ?>css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- //Custom Theme files -->
    <!-- web font -->
    <link href="//fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic'
          rel='stylesheet' type='text/css'>
    <!-- //web font -->
</head>
<body>
<!--mian-content-->
<h1>Adroit Devs</h1>
<div class="main-wthree">
    <h2>404</h2>
    <p><span class="sub-agileinfo">Sorry! </span>The page you requested was not found!....</p>
    <!--form-->
    <div class="form-group">
        <form class="newsletter" id="subscribe" action="#" method="post">
            <input class="form-control" placeholder="Enter Your Email Address" name="email" type="email"
                   required>
            <input style="vertical-align: middle;width: 10%" name="submit"
                   class="text-center btn btn-default btn-submit" type="submit" value="   ">
        </form>
    </div>
    <!--//form-->
</div>
<!--//mian-content-->
<!-- copyright -->
<div class="copyright-w3-agile">
    <p> © 2017 Adroit Devs. All rights reserved</p>
</div>
<!-- //copyright -->

</body>
</html>
<script src="<?php echo base_url('assets/main/') ?>js/vendor/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/jquery.validate.min.js"></script>
<script src="<?php echo base_url('assets/main/') ?>js/jquery.form.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>
<script>
    $(document).ready(function () {
        $("#subscribe").validate({
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    type: "POST",
                    data: $(form).serialize(),
                    url: "http://localhost/Adroit_Web/landing/subscribe_email",
                    success: function () {
                        swal("Thanks!", "Your email is now registered", "success");
                    },
                    error: function () {
                        swal("Sorry!", "Your email is not registered successfully, please try again", "error");
                    }
                });
            }
        });
    });
</script>