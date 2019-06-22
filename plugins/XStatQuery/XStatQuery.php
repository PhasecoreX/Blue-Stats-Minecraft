<?php

namespace BlueStats\Plugin;

use BlueStats\API\plugin;

class XStatQuery extends plugin
{
    public static $pluginType    = 'query';
    public static $isMySQLplugin = TRUE;
    public        $name          = 'XStatQuery';
    public        $database      = [
                      "prefix" => "xstat_",
                  ];
    public        $onlinePlayers;

    public function onlinePlayers () {
        if (isset($this->onlinePlayers))
            return $this->onlinePlayers ?: [];

        $this->onlinePlayers = array();
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        $query = "SELECT ps1.value FROM {$this->database["prefix"]}player_string ps1 JOIN {$this->database["prefix"]}player_string ps2 ON ps2.uuid = ps1.uuid AND ps2.type = 'status' AND ps2.value != 'offline' WHERE ps1.type = 'name'";

        if ($stmt->prepare($query)) {
            $stmt->execute();

            $output = array();
            foreach ($stmt->get_result()->fetch_all(MYSQLI_NUM) as $row) {
                $output[] = $row[0];
            }

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            $this->onlinePlayers = $output;
        }
        else if ($stmt->error && DEBUG)
            print($stmt->error);

        return $this->onlinePlayers ?: [];
    }

}
