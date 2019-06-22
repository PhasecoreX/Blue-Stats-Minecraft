<?php

class formatter {

    private $bluestats;

    public function __construct ($bluestats) {
        $this->bluestats = $bluestats;
    }

    public function playerName($value) {
        if ($this->bluestats->url->useUUID) {
            $uuid  = $this->bluestats->basePlugin->player->getUUIDfromName($value);
            return "<a href=\"" . $this->bluestats->url->player($uuid) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\" height=\"32\" width=\"32\"> {$value}</a>";
        }
        return "<a href=\"" . $this->bluestats->url->player($value) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\" height=\"32\" width=\"32\"> {$value}</a>";
    }

    public function playerUUID($uuid) {
        $name = $this->bluestats->basePlugin->player->getNamefromUUID($uuid);
        if ($this->bluestats->url->useUUID)
            return "<a href=\"" . $this->bluestats->url->player($uuid) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\" height=\"32\" width=\"32\"> {$name}</a>";
        return "<a href=\"" . $this->bluestats->url->player($name) . "\"><img src=\"https://crafatar.com/avatars/{$uuid}?overlay&size=32.png\" alt=\"\" height=\"32\" width=\"32\"> {$name}</a>";
    }

    public function damageSource($value) {
        if (preg_match('/^[0-9A-Fa-f\-]{36}$|^[0-9A-Fa-f]{32}$/m', $value))
            return $this->playerUUID($value);
        return $this->itemName($value);
    }

    public function date($value) {
        if (is_numeric($value))
            return date('H:i m-d-y', $value/1000);
        return $value;
    }

    public function time($value) {
        return secondsToTime(round($value));
    }

    public function itemName($value) {
        return ucwords(str_replace('_', ' ', strtolower($value)));
    }

    public function int($value) {
        return number_format((float)$value, 0, '.', ',');
    }

    public function round2($value) {
        return number_format((float)$value, 2, '.', ',');
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
                break;
            case "damage_source":
                return $this->damageSource($value);
                break;
            case "int":
                return $this->int($value);
                break;
            case "round_2":
                return $this->round2($value);
                break;
            default:
                return $value;
        }
    }
}
