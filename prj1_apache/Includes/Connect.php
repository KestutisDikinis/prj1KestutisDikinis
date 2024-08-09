<?php
session_start();
$errors = [];

// forbidden check here is a variable that can be passed with the include statement. will redirect the user back to the
// home page if he/she is not logged in
if($forbiddenCheck == true && !isset($_SESSION['token'])){
    header('location: index.php');
}
include 'Includes/env_variables.php';
$conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
    $host, $port, $dbname, $user, $password);
$db = new PDO($conStr);

?>

<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>