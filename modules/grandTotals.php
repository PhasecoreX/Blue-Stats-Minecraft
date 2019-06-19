<?php
/** @var module $this */
$blocks_names = json_decode(file_get_contents($this->bluestats->appPath . "/items.json"), TRUE);

$render = function ($module, $plugin, $blocks_names) {
    $output = "";

    if (!isset($plugin->database['groups'])) {
        $plugin->database['groups'] = [];
    }

    // First render the groups defined in the plugin definition
    foreach ($plugin->database['groups'] as $groupId => $info) {
        // Set default stat options
        if (!isset($info['display'])) $info['display'] = TRUE;

        // If group is set to not display, break now to stop rendering
        if (!$info['display']) continue;

        $output .= "<h4>{$plugin->database["groups"][$groupId]["name"]}</h4>";
        $table  = New Table();

        foreach ($plugin->database["groups"][$groupId]['stats'] as $stat) {
            $values = [$plugin->database['stats'][$stat]['name']];
            $data   = $plugin->stats->sum($stat);
            // Get aggregate stat formatter
            $formatter = "int";
            foreach ($plugin->database['stats'][$stat]["values"] as $columns) {
                if ($columns['aggregate']) {
                    $formatter = $columns['dataType'];
                    break;
                }
            }
            array_push($values, $module->bluestats->formatter->format($data, $formatter));
            call_user_func_array([$table, 'addRecord'], $values);
        }

        // Generate header for table
        $values = [];

        foreach ($plugin->database["groups"][$groupId]['headers'] as $entry) {
            array_push($values, $entry);
        }
        call_user_func_array([$table, 'makeHeader'], $values);

        $output .= $table->tableToHTML(FALSE);
    }

    return $output;
};

if (isset($this->args[0]))
    return print($render($this, $this->bluestats->plugins[$this->args[0]], $blocks_names));

$output = "";

/** @var \BlueStats\API\plugin $plugin */
foreach ($this->bluestats->plugins as $plugin) {
    if ($plugin::$isMySQLplugin)
        $output .= "<h3>$plugin->name Grand Totals</h3>" . $render($this, $plugin, $blocks_names);
}

echo $output;
