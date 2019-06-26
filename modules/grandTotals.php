<?php
// Option to whether or not to put the highscore in a bootstrap panel
$this->config->setDefault("panelEnable", TRUE);
$panelEnable = $this->config->get("panelEnable");

$render = function ($module, $plugin, $statGroup, $headers) {
    $table  = New Table();

    foreach ($statGroup as $stat) {
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

    foreach ($headers as $entry) {
        array_push($values, $entry);
    }
    call_user_func_array([$table, 'makeHeader'], $values);

    return $table->tableToHTML(FALSE);
};

echo "<h2>Grand Totals</h2>";

/** @var module $this */
foreach ($this->bluestats->plugins as $plugin) {
    /** @var \BlueStats\API\plugin $plugin */
    if (!($plugin::$pluginType == 'stat'))
        continue;

    echo "<h3>{$plugin->name}</h3>";

    if (!isset($plugin->database['groups'])) $plugin->database['groups'] = [];

    echo "<div class='row'>";
    
    foreach ($plugin->database['groups'] as $groupId => $group) {
        // Set default stat options
        $pageName = "grandTotals";
        if (!isset($group['display']) || (gettype($group['display']) == "boolean" && $group['display'])) {
            $group['display'] = array($pageName);
        } else if (!$group['display']) {
            $group['display'] = array();
        }

        // If stat is set to not display, continue now to stop rendering
        if (!in_array($pageName, $group['display'])) continue;


        if ($panelEnable): ?>
            <div class='col-md-6'>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?= $group['name'] ?></h4>
                    </div>
                    <div class="panel-body">
                        <?= $render($this, $plugin, $group['stats'], $plugin->database["groups"][$groupId]['headers']); ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class='col-md-6'>
                <h4><?= $group['name'] ?></h4>
                <?= $render($this, $plugin, $group['stats'], $plugin->database["groups"][$groupId]['headers']); ?>
            </div>
        <?php endif;
    }
    echo "</div>";
}
