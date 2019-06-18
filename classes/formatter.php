<?php

class formatter {

    private $bluestats;

    public function __construct ($bluestats) {
        $this->bluestats = $bluestats;
    }

    public function playerName($value) {
        if ($this->bluestats->url->useUUID) {
            $uuid  = $this->bluestats->basePlugin->player->getUUIDfromName($value);
            return "<a href=\"" . $this->bluestats->url->player($uuid) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\"> {$value}</a>";
        }
        return "<a href=\"" . $this->bluestats->url->player($value) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\"> {$value}</a>";
    }

    public function playerUUID($uuid) {
        $name = $this->bluestats->basePlugin->player->getNamefromUUID($uuid);
        if ($this->bluestats->url->useUUID)
            return "<a href=\"" . $this->bluestats->url->player($uuid) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\"> {$name}</a>";
        return "<a href=\"" . $this->bluestats->url->player($name) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\"> {$name}</a>";
    }

    public function date($value) {
        if (is_numeric($value))
            return date('H:i m-d-y', $value/1000);
        return $value;
    }

    public function time($value) {
        return secondsToTime($value);
    }

    public function itemName($value) {
        return ucwords(str_replace('_', ' ', strtolower($value)));
    }

    public function format($value, $type) {
        switch ($type) {
            case "player_name":
                return $this->playerName($value);
                break;
            case "player_uuid":
                return $this->playerUUID($value);
                break;
            case "date":
                return $this->date($value);
                break;
            case "time":
                return $this->time($value);
                break;
            case "item_name":
                return $this->itemName($value);
            default:
                return $value;
        }
    }
}
