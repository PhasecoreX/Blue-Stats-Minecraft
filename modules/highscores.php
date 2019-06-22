<?php

// Option to whether or not to put the highscore in a bootstrap panel
$this->config->setDefault("panelEnable", TRUE);
$this->config->setDefault("count", 10);
$this->config->setDefault("playerStatus", TRUE);

$panelEnable = $this->config->get("panelEnable");
$this->count = $this->config->get("count");

if($this->config->get("playerStatus")) {
    foreach ($this->bluestats->plugins as $plugin) {
        /** @var \BlueStats\API\plugin $plugin */
        if ($plugin::$pluginType == 'query') {
            $this->loadPlugin($plugin->name);
            if (isset($this->plugins[$plugin->name])) {
                $this->statusPlugin = $this->plugins[$plugin->name];
                break;
            }
        }
    }
}

$render = function ($module, $plugin, $stat) {
    $info = $plugin->database['stats'][$stat];

    $table = new Table();

    $aggregateID = "";

    // Get aggregate stat id
    foreach ($info["values"] as $id => $info) {
        if ($info['aggregate']) {
            $aggregateID = $id;
            break;
        }
    }

    $stats = $plugin->stats->statList($stat, $this->count);

    if (!isset($stats) || empty($stats))
        return FALSE;

    foreach ($stats as $row) {
        // If the ID is not the username, get the username from the id. If the ID is the username, don't bother with any database queries
        if ($plugin->database['identifier'] != 'name') $username = $plugin->player->getName($row['id']);
        else $username = $row['id'];

        // Do the same for the uuid
        if ($plugin->database['identifier'] != 'uuid') $uuid = $plugin->player->getUUID($row['id']);
        else $uuid = $row['id'];

        if ($this->bluestats->url->useUUID) {
            $name = "<a href=\"" . $module->bluestats->url->player($uuid) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\" height=\"32\" width=\"32\"> {$username}</a>";
        }
        else {
            $name = "<a href=\"" . $module->bluestats->url->player($username) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\" height=\"32\" width=\"32\"> {$username}</a>";
        }

        // Format according to datatype of value
        $row['aggregate'] = $module->bluestats->formatter->format($row['aggregate'], $plugin->database['stats'][$stat]["values"][$aggregateID]["dataType"]);

        $values = [];
        array_push($values, $name);

        if (isset($this->statusPlugin)) {
            if (in_array($username, $this->statusPlugin->onlinePlayers())) {
                array_push($values, '<span class="label label-success">Online</span>');
            }
            else {
                array_push($values,'<span class="label label-danger">Offline</span>');
            }
        }

        array_push($values, $row['aggregate']);


        call_user_func_array([$table, 'addRecord'], $values);
    }

    // Dynamically create headers based on config options
    $headers = [];
    array_push($headers, 'Player');
    if (isset($this->statusPlugin))
        array_push($headers, 'Status');
    array_push($headers, $info['name']);

    call_user_func_array([$table, 'makeHeader'], $headers);

    return $table->tableToHTML(FALSE);

};

/** @var module $this */
foreach ($this->bluestats->plugins as $plugin) {
    /** @var \BlueStats\API\plugin $plugin */
    if (!($plugin::$pluginType == 'stat'))
        continue;

    echo "<h2>{$plugin->name}</h2>";
    $displayedStat = array();

    if (!isset($plugin->database['groups'])) $plugin->database['groups'] = [];

    foreach ($plugin->database['groups'] as $groupId => $group) {
        echo "<h3>{$group['name']}</h3>";
        echo "<div class='row'>";
        foreach ($group['stats'] as $stat) {
            $info = $plugin->database['stats'][$stat];
            $renderResult = $render($this, $plugin, $stat);
            if (!$renderResult)
                continue;

            if ($panelEnable): ?>
                <div class='col-md-6'>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?= $info['name'] ?></h4>
                        </div>
                        <div class="panel-body">
                            <?= $renderResult; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class='col-md-6'>
                    <h4><?= $info['name'] ?></h4>
                    <?= $renderResult; ?>
                </div>
            <?php endif;

            $displayedStat[] = $stat;
        }
        echo "</div>";
    }

    echo "<div class='row'>";

    foreach ($plugin->database['stats'] as $stat => $info) {
        // Set default stat options
        if (!isset($info['display'])) $info['display'] = TRUE;
        if (!$info['display']) continue;
        if (in_array($stat, $displayedStat)) continue;

        $info = $plugin->database['stats'][$stat];
        $renderResult = $render($this, $plugin, $stat);
        if (!$renderResult)
            continue;

        if ($panelEnable): ?>
            <div class='col-md-6'>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?= $info['name'] ?></h4>
                    </div>
                    <div class="panel-body">
                        <?= $renderResult; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class='col-md-6'>
                <h4><?= $info['name'] ?></h4>
                <?= $renderResult; ?>
            </div>
        <?php endif;

        $displayedStat[] = $stat;
    }
    echo "</div>";
}
