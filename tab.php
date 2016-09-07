<?php
$thisPage = "tab";
/**
 * Default tab page
 */

require './config.php';
require './template/header.php';
require './vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
$detect = new Mobile_Detect;


// require './template/navigation.php';

$black_logos = false;

if ( isset($show_voucher) && $show_voucher ) { 
	$banner_url = "http://xyz";
	$url_target= "blank";
 }
else {
	$banner_url = "./getcoupon.php";
	$url_target= "self";
}

?>

<div class="app-wrapper">
	<div>
		<div class = "tab__inner">
			<?php
			if ($detect->isMobile()) {
			echo '<div class = "tab__mobile-bg"><br></div>';}
			// echo '<img class = "tab__mobile-bg" src = "./assets/images/bg_ring.jpg">';}

			else {
			echo '<video playsinline autoplay muted loop class = "bgvid"><source src = "assets/videos/dubai_parks.mp4"></video>';} 
			?>
			<div class="container tab__overlay">
			<!--<div class="logo clearfix">
				<img src="./assets/images/dubai-logo-white.png" />
			</div>-->

				<h2> ETWAS <span class = "bolded">ERSTAUNLICHES</span> KOMMT... </h2>
					<p class="tab__byline">Entschlüssel den Code um mit etwas Glück etwas <span class = "txt-highlight"> ERSTAUNLICHES zu GEWINNEN</span></p>
					<p>Logge Dich bei Facebook ein, um loszulegen</p>
				<a href="register.php"><img class = "tab__fb-login" src = "./assets/images/login_btn.png"></a>
			</p>
			<p>&nbsp;</p>
</div>
</div>
</div>


<div class="tab__container-tc-priv">
				<div class="tc">
					<a target="_blank" href="<?php echo AppConfig::get('app_terms'); ?>">Teilnahmebedingungen</a>
				</div>

				<div class="privacy">
					<a target="_blank" href="<?php echo AppConfig::get('app_privacy'); ?>">Datenschutzerklärung</a>
				</div>
			</div>
		</div>
</div>
<?php

require './template/footer.php';

?>