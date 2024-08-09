<?php
ob_start();
include 'Includes/Connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Page</title>
    <meta charset="utf-8">
    <?php include './includes/headings.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/event_list_card.css">
</head>

<body>
<?php
include 'header.php'; ?>
<section class="page-header index-page-raise-box-inset">
    <div class="landing-page">

        <img src="img/admin_background.jpg">
        <div class="page-content">
            <h1>Administrator dashboard</h1>
        </div>
    </div>

</section>
<?php
if($_SESSION['role'] == 1 && (isset($_SESSION['token']) && isset($_SESSION["UserID"]))) {

    include "scripts.php";
//query variables
    $q_offset = 1;
    $q_text = NULL;

    if (isset($_GET['offset'])) {
        if ($_GET['offset'] == 'offset') {
            $q_offset = 1;
        } else {
            $q_offset = $_GET['offset'];
        }
    }
    if (isset($_GET['text']) && strlen($_GET['text']) > 0) {
        $q_text = $_GET['text'];
    }
}else{
    $_SESSION = array();

    session_unset();
    session_destroy();
    header('Location: index.php');
}
$events = get_events(10 , $q_offset, $q_text);
$categories = get_event_categories();
$dates = get_event_dates();
?>



<section class="container">
    <h2  class="container-header"><span class="accent-text">A</span>LL EVENTS</h2>
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
        $max_length = 300;
        if(strlen($description) > $max_length){
            $description = substr($description,0,$max_length);
            $description = $description.'...';
        }
        include 'components/event_list_card.php';
    }

    ?>


</section>
<h2  class="container-header"><span class="accent-text">U</span>ser search</h2>
<section style="align-self: center; width: 50%">
    <form action="home_admin.php" method="GET" class="container flex flex-direction-column">

        <label>Username</label><br/>
        <input name="username" type="text" id="username" required/><br/>

        <button type="submit" name="Submit" class="button-large">Search</button>

    </form>
    <?php
    $username = $_GET['username'];
    $user = getUserByUsername($username);
    if(isset($_GET['username'])) {
        if ($user != null) {
            $img = "./img/user.png";
            foreach ($user as $item) {
                include 'components/profile_admin_view.php';
            }
        } else {
            echo "<h1 class='center accent-text'>There is no account with this username</h1>";
        }
    }
    ?>
</section>




<?php
ob_flush();
include './footer.php'; ?>
</body>

</html>