<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>RadioTide</title>
    <meta name="description" content="A simple service to import Rdio data into Tidal.">
    <meta name="keywords" content="radio tide rdio tidal data import export sync service backup transfer api simple">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/layout.css">
</head>
<body>
    <div class="container">
        <div class="header clearfix">
            <nav>
                <ul class="nav nav-pills pull-right">
                <?php if ($this->is_logged_in()): ?>
                    <li role="presentation"><a href="/">Import</a></li>
                    <li role="presentation"><a href="/logout" id="logout">Logout</a></li>
                <?php else: ?>
                    <li role="presentation"><a href="/login">Login</a></li>
                <?php endif ?>
                </ul>
            </nav>
            <h3 class="text-muted">RadioTide</h3>
        </div>
    </div>

    <?= $this->section('content') ?>

    <div class="container">
        <div class="footer text-center text-muted">
            <p>&copy; 2015 <a href="https://shadowhand.me/">shadowhand</a></p>
            <p><small>
                Not affiliated with <a href="http://rdio.com/">Rdio</a> or <a href="http://tidal.com/">Tidal</a> in any way.
                Trademarks are owned by their respective parties.<br>
                Not responsible for damages that may result from using this service.
            </small></p>
        </div>
    </div>

    <a href="https://github.com/shadowhand/radiotide"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="/js/layout.js"></script>
</body>
</html>
