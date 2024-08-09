<?php
    ob_start();
    session_start();
    include 'scripts.php';
    if(!isset($_SESSION["UserID"]) AND $_SESSION["role"] != 2){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Organiser Dashboard</title>
    <meta charset="utf-8">
    <?php include 'Includes/headings.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/dashboardStyles.css";
</head>

<body>

<?php include 'header.php'; ?>


<section class="flex flex-gap" id="top-highlight">
    <div>
        <img id="profile-section" class="profile-section-img" src="./img/user.svg" alt="Organiser Profile Page"/>
    </div>
    <div>
        <?php include 'components/greeting.php' ?>
    </div>
</section>

<div class="index-page-splitter-gradient ">
    <h2 class="container perfect-center"><span class="accent-text">My</span> EVENTS</h2>
    <section class="container flex perfect-center">
        <?php
        $events = get_events_by_User($_SESSION['UserID']);
        foreach ($events as $item) {
            $date = $item['event_date'];
            $description = $item['description'];
            $icon = "./img/event_icon.svg"; // TODO: allow this to come from the database
            $ID = $item['event_id'];
            $title = $item['name'];
            $bg_img = $item['image'];
            include 'components/media_card_organiser.php';
        }
        ?>
        <a href="event_upload.php"><button type="button" >Add Event</button></a>
    </section>
</div>
</section>


<?php include './footer.php'; ?>
<?php
    ob_flush();
?>
</body>

</html>