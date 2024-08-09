<?php include 'Includes/Connect.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>All Events</title>
    <meta charset="utf-8">
    <?php include './includes/headings.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/event_list_card.css">
</head>

<body>

<?php include 'header.php'; ?>

<?php
include "scripts.php";
//query variables
$q_date = NULL;
$q_category = NULL;
$q_offset = 0;
$q_text = NULL;

if(isset($_GET['offset'])){
    if($_GET['offset'] == 'offset'){
        $q_offset = 0;
    }else{
        $q_offset = $_GET['offset'] * 10;
    }
}
if(isset($_GET['text']) && strlen($_GET['text']) > 0){
    $q_text = $_GET['text'];
}

$events = get_events(10 , $q_offset, $q_text);
$categories = get_event_categories();
$dates = get_event_dates();
?>

<section class="page-header index-page-raise-box-inset">
    <div class="landing-page">

        <video width="100%" autoplay muted loop>
            <source src="img/tommorow_land_bgvideo.mp4" type="video/mp4">
        </video>
        <div class="page-content">
            <h1>ALL EVENTS</h1>

            <nav class="container perfect-center" style="box-shadow: 1px 0px 15px 0px rgba(0,0,0,0.13)">
                <!-- always displaying 10 events-->
                <?php
                $event_amount = ceil($events[1]['count'] / 10);
                if($event_amount > 9) $event_amount = 8;

                for($x = 0; $x < $event_amount; $x++){
                    $offset = $x ;
                    if($offset != 0){
                        echo '<form  method="get">';
                        echo "<input style='padding: 10px;background: transparent;' type='submit' name='offset' value='$offset'/>";
                        echo "<input type='text' name='text' hidden value='$q_text' />";
                        echo '</form>';
                    }
                }
                ?>
            </nav>
        </div>
    </div>

</section>



<section class="container index-page-splitter-gradient">
    <?php
    foreach ($events as $item) {
        $event_tickets = get_ticket_price_range($item['event_id']);
        $date = $item['event_date'];
        $description = $item['description'];
        $img = $item['image']; //"./img/event_icon.svg"
        $ID = $item['event_id'];
        $title = $item['name'];
        $price_range = "€".$event_tickets['minprice'] . " - €" . $event_tickets['maxprice'];
        $category = $item['category'];
        include 'components/event_list_card.php';
    }

    ?>


</section>


<?php include './footer.php'; ?>
</body>

</html>