<?php include 'Includes/Connect.php'; ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <?php include 'Includes/headings.php'; ?>
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'scripts.php'; ?>
<section class="page-header index-page-raise-box-inset">
    <div class="landing-page">

        <video width="100%" autoplay muted loop>
            <source src="img/tommorow_land_bgvideo.mp4" type="video/mp4">
        </video>
        <div class="page-content">
            <?php
            if(isset($_SESSION['UserID'])){
                $user = getUserById($_SESSION['UserID']);
                echo '<h1>Welcome back, <b>'.$user['username'].'</b></h1>';
            }else{
                echo '<h1>Welcome to <i>Tickibuy</i></h1>';
            }
            $events = get_events(8);
            ?>
            <p>
               Take a look at our diverse list of featured events below. or take a trip to our vast category of events. We are constantly on a pursuit to provide you with the best possible events that are exiting
            </p>
            <a href="/events.php">View all events</a>
        </div>
    </div>

</section>

<div class="index-page-splitter-gradient ">
    <h2 class="container perfect-center"><span class="accent-text">F</span>EATURED EVENTS</h2>
    <section class="container flex perfect-center">
        <?php
        foreach ($events as $item) {
            $date = $item['event_date'];
            $description = $item['description'];
            $icon = "./img/event_icon.svg"; // TODO: allow this to come from the database
            $ID = $item['event_id'];
            $title = $item['name'];
            $bg_img = $item['image'];
            include 'components/media_card.php';
        }
        ?>
    </section>
</div>



<section class="index-page-raise-box">
    <div class="landing-page-sub">
        <img class="landing-page-content-image" src="img/Tomorrowland-cover.jpg" />
        <div class="page-content aqua">
            <h1 class="aqua">Who are we?</h1>
            <p>
                We are a group of developers <b>fueled</b> by our passion and <b>devoted</b> to writing software that will <b>change the world</b>.
            </p>
            <a  class="aqua" href="/events.php?date=Date&category=indoor">View all events</a>
        </div>
</section>
<?php include 'footer.php'; ?>
</body>
</html>