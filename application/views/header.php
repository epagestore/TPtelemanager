<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document</title>
	<link href="http://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/admin.css" rel="stylesheet">
	<script src="<?php echo base_url();?>/js/jquery-1.10.2.min.js" type="text/javascript"></script>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/js/excanvas.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.flot.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.flot.resize.js"></script>
     <script src="<?php echo base_url();?>assets/js/bootstrap-paginator.js"></script>
   
    <link href="<?php echo base_url();?>assets/css/tabs.css" rel="stylesheet">
    <link href="<?php echo base_url();?>jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>jQueryAssets/jquery.ui.tabs.min.css" rel="stylesheet" type="text/css">
    
<style>
#user{
	float:left;
}
.mssg{
	border: 1px solid;
	display: inline-block;
	clear:both;
	float:left;
	margin:7px;
	padding: 3px;
	border-radius: 8px;
	border-color: rgba(45, 152, 214, 0.36);
	background: rgba(146, 198, 228, 0.36);
}
#Chat{
	width: 300px;
	border: 1px solid;
	padding: 5px;
	float:left;
	min-height:50px;

}
</style>
</head>
<?php $baseurl=base_url().'index.php';?>
<body>
<div class="masthead">
	
		<div class="container">
			
			<div class="masthead-top clearfix">
				
				<ul class="nav nav-pills pull-right">
					
					<li class="dropdown">
                   
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> <?php echo $this->session->userdata('firstname').' '.$this->session->userdata('lastname'); ?> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li class="active"><a href="<?php echo $baseurl;?>/home/change_password">Change Password</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $baseurl;?>/home/logout">Logout</a></li>
						</ul>
					</li>
				</ul>
	
				<h1><i class="icon-bookmark icon-large"></i> Trustedpayer - Telemanager</h1>
				
			</div>
			
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
					
						<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						
						<div class="nav-collapse">
						<ul class="nav">
							<!--<li class="active">
								<a href="<?php echo $baseurl;?>"><i class="icon-home"></i> Dashboard</a>
							</li>-->
							<li class="dropdown">
								<a  href="<?php echo $baseurl;?>/transaction"><i class="icon-sitemap"></i>Product Transaction</a>
							</li>
                           <li class="dropdown">
								<a   href="<?php echo $baseurl;?>/transaction/milestoneTransaction"><i class="icon-sitemap"></i>Milestone Transaction </a>
								
							</li> 
                              <li class="dropdown">
								<a   href="<?php echo $baseurl;?>/despute"><i class="icon-sitemap"></i>Dispute </a>
								
							</li>                      
						</ul>
						
						</div>
					</div>
				</div>
			</div>
			
		</div>
	
	</div>
   