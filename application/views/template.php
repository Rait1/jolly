<!DOCTYPE html>
<html lang="en">
<head>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <meta charset="utf-8">
    <title>Jolly</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">


</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">Jolly</a>

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <!--/.uus osa -->

            <ul class="nav">
                <li class="active">
                    <a href="<?=URL::base()?>login">Login</a>
                </li>
            </ul>

            </div>
        <!--/.TODO: add logout link, hide one of the links depending on user authentication status, implement logout.-->

           <!--/.uus osa -->
            <!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class=" container">

                    <?=$content?>

        </div>
        <!-- /container -->

        <?=Notify::render()?> <!-- -->
</body>
</html>


