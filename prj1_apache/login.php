<?php ob_start(); // we have a html before php, so ob_start is like indicator where to start stopping the html ?>
<?php include 'Includes/Connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Log in</title>
    <?php include './includes/headings.php'; ?>
</head>
<body>
<?php
session_start();
?>

<?php include 'header.php'; ?>
<?php include 'scripts.php'; ?>
<?php

if($_SESSION['role'] == 1){
    header("Location: home_admin.php");
}elseif ($_SESSION['role'] == 2){
    header("Location: home_organiser.php");
}elseif ($_SESSION['role'] == 3){
    header("Location: home_user.php");
}?>

<?php require_once('classes/Account.php')?>
<?php
if (!empty($_POST)) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = new Account();

    if (!isset($email) && !isset($password)) {
        echo "username and or password field cannot be empty";
    } else {
        $result = $user->login($email, $password);

        if ($result != null) {
            $_SESSION["account_id"] = $result["account_id"];
            $_SESSION["username"] = $email;
            $_SESSION["role"] = $user->getUserRole();

            header('Location: index.php');
            exit;
        } else {
            echo "<p align='center'>Username and/or password incorrect.</p>";
            echo '
    <form action="login.php" method="POST" id="formLogin" class="container flex flex-direction-column">

        <label for="email">Email</label><br/>
        <input name="email" type="text" id="email" required=""/><br/>
        <label>Password</label><br/>
        <input name="password" type="password" id="password" required=""/><br/><br/>

        <button type="submit" name="Submit" value="LOGIN" class="button-large">Login</button>

</form>
<p>
    Not a member yet? <a href="register.php">Register</a>
</p>
';
        }

//        $_SESSION["email"] = "";
//        $_SESSION["account_id"] = "";
    }
    //$conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", "prj1_postgres", "5432", "postgres", "postgres", "P@ssword1");
    //$connection = new PDO($conStr);


    //$query = "SELECT * FROM accounts WHERE  username = '$username' AND password = '$password' ";
    //$result = pg_query($query) or die('Query failed: ' . pg_last_error());

} else {
    echo '
    <form action="login.php" method="POST" id="formLogin" class="container flex flex-direction-column">

    <label>Email</label><br/>
    <input name="email" type="text" id="email" required/><br/>
    <label>Password</label><br/>
    <input name="password" type="password" id="password" required/><br/><br/>

    <button type="submit" name="Submit" value="LOGIN" class="button-large">Login</button>

</form>
<p>
    Not a member yet? <a href="register.php">Register</a>
</p>
    ';
}
ob_flush(); // here is the end of html, so ob_flush needs to be here
?>


<?php include 'footer.php'; ?>
</body>
</html>

