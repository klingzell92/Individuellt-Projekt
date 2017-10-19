<?php
$index = $di->get("url")->create("quiz/start");
?>

<div class="main">
    <div class="result">
    <h3>Du har gjort testet max antal gånger</h3>
    <a href="<?=$index?>">Tillbaka till start</a>
    </div>
</div>
