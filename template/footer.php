<?php

/**
 * Footer template
 */

if ($black_logos) {
	$logo_dubaiparks = "dubaiparks_black.png";
	$logo_tc = "tc_logo_footer_black.png";
}
else {
	$logo_dubaiparks = "dubaiparks_black.png";
	$logo_tc = "tc_logo_footer.png";
}

?>			
		<!--
		<div class="container-fluid footer-branding text-left">
			<div class="row">
				<div class="col-xs-3 logo-rec text-left">
					<a target="_blank" href="<?php echo AppConfig::get('dubaiparks_link'); ?>">
						<img src="assets/images/<?php print $logo_dubaiparks; ?>" alt="">
					</a>
				</div>


				<div class="col-xs-3 text-center">
					<a target="_blank" href="<?php echo AppConfig::get('tc_link'); ?>">
						<img src="assets/images/<?php print $logo_tc; ?>" alt="">
					</a>
				</div>

				<div class="col-xs-3 logo-rec text-center">
					<a target="_blank" href="<?php echo AppConfig::get('moonpalace_link'); ?>">
						<img src="assets/images/moonpalace.png" alt="">
					</a>
				</div>


				<div class="col-xs-3 text-right">
					<a target="_blank" href="<?php echo "http://thomascookairlines.com" ?>">
						<img src="assets/images/tc_airlines_logo.png" alt="">
					</a>
				</div>


			</div>
		</div>
	</div>
</div>
-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<script src="assets/js/jquery.placeholderfallback.min.js"></script>
	<script src="assets/js/socialmedia.min.js"></script>
	<script src="assets/js/main.js?v=<?php echo time(); ?>"></script>
	<!--[if lt IE 10]>
        <script>
            (function() {
                jQuery('#firstNameField, #lastNameField, #emailField, #phoneField, friend-email').placeholderfallback();
            })();
        </script>
    <![endif]-->

	<?php

	if ( isset($last_page) ) {
		print "<script>";
		print 'if (screen.width > 660) {';
		print '$(".voucher a").attr("href", "http://www.thomascook.com/").attr("target", "blank");';
		print'}';
		print "</script>";
	}

	/**
	 * Live Reload script only for development environment
	 */
	if ( AppConfig::get('is_dev') )
		//echo '<script src="http://localhost:35729/livereload.js"></script>';

	?>

</body>
</html>