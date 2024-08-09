<?php
//include connection & session
include 'Includes/Connect.php';
?>

 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <?php include './includes/headings.php'; ?>
</head>
<body>
<?php include 'header.php'; ?>
<main class="container">
    <form method="post" action="register.php" class="form-full">
        <div class="input-group flex">
            <fieldset class="flex flex-direction-column flex-col-4">
                <legend>Basic info:</legend>
                <label>Username</label>
                <input type="text" name="username">
                <label>Password</label>
                <input type="password" name="password_1">
                <label>Email</label>
                <input type="email" name="email">
                <label>First name</label>
                <input type="text" name="fname">
                <label>Middle name</label>
                <input type="text" name="mname">
                <label>Last name</label>
                <input type="text" name="lname">
            </fieldset>

            <br />
            <hr />
            <br />

            <fieldset class="flex flex-direction-column flex-col-4">
                <legend>Details:</legend>
                <label>Date of birth</label>
                <input type="date" name="dob">
                <label>Phone number</label>
                <input type="tel" name="phone">
                <label>City</label>
                <input type="text" name="city">
                <label>Address</label>
                <input type="text" name="address">
                <label>Postal code</label>
                <input type="text" name="postal" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}">
                <label>User type</label>
                <select name="role"><option value="3">User account</option><option value="2">Event organiser</option></select>
            </fieldset>

            <button type="submit" class="btn" name="register">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
</main>
<?php
include 'scripts.php';
// REGISTER USER
if (!empty($_POST)) {
// form validation: ensure that the form is correctly filled ...
    $username = $_POST['username'];
    $email = $_POST['email'];

    // $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", "localhost", "5432", "postgres", "postgres", "mypassword");
    // $db = new PDO($conStr);
    $query = "SELECT * FROM accounts WHERE username = :username OR email = :email LIMIT 1";
    $tp = $db->prepare($query);
    $tp->execute(['username' => strip_tags($username), 'email' => strip_tags($email)]);
    $user = $tp->fetch();

    $password = $_POST['password_1'];
    $fname = $_POST['fname'];
    $middle_name = $_POST['mname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $postal = $_POST['postal'];
    $role = $_POST['role'];
    register($username, $password, $email, $fname, $middle_name, $lname, $dob, $phone, $city, $address, $postal, $role);


}


?>

<?php include 'footer.php'; ?>
</body>
</html>