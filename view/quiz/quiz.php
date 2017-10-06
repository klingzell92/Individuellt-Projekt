<?php
$postHandler = $di->get("url")->create("quiz/result");
 ?>

<script type="text/javascript">
window.setTimeout(function() {
    document.forms['quiz'].submit();
}, 30000);
</script>

<div class="main">
<h1><?=$course?> <?=$test?></h1>
<form method="post" name="quiz" action="<?= $postHandler?>">
<?php

foreach ($content as $key => $questions) {
?>
<div class="question">

    <h3><?= $questions["question"] ?></h3>
<?php
foreach ($questions["alternatives"] as $alt => $alternative) {
 ?>
    <input type="radio" name="<?= $key ?>" value="<?= $alternative ?>"> <?= $alternative ?><br>
<?php
}
?>
    <input type = "radio" name="<?= $key ?>" value ="Inget svar" checked> Hoppa över
</div>
<?php
}
?>
<input type="hidden" name="course" value="<?=$course?>">
<input type="hidden" name="test" value="<?=$test?>">
<input type="submit" value="Lämna in test">
</form>
</div>
