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

$this->config->setDefault("image-src", "https://crafatar.com/avatars/{UUID}?overlay&size=64.png");
$imageSrc = $this->config->get("image-src");
?>
<div class="text-center">
    <?php
    foreach ($statusPlugin->onlinePlayers() as $player):
        $link = $player;
        $imageSrc = str_replace("{NAME}", $player, $imageSrc);
        if ($this->bluestats->url->useUUID) {
            $link = $this->bluestats->basePlugin->player->getUUIDfromName($player);
            $imageSrc = str_replace("{UUID}", $link, $imageSrc);
        }
        ?>
        <a href="<?= $this->bluestats->url->player($link) ?>">
            <img src="<?= $imageSrc ?>" alt="<?= $player ?>" title="<?= $player ?>"
                 data-toggle="tooltip" data-placement="top">
        </a>
    <?php endforeach; ?>
</div>
