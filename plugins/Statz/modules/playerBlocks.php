<table class="table table-hover table-sorted" id="blocks">
    <thead>
    <tr>
        <th>Block</th>
        <th>World</th>
        <th>Amount Broken</th>
        <th>Amount Placed</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($plugin->getPlayerBlock($player->uuid) as $id => $value): ?>
        <tr>
            <td>
                <!--<img src="http://blocks.fishbans.com/" alt="">-->
                <?= ucfirst(strtolower(str_replace("_", " ", $value["name"]))) . ":" . $value["data"] ?>
            </td>
            <td>
                <?= $value["world"] ?>
            </td>
            <td>
                <?= $value["blocks_broken"] ?>
            </td>
            <td>
                <?= $value["blocks_placed"] ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
