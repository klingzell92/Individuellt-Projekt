<?php
$postHandler = $di->get("url")->create("quiz/result");
$countTo = $di->get("session")->get("quizCountTo");
$content = $di->get("session")->get("questions");
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
    document.forms['quiz'].submit();
  }
}, 10);
</script>

<div class="main">
<h1><?=$course?> <?=$test?></h1>

<p id="demo">5:00</p>

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
