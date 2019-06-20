<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>BlueStats | Admin Interface</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/3.4.1/paper/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">BlueStats Admin</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="?logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php
            include "parts/plugins.php";
            ?>
        </div>
        <div class="col-md-9">
            <?php
            if (isset($message)) {
                echo '<div class="alert alert-info" role="alert">' . $message . '</div>';
            }
            ?>
            <?php
            /** @noinspection PhpIncludeInspection */
            include "parts/values.php";
            ?>
        </div>
    </div>
</div>
</body>
</html>
