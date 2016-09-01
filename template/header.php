<?php
$thisPage;
/**
 * Header template
 */
?>

<!doctype html>
<html xmlns:fb="http://ogp.me/ns/fb#" class="desktop">
<head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb# <?php echo AppConfig::get('facebook_namespace'); ?>:http://ogp.me/ns/fb/<?php echo AppConfig::get('facebook_namespace'); ?>">
    <title><?php echo AppConfig::get('app_title'); ?></title>

    <!-- Charset encoding -->
    <meta charset="utf-8">

    <!-- Viewport optimization -->
    <meta name="viewport" content="initial-scale=1.0,width=device-width">

    <!-- Metadata -->
    <meta name="description" content="<?php echo AppConfig::get('app_description'); ?>">

    <!-- Facebook OG metadata -->
    <meta property="fb:app_id" content="<?php echo AppConfig::get('facebook_app_id'); ?>">
    <meta property="og:title" content="<?php echo AppConfig::get('app_title'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo AppFunction::getAppUrl(); ?>">
    <meta property="og:image" content="<?php echo AppFunction::getFeaturedImage(); ?>">
    <meta property="og:description" content="<?php echo AppConfig::get('app_description'); ?>">

    <!-- Twitter Card metadata -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="<?php echo AppConfig::get('twitter_handle'); ?>">
    <meta name="twitter:title" content="<?php echo AppFunction::getAppUrl(); ?>">
    <meta name="twitter:description" content="<?php echo AppConfig::get('app_description'); ?>">
    <meta name="twitter:url" content="<?php echo AppFunction::getAppUrl(); ?>">
    <meta name="twitter:image" content="<?php echo AppFunction::getFeaturedImage(); ?>">

    <!-- Stylesheet -->
    
    <link rel="stylesheet" href="../../<?php echo AppConfig::get('assets'); ?>/css/font-awesome-4.6.3/css/font-awesome.min.css">
<!--<link rel="stylesheet" href="../../<?php echo AppConfig::get('assets'); ?>/css/bootstrap-3.3.7-dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../../<?php echo AppConfig::get('assets'); ?>/css/style.css">
    <!-- Favicons -->
    <link rel="shortcut icon" href="<?php echo AppConfig::get('assets'); ?>/images/favicon.png">
    
     <!--[if lt IE 10]>
    <style>
        .icon-mail {
            padding-left: 33px;
        }

        #inviteViaEmail {
            color: #1592c2;
        }
    </style>

    <![endif]-->

    <!--[if lt IE 9]>
    <style>
    #closeInviteViaEmailForm {
        color: white;
        opacity: 0.8;
        filter: alpha(opacity=80);
    }
    </style>
    <script>
    document.createElement('video');
    </script>
    <![endif]-->

</head>
<body>
    <div class = "hd__page-header">
    <img class = "hd__tc-logo" src = "./assets/images/tc_logo_de.png">
    <img class = "hd__dp-logo" src = "./assets/images/dp_logo_header.png">
   
        
    <div class = "hd__navigation-container">
    <div id = "hd__navigation" class = "hd__navigation">
    <ul>
    <li <?php if ($thisPage == 'tab') {echo "class = 'currentPage'";}?>><a href = "tab.php">HOME</a></li> |
        <li <?php if ($thisPage == "register") {echo "class = 'currentPage'";}?>><a href = "register.php">TEILNEHMEN</a></li> |
        <li <?php if ($thisPage == "tcs") {echo "class = 'currentPage'";}?>><a href = "terms-conditions.php">AGBs</a></li>
    </ul>
    </div>
    </div>
</div>