<div class="container">
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h1>URBN Technologies</h1>
	<!--<iframe height="3200" width="100%" src="http://urbntechnology.com/" scrolling="no"></iframe>-->

    <div class="box">
	<h3>Row Counts</h3>
        <p>Timeline Messages Row Count: <?php echo $this->timelinecount; ?></p>
        <p>Timeline Comments Row Count: <?php echo $this->commentcount; ?></p>
        <p>MIDC Row Count: <?php echo $this->midccount; ?></p>
        <p>Twitter Row Count: <?php echo $this->twittercount; ?></p>
        <p>Macomb County Jail Row Count: <?php echo $this->macombjailcount; ?></p>
        <p>Oakland County Jail Row Count: <?php echo $this->oaklandjailcount; ?></p>
        <p>Wayne County Jail Row Count: <?php echo $this->waynejailcount; ?></p>
        <p>Crisnet Row Count: <?php echo $this->crisnetcount; ?></p>
    </div>

</div>
