<?php
ob_start();
include 'Includes/Connect.php'; $forbiddenCheck=true;

?>


<?php include 'header.php'; ?>

<?php
include 'scripts.php';

if($_SESSION['role'] == 1 && (isset($_SESSION['token']) && isset($_SESSION["UserID"]))){
    global $db;

    // get the event that the user wants to edit via params
    $user_id = 0;
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
    }


    // make sure the events belong to the user we just queried
    $stmt = $db->prepare('SELECT * FROM events WHERE event_id = ?');
    $stmt->execute([$event_id]); // here we use the querried results instead of the session variable just in case.
    $event = $stmt->fetch();

}else{
    header('Location: index.php');
}

?>
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
<section class="container flex ">
    <form action="events_edit_admin.php" class="flex flex-direction-column" method="post">
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
            <select name="category" id="category">
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
