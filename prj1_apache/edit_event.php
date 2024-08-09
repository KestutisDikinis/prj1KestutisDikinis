<?php ob_start(); ?>
<?php include 'Includes/Connect.php'; $forbiddenCheck=true;?>
<!DOCTYPE html>
<html>

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

<?php include 'header.php'; ?>

<?php
include 'scripts.php';

//$tickets = get_event_tickets($event_id)

// TODO: implement security -> https://www.w3schools.com/php/php_form_validation.asp
if(isset($_SESSION['token']) && isset($_SESSION["UserID"])){
    include 'Includes/env_variables.php';
    $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
        $host, $port, $dbname, $user, $password);
    $db = new PDO($conStr);

    // get the event that the user wants to edit via params
    $event_id = 0;
    if (isset($_GET['id'])) {
        $event_id = $_GET['id'];
    }

    // querry the user
    $stmt = $db->prepare('SELECT * FROM accounts WHERE account_id = ? AND password = ?');
    $stmt->execute([$_SESSION["UserID"], $_SESSION['token']]);
    $accnt = $stmt->fetch();


    // make sure the events belong to the user we just queried
    $stmt = $db->prepare('SELECT * FROM events WHERE uploader_id = ? AND event_id = ?');
    $stmt->execute([$_SESSION["UserID"], $event_id]); // here we use the querried results instead of the session variable just in case.
    $event = $stmt->fetch();


    if($accnt == FALSE){
        echo "<h1 class='center accent-text'>Your session is not valid. Please try <a href='/login.php'>logging in</a> again</h1>";
        return;
    }
//    if($event["uploader_id"] != $_SESSION["UserID"]){
//        echo "<h1 class='center accent-text'>You do not have permission to edit this event</h1>";
//        return;
//    }

    //$event = get_event($event_id);


}else{
    echo "<h1 class='center accent-text'>You are not logged in</h1>";
    return;
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Edit Event</title>
        <?php include 'Includes/headings.php'; ?>
    </head>

    <body>
    <section class="container flex ">
        <form action="edit_event.php" class="flex flex-direction-column" method="post">
            <input type="hidden" name="varname" value="<?php echo $event['event_id'] ?>">
            <h2>Editing event: <?php echo $event['name']; ?></h2>
            <div class="container">
                <label for="event_name">Event name</label>
                <input name="name" value="<?php echo $event['name']?>" id="name" type="text"/>
            </div>
            <div class="container">
                <label for="event_date">Event date</label>
                <input name="event_date" value="<?php echo $event['event_date']?>" id="date" type="date"/>
            </div>
            <div class="container">
                <label for="location">Event location</label>
                <input name="location" value="<?php echo $event['location']?>" id="location" type="text"/>
            </div>
            <div class="container">
                <label for="category">Category</label>
                <select name="category" id="category">√
                    <option <?php echo $event['category'] == "outdoor" ? "selected" : ""; ?>value="outdoor">outdoor</option>
                    <option <?php echo $event['category'] == "indoor" ? "selected" : ""; ?>value="indoor">indoor</option>
                    <option <?php echo $event['category'] == "mixed" ? "selected" : ""; ?>value="mixed">mixed</option>
                </select>
            </div>

            <div class="container">
                <label for="starting_time'">Starting time</label>
                <input name="starting_time" value="<?php echo $event['starting_time']?>" id="starting_time" type="time" />
            </div>

            <div class="container">
                <label for="image">Event image</label>
                <input name="img" value="<?php echo $event['image']?>" id="image" type="url"/>
            </div>

            <div class="container">
                <label for="video">Event Video</label>
                <input name="video" value="<?php echo $event['video']?>" id="video" type="url"/>
            </div>

            <div class="container">
                <label for="description">Description</label>
                <textarea name="description" rows="10" cols="50" id="description" value="this needs to get the previous data">
                <?php echo $event['description']?>
            </textarea>
            </div>

            <div class="container">
                <label for="delete_event">Delete event?</label>
                <input name="delete_event" type="checkbox" value="<?php echo $event['event_id']; ?>"/>
            </div>
            <br/>
            <button type="submit">Submit</button>

        </form>
        <hr />
        <img src="img/flyer.jpg">
        <div>

        </div>

    </section>

    <?php

    if (isset($_POST['delete_event'])) {
        delete($_POST['delete_event']);
        header('Location: home_organiser.php');
    }
    if(!empty($_POST)) {

        $id = $_POST['varname'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $event_date = $_POST['event_date'];
        $category = $_POST['category'];
        $starting_time = $_POST['starting_time'];
        $img = $_POST['img'];
        $video = $_POST['video'];
        echo $id;

        update_event($id,$name, $description, $location,$event_date,$category,$starting_time,$img,$video);
        header('Location: home_organiser.php');
    }
    ?>


<?php include './footer.php'; ?>
</body>

</html>
<?php ob_flush();?>