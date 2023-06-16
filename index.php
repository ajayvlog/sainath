<?php
include("action.php");

$message = "" ;
$session_name = "";

$expinfo = $obj->software_expire_info();
$expmsg = "";
$isexpired = 0;


if($expinfo['soft_exp_id'] > 0)
{
	$isexpired = 0;
	$expmsg = "Software Will Expired at: ".$obj->dateformatindia($expinfo['expired_date']);

}
else
{
	$isexpired = 1;
	$expmsg = "Your software has been expired. Kindly contact to administrator for renewal: +91-9770131555";
}

//echo $isexpired;die;

if(isset($_GET['msg']))
{
	$msg = $_GET['msg'];

	if($msg == 'error')
	$message = "<div class='alert alert-error'><button data-dismiss='alert' class='close' type='button'>×</button>Wrong User Id or Password</div>"  ;
	if($msg == 'blank')
	$message = "<div class='alert alert-info'><button data-dismiss='alert' class='close' type='button'>×</button>User Id & Password Should not blank</div>" ;
	if($msg == 'invalid')
	$message ="<div class='alert alert-error'><button data-dismiss='alert' class='close' type='button'>×</button>Invalid User login</div>" ;
	if($msg == 'logout')
	$message = "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>×</button>Successfully Logged Out !!</div>" ;
	
}

?>
<!DOCTYPE html>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>TriSol - Call : +91-9770131555</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script src="lib/commonfun.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/detectizr.min.js"></script>
<style type="text/css">
	blink {
  -webkit-animation: 2s linear infinite condemned_blink_effect; /* for Safari 4.0 - 8.0 */
  animation: 2s linear infinite condemned_blink_effect;
}

/* for Safari 4.0 - 8.0 */
@-webkit-keyframes condemned_blink_effect { 
  0% {
    visibility: hidden;
  }
  50% {
    visibility: hidden;
  }
  100% {
    visibility: visible;
  }
}

@keyframes condemned_blink_effect {
  0% {
    visibility: hidden;
  }
  50% {
    visibility: hidden;
  }
  100% {
    visibility: visible;
  }
}
</style>
</head>

<body class="loginbody">

<div class="loginwrapper">
	<div class="loginwrap zindex100 animate2 bounceInDown">
	

	<h1 class="logintitle"><span class="iconfa-lock"></span> Sign In <span class="subtitle">Hello! Sign in to get you started!</span></h1>
	
        <div class="loginwrapperinner">
        <?php if($message != "")
		{echo $message;
		}?><img src="img/cips_logo.png" height="400px" width="400px"><br>
            <form id="loginform" action="checklogin.php" method="post">
			<?php if($isexpired == 0){ ?>
              <p class="animate4 bounceIn"><input type="text" id="admin_name" name="admin_name"  placeholder="Username" autocomplete="off" autofocus /></p>
                <p class="animate5 bounceIn"><input type="password" id="admin_pwd" name="admin_pwd" placeholder="Password" autocomplete="off" /></p>
                    <p class="animate5 bounceIn"> 
					<?php 
					 $sessionid = $obj->getvalfield("m_session","sessionid","status = 1");
					 $session_name  = $obj->getvalfield("m_session","session_name","sessionid = '$sessionid'");
					?>
                     <input type="hidden" name="sessionid" id="sessionid" class="form-control"  value="<?php echo $sessionid; ?>" tabindex="2"   autocomplete="off"/>
                     <h3 align="center" style="color:#F6F8F6"><strong>Session : <?php echo $session_name ; ?></strong></h3></p>

                    <input  type="submit" name="login" onClick="return checkinputmaster('admin_name,admin_pwd')" class="btn btn-default btn-block" value="Sign IN">
                    </p>
               <p style="color: red; font-size: 20px;text-align: center;" class="animate7 fadeIn"> 
               		<?php echo $expmsg; ?>

               	</p>
			     <?php } else{ ?>
               	<p style="color: red; font-size: 20px;text-align: center;" class="animate7 fadeIn"> 
               		<?php echo $expmsg; ?>

               	</p>
               	<?php } ?>
				<center><h5 style="color:#F6F8F6">A product by TrinitySolutions.</h5></center>
            </form>
            <?php if($isexpired > 0){ ?>
			<center> <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_HsxZzSO3FE7Ipq" async> </script> </form></center>
		    <?php } ?>
        </div><!--loginwrapperinner-->

    </div>
    <div class="loginshadow animate3 fadeInUp"></div>
</div><!--loginwrapper-->

<script type="text/javascript">
jQuery.noConflict();

jQuery(document).ready(function(){
	
	var anievent = (jQuery.browser.webkit)? 'webkitAnimationEnd' : 'animationend';
	jQuery('.loginwrap').bind(anievent,function(){
		jQuery(this).removeClass('animate2 bounceInDown');
	});
	
	jQuery('#admin_name,#password').focus(function(){
		if(jQuery(this).hasClass('error')) jQuery(this).removeClass('error');
	});
	
	jQuery('#loginform button').click(function(){
		if(!jQuery.browser.msie) {
			if(jQuery('#admin_name').val() == '' || jQuery('#password').val() == '') {
				if(jQuery('#admin_name').val() == '') jQuery('#admin_name').addClass('error'); else jQuery('#admin_name').removeClass('error');
				if(jQuery('#password').val() == '') jQuery('#password').addClass('error'); else jQuery('#password').removeClass('error');
				jQuery('.loginwrap').addClass('animate0 wobble').bind(anievent,function(){
					jQuery(this).removeClass('animate0 wobble');
				});
			} else {
				jQuery('.loginwrapper').addClass('animate0 fadeOutUp').bind(anievent,function(){
					jQuery('#loginform').submit();
				});
			}
			return false;
		}
	});
});
</script>
</body>
</html>
