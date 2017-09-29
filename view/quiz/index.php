<?php
$test = $di->get("url")->create("quiz/quiz");
 ?>

<div class="main">

<?php
    foreach($content as $key=>$val){
        echo "<div class='course'>";
        echo "<h3> $key </h3>";
      foreach($val as $k=>$v){
        echo "<a href='$test/$key/$k'>$k </a>";
      }
      echo "</div>";
    }
?>
</div>
