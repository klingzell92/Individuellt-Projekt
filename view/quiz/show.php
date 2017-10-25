<?php
$session = $di->get("session");
$postHandler = $di->get("url")->create("quiz/handle");
$countTo = $session->get("quizCountTo");
$index = $di->get("url")->create("quiz/start");
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
   if (distance < 1) {
     clearInterval(x);
     document.forms['quiz'].submit();
   }
 }, 10);
 </script>

<div class="main">
    <h1><?=$course?> <?=$test?></h1>
    <p class="quizTime" id="time">5:00</p>
    <form action="<?=$postHandler?>" name="quiz" method="post">
        <div class="show">
            <h3>Dina svar för <?=$course?> <?=$test?> är:</h3>
                <ul>
<?php
foreach ($answers as $key => $answer) {
?>
            <li>
                <h4><?=$questions[$key]["question"]?></h4>
                <p><?=$answer?></p>
            </li>
<?php
}
?>
                </ul>
            <input type="hidden" name="course" value="<?=$course?>">
            <input type="hidden" name="test" value="<?=$test?>">

            <input class="right navButton" type="submit" value="Lämna in test">
            <a href="<?=$previous?>/<?=$course?>/<?=$test?>" class="left navButton" > Tillbaka </a>

        </div>
    </form>
</div>
