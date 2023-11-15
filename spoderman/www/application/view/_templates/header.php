<!doctype html>
<html>
<head>
    <title>Detroit Crime Commission</title>
    <!-- META -->
    <meta charset="utf-8">
    <!-- send empty favicon fallback to prevent user's browser hitting the server for lots of favicon requests resulting in 404s -->
    <link rel="icon" href="<?php echo Config::get('URL'); ?>favicon.ico" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css" />
    <script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/bootstrap.min.css"/>
    <script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/bootstrap.min.js"></script>
</head>
<body>
    <!-- wrapper, to center website -->
    <div class="wrapper">

        <!-- logo -->
        <!--<div class="logo"></div>-->

        <!-- navigation -->
	<nav class="navbar navbar-default">
	<div class="container-fluid">
	<div class="navbar-header">
	<a class="navbar-brand" href="#"><img alt="URBN" src="<?php echo Config::get('URL'); ?>logo.png"></a>
	</div>

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

        <ul class="nav navbar-nav">
            <li <?php if (View::checkForActiveController($filename, "index")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>index/index">Home</a>
            </li>
            <?php if (Session::userIsLoggedIn()) { ?>
	    <li <?php if (View::checkForActiveController($filename, "searcher") or View::checkForActiveController($filename, "imagesearcher")) { echo ' class="active dropdown" '; } else { echo ' class="dropdown" ';  } ?> >
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Searches<span class="caret"></span></a>
		<ul class="dropdown-menu">
                <li <?php if (View::checkForActiveController($filename, "searcher")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>searcher/index">Search Page</a>
                </li>

                <li <?php //if (View::checkForActiveController($filename, "searcher")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>searcher/index#nameSearcher">Name Search</a>
                </li>
                <li <?php //if (View::checkForActiveController($filename, "searcher")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>searcher/index#locationSearcher">Location Search</a>
                </li>
                <li <?php //if (View::checkForActiveController($filename, "searcher")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>searcher/index#facebookSearcher">Facebook Search</a>
                </li>
                <li <?php //if (View::checkForActiveController($filename, "searcher")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>searcher/index#twitterSearcher">Twitter Search</a>
                </li>

		<li role="separator" class="divider"></li>

                <li <?php if (View::checkForActiveController($filename, "imagesearcher")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>imagesearcher/index">Image Searcher</a>
		</li>
		</ul>
	   </li>

                <!--<li <?php //if (View::checkForActiveController($filename, "schedualer")) { echo ' class="active" '; } ?> >
                    <a href="<?php //echo Config::get('URL'); ?>schedualer/index">Scheduler</a>
                </li>-->
                <li <?php if (View::checkForActiveController($filename, "howto")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>howto/index">How To</a>
                </li>
            	<!--<li <?php //if (View::checkForActiveController($filename, "wiki")) { echo ' class="active" '; } ?> >
                	<a href="<?php //echo Config::get('URL'); ?>wiki/">Wiki</a>
	    	</li>-->
            	<li <?php if (View::checkForActiveController($filename, "wiki")) { echo ' class="active" '; } ?> >
                	<a href="https://unet1.dtxsec.com" target="_blank">Wiki</a>
	    	</li>
            <?php } else { ?>
                <!-- for not logged in users -->
                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/index")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>login/index">Login</a>
                </li>
                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/register")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>login/register">Register</a>
                </li>
            <?php } ?>
        </ul>

        <!-- my account -->
        <ul class="nav navbar-nav navbar-right">
            <?php if (Session::get("user_account_type") == 7) : ?>
            <li <?php if (View::checkForActiveController($filename, "admin") or View::checkForActiveController($filename, "profile")) { echo ' class="active dropdown" '; } else { echo ' class="dropdown" ';  } ?> >
		 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
		 <ul class="dropdown-menu">
                <li <?php if (View::checkForActiveController($filename, "admin")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>admin/">Admin Page</a>
                </li>
            	<li <?php if (View::checkForActiveController($filename, "profile")) { echo ' class="active" '; } ?> >
                	<a href="<?php echo Config::get('URL'); ?>profile/index">Profiles</a>
	    	</li>
		</ul>
		</li>
            <?php endif; ?>

        <?php if (Session::userIsLoggedIn()) : ?>
            <li <?php if (View::checkForActiveController($filename, "login") or View::checkForActiveController($filename, "messages")) { echo ' class="active dropdown" '; } else { echo ' class="dropdown" ';  } ?> >
                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="#">My Account<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li <?php if (View::checkForActiveController($filename, "messages")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>messages/index">Messages</a>
                    </li>
		    <li role="separator" class="divider"></li>
                    <li <?php //if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/showProfile">Account Page</a>
                    </li>
                    <li <?php //if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/editAvatar">Edit your avatar</a>
                    </li>
		    <li <?php //if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/editusername">Edit my username</a>
                    </li>
		    <li <?php //if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/edituseremail">Edit my email</a>
                    </li>
		    <li <?php //if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/changePassword">Change Password</a>
                    </li>
		    <li <?php //if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                    </li>
                </ul>

	    </li>
        <?php endif; ?>
        </ul>

	</div>
	</div>
	</nav>
