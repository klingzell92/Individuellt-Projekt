<?php
$index = $di->get("url")->create("quiz/start");
?>

<div class="main">
    <div class="stop">
    <h3>Du har gjort testet max antal gånger</h3>
    <a class="navButton" href="<?=$index?>">Tillbaka till start</a>
    </div>
</div>
