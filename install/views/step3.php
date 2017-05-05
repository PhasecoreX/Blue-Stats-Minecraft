<?php

require dirname(dirname(__DIR__)) . "/plugins/query/minecraftQuery.php";

use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

$success = true;

if (isset($_POST["bs-host"]) && isset($_POST["bs-username"]) && isset($_POST["bs-password"]) && isset($_POST["bs-db"])) {
    /* Connect to MySQL */
    $mysqli = new mysqli(
        $_POST["bs-host"],
        $_POST["bs-username"],
        $_POST["bs-password"],
        $_POST["bs-db"]
    );

    if ($mysqli->connect_error) {
        echo "<i class=\"fa fa-times text-warning\"></i> <b>BlueStats database connetion error:</b> " . $mysqli->connect_error . "<br>";
        $success = false;
    } else {
        echo "<i class=\"fa fa-check text-success\"></i> BlueStats database success!<br>";
    }

} else {
    echo "<i class=\"fa fa-times text-warning\"></i> BlueStats database details missing<br>";
    $success = false;
}

if (isset($_POST["lolstats-enable"]) && $_POST["lolstats-enable"] == "on") {
    if (isset($_POST["lolstats-host"]) && isset($_POST["lolstats-username"]) && isset($_POST["lolstats-password"]) && isset($_POST["lolstats-db"])) {
        /* Connect to MySQL */
        $mysqli = new mysqli(
            $_POST["lolstats-host"],
            $_POST["lolstats-username"],
            $_POST["lolstats-password"],
            $_POST["lolstats-db"]
        );

        if ($mysqli->connect_error) {
            echo "<i class=\"fa fa-times text-warning\"></i> <b>Lolmewn Stats database connetion error:</b> " . $mysqli->connect_error . "<br>";
            $success = false;
        } else {
            echo "<i class=\"fa fa-check text-success\"></i> Lolmewn Stats success!<br>";
        }

    } else {
        echo "<i class=\"fa fa-times text-warning\"></i> Lolmewn Stats database details missing<br>";
        $success = false;
    }
}

if (isset($_POST["mcmmo-enable"]) && $_POST["mcmmo-enable"] == "on") {
    if (isset($_POST["mcmmo-host"]) && isset($_POST["mcmmo-username"]) && isset($_POST["mcmmo-password"]) && isset($_POST["mcmmo-db"])) {
        /* Connect to MySQL */
        $mysqli = new mysqli(
            $_POST["mcmmo-host"],
            $_POST["mcmmo-username"],
            $_POST["mcmmo-password"],
            $_POST["mcmmo-db"]
        );

        if ($mysqli->connect_error) {
            echo "<i class=\"fa fa-times text-warning\"></i> <b>Mcmmo database connetion error:</b> " . $mysqli->connect_error . "<br>";
            $success = false;
        } else {
            echo "<i class=\"fa fa-check text-success\"></i> Mcmmo success!<br>";
        }

    } else {
        echo "<i class=\"fa fa-times text-warning\"></i> Mcmmo database details missing<br>";
        $success = false;
    }
}

$query = new MinecraftQuery();
if (function_exists('fsockopen')) {
    if (isset($_POST['ip']) && isset($_POST['port'])) {
        if (isset($_POST['query-enable'])) {
            if ($_POST['query-enable'] == "on") {
                try {
                    $query->Connect($_POST['ip'], $_POST['port']);
                    echo "<i class=\"fa fa-check text-success\"></i> Successfully queried server<br>";
                } catch (MinecraftQueryException $e) {
                    echo "<i class=\"fa fa-times text-warning\"></i> Server query failed<br>";
                    $success = false;
                }
            }
        }
    }
}

if (isset($_POST["theme"])) {
    if (in_array($_POST["theme"], ["webstatsx","material"])) {
        $_SESSION["theme"] = $_POST["theme"];
    }
}


$_SESSION = $_POST;

if ($success) {
    echo '<a class="btn btn-success pull-right" href="?step=4">Install</a>';
} else {
    echo '<a class="btn btn-danger pull-left"  href="?step=2">Back</a>';
}
