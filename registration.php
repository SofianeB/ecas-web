<!DOCTYPE html>
<!-- <?php include('server.php') ?> -->
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ECASLab</title>

    <script src="//code.jquery.com/jquery-latest.js" type="text/javascript"></script>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/small-business.css" rel="stylesheet">
    <link href="css/custom_style.css" rel="stylesheet">

        <script type="text/javascript">

    	function captcha() {

    		document.getElementById("form").reset();

    	    var alpha = new Array('1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    	    var i;
    	    for (i=0;i<6;i++){
    	    	var a = alpha[Math.floor(Math.random() * alpha.length)];
    	    	var b = alpha[Math.floor(Math.random() * alpha.length)];
    	        var c = alpha[Math.floor(Math.random() * alpha.length)];
    	        var d = alpha[Math.floor(Math.random() * alpha.length)];
    	        var e = alpha[Math.floor(Math.random() * alpha.length)];
    	        var f = alpha[Math.floor(Math.random() * alpha.length)];
    	        var g = alpha[Math.floor(Math.random() * alpha.length)];
    	    }

    	    var code = a +  b + c + d + e + f + g;
    	    document.getElementById("mainCaptcha").value = code;

    	    $(this).scrollTop(0);
    	}

    	function refreshCaptcha() {
   		 var alpha = new Array('1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
   		    var i;
   		    for (i=0;i<6;i++){
   		    	var a = alpha[Math.floor(Math.random() * alpha.length)];
   		    	var b = alpha[Math.floor(Math.random() * alpha.length)];
   		        var c = alpha[Math.floor(Math.random() * alpha.length)];
   		        var d = alpha[Math.floor(Math.random() * alpha.length)];
   		        var e = alpha[Math.floor(Math.random() * alpha.length)];
   		        var f = alpha[Math.floor(Math.random() * alpha.length)];
   		        var g = alpha[Math.floor(Math.random() * alpha.length)];
   		    }

   		    var code = a + b + c + d + e + f + g;
   		    document.getElementById("mainCaptcha").value = code;
   		}

		$(function() {
			$('img').click(function() {
				$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
				$('#enlargeImageModal').modal('show');
			});
		});

		function refresh() {
			document.getElementById('first_name').value = "";
			document.getElementById('last_name').value = "";

		}

	</script>

  </head>

  <body onload="captcha();">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark2 fixed-top">
      <div class="container">
		<a class="navbar-brand2" href="home.html"><img class="header-image" src="img/ecas_logo.png" alt="ECASLab Logo" width="260px"></a>&nbsp;&nbsp;&nbsp;
	<a class="navbar-brand2" href=""><img class="header-image" src="img/institute.png" width="200px" alt="Institute Logo"></a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="home.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="experiments.html">Experiments</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="registration.php">Register
              	<span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
    <br>
      <!-- Heading Row -->
      <div class="row my-4">
      	<div class="col-lg-2"></div>
      	<div class="col-lg-8">

      	<h3 align="center">ECASLab Registration Form</h3>
      	<br>
      	<div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><b>Sign Up!</b></h6>
            </div>
        	<div class="panel-body">
    	        <form id="form" action="registration.php" method="post">
                <?php include('errors.php'); ?>
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" maxlength="20" placeholder="First Name *" id="first_name" name="first_name" type="text" value = "<?php echo $first_name; ?>" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" maxlength="20" placeholder="Last Name *" id="last_name" name="last_name" type="text" value = "<?php echo $last_name; ?>" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" maxlength="60" placeholder="E-mail *" id="email" name="email" type="email" value = "<?php echo $email; ?>" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" maxlength="90" placeholder="Affiliation *" id="affiliation" name="affiliation" type="text" value = "<?php echo $affiliation; ?>" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" maxlength="30" placeholder="Country *" id="country" name="country" type="text" value = "<?php echo $country; ?>" autofocus required>
                        </div>
                        <div class="form-group">
    				        <textarea class="form-control" style="resize:none" maxlength="300" placeholder="Motivation * (Research, Training, etc.)" id="motivation" rows="5" name="motivation" value="<?php echo $motivation; ?>" autofocus required></textarea>
                        </div>

                        <table class="col-lg-12">
    			        	<tr>
    			           		<td>
    			                 	<label>Captcha *</label>
    			           		</td>
    			          	</tr>
    			          	<tr>
    			           		<td>
    			             		<input class="form-control" type="text" id="mainCaptcha" readonly="readonly" name="mainCaptcha" value = "<?php echo $mainCaptcha; ?>"/>
    			             		<p>Can't read the above security code? <a href="javascript:void(0);" onclick="refreshCaptcha()">Refresh</a></p>
    			           		</td>
    			          	</tr>
    			          	<tr>
    			          		<td>
    			            		<input class="form-control" maxlength="15" type="text" id="securityCode" name="securityCode" value = "<?php echo $securityCode; ?>" placeholder="Security Code *" autofocus required/>
    			          		</td>
    			        	</tr>
    			        	<tr>
    			        		<td><br></td>
    			        	</tr>
    			        	<tr>
    			          		<td>
    								<label>
    							    	<input class="checkbox-inline" type="checkbox" checked="true" value="yes" id="newsletter" name="newsletter"/>&nbsp;&nbsp;&nbsp;Subscribe to our Mailing List to get the latest news on ECASLab.
    							    </label>
    			          		</td>
    			        	</tr>
    					</table>
    					<div id="message"></div>
                        <div class="text-center">
                        	<button type="submit" id="submit" name="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div id="submit"></div>
            </div>
        </div>
        <div class="col-lg-2"></div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; ECASLab 2018</p>
        <p class="m-0 text-center text-white">Contact us at ecas-support [at]cmcc [dot] it and subscribe to our user mailing list to get regularly updated on the latest news about ECASLab</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
