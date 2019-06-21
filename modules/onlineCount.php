<?php
/** @var module $this */
foreach ($this->bluestats->plugins as $plugin) {
    /** @var \BlueStats\API\plugin $plugin */
    if ($plugin::$pluginType == 'query') {
        $this->loadPlugin($plugin->name);
        if (isset($this->plugins[$plugin->name])) {
            $statusPlugin = $this->plugins[$plugin->name];
            break;
        }
    }
}
if (!isset($statusPlugin))
    return;

echo count($plugin->onlinePlayers());
