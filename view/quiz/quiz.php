

<div class="main">
<form>
<?php
var_dump($random);
foreach ($content as $key => $questions) {
?>
<div>

    <p><?= $questions["question"] ?></p>

    <input type="radio" name="<?= $key ?>" value="<?= $questions["alt1"] ?>"> <?= $questions["alt1"] ?><br>
    <input type="radio" name="<?= $key ?>" value="<?= $questions["alt2"] ?>"> <?= $questions["alt2"] ?><br>
    <input type="radio" name="<?= $key ?>" value="<?= $questions["alt3"] ?>"> <?= $questions["alt3"] ?><br>
    <input type="radio" name="<?= $key ?>" value="<?= $questions["alt4"] ?>"> <?= $questions["alt4"] ?>
</div>

<?php
}
?>
<input type="submit" value="Lämna in test">
</form>
</div>
