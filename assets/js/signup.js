$("#signin-form").submit(function(e) {
    // e.preventDefault();
    $('.alert').addClass('hidden');
    var formData = "inputEmail=" + $("#signin-inputEmail").val();
    formData += "&inputPassword=" + $("#signin-inputPassword").val();
    $.ajax({
        url : "./accounts/login",
        type: "POST",
        data : formData,
        success: function(data, textStatus, jqXHR)
        {
            data = JSON.parse(data);
            if (data.status === "success") {
                window.location=window.location;
            } else {
                $("#status").removeClass().addClass("alert alert-danger").html(data.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#status").removeClass().addClass("alert alert-danger").html("Error occured. Please try later.");
        }
    });
    return false;
});
$("#signup-form").submit(function(e) {
    // e.preventDefault();
    var formData = "";
    formData += "inputName=" + $("#signup-inputName").val();
    formData += "&inputEmail=" + $("#signup-inputEmail").val();
    formData += "&inputGender=" + $("#signup-inputGender").val();
    formData += "&inputPhone=" + $("#signup-inputPhone").val();
    if($("#signup-inputCollege option:selected").val()!=('others')){
    formData += "&inputCollege=" + $("#signup-inputCollege option:selected").text();
    }
    else if($('#signup-inputCollege option:selected').val()=='others'){
        formData += "&inputCollege="+$("#signup-o-inputCollege").val();
    };
    formData += "&inputCollegeId=" + $("#signup-inputCollegeId").val();
    if($("#signup-inputCity option:selected").val()!=('others')){
    formData += "&inputCity=" + $("#signup-inputCity option:selected").text();
    }
    else if($('#signup-inputCity option:selected').val()=='others'){
        formData += "&inputCity="+$("#signup-o-inputCity").val();
    };
   // formData += "&inputCity=" + $("#signup-inputCity").val();
    formData += "&inputState=" + $("#signup-inputState").val();
    formData += "&inputPassword=" + $("#signup-inputPassword").val();
    $.ajax({
        url : "./accounts/signup",
        type: "POST",
        data : formData,
        success: function(data, textStatus, jqXHR)
        {
            data = JSON.parse(data);
            if (data.status === "success") {
                $("#status").removeClass().addClass("alert alert-success").html(data.message);
                setTimeout(function(){window.open(data.email.split('@')[1],'_blank');}, 2000);
            } else {
                $("#status").removeClass().addClass("alert alert-danger").html(data.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#status").removeClass().addClass("alert alert-danger").html("Account is already created. Please login with your email and password");
        }
    });
    return false;
});
$('#btn_forgot_password').click(function (e) {
    e.preventDefault();
   $('.form_forgot_password').toggleClass('hidden');
});

// This is called with the results from from FB.getLoginStatus().


// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.

window.fbAsyncInit = function() {
    FB.init({
        appId      : '286235854918340',
        cookie     : true,  // enable cookies to allow the server to access
        // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.1' // use version 2.1
    });

    // Now that we've initialized the JavaScript SDK, we call
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

};

// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function fb_signup() {
    $('#loading').show();
    var data = {
        scope : 'email'
    };
    FB.login(function(response) {
        if (response.authResponse) {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', function(response) {
                console.log('Good to see you, ' + response.name + '.');
                console.log(response);
                if(response.email==undefined){
                    $('#loading').hide();
                    $("#status").removeClass().addClass("alert alert-danger").html("You did not provide your email address!");
                    data['auth_type'] = 'rerequest';
                    return false;
                }else{
                    data = {
                        'inputEmail': response.email,
                        'inputFb': true,
                        'inputName': response.name
                    };
                    social_login(data);
                }
            });


        } else {
            console.log('User cancelled login or did not fully authorize.');
//            $("#status").removeClass().addClass("alert alert-danger").html("Error occured. Please try later.");
            $('#loading').hide();

        }
    },{
        scope: 'email',
        auth_type: 'rerequest'
    });
}

//google plus sign-in
//very bad way to code but cant help
var count = 0;
var helper = (function() {
    var BASE_API_PATH = 'plus/v1/';

    return {
        /**
         * Hides the sign in button and starts the post-authorization operations.
         *
         * @param {Object} authResult An Object which contains the access token and
         *   other authentication information.
         */
        onSignInCallback: function(authResult) {
            $('#loading').show();
            gapi.client.load('plus','v1', function(){
                console.log(authResult);
                if (authResult['access_token']) {
                    email_fetch();
                } else if (authResult['error'] != "immediate_failed") {
                    if(count>0)
                        $("#status").removeClass().addClass("alert alert-danger").html("Error occured. Please try later.");
                    ++count;
                }
                $('#loading').hide();
                console.log('authResult', authResult);
            });
        }
    };
})();

/**
 * jQuery initialization
 */

function email_fetch () {
    var request = gapi.client.plus.people.get( {'userId' : 'me', 'fields' : 'emails,name'} );
    request.execute( function(data) {
        console.log('ema');
        console.log(data);
        if (data.error) {
        }
        var full_name = "";
        for(name in data.name){
            full_name += data.name[name]+' ';
        }
        full_name = full_name.split(' ').reverse().join(' ');
        data = {
            'inputEmail': data.emails[0].value,
            'inputGp': true,
            'inputName': full_name.trim()
        }
        social_login(data);
    });
}
$(document).ready(function() {
    $('#loading').hide();
    $('#disconnect').click(helper.disconnect);
    $('#loaderror').hide();
    if ($('[data-clientid="YOUR_CLIENT_ID"]').length > 0) {
        alert('This sample requires your OAuth credentials (client ID) ' +
            'from the Google APIs console:\n' +
            '    https://code.google.com/apis/console/#:access\n\n' +
            'Find and replace YOUR_CLIENT_ID with your client ID.'
        );
    }
});

/**
 * Calls the helper method that handles the authentication flow.
 *
 * @param {Object} authResult An Object which contains the access token and
 *   other authentication information.
 */
var attempt = 0;
function onSignInCallback(authResult) {
    if(attempt!=0){
        helper.onSignInCallback(authResult);
    }
    ++attempt;
}

function gp_signup(){
    $('#___signin_0').children()[0].click();
    $('#loading').show();
}


function social_login(data){
    $.ajax({
        url : "./accounts/signup",
        type: "POST",
        data : data,
        success: function(data, textStatus, jqXHR)
        {
            $('#loading').hide();
            data = JSON.parse(data);
            console.log(data);
            if (data.status === "success") {
                window.location=window.location;
            } else {
                $("#status").removeClass().addClass("alert alert-danger").html(data.message);
            }
        }
    });
}
