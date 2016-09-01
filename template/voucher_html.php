<?php
$voucher_btn = "download";
$banner_btn = "banner";
if ( isset($last_page) ) {
	$voucher_btn = "redeem";
	$banner_btn = "banner_2";
}

$banner_url = "./getcoupon.php"
?>
<div class="row voucher">
		<a style="position: relative" href="<?php print $banner_url; ?>" target="_<?php print $url_target; ?>">
				<div style="position: relative; display:inline-block">
					<img src="./assets/images/<?php print $banner_btn; ?>.jpg" />
					<div class="voucher-btn">
						<img src="./assets/images/<?php print $voucher_btn; ?>.png" />
					</div>
				</div>
		</a>
</div>