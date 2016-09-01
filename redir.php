<?php

/**
 * Default home page
 */

require './config.php';

require './template/header.php';
// require './template/navigation.php';

?>

<script>
	top.location.href = '<?php print "https://apps.facebook.com/".AppConfig::get("facebook_namespace"); ?>';
</script>

<?php

require './template/footer.php';

?>