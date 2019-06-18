<?php
/** @var module $this */
$this->loadPlugin("query");

if (!isset($this->plugins["query"]))
    return;

$plugin = $this->plugins["query"];

$this->config->setDefault("image-src", "https://crafatar.com/avatars/{UUID}?overlay&size=64.png");
$imageSrc = $this->config->get("image-src");
?>
<div class="text-center">
    <?php
    foreach ($plugin->onlinePlayers() as $player):
        $link = $player;
        if ($this->bluestats->url->useUUID)
            $link = $this->bluestats->basePlugin->player->getUUIDfromName($player);
        ?>
        <a href="<?= $this->bluestats->url->player($link) ?>">
            <img src="<?= str_replace("{UUID}", $player, $imageSrc) ?>" alt="<?= $player ?>" title="<?= $player ?>"
                 data-toggle="tooltip" data-placement="top">
        </a>
    <?php endforeach; ?>
</div>
