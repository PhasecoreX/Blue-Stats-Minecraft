<?php
/** @var module $this */
foreach ($this->bluestats->plugins as $plugin) {
    /** @var \BlueStats\API\plugin $plugin */
    if ($plugin::$isMySQLplugin)
        continue;
    $this->loadPlugin($plugin->name);
    if (isset($this->plugins[$plugin->name])) {
        $statusPlugin = $this->plugins[$plugin->name];
        break;
    }
}
if (!isset($statusPlugin))
    return;

if (in_array($this->player->name, $plugin->onlinePlayers())) {
    echo '<span class="label label-success">Online</span>';
}
else {
    echo '<span class="label label-danger">Offline</span>';
}
