<?php
/** @var module $this */
$this->loadPlugin("Statz");

/** @var \BlueStats\API\plugin $plugin */
$plugin = $this->plugins['Statz'];

$this->config->setDefault("stats", ['votes', 'teleports', 'deaths', 'blocks_broken']);

$language = $this->config->get("language","BlueStats");
$stats   = $this->config->get("stats");
?>

<div class="row">
    <?php foreach ($stats as $stat): ?>
        <?php
        $data    = $plugin->stats->statList($stat, 1);
        $value = 0;
        $linkId  = "";

        if (isset($data[0])) {
            $value = $data[0]["aggregate"];

            if ($plugin->database['identifier'] == "id") {
                $username = $plugin->player->getNamefromID($data[0]['id']);
                $uuid     = $plugin->player->getUUIDfromID($data[0]['id']);
            }
            else {
                $username = $plugin->player->getNamefromID($plugin->player->getID($data[0]['id']));
                $uuid     = $data[0]['id'];
            }

            if ($this->bluestats->url->useUUID) {
                $linkId = $uuid;
            }
            else {
                $linkId = $username;
            }
        }

        $replace = $plugin->database['stats'][$stat]['text'][$language]['plural'];
        if ($value == 1)
            $replace = $plugin->database['stats'][$stat]['text'][$language]['single'];

        $display = $this->bluestats->formatter->format($value, $data[0]['data_type']);

        ?>
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="panel panel-default">
                <a href="<?= $this->bluestats->url->player($linkId) ?>">
                    <img src="https://crafatar.com/avatars/<?= isset($uuid) ? $uuid : "00000000000000000000000000000000" ?>?overlay&size=300.png"
                     alt="" style="width:100%;">
                </a>
                <div class="panel-body">
                    <h4 style="margin-top:0;padding:0;"><a
                                href="<?= $this->bluestats->url->player($linkId) ?>"><?= isset($username) ? $username : "Nobody" ?></a>
                    </h4>
                    <h6 style="margin-top:0;padding:0;"
                        class="text-muted"><?= str_replace("{VALUE}", $display, $replace) ?></h6>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
