<nav>
    <ul>
    <li>
        <span><a href="<?=$di->get("url")->create("quiz/start")?>">dbwebb quiz</a></span>
    </li>
    <?php
    if ($di->get("session")->has("user")) {
    ?>
    <li style="float:right"><a class="active" href="<?=$di->get("url")->create("logout")?>">Logga ut</a></li>
    <?php
    }
    ?>
    </ul>
</nav>
