<?php
$session = $di->get("session");
$postHandler = $di->get("url")->create("quiz/result");
$countTo = $session->get("quizCountTo");
$content = $session->get("questions");
$pagination = $session->get("pagination");
$page = $session->get("page");
$next = $di->get("url")->create("quiz/next");
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
  document.getElementById("demo").innerHTML = minutes + ":" + seconds;

  // If the count down is finished, submit the form
  if (distance < 2) {
    clearInterval(x);
    //document.forms['quiz'].submit();
    document.getElementById("demo").innerHTML = "Tiden är slut";
  }
}, 10);
</script>

<div class="main">
<h1><?=$course?> <?=$test?></h1>

<p id="demo">5:00</p>
<?php
if ($page < 4) {
?>
<form method="post" name="quiz" action="<?= $next?>">
<?php
} else {
?>
<form method="post" name="quiz" action="<?= $postHandler?>">
<?php
}
?>
<div class="question">

    <h3><?= $content[$pagination[$page]]["question"] ?></h3>
<?php
foreach ($content[$pagination[$page]]["alternatives"] as $alt => $alternative) {
 ?>
    <input type="radio" name="<?= $pagination[$page] ?>" value="<?= $alternative ?>"> <?= $alternative ?><br>
<?php
}
?>
    <input type = "radio" name="<?= $pagination[$page] ?>" value ="Inget svar" checked> Hoppa över<br>
    <input type="hidden" name="course" value="<?=$course?>">
    <input type="hidden" name="test" value="<?=$test?>">
    <input type="submit" value="Nästa">
</div>
</form>
</div>
