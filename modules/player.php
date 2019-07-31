<?php

// Option to whether or not to put the player stats in a bootstrap panel
$this->config->setDefault("panelEnable", TRUE);

$this->panelEnable = $this->config->get("panelEnable");

/** @var module $this */
$blocks_names = json_decode(file_get_contents($this->bluestats->appPath . "/items.json"), TRUE);

$render = function ($module, $plugin, $blocks_names) {
    $module->config->setDefault("combineWorlds", TRUE);
    $combineWorlds = $module->config->get("combineWorlds");

    $output = "";

    if (!isset($plugin->database['groups'])) {
        $plugin->database['groups'] = [];
    }

    // First render the groups defined in the plugin definition
    foreach ($plugin->database['groups'] as $groupId => $info) {
        // Set default stat options
        $pageName = "player";
        if (!isset($info['display']) || (is_bool($info['display']) && $info['display'])) {
            $info['display'] = array($pageName);
        } else if (!$info['display']) {
            $info['display'] = array();
        }

        // If stat is set to not display, continue now to stop rendering
        if (!in_array($pageName, $info['display'])) continue;

        $table  = New Table();

        foreach ($plugin->database["groups"][$groupId]['stats'] as $stat) {
            $values = [$plugin->database['stats'][$stat]['name']];
            $data   = $plugin->stats->player($module->player, $stat, [
                "summary" => TRUE,
            ]);
            // Get aggregate stat name and formatter
            $aggregateName = "value";
            $formatter = "int";
            foreach ($plugin->database['stats'][$stat]["values"] as $columns) {
                if ($columns['aggregate']) {
                    $aggregateName = $columns['column'];
                    $formatter = $columns['dataType'];
                    break;
                }
            }
            foreach ($data[0] as $key => $entry) {
                if ($key == $aggregateName)
                    array_push($values, $module->bluestats->formatter->format($entry, $formatter));
            }
            call_user_func_array([$table, 'addRecord'], $values);
        }

        // Generate header for table
        $values = [];

        foreach ($plugin->database["groups"][$groupId]['headers'] as $entry) {
            array_push($values, $entry);
        }
        call_user_func_array([$table, 'makeHeader'], $values);

        if ($this->panelEnable) {
            $output .= "<div class='row'>";
            $output .= "    <div class='col-md-12'>";
            $output .= "        <div class=\"panel panel-default\">";
            $output .= "            <div class=\"panel-heading\">";
            $output .= "                <h4 class=\"panel-title\">{$plugin->database["groups"][$groupId]["name"]}</h4>";
            $output .= "            </div>";
            $output .= "            <div class=\"panel-body\">";
            $output .= "                ".$table->tableToHTML(FALSE);
            $output .= "            </div>";
            $output .= "        </div>";
            $output .= "    </div>";
            $output .= "</div>";
        } else {
            $output .= "<h4>{$plugin->database["groups"][$groupId]["name"]}</h4>";
            $output .= $table->tableToHTML(FALSE);
        }
    }

    // Loop through all defined stats in plugin definition
    foreach ($plugin->database['stats'] as $stat => $info) {
        // Set default stat options
        $pageName = "player";
        if (!isset($info['display']) || (is_bool($info['display']) && $info['display'])) {
            $info['display'] = array($pageName);
        } else if (!$info['display']) {
            $info['display'] = array();
        }

        // If stat is set to not display, continue now to stop rendering
        if (!in_array($pageName, $info['display'])) continue;

        $statName = $plugin->database["stats"][$stat]["name"];
        $table    = New Table();

        // Get stats
        $data = $plugin->stats->player($module->player, $stat, [
            "combineWorlds" => $combineWorlds,
        ]);

        // Get aggregate stat name
        $aggregateName = "value";
        foreach ($info["values"] as $column) {
            if ($column['aggregate']) {
                $aggregateName = $column['column'];
                break;
            }
        }

        // If retrieved stats are empty, don't bother displaying them
        if (!isset($data) ||
            empty($data) ||
            count($data) === 0 ||
            $data[0] === NULL ||
            $data[0][$aggregateName] === NULL)
            continue;

        foreach ($data as $key => $entry) {
            $values = [];
            $count  = 0;
            $itemID = 0;
            foreach ($entry as $statt => $value) {
                if ($combineWorlds && $plugin->database["stats"][$stat]["values"][$count]["dataType"] == "world")
                    $count++;
                switch ($plugin->database["stats"][$stat]["values"][$count]["dataType"]) {
                    case "item_id":
                        // If the data collected was of type item_id, store it and wait until the data type is received.
                        $itemID = $value;
                        break;
                    case "item_type":
                        // If an item type value is recieved assume the item id has already been recieved. Thus, also print the name of the block into the table
                        $name = getBlockNameFromID($itemID, $value, $blocks_names) ?: getBlockNameFromID($itemID, 0, $blocks_names) ?: $itemID . '-' . $value;
                        array_push($values, $name);
                        break;
                    default:
                        array_push($values, $module->bluestats->formatter->format($value, $plugin->database["stats"][$stat]["values"][$count]["dataType"]));
                }
                $count++;
            }
            call_user_func_array([$table, 'addRecord'], $values);
        }

        // Generate header for table
        $values = [];

        foreach ($plugin->database["stats"][$stat]["values"] as $entry) {
            switch ($entry["dataType"]) {
                case "item_id":
                    break;
                case "item_type":
                    array_push($values, "Block");
                    break;
                case "world":
                    if (!$combineWorlds) array_push($values, $entry["name"]);
                    break;
                default:
                    array_push($values, $entry["name"]);
            }
        }
        call_user_func_array([$table, 'makeHeader'], $values);

        if ($this->panelEnable) {
            $output .= "<div class='row'>";
            $output .= "    <div class='col-md-12'>";
            $output .= "        <div class=\"panel panel-default\">";
            $output .= "            <div class=\"panel-heading\">";
            $output .= "                <h4 class=\"panel-title\">$statName</h4>";
            $output .= "            </div>";
            $output .= "            <div class=\"panel-body\">";
            $output .= "                ".$table->tableToHTML();
            $output .= "            </div>";
            $output .= "        </div>";
            $output .= "    </div>";
            $output .= "</div>";
        } else {
            $output .= "<h4>$statName</h4>";
            $output .= $table->tableToHTML();
        }
    }

    return $output;
};

if (isset($this->args[0])) {
    if ($this->args[0] == "basePlugin")
        $this->args[0] = $this->bluestats->basePlugin->name;
    return print($render($this, $this->bluestats->plugins[$this->args[0]], $blocks_names));
}

$output = "";

/** @var \BlueStats\API\plugin $plugin */
foreach ($this->bluestats->plugins as $plugin) {
    if ($plugin::$pluginType == 'stat')
        $output .= "<h3>$plugin->name</h3>" . $render($this, $plugin, $blocks_names);
}

echo $output;
