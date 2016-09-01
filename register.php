<?php


/**
 * Default tab page
 */
$thisPage = "register";
require './config.php';
require './template/ValidateFormModel.php';
require './template/header.php';
// require './template/navigation.php';

?>
    <div class="app-wrapper">
        <div class="reg__bg-wrapper">
            <div class="reg__registration">
                <div class="reg__instructions">
                    <div class="reg__steps-container">
                        <img class = "reg__step-1-img" src = "./assets/images/DE_ENTER_STEP_1.png">
                            <div class="reg__button-container"> <span class="btn-fb-like">
								<div class="fb-like" data-href="https://facebook.com/thomascook" data-layout="button" data-action="like" data-show-faces="false" data-share="false">
								</div>
							</span> </div>
                        <dd class="reg__unlike-warning">Du hast Dich als Fan entfernt. Bitte klicke noch einmal auf "Gefällt mir".</dd>
                        <div class="reg__step-2">
                            <img class="reg__step-2-img" src="./assets/images/DE_ENTER_STEP_2.png">
                        </div>
                    </div>
                </div>
                <form id="registerForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" class="form-horizontal" role="form">
                    <div class="reg__form-container">
                        <input type="text" name="first_name" id="firstNameField" placeholder="Vorname" class="reg__form">
                        <input type="text" name="last_name" id="lastNameField" placeholder="Nachname" class="reg__form">
                        <input type="text" name="email" id="emailField" placeholder="Email-Adresse" class="reg__form">
                        <!--<div class="form-group">
						<label class="sr-only" for="emailField">Phone</label>
						<div class="col-sm-6 col-sm-offset-3">
							<input type="text" name="phone" id="phoneField" placeholder="Phone" class="form-control">
						</div>
					</div> -->
                        <p class="reg__mn-message">Hast Du den <span class="bold">Code</span> entschlüsselt? Trage ihn unten ein:</p>
                        <div class="reg__mystery-numbers">
                            <input id="num1" class="reg__mystery-number-form" type="text" pattern="[0-9]" placeholder="?" maxlength="1">
                            <input id="num2" class="reg__mystery-number-form" type="text" pattern="[0-9]" placeholder="?" maxlength="1">
                            <input id="num3" class="reg__mystery-number-form" type="text" pattern="[0-9]" placeholder="?" maxlength="1">
                            <input id="num4" class="reg__mystery-number-form" type="text" pattern="[0-9]" placeholder="?" maxlength="1">
                            <input id="num5" class="reg__mystery-number-form" type="text" pattern="[0-9]" placeholder="?" maxlength="1">
                            <input id="num6" class="reg__mystery-number-form" type="text" pattern="[0-9]" placeholder="?" maxlength="1"> </div>
                        <!--<div class = "reg__checkbox-container">
							<div class="reg__checkbox">
								<label>
									<input type="checkbox" checked name="dubaiparks_subscription" id="dubaiparksSubscriptionField"> I want to receive emails from Dubai Parks and Resorts
								</label>
							</div>
							<div class="reg__checkbox">
								<label>		
									<input type="checkbox" checked name="tc_subscription" id="tcSubscriptionField"> <div class = "reg__reg__long-checkbox">I want to sign up to receive marketing emails from Thomas Cook. 
									We will not pass on your data to third parties for marketing. 
									<a class = "txt-highlight" href="https://www.thomascook.com/privacy-policy/" target="_blank">View Privacy Policy</a></div>
								</label>
							</div>
						</div> -->
                        <div class="reg__btn-container">
                            <div class="text-center">
							<input type="text" class="app-cabacha" name="cabacha_<?php echo sha1(time()); ?>" value="">
							<input type="hidden" name="cabacha" value="cabacha_<?php echo sha1(time()); ?>">
							<input type="hidden" name="fbid" value="" id="fbidField">
                            <input type="submit" name="submit" value="Bestätigen" id="reg__submitBtn" class="button"> 
						</div>
                    </div>
                </form>
                </div>
            </div>
            <div class="reg__container-tc-priv">
                <div class="tc"> <a target="_blank" href="<?php echo AppConfig::get('app_terms'); ?>">Teilnahmebedingungen</a> </div>
                <div class="privacy"> <a target="_blank" href="<?php echo AppConfig::get('app_privacy'); ?>">Datenschutzerklärung</a> </div>
            </div>
        </div>
    </div>
    <?php require './template/footer.php'; ?>