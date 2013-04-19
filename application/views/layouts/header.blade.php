<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Everyday Folk</title>
        {{ Asset::container('bootstrapper')->styles(); }}
    </head>

    <body>
    <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <div class="nav-collapse">
                        <ul class="nav">
                            @section('navigation')
                            <li><a href="/">Home</a></li>
                            <li><a href="/home/about">About</a></li>
                            <li><a href="/image">Instagram</a></li>
                            <li><a href="/image/feed">Feed</a></li>
                            <li><a href="/">Location</a></li>
                            <li><a href="/users">Users</a></li>
                            @yield_section
                        </ul>
                    </div><!--/.nav-collapse -->
                    <input class="search" onblur="search tags" value="Search Tags" onclick="$(this).val('');" />
                </div>
            </div>
        </div>
    <header class="container">
			<h1>Laravel</h1>
			<h2>A Framework For Web Artisans</h2>

			<p class="intro-text" style="margin-top: 45px;">
			</p>
		</header>

        <div class="container">
            @yield('main')
            <hr>
            <footer>
            <p>&copy; Everyday Folk</p>    
            </footer>
            
        </div> <!-- /container -->
        {{ Asset::container('bootstrapper')->scripts(); }}
    </body>
</html>