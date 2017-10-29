<?php
$session = $di->get("session");
$postHandler = $di->get("url")->create("quiz/handle");
$countTo = $session->get("quizCountTo");
$content = $session->get("questions");
$pagination = $session->get("pagination");
$page = $session->get("page");
$next = $di->get("url")->create("quiz/next");
$previous = $di->get("url")->create("quiz/previous");

 ?>

<script type="text/javascript">

var test = "<?php echo $countTo;?>";
var countTo = new Date(test * 1000);
//countTo.setMinutes(countTo.getMinutes() + 5);

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Distance between now and 5 minutes from now
  var distance = countTo - now;

  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  if (seconds < 10) {
      seconds = "0" + seconds;
  }
  // Display the result in the element with id="time"
  document.getElementById("time").innerHTML = minutes + ":" + seconds;

  // If the count down is finished, submit the form
  if (distance < 2) {
    clearInterval(x);
    document.getElementById("quiz").action = "<?php echo $postHandler;?>";
    document.forms['quiz'].submit();
  }
}, 10);
</script>

<div class="main">
<h1><?=$course?> <?=$test?></h1>

<p class="quizTime" id="time">5:00</p>
<form method="post" name="quiz" action="<?= $next?>" id="quiz">

<div class="question">

    <h3><?= $content[$pagination[$page]]["question"] ?></h3>
    <ul>
<?php
foreach ($content[$pagination[$page]]["alternatives"] as $alt => $alternative) {
 ?>
 <?php
if ($session->has("answers") && array_key_exists($pagination[$page], $session->get("answers")) && $session->get("answers")[$pagination[$page]] == $alternative) {
?>
    <li>
        <input type="radio" name="<?= $pagination[$page] ?>" id="<?= $alternative ?>" value="<?= $alternative ?>" checked>
        <label for="<?= $alternative ?>"><?= $alternative ?></label>
        <div class="check"><div class="inside"></div></div>
    </li>
<?php
} else {
 ?>
    <li>
        <input type="radio" name="<?= $pagination[$page] ?>" id="<?= $alternative ?>" value="<?= $alternative ?>">
        <label for="<?= $alternative ?>"><?= $alternative ?></label>
        <div class="check"><div class="inside"></div></div>
    </li>
<?php
}
}?>
</ul>
<?php
if (!$session->has("answers") || !array_key_exists($pagination[$page], $session->get("answers"))) {
?>
<div class="default">
    <input type="radio" name="<?= $pagination[$page] ?>" value="Inget svar" checked>
</div>
<?php
}
?>
    <input type="hidden" name="course" value="<?=$course?>">
    <input type="hidden" name="test" value="<?=$test?>">
<?php
if ($page < 4) {
?>
    <input class="right navButton" type="submit" value="Nästa">
<?php
} else {
?>
    <input class="right navButton" type="submit" value="Lämna in test">
<?php
}
if ($page > 0) {
?>
    <a href="<?=$previous?>/<?=$course?>/<?=$test?>" class="left navButton" > Tillbaka </a>
<?php
}
?>
</div>
</form>
</div>
