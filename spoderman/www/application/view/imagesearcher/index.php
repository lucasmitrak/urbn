<div class="container">
    <!--<div class="box">-->

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

<?php
	echo $this->uploaded;
?>
    <form method="POST" enctype="multipart/form-data">
	<label for="flFaces">Face</label><input type="file" name="flFaces[]" id="flFaces" multiple="multiple">
	<br>
	<label for="flGuns">Gun</label><input type="file" name="flGuns[]" id="flGuns" multiple="multiple">
	<br>
	<label for="flStreetViews">Street View</label><input type="file" name="flStreetViews[]" id="flStreetViews" multiple="multiple">
	<br>
	<label for="flDrugs">Drugs</label><input type="file" name="flDrugs[]" id="flDrugs" multiple="multiple">
	<br>
	<input type="submit" name="btnFile" value="Upload Selected Files">
    </form>
    <!--</div>-->
</div>
