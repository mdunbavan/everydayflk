<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Everyday Folk</title>
        {{ Asset::container('bootstrapper')->styles(); }}
        <!--<link href="<?php echo URL::to_asset('bundles/bootstrapper/css/bootstrap.css'); ?>" media="all" type="text/css" rel="stylesheet">-->
        <link href="<?php echo URL::to_asset('public/icomoon13696/style.css'); ?>" media="all" type="text/css" rel="stylesheet">
        <link href="<?php echo URL::to_asset('laravel/css/style.css'); ?>" media="all" type="text/css" rel="stylesheet">
    </head>
    <body>
	<header id="top">
    <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <div class="nav-collapse">
                        <ul class="nav">
                            @section('navigation')
                            <li><a href="/">Home</a></li>
                            <li><a href="/home/about">About</a></li>
                            <li><a href="/image">#folkdetails</a></li>
                            <li><a href="/image/feed">#folkbluemonday</a></li>
                            @yield_section
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
            <div id="user" style="display:none;">
            	<?php echo '<img src="'; echo $current_user->getProfilePicture(); echo '"'; echo '/>'; ?>
                	<p>Username: <?php echo '<p>'; echo $current_user; echo '</p>'; ?></p>
                	<p>Total following: <?php echo $current_user->getFollowsCount() ?></p>
                	<p>Total following you: <?php echo $current_user->getFollowersCount() ?></p>  
            </div>
        </div>
        <div id="profile">
        	<div class="container">
        		<h1 class="span2">Folk</h1>
        		<ul class="nav" id="tags">
                    @section('navigation')
                       <li><a href="/image">#folkdetails</a></li>
                       <li><a href="/image/feed">#folkbluemonday</a></li>
                 </ul>
        	</div>             	
        </div>
		</header>

        <div id="content">
        	<div class="container">
            @yield('main')
            </div>
            <hr>
            <footer>
            <p>&copy; Everyday Folk</p>    
            </footer>
            
        </div> <!-- /container -->
        {{ Asset::container('bootstrapper')->scripts(); }}
        {{ HTML::script(URL::$base.'/public/js/bootstrap-ajax.js') }}
        {{ HTML::script(URL::$base.'/public/js/functions.js') }}
    </body>
</html>