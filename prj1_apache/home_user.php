<?php
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <meta charset="utf-8">
    <?php include 'Includes/headings.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/dashboardStyles.css">
</head>

<body>
<?php
include 'scripts.php';
$user = getUserById($_SESSION['UserID']);
if(!isset($_SESSION['UserID'])){
    header('Location: login.php ');
}

$tp = $db->prepare('SELECT * FROM owning WHERE customer_id = ? AND payment_completed = true');
$tp->execute([$_SESSION['UserID']]);
$tickets = $tp->fetchAll();
//<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Fwww.google.com%2F&choe=UTF-8" title="Link to Google.com" />
?>

<?php include 'header.php'; ?>


<section class="flex flex-gap" id="top-highlight">
    <div>
        <img id="profile-section" class="profile-section-img" src="./img/user.svg" alt="Organiser Profile Page"/>
    </div>
    <div>
        <?php include 'components/greeting.php' ?>
    </div>
</section>


<section class="container, eventsList">

    <h2 id="myEvents" class="center"><span class="accent-text">My </span> Tickets</h2>
    <div class="container perfect-center">
        <?php
        foreach ($tickets as $item) {
            $ev = get_event($item['event_id']);
            $tick = get_ticket($item['ticket_id']);

            $date = $tick['event_date'];
            $description = $tick['description'];
            $icon = "./img/ticket.svg";
            $ID = $item['event_id'];
            $title = $tick['name'];
            $bg_img = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".urlencode($item['ticket_id'])."&choe=UTF-8";
            $barcode = true;
            include 'components/media_card.php';
        }
        ?>
    </div>
</section>


<?php include './footer.php'; ?>
<?php
ob_flush();
?>
</body>

</html>