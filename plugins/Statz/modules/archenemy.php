<?php
$config->setDefault("image-src", "http://cravatar.eu/avatar/{NAME}/64");
$imageSrc = $config->get("image-src");
$stmt = $plugin->mysqli->stmt_init();

$sql = "SELECT *, sum(value) as value 
FROM {$plugin->prefix}pvp INNER JOIN `{$plugin->prefix}players` on {$plugin->prefix}pvp.UUID = {$plugin->prefix}players.UUID 
WHERE `victim` = ?
GROUP BY {$plugin->prefix}pvp.UUID 
ORDER BY value Desc Limit 1";

if ($stmt->prepare($sql)) {
    $stmt->bind_param("s", $player->uuid);
    /* execute query */
    $stmt->execute();

    $output = array();

    /* fetch value */
    $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    /* close statement */
    $stmt->close();
}
if (!empty($output)):
    if ($url->useUUID) {
        $linkId = $output[0]["uuid"];
    } else {
        $linkId = $output[0]["name"];
    }
    ?>
    <div class="panel panel-default">
        <img src="<?= str_replace("{NAME}", $linkId, $imageSrc) ?>.png" alt="" style="width:100%;">

        <div class="panel-body">
            <h3><a href="<?= $url->player($linkId) ?>"><?= $output[0]["name"] ?></a></h3>
            <h6 class="text-muted"><?= $player->name ?>'s Arch
                Enemy</h6>
        </div>
    </div>
<?php endif; ?>