<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="shortcut icon" href="/images/favicon.ico">
        <title>{{ $title }}</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/images/logo.png" alt="" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="/blogs" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="/podcasts" class="nav-link">Podcasts</a>
                        </li>
                        <li class="nav-item">
                            <a href="/events" class="nav-link">Events</a>
                        </li>
                        <li class="nav-item">
                            <a href="/support" class="nav-link">Support</a>
                        </li>
                        <li class="nav-item">
                            <a href="/contact" class="nav-link">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <block:content>

            </block:content>
        </main>


        <footer>
            <div class="container">
                <div class="col">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="">Podcasts</a></li>
                        <li><a href="">Events</a></li>
                        <li><a href="">Support</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>