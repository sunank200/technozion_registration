<!DOCTYPE html>
<html>
<head>
    <title>
        <?php if(!empty($title)) echo $title.' | TECHNOZION '.date('y').', NIT Warangal'; else echo 'TECHNOZION '.date('y').', NIT  Warangal | Online Registrations'; ?>
    </title>
    <!-- SEO -->
    <meta name="description" content="NIT Warangal Presents Technozion 2014. The annual Technical extravaganza. Events and workshop registrations are open.">
    <!-- Facebook open graph -->
    <meta property="og:title" content="Technozion 2014"/>
    <meta property="og:type" content="Fest Website, non profit organisation"/>
    <meta property="og:image" content="http://www.technozion.org/tz14/assets/images/favicon.png"/>
    <meta property="og:url" content="http://www.technozion.org"/>
    <meta property="og:description" content="Technozion is the annual celebration of engineering, science and technology organised wholly and solely by the students of NIT Warangal. Thus, one can not go wrong with the level of enthusiasm shown by the young engineering population, and the resulting magnificent ideas from it."/>
    <!-- Twitter cards -->
    <meta name="twitter:card" content="Technozion is the annual celebration of engineering, science and technology organised wholly and solely by the students of NIT Warangal. Thus, one can not go wrong with the level of enthusiasm shown by the young engineering population, and the resulting magnificent ideas from it." />
    <meta name="twitter:site" content="@Technozion14" />
    <meta name="twitter:title" content="Technozion , NITWarangal" />
    <meta name="twitter:description" content="National Level Technical Fest of NIT-Warangal." />
    <meta name="twitter:image" content="http://www.technozion.org/tz14/assets/images/header.png" />
    <meta name="twitter:url" content="https://register.technozion.org/" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="http://www.technozion.org/tz14/assets/images/favicon.png"/>
    <link rel="stylesheet" href="<?php echo asset_url()."css/flatly.bootstrap.min.css"; ?>">
    <link rel="stylesheet" href="<?php echo asset_url()."css/signup.css"; ?>">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url()."css/social-buttons-3.css"; ?>">
    <script src="<?php echo asset_url()."js/jquery.min.js"; ?>"></script>
    <script>
        (function() {
            var po = document.createElement('script');
            po.type = 'text/javascript'; po.async = true;
            po.src = 'https://plus.google.com/js/client:plusone.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    </script>

</head>
<body>
    <div id = "loading" style="display: block;position: absolute;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.43);z-index: 1000;overflow: visible">
        <center><img style="margin-top: 10%" src="<?php echo asset_url()."images/728.GIF"; ?>" alt=""/></center>
    </div>
    <div class="container signup">
        <div class="row" id="header">

        </div>
        <div class="row" id="main">
            <div class="col-md-6">
                <div class="row" id="logo">
                    <center><img src="<?php echo get_tz_logo('side-menu'); ?>" class="img-responsive img-rounded" height="250" width="250" alt="Technozion Logo"></center>
                </div>
                <div class="row" id="name">
                    <h4>Online events & workshops registration</h4>
                    <h2>TECHNOZION <?php echo date('y') ?></h2>
                    <p><strong>Updates:</strong><br>New workshops added, for more details <a href="http://workshops.technozion.org" target="_blank">workshops.technozion.org</a></p>
                </div>

            </div>
            <div class="col-md-6" id="signinarea">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php
                        if($this->session->flashdata('success') == TRUE)
                            echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('success').'</div>';

                        if($this->session->flashdata('warning') == TRUE)
                            echo '<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('warning').'</div>';

                        if($this->session->flashdata('info') == TRUE)
                            echo '<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('info').'</div>';

                        if($this->session->flashdata('danger') == TRUE)
                            echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('danger').'</div>';
                        ?>
                    </div>
                </div>

                <div class="row" id="status">
                </div>
                <div class="well well-sm">
                    <center>
                        <div class="btn-group">
                           <button class="btn btn-facebook" onclick="fb_signup()"><i class="fa fa-facebook"></i> | Connect with Facebook</button>
                           <div id="gConnect" style="display: none;z-index: -100">
                            <button class="g-signin"
                            data-scope="https://www.googleapis.com/auth/plus.profile.emails.read profile"
                            data-requestvisibleactions="http://schemas.google.com/AddActivity"
                            data-clientId="622509322573-rfjsanmsvlfkqgqtq7di4gs9c1tq76bd.apps.googleusercontent.com"
                            data-callback="onSignInCallback"
                            data-theme="dark"
                            data-cookiepolicy="single_host_origin">
                        </button>
                    </div>
                    <button class="btn btn-google-plus" onclick="gp_signup()"><i class="fa fa-google-plus"></i> | Connect with Goolge+</button>
                </div>
            </center>
            <!--                        <div class="fb-login-button" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false" data-scope="email" ></div>-->
        </div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane form-panel active" id="login">
                <form id="signin-form" action="" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="signin-inputEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input required autofocus type="email" class="form-control" id="signin-inputEmail" placeholder="emailid@example.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signin-inputPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input required type="password" class="form-control" id="signin-inputPassword">
                        </div>
                    </div>

                    <div class="btn-group col-md-offset-2">
                        <button type="submit" class="btn btn-primary btn-signin">Login to My TZ account</button>


                    </div>
                    <br><br>

                    <a href="#" class="col-md-offset-2" id="btn_forgot_password">Forgot Password?</a>
                </form>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <center> 
                         <h3><strong>Registration is closed</strong></h3>
                     </center>
                 </div>
             </div>

             <form action="<?php echo base_url('forgot_password/request') ?>" class="form_forgot_password hidden" method="POST" role="form">
                <legend>Forgot Password?</legend>

                <div class="form-group">
                    <label for="inputEmail">Registered Email</label>
                    <input type="email" name="email" id="inputEmail" class="form-control" required="required" title="Your registered email id" placeholder="Valid email ID">
                </div>



                <button type="submit" class="pull-right btn btn-primary">Reset Password</button>
            </form>
        </div>
    </div>
</div>
</div>
<div class="row" id="footer">
    <!-- <p class="pull-left help-block">page rendered in <strong>{elapsed_time}</strong> seconds</p> -->
    <p class="help-block pull-left hidden-xs hidden-sm"><a href="http://www.technozion.org">www.technozion.org </a>| <a href="http://blog.technozion.org ">blog.technozion.org </a>| <a href="http://events.technozion.org">events.technozion.org</a></p>
    <p class="pull-right help-block">&copy; <?php echo date('Y') ?>, Technozion NITW</p>
</div>
</div>
<script src="<?php echo asset_url()."js/bootstrap.min.js"; ?>"></script>
<script src="<?php echo asset_url()."js/signup.js"; ?>"></script>
<script src="<?php echo asset_url()."js/college_city.js"?>"></script>
</body>
</html>