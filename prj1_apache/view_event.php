<?php include 'Includes/Connect.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>View Event</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
    <link rel="stylesheet" type="text/css" href="css/elements.css"/>
    <link rel="stylesheet" type="text/css" href="css/header.css"/>
    <link rel="stylesheet" type="text/css" href="css/footer.css"/>
    <link rel="stylesheet" type="text/css" href="css/flexbox.css">
</head>

<body>

<?php include 'header.php'; ?>

<?php

include 'scripts.php';
$event_id = 0;

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
}

//$stmt = $db->prepare('SELECT * FROM events WHERE event_id = ?');
////$stmt->execute([$event_id]);
////$event = $stmt->fetch();
////
////$tp = $db->prepare('SELECT * FROM ticket WHERE event_id = ?');
////$tp->execute([$event_id]);
////$tickets = $tp->fetchAll();

$event = get_event($event_id);
$tickets = get_event_tickets($event_id);

?>

<section class="flex flex-gap" id="top-highlight">
    <div class="top-highlight-img-container">
        <img class="top-highlight-img shadow-subtle" src="<?php echo $event['image'] ?>" alt="event image"/>
    </div>
    <div>
        <h1><?php echo $event['name'] . " | " . $event['event_date'] . " | " . $event['category']; ?></h1>
        <p style="height: 25vh;" class="mo-description"> <?php echo $event['description'] ?> </p>
    </div>

    <div class="flex flex-direction-column media-right"
         style="align-items: flex-end; width: 50%; padding-right: 2vw;">
        <a href="#VIDEOS"><img style="padding-top: 1vh;" class="icon-medium button-icon"
                               src="./img/screen-player.svg" alt="videos"/></a>
        <a href="#DESCRIPTION"><img style="padding-top: 1vh;" class="icon-medium button-icon"
                                    src="./img/search.svg" alt="description"/></a>
        <a href="#TICKETS"><img style="padding-top: 1vh;" class="icon-medium button-icon"
                                src="./img/park-tickets-couple.svg" alt="tickets"/></a>
        <?php if($_SESSION['role'] == 1){
            echo '<a href="events_edit_admin.php?id='.$event_id.'"><img style="padding-top: 1vh;" class="icon-medium button-icon"
                                src="./img/settings_icon.png" alt="tickets"/></a>';
        } ?>

    </div>
</section>


<section class="container">
    <h2 id="VIDEOS" class="container-header"><span class="accent-text">V</span>IDEO</h2>
    <?php
    $video_src = $event['video'];
    echo '<iframe width="100%" src="' . $video_src . '" frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    ?>
</section>


<section class="container flex-direction-column">
    <h2 id="DESCRIPTION" class="container-header"><span class="accent-text">D</span>ESCRIPTION</h2>
    <p>
        <?php
        echo $event['description'];
        ?>
    </p>

</section>


<section class="container">
    <h2 id="TICKETS" class="container-header"><span class="accent-text">T</span>ICKETS</h2>
    <?php
        foreach ($tickets as $item) {
            $date = $item['name']; // we need an entry in the database for this...
            $description = $item['category'];
            if($item['stock'] > 0){
                $availability = "Available";
            }else{
                $availability = "Sold out";
            }
            $price = $item['price'];
            $T_ID = $item['ticket_id'];
            $E_ID = $event_id;


            include './components/ticket_list_item.php';
        }
    ?>
</section>


<?php include './footer.php'; ?>
</body>

</html>