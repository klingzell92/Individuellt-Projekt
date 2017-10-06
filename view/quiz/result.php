<?php
$index = $di->get("url")->create("quiz/index");
 ?>

<div class="main">
    <div class="result">
    <h3>Ditt resultat på <?=$course?> <?=$test?> blev: <?=$result?></h3>
    <h4>Tid: <?=$time?></h4>
<?php
foreach ($answers as $key => $answer) {
?>
        <h4><?=$questions[$key]["question"]?></h4>
        <p><?=$answer?></p>
<?php
}
?>
    <a href="<?=$index?>">Index</a>
    </div>
</div>
