<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Authentication of credentials">
<meta name="author" content="WSDC">
<title>Technozion Management System (TMS)</title>

<head>
    <title>Student Login</title>
    <link href="<?php echo asset_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>css/signin.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-sm-8 col-lg-8">
            <div class="jumbotron">
              <div class="container">
                <h1>TECHNOZION <?php echo date('y') ?></h1>
                <p></p>
                <p>
                  TECHNOZION MANAGEMENT SYSTEM
                </p>
              </div>
            </div>
                <div id="center">
                    <div id="full_form">
                        NATIONAL INSTITUTE OF TECHNOLOGY WARANGAL
                        <br>
                        <br>An Institute of National Importance
                    </div>
                </div>
            </div>
            <div class="clearfix visible-xs"></div>
            <div class="col-xs-12 col-md-4 col-sm-4 col-lg-4">
                    <br>

                    <form class="form form-signin" role="form" method="post" accept-charset="utf-8">
                      <legend>Login</legend>
                      <?php if(!empty($message)): ?>
                        <div class="text-danger fade in"><?php echo $message;?></div>
                      <?php else: ?>
                      <p class="text-info fade in">Please login with you credentials  below.</p>
                      <?php endif; ?>
                      <div class="form-group">
                        <input required="required" type="text" id="identity" name="identity" class="form-control" placeholder="username" autofocus>
                      </div>
                      <div class="form-group">
                        <input required="required" type="password" id="password" name="password" class="form-control" placeholder="Password">
                      </div>
                      <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-md btn-primary ">Login</button>
                      </div>

                      <div class="form-group">
                        <a href="<?php echo base_url('auth/forgot_password') ?>" >Forgot password/username of your account?</a>
                      </div>
                    </form>
            </div>
        </div>
        <div class="row">
            <hr>
            <p class="pull-right help-block"><span class="glyphicon glyphicon-copyright-mark"> </span> <?php echo date('Y') ?>,Technozion NITW</p>
            <p class="pull-left help-block"><span class="glyphicon glyphicon-envelope"> </span><!--  <a href="mailto:wsdc.nitw@gmail.com">wsdc.nitw@gmail.com</a> |  --> </span> +91-8801453511</p>
        </div>
    </div>

    <!-- /container -->
    <!-- Main Body Ends -->
    <script src="<?php echo asset_url(); ?>js/jquery.js"></script>
    <script src="<?php echo asset_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/login.js"></script>
    <script type="text/javascript">
        // $(document).ready(function () {
        //     var stri = new String(window.location);
        //     if (stri.indexOf("successful_password_reset") !== -1) {
        //         $('#password-reset-success').show();
        //     }
        //     if (stri.indexOf("failure") !== -1) {
        //         $('#password-reset-error').show();
        //     }
        // });
</script>
</body>

</html>
  