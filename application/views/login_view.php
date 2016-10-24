
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simple Login From</title>

<link href="<?php echo base_url();?>assets/css/admin.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">

<style>

fieldset {
border:1px solid #888;
border-right:1px solid #666;
border-bottom:1px solid #666;
width:300px;
margin-left:470px;
margin-top:80px;
}
legend {
font-weight:bold;
border:1px solid #888;
border-right:1px solid #666;
border-bottom:1px solid #666;
padding: 0.5em;
background-color:#666;
color:#fff;
text-shadow:0 -1px 0 #333;
letter-spacing: 0.1em;
text-transform:uppercase;
}
input {
display:block;
width:175px;
float:left;
margin-bottom:10px;
}
label {
display:block;
text-align:right;
float:left;
width:75px;
padding-right: 20px;
}
.checkbox {
width: 1em;
}
br {
clear:left;
}
.buttonsubmit {
width: 75px;
margin-left:95px;
}
</style>
</head>
<body>

<div class="masthead">
	
		<div class="container">
			
			<div class="masthead-top clearfix">
				
				<h1><i class="icon-bookmark icon-large"></i> Trustedpayer - Telemanager</h1>
				
			</div>
</div>
</div>
    <div id='login_form'>
        <form action='<?php echo base_url();?>index.php/login/process' method='post' name='process'>
			<fieldset>
			<legend>Login</legend>
            <label for='uname'>Username</label>
            <input type='text' name='username' id='username' size='25' /><br />
        
            <label for='password'>Password</label>
            <input type='password' name='password' id='password' size='25' /><br />                            
			<label style="margin-left:75px;"><?php echo $err_msg;?></label>
            <br/>        
            <input type='Submit' value='Login' class='buttonsubmit'/>  
        	</fieldset>
        </form>
    </div>
</body>
</html>