<div class="container">
    <link rel="stylesheet" type="text/css" href="<?php echo Config::get('URL'); ?>css/datatables.min.css"/>
    <script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/datatables.min.js"></script>

    <h1>Searcher</h1>
    <!--
    <div class="box">
        <h3>Timeline Messages Row Count: <?php echo $this->timelinecount; ?></h3>
        <h3>Timeline Comments Row Count: <?php echo $this->commentcount; ?></h3>
        <h3>MIDC Row Count: <?php echo $this->midccount; ?></h3>
        <h3>Twitter Row Count: <?php echo $this->twittercount; ?></h3>
        <h3>Macomb County Jail Row Count: <?php echo $this->macombjailcount; ?></h3>
        <h3>Oakland County Jail Row Count: <?php echo $this->oaklandjailcount; ?></h3>
        <h3>Wayne County Jail Row Count: <?php echo $this->waynejailcount; ?></h3>
        <h3>Crisnet Row Count: <?php echo $this->crisnetcount; ?></h3>
    </div>
    -->

    <div class="box">
    <h2 id="nameSearcher">Name Searcher</h2>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <!--<h3>Name Search</h3>-->
	<form action="<?php echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtFN" placeholder="Search First Name" />
            <input type="text" name="txtLN" placeholder="Search Last Name" />
            <input class="btn btn-info" type="submit" name="btnFNLN" class="login-submit-button" value="Search"/>
	    <br>
	    <label for="ckFNLNOr">Check for 'or' search</label><input type="checkbox" name="ckFNLNOr" id="ckFNLNOr">
        </form>
    </div>

    <div class="box">
    <h2 id="locationSearcher">Location Searcher</h2>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <!--<h3>Name Search</h3>-->
	<form action="<?php echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtLat" placeholder="Search Latitude in degrees" />
            <input type="text" name="txtLon" placeholder="Search Longitude in degrees" />
	    <br>
	    <br>
            <input type="text" name="txtRad" placeholder="Search Radius" />
            <input class="btn btn-info" type="submit" name="btnL" class="login-submit-button" value="Search"/>
        </form>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

<!--
    <div class="box">
    <h2 id="facebookSearcher">Facebook</h2>

        <?php //$this->renderFeedbackMessages(); ?>

        <h3>Timeline Message Search</h3>
        <form action="<?php echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtFTM" placeholder="Search Text" required />
            <input type="submit" name ="btnFTM" class="login-submit-button" value="Search"/>
        </form>

        <?php //$this->renderFeedbackMessages(); ?>

        <h3>Timeline Comments Search</h3>
        <form action="<?php echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtFTC" placeholder="Search Text" required />
            <input type="submit" name="btnFTC" class="login-submit-button" value="Search"/>
        </form>
      </div>
-->

    <div class="box">
    <h2 id="facebookSearcher">Facebook</h2>

        <!-- echo out the system feedback (error and success messages) -->
        <?php //$this->renderFeedbackMessages(); ?>

        <h3>Search</h3>
        <form action="<?php echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtF" placeholder="Search Text" required />
            <input type="submit" name ="btnF" class="login-submit-button" value="Search"/>
        </form>
      </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div class="box">
    <h2 id="twitterSearcher">Twitter</h2>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Search</h3>
        <form action="<?php echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtTW" placeholder="Search Text" />
            <input type="submit" name="btnTW" class="login-submit-button" value="Search"/>
        </form>
    </div>

    <!--
    <div class="box">
    <h2>MIDC</h2>

        <?php //$this->renderFeedbackMessages(); ?>

        <h3>Name Search</h3>
	<form action="<?php //echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtMFN" placeholder="Search First Name" />
            <input type="text" name="txtMLN" placeholder="Search Last Name" />
            <input type="submit" name="btnMIDC" class="login-submit-button" value="Search"/>
	    <br>
	    <label for="ckMOr">Check for 'or' search</label><input type="checkbox" name="ckMOr" id="ckMOr">
        </form>
    <br>
    </div>
    -->

    <!--
    <div class="box">
    <h2>Macomb County Jail</h2>

        <?php //$this->renderFeedbackMessages(); ?>

        <h3>Search</h3>
        <form action="<?php //echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtMCFN" placeholder="Search First Name" />
            <input type="text" name="txtMCLN" placeholder="Search Last Name" />
            <input type="submit" name="btnMC" class="login-submit-button" value="Search"/>
	    <br>
	    <label for="ckMCOr">Check for 'or' search</label><input type="checkbox" name="ckMCOr" id="ckMCOr">
        </form>
    <br>
    </div>
    -->

    <!--
    <div class="box">
    <h2>Oakland County Jail</h2>

        <?php //$this->renderFeedbackMessages(); ?>

        <h3>Name Search</h3>
        <form action="<?php //echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtOCFN" placeholder="Search First Name" />
            <input type="text" name="txtOCLN" placeholder="Search Last Name" />
            <input type="submit" name="btnOC" class="login-submit-button" value="Search"/>
	    <br>
	    <label for="ckOCOr">Check for 'or' search</label><input type="checkbox" name="ckOCOr" id="ckOCOr">
        </form>
    <br>
    </div>
    -->

    <!--
    <div class="box">
    <h2>Wayne County Jail</h2>

        <?php //$this->renderFeedbackMessages(); ?>

        <h3>Name Search</h3>
        <form action="<?php //echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtWCFN" placeholder="Search First Name" />
            <input type="text" name="txtWCLN" placeholder="Search Last Name" />
            <input type="submit" name="btnWC" class="login-submit-button" value="Search"/>
	    <br>
	    <label for="ckWCOr">Check for 'or' search</label><input type="checkbox" name="ckWCOr" id="ckWCOr">
        </form>
    <br>
    </div>
    -->

    <!--
    <div class="box">
    <h2>Crisnet</h2>

        <?php //$this->renderFeedbackMessages(); ?>

        <h3>Name Search</h3>
        <form action="<?php //echo Config::get('URL'); ?>table/index" method="post">
            <input type="text" name="txtCRFN" placeholder="Search First Name" />
            <input type="text" name="txtCRLN" placeholder="Search Last Name" />
            <input type="submit" name="btnCR" class="login-submit-button" value="Search"/>
	    <br>
	    <label for="ckCROr">Check for 'or' search</label><input type="checkbox" name="ckCROr" id="ckCROr">
        </form>
    <br>
    </div>
    -->

</div>
