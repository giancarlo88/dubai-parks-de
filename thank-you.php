<?php

/**
 * Thank you page
 */
$thisPage = "register";
require './config.php';
require './template/UserEntriesModel.php';
require './template/header.php';
// require './template/navigation.php';

$show_voucher = true;
$last_page = true;


?>


<div id="ty" class="app-wrapper">

	<div class="ty__bg-wrapper">

			<div class="ty__overlay">
			<div class = "ty__text">
			<h2>Glückwunsch</h2>
			<h2>Du hast den Code geknackt und nimmst am Gewinnspiel teil um eine Reise nach Dubai mit Übernachtung im JA Hotel and Flug mit Emirates zu gewinnen.</h2>
			<h2>ETWAS <span class = "bolded">ERSTAUNLICHES</span> KOMMT...</h2>
			<h1><span class = "ty__date txt-highlight bolded">31/10/16</span></h1>
			<p>Jetzt teilen, um Deine Gewinnchancen zu erhöhen</p>
			<!--<p style="display: none" class="text-center">You have invited <?php echo isset($userTotalInvites) ? $userTotalInvites . ((int)$userTotalInvites === 1 ? ' friend' : ' friends' ) : '0 friends'; ?> and you now <span class="line-break">have <?php echo isset($userTotalEntries) ? $userTotalEntries . ((int)$userTotalEntries === 1 ? ' entry' : ' entries') : '0 entries'; ?>.</span></p>-->
</div>

			<div class="social-share clearfix">
				<ul class="list-inline text-center">
					<li>
						<a class="ss-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(AppFunction::getAppUrl()); ?>"
							data-title="<?php echo AppConfig::get('app_title'); ?>"
							data-link="<?php echo AppFunction::getAppUrl(); ?>"
							data-picture="<?php echo AppFunction::getFeaturedImage(); ?>"
							data-caption="<?php echo AppFunction::getAppUrl(); ?>"
							data-description="<?php echo AppConfig::get('facebook_share_message') ?>"
							>

							<span>
								<img class="ty__sm-icon" src = "./assets/images/fb_icon.png">
							</span>
						</a>
					</li>
					<li>
						<a class="ss-twitter" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(AppConfig::get('twitter_tweet')); ?>&url=<?php echo urlencode(AppConfig::get('twitter_url')); ?>">
							
							<span>
								<img class="ty__sm-icon sm-twitter" src = "./assets/images/twitter_icon.png">
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

<div class="ty__container-tc-priv">
				<div class="tc">
					<a target="_blank" href="<?php echo AppConfig::get('app_terms'); ?>">Teilnahmebedingungen</a>
				</div>
				<div class="privacy">
					<a target="_blank" href="<?php echo AppConfig::get('app_privacy'); ?>">Datenschutzerklärung</a>
				</div>
				<img src = "./assets/images/JA_Resorts_Hotels.png">
				<img src = "./assets/images/emirates_logo.jpg">
			</div>

	</div>		
			<script>

				// if (screen.width > 1025) {
				// 	window.setTimeout(function() {
				// 	    window.location = 'getcoupon.php';
				// 	  }, 1000);
				// }

				
			</script>
		</div>

		<?php

require './template/footer.php';

?>