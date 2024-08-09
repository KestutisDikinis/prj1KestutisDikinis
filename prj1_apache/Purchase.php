<?php ob_start(); ?>
<?php include 'Includes/Connect.php'; $forbiddenCheck=true;?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Purchase ticket</title>
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


if(isset($_SESSION['token']) && isset($_SESSION["UserID"])){

    $ticket_id = 0;
    $event_id = 0;
    if (isset($_GET['ticket_id'])) {
        $ticket_id = $_GET['ticket_id'];
    }

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $tp = $db->prepare('SELECT * FROM ticket WHERE ticket_id = ?');
    $tp->execute([validate_input($ticket_id)]);
    $ticket = $tp->fetch();


    if(!empty($_POST)) {
        // purchase.
        try{
            $purs = $db->prepare("insert into owning
    (customer_id, event_id, amount_of_tickets, payment_completed, ticket_id, time_of_purchase)
values (?, ?, 1, true, ?, now()::timestamp);");
            $purs->execute([
                $_SESSION["UserID"],
                $ticket['event_id'],
                $ticket['ticket_id']
            ]);
        }catch(PDOException $e){
            echo "<h2 class='accent-text center'>You already own 10 active tickets!!</h2>";
        }




    }


}else{
    echo "<h1 class='center accent-text'>Please <a href='login.php'>log-in</a> to purchase a ticket.</h1>";
    return;
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Edit Event</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/index.css"/>
        <link rel="stylesheet" type="text/css" href="css/elements.css"/>
        <link rel="stylesheet" type="text/css" href="css/header.css"/>
        <link rel="stylesheet" type="text/css" href="css/footer.css"/>
        <link rel="stylesheet" type="text/css" href="css/flexbox.css">
    </head>

    <body>
    <section class="container flex">
        <form method="post" class="container flex flex-direction-column flex-col-6">
            <h1 class="center">Buying ticket : <?php echo $ticket['name'];?></h1>
            <span class="center">
                <input placeholder="Credit Card Number" name="cc"/>
                <input placeholder="MM/YY" name="exp"/>
            </span>

            <aside class="center">
                <input placeholder="CVV" name="cvv"/>
            </aside>
            <br />
            <span class="flex flex-col-8 perfect-center"><button type="submit">Purchase</button></span>

        </form>

        <section class="container flex flex-direction-column">
            <h3 class="center">We accept:</h3>
            <img src="img/we_accept_cards2.png" />
        </section>
    </section>



    <?php include './footer.php'; ?>
    </body>

    </html>
<?php ob_flush();?>