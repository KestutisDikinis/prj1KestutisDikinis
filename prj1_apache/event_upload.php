<?php ob_start();
?>
<?php include 'Includes/Connect.php'; $forbiddenCheck=true;?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Upload Event</title>
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

    // querry the user
    $stmt = $db->prepare('SELECT * FROM accounts WHERE account_id = ? AND password = ?');
    $stmt->execute([$_SESSION["UserID"], $_SESSION['token']]);
    $accnt = $stmt->fetch();
    if($accnt == FALSE || $_SESSION['role'] != 2){
        echo "<h1 class='center accent-text'>Your session is not valid. Please try <a href='/login.php'>logging in</a> again</h1>";
        return;
    }


}else{
    echo "<h1 class='center accent-text'>You are not logged in</h1>";
    return;
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Uploading an Event</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/index.css"/>
        <link rel="stylesheet" type="text/css" href="css/elements.css"/>
        <link rel="stylesheet" type="text/css" href="css/header.css"/>
        <link rel="stylesheet" type="text/css" href="css/footer.css"/>
        <link rel="stylesheet" type="text/css" href="css/flexbox.css">
    </head>

    <body>
    <section class="container flex ">
        <form action="event_upload.php" class="flex flex-direction-column" method="post">
            <h2>Uploading event:</h2>
            <div class="container">
                <label for="event_name">Event name</label>
                <input name="name" placeholder="Super Smokey BBQ in my backyard"/>
            </div>
            <div class="container">
                <label for="event_date">Event date:</label>
                <input name="event_date" value="<?php echo $date = date("Y/m/d")?>" id="date" type="date"/>
            </div>
            <div class="container">
                <label for="location">Event location:</label>
                <input name="location" id="location" type="text" placeholder="Infinite Loop 1"/>
            </div>
            <div class="container">
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="outdoor">outdoor</option>
                    <option value="indoor">indoor</option>
                    <option value="mixed">mixed</option>
                </select>
            </div>

            <div class="container">
                <label for="starting_time'">Starting time:</label>
                <input name="starting_time" value="<?php echo $date = date("H:i:s")?>" id="starting_time" type="time" />
            </div>

            <div class="container">
                <label for="amount_of_tickets'">Amount of tickets:</label>
                <input name="tickets_amount" id="amount_of_tickets'" type="number" placeholder="Number of visitors" />
            </div>

            <div class="container">
                <label for="image">Event image:</label>
                <input name="img" value="" id="image" type="url" placeholder="Image URL"/>
            </div>

            <div class="container">
                <label for="video">Event Video:</label>
                <input name="video" value="" id="video" type="url" placeholder="Video URL"/>
            </div>

            <div class="container">
                <label for="description">Description: </label>
                <textarea name="description" rows="10" cols="50" id="description" placeholder="Delicious Ribs and cold Beer!">
            </textarea>
            </div>

            <br/>
            <button type="submit">Upload</button>

        </form>
        <hr />
        <div>

        </div>



    </section>

    <?php
    if(!empty($_POST)) {

        $currentDay = date("d");
        $currentMonth = date('m');
        $currentMinute = date('i');
        $currentSecond = date('s');

        $id = $currentDay + $currentMonth + $currentMinute + $currentSecond;
        $name = $_POST['name'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $event_date = $_POST['event_date'];
        $category = $_POST['category'];
        $amount_of_tickets = $_POST['tickets_amount'];
        $starting_time = $_POST['starting_time'];
        $img = $_POST['img'];
        $video = $_POST['video'];
        $uploader_id = $_SESSION['UserID'];
        echo $id;

        addEvent($id,$name,$description,$location,$event_date,$category,$amount_of_tickets, $starting_time, $img, $video,$uploader_id);
        header('Location: home_organiser.php');
    }
    ?>


    <?php include './footer.php'; ?>
    </body>

    </html>
<?php ob_flush();?>