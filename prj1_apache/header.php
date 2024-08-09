<header class="flex primary-bg">
    <img class="media-left header-item header-img" src="./img/ticki_buy.png" />
    <a href="/index.php" class="header-item header-link"><h2>Home</h2></a>
    <a href="/events.php" class="header-item header-link"><h2>All events</h2></a>
    <?php

    if($_SESSION['role'] == 1){
        echo '<a href="home_admin.php" class="header-item header-link"><h2>Admin dashboard</h2></a>';
        $action = 'home_admin.php';
    }elseif ($_SESSION['role'] == 2){
        $action = 'home_organiser.php';
        echo '<a href="home_organiser.php" class="header-item header-link"><h2>Organiser dashboard</h2></a>';
    }elseif ($_SESSION['role'] == 3){
        $action = 'home_user.php';
        echo '<a href="home_user.php" class="header-item header-link"><h2>User dashboard</h2></a>';
    }?>

    <div class="header-search-container">
        <form action="events.php" method="get" class="header-form">
            <input value="<?php if(isset($_GET['text'])){ echo $_GET['text'];}?>"
                   name="text"
                   placeholder="Search event"
                   type="text"
                   class="header-searchbox" />
        </form>
    </div>

    <a href="/login.php" class="flex">
        <img class="media-right header-item perfect-center" src="./img/user.svg" style="width: 2.5vw;" style="height: 1vw" />

    </a>
    <?php
    if(isset($_SESSION['role'])){
        echo '
            <a href="logout.php" class="flex">
                <img class="media-right header-item perfect-center header-logout-icon" src="./img/logout_icon.svg" />  
            </a>
        ';
    }
    ?>
</header>