<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>RadioTide</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/layout.css">
</head>
<body>
    <div class="container">
        <div class="header clearfix">
            <nav>
                <ul class="nav nav-pills pull-right">
                    <li role="presentation"><a href="/">Import</a></li>
                    <li role="presentation"><a href="/login">Login</a></li>
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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="/js/layout.js"></script>
</body>
</html>
