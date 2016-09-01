<?php
$thisPage = "register";
/**
 * Default tab page
 */

require './config.php';
require './template/header.php';


// require './template/navigation.php';


?>

<div class="app-wrapper">
<div class = "scr__instructions">
		<p>RUBBEL ALLE BEREICHE FREI UM DEN <span class = "txt-highlight">CODE ZU KNACKEN</span>. 
		SOBALD DU ALLE <span class = "bolded">6 ZAHLEN</span> AUFGEDECKT HAST, KANNST DU AM GEWINNSPIEL TEILNEHMEN.</p>
</div>
	<div class="scr__mystery-number-row">
		<div class = "scr__logo-number-container">
			<img class = "scr__mg-logo" src = "./assets/images/motiongate_logo.png">
			<div class = "scr__mystery-number scr__mystery-box1"><span class = "scr__mystery-number-text" id = "scr__mystery-number1"></span></div>
		</div>
		<div class = "scr__logo-number-container">
			<img src = "./assets/images/bollywood_parks_logo.png">
			<div class = "scr__mystery-number scr__mystery-box2"><span class = "scr__mystery-number-text" id = "scr__mystery-number2">&nbsp;</span></div>
		</div>
			<span class = "scr__big-slash">/</span>
		<div class = "scr__logo-number-container">
			<img src = "./assets/images/riverland_logo.png">
			<div class = "scr__mystery-number scr__mystery-box3"><span class = "scr__mystery-number-text" id = "scr__mystery-number3">&nbsp;</span></div>
		</div>
		<div class = "scr__logo-number-container">
			<img src = "./assets/images/legoland_waterpark_logo.png">
			<div class = "scr__mystery-number scr__mystery-box4"><span class = "scr__mystery-number-text" id = "scr__mystery-number4">&nbsp;</span></div>
		</div>
		<span class = "scr__big-slash">/</span>
		<div class = "scr__logo-number-container">
			<img src = "./assets/images/legoland_logo.png">
			<div class = "scr__mystery-number scr__mystery-box5"><span class = "scr__mystery-number-text" id = "scr__mystery-number5">&nbsp;</span></div>
		</div>
		
		<div class = "scr__logo-number-container">
			<img src = "./assets/images/lapita_logo.png">
			<div class = "scr__mystery-number scr__mystery-box6"><span class = "scr__mystery-number-text" id = "scr__mystery-number6">&nbsp;</span></div>
	</div>
	

	<div class = "s-wrapper">
	
	<div class="scr__scratch-container" id="js-container">
	<div class ="scr__scratch-overlay"><img id ="scratch-overlay" src = "overlay_v2.png"></div>
	<canvas class="scr__canvas" id="js-canvas1" ></canvas>
	<canvas class="scr__canvas" id="js-canvas2" ></canvas> 
	<canvas class="scr__canvas" id="js-canvas3" ></canvas> 
	<canvas class="scr__canvas" id="js-canvas4" ></canvas> 
	<canvas class="scr__canvas" id="js-canvas5" ></canvas> 
	<canvas class="scr__canvas" id="js-canvas6" ></canvas>
	<img id = "scr__scratch-underlay" class = "scr__scratch-underlay" src = "underlay_v2.png">
	</div>
	</div>
</div>
</div>

        	

</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/scratch.js"></script>
<?php

require './template/footer.php';

?>