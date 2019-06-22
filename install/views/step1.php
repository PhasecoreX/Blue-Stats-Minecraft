<?php $allowInstall = TRUE;
$processUser        = NULL;
if (function_exists('posix_getpwuid')) {
    $processUser = posix_getpwuid(posix_geteuid());
}
?>
Minimum PHP version: 5.2.0
<?php
if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
    echo '<i class="fa fa-check text-success"></i> (PHP version ' . PHP_VERSION . ' is installed)';
}
else {
    echo '<i class="fa fa-times text-warning"></i> (PHP version ' . PHP_VERSION . ' is installed)';
    $allowInstall = FALSE;
}
?>

<h2>Php modules:</h2>
<?php
if (function_exists('fsockopen')) {
    echo 'fsockopen is installed <i class="fa fa-check text-success"></i>';
}
else {
    echo 'fsockopen is not installed <i class="fa fa-times text-warning"></i> (MC query will be disabled)';
}
?>
<br>
<?php
if (function_exists('mysqli_fetch_all')) {
    echo 'MySQLnd is installed <i class="fa fa-check text-success"></i>';
}
else {
    echo 'MySQLnd is not installed <i class="fa fa-times text-warning"></i> (Install or activate MySQLnd before continuing))';
    $allowInstall = FALSE;
}
?>

<h2>File permissions:</h2>
<?php
if (is_writable('../')) {
    echo 'Can write to BlueStats root <i class="fa fa-check text-success"></i>';
}
else {
    echo 'Can not write to BlueStats root <i class="fa fa-times text-warning"></i> (Must create config files manually)';
}
?>

<br>

<?php
if (is_writable('../cache/')) {
    echo 'Can write to cache folder <i class="fa fa-check text-success"></i>';
}
else {
    echo 'Can not write to cache folder <i class="fa fa-times text-warning"></i> (Cache will not work)';
    if ($processUser !== NULL) { ?>
        <br>To fix, run<br>
        <pre>
sudo chown <?= $processUser['name'] ?> <?= dirname(dirname(__DIR__)) ?>/cache -R
sudo chmod 755 <?= dirname(dirname(__DIR__)) ?>/cache -R</pre>
        <?php
    }
    $allowInstall = FALSE;
}
?>


<?php
if ($allowInstall === TRUE) {
    echo '<a class="btn btn-success pull-right" href="?step=2">Next Step</a>';
}
?>
