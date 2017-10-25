<?php
$index = $di->get("url")->create("quiz/start");
 ?>

<div class="main">
    <div class="show">
    <h3>Ditt resultat på <?=$course?> <?=$test?> blev: <?=$result?></h3>
    <h4>Tid: <?=$time?></h4>
    <ul>
<?php
foreach ($answers as $key => $answer) {
?>
    <li>
        <h4><?=$questions[$key]?></h4>
        <p><?=$answer?></p>
    </li>
<?php
}
?>
    </ul>
    <a href="<?=$index?>" class="navButton">Index</a>
    </div>
</div>
