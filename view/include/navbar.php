<nav>
    <ul>
    </li><li>
    <li class="logo">
        <a href="<?=$di->get("url")->create("quiz/start")?>">dbwebb quiz</a>
    </li>
    <?php
    if ($di->get("session")->has("user")) {
    ?>
    <li class="logout"><a class="active" href="<?=$di->get("url")->create("logout")?>">Logga ut</a></li>
    <?php
    } else {
    ?>
    <li></li>
    <?php
    }
    ?>
    </ul>
</nav>
