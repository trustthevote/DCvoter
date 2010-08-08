<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>District of Columbia Distance Voting</title>
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function submitIt() {
	var er = 0;
	if(document.getElementById("Fname").value == ""){
		er = 1;
	}
	if(document.getElementById("Lname").value == ""){
		er = 1;
	}
	if(document.getElementById("Address1").value == ""){
		er = 1;
	}
	if(document.getElementById("Zip").value == ""){
		er = 1;
	}
	if(document.getElementById("PIN").value == ""){
		er = 1;
	}
	if(document.getElementById("captcha").value == ""){
		er = 1;
	}
	
	if (er != 0) {
		alert("All fields must be completed");
	} else {
		document.forms["ps1"].submit();
	}

}
//-->
</script>
<link href="style01_1.css" rel="stylesheet" type="text/css" />
</head>
 
 
<body>
<form id="ps1" name="ps1" action="voter_confirm.php" method="post">
 
<div id="wrapper">
	<div id="header">
		<a href="index.htm"><img src="images/docdv-header.jpg" alt="docdv-header" width="950" height="70" /></a>	</div><!--end header-->
	
	<div id="title">
			<h1>ID form</h1>
	</div><!--end title-->
	
 	<div id="maincontent">
			<p>Please help us find your voter record.</p>
 

		        	<input type="text" name ="Fname" id="Fname" />
		        	<input type="text" name = "Lname" id="Lname" />
		        	<label for="namefield">First Name/ Last Name</label>
		        
			        <input type="text" name = "Address1" id="Address1" />
			        <input type="text" name = "Zip" id="Zip" />
			        <label for="addressfield">Address/ Zip Code</label>
			        
			        <input type="text" name = "PIN" id="PIN" />
			        <a href="pin_request.php">Request a PIN</a>
		        <label for="pinfield">PIN</label>
		    		
		    	  	
					<img src="images/captcha.png" alt="captcha" width="270" height="60" />	   			
					<p id="captchalabel">
		   			Enter both words, separated by a space.<br />
		    		Can't read this? <a href="">Try another.</a></p>
	
		    		
		    		<input type="text" id="captcha" name="captcha" />
<label for="captchafield">Security Check</label>
		        	
		        	<input type="button" onclick="submitIt();" value="Confirm"/>
 	</div><!--end maincontent-->
 
 		
 			<div id="helpcontent">
			<p>Your name and address information must match the information we have in your current voter 			record; the pin number must exactly match the number that was provided to you.<br><br>
 
			You can find all of this information– including name and address information–in the email you 			received.<br><br>
 
			All fields are required.</p>
			</div>
	<div id="footer">
		<div class="footertext">
			District of Columbia Distance Voting | <a href="">About</a>		</div>
			<img id="footerlogos" src="images/footer.png" alt=""/>	</div>
</div>
<!--end wrapper-->
			</form>

</body>
</html>


