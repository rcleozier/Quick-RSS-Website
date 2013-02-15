<?php

include('config.php');
include('classes/bootstrap.php');

$sites = new bootstrap($keywords,$setApplicationName,$setDeveloperKey,$categories_array);
$categories = $sites->getCategories();
$posts  = $sites->displayFeeds();

?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

    <meta charset="utf-8" />

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title> <?=$site_name;?></title>

    <meta name="description" content="" />
    
     <!-- Mobile viewport optimized: j.mp/bplateviewport -->
 	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,bold" rel="stylesheet" /> <!-- Load Droid Serif from Google Fonts -->
    
    <!-- All JavaScript at the bottom, except for Modernizr and Respond.
    	Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries -->
    <script src="../assets/js/modernizr-1.7.min.js"></script>
    <script src="../assets/js/respond.min.js"></script>
</head>

<body>

<div id="wrapper">

    <header id="header" class="clearfix" role="banner">
    
        <hgroup>
            <h1 id="site-title"><a href="index.php"><?=$site_name;?></a></h1>
            <h2 id="site-description"><?=$description?></h2>
        </hgroup>
    
    </header> <!-- #header -->

<div id="main" class="clearfix">

	<!-- Navigation -->
    <nav id="menu" class="clearfix" role="navigation">
        <ul> 
            <li class="current"><a href="index.php">Home</a></li>
            <li><a href="store.php">Store</a></li>
        </ul>
    </nav> <!-- #nav -->
    
    <!-- Show a "Please Upgrade" box to both IE7 and IE6 users (Edit to IE 6 if you just want to show it to IE6 users) - jQuery will load the content from js/ie.html into the div -->
    
    <!--[if lte IE 7]>
        <div class="ie warning"></div>
    <![endif]-->
    
    <div id="content" role="main">
    

        <? foreach($posts as $post) { 
                foreach($post['feeds'] as $feed) { 
        ?>


        <article class="post">
        
            <h2 class="entry-title"><a href="#"><?=$feed['title']?></a></h2>
            
           <!--  <figure>
                <a href="<?=$feed['thumbnail_image'];?>"><img src="<?=$feed["thumbnail_image"]?>" alt="Post thumbnail" class="thumbnail alignleft" style="max-width:170px;max-height:170px"/></a>
            </figure> -->
            
            <div class="entry-content" style="text-align:left !important">
                    <?=$feed['description']?>
            </div> <!-- .entry-content -->
            
            <footer class="post-meta">
                <p>
                    In <a href="#" rel="category"><?=$post['category']?></a>
                    by <span class="author vcard"><a class="url fn n" href="<?=$feed['link']?>"><?=$feed['author']?></a></span>
                    on <?=$feed['published'];?>
                </p>
                <a href="<?=$feed['link']?>" class="more-link">Read more</a>
            </footer> <!-- .post-meta -->
        
        </article> <!-- .post 1 -->
        
        <hr /> <!-- Post seperator - Not the most optimal solution -->
        
        <? } } ?>

    </div> <!-- #content -->
    
    <aside id="sidebar" role="complementary">
    
        <aside class="widget">
            <h3>Categories</h3>
           
            <ul>
             <? foreach($categories as $cat) { ?>
                <li><a href="#"><?=$cat;?></a></li>
            
            <? } ?>
            </ul>
        </aside> <!-- .widget -->
        
    
        <aside class="widget">
            <h3>About Us</h3>
            
            <p>
                <?=$about_your_site?>
            </p>
        </aside> <!-- .widget -->
    
    </aside> <!-- #sidebar -->
    
</div> <!-- #main -->
    
    <footer id="footer">
        <!-- You're free to remove the credit link to Jayj.dk in the footer, but please, please leave it there :) -->
        <p>
            Copyright &copy; <?=date('Y')?> <a href="<?=$site_url;?>"><?=$site_name?></a>
        
        </p>
    </footer> <!-- #footer -->
    
    <div class="clear"></div>

</div> <!-- #wrapper -->

	<!-- JavaScript at the bottom for fast page loading -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>
</html>