<?php
include 'Includes/Connect.php';

function get_event($id = 0){
    global $db;
    $stmt = $db->prepare('SELECT * FROM events WHERE event_id = ?');
    $stmt->execute([strip_tags($id)]);
    $event = $stmt->fetch();
    return $event;
}
function get_ticket($id = 0){
    global $db;
    $stmt = $db->prepare('SELECT * FROM ticket WHERE ticket_id = ?');
    $stmt->execute([strip_tags($id)]);
    $ticket = $stmt->fetch();
    return $ticket;
}

function get_events_by_User($id = 0) {
    global $db;
    $stmt = $db ->prepare('SELECT * FROM events WHERE uploader_id = ?');
    $stmt -> execute([strip_tags($id)]);
    $events = $stmt->fetchAll();
    return $events;
}
function get_events($limit = 10, $offset = 0, $text = NULL){
    global $db;
    $extra_query = null;
    $stmt = null;

    if(isset($text)){
        $extra_query = ' WHERE "name" ILIKE :text OR description ILIKE :text OR category ILIKE :text OR "location" ILIKE :text ';
        $sanitized_text = validate_input($text);


        if(isset($extra_query) && isset($sanitized_text)){
            $stmt = $db->prepare('SELECT *, COUNT(*) OVER() AS Count FROM events ' . $extra_query . ' OFFSET :offset LIMIT :limit');
            $stmt->execute(['text' => '%'.$sanitized_text.'%', 'limit' => $limit, 'offset' => $offset]);
        }

    }else{
        $stmt = $db->prepare('SELECT *, COUNT(*) OVER() AS Count FROM events OFFSET :offset LIMIT :limit');
        $stmt->execute(['limit' => $limit, 'offset' => $offset]);
    }

    $events = $stmt->fetchAll();
    return $events;
}
function get_featured_events(){
//TODO: implement this.. if for example an event has 0 tickets..
}
function get_event_organizer($id){
    global $db;
    $stmt = $db->prepare('SELECT * FROM accounts WHERE account_id = ? AND roles = 2'); // only allow querying an organizer.
    $stmt->execute([strip_tags($id)]);
    $organizer = $stmt->fetch();
    return $organizer;
}
function get_event_tickets($id = 0){
    global $db;
    $tp = $db->prepare('SELECT * FROM ticket WHERE event_id = ?');
    $tp->execute([strip_tags($id)]);
    $tickets = $tp->fetchAll();
    return $tickets;
}
function get_ticket_price_range($event_id){
    global $db;
    $tp = $db->prepare('select max(price) as maxprice, min(price) as minprice FROM ticket WHERE event_id = ? group by event_id;');
    $tp->execute([strip_tags($event_id)]);
    $tickets = $tp->fetch();
    return $tickets;
}

function get_event_dates(){
    global $db;
    $tp = $db->prepare('SELECT DISTINCT event_date FROM events');
    $tp->execute();
    $dates = $tp->fetchAll();
    return $dates;
}
function get_event_categories(){
    global $db;
    $tp = $db->prepare('SELECT DISTINCT category FROM events');
    $tp->execute();
    $categ = $tp->fetchAll();
    return $categ;
}

function delete($id){
    global $db;
    $sql = 'DELETE FROM events WHERE event_id = :id';
    $sql2 = 'DELETE FROM ticket WHERE event_id = :id';
    $stmt = $db->prepare($sql);
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindValue(':id', $id);
    $stmt->bindValue(':id', $id);

    $stmt2->execute();
    $stmt->execute();
    echo "DELETED";
}

function logout(){
    session_unset();
    session_destroy();
}
function register($username, $password, $email, $fname, $middle_name, $lname, $dob, $phone, $city, $address, $postal, $role){
    global $db;

    //TODO: make sure role here gets checked.. if the user manually passes role 1 it will give him admin rights!!!
    $hash = null;
    $hash = password_hash($password, PASSWORD_DEFAULT);//encrypt the password before saving in the database

    $exec_values = array(
          ':uname' => $username,
          ':password' => $hash,
          ':email' => validate_input($email),
          ':fname' => validate_input($fname),
          ':middle_name' => validate_input($middle_name),
          ':lname' => validate_input($lname),
          ':dob' => $dob,
          ':phone' => validate_input($phone),
          ':city' => validate_input($city),
          ':address' => validate_input($address),
          ':postal' => validate_input($postal),
          ':role' => validate_input($role)
    );

    $query = "INSERT INTO accounts (username, password, email, first_name, middle_name, last_name, dob, phone_number, city, address, postal_code, roles)
 VALUES(:uname, :password, :email, :fname, :middle_name, :lname, :dob, :phone, :city, :address, :postal, :role)";
    $tp = $db->prepare($query);
    $tp->execute($exec_values);
}
function getUserById($id){
    global $db;
    $stmt = $db->prepare('SELECT * FROM accounts WHERE account_id = ?');
    $stmt->execute([strip_tags($id)]);
    $user = $stmt->fetch();
    return $user;
}

function getUserByUsername($username){
    global $db;
    $stmt = $db->prepare('SELECT * FROM accounts WHERE username = ?');
    $stmt->execute([strip_tags($username)]);
    $user = $stmt->fetchAll();
    return $user;
}

function validate_input($data) { // check if the string passed is propper
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if(strpos($data, '"') == true || strpos($data, "'") == true){
       $data = str_replace("'", "dash", $data);
       $data = str_replace('"', "dash", $data);
    }
    if(strlen($data) < 1){
        $data = "Invalid string provided";
    }
    return $data;
}

function update_event($eventID ,$name, $description, $location,$event_date,$category,$starting_time,$img,$video){
    global $db;

    $exec_values = array(
        ':name' => $name,
        ':description' => $description,
        ':location' => $location,
        ':event_date' => $event_date,
        ':category' => $category,
        ':starting_time' => $starting_time,
        ':image' => $img,
        ':video' => $video,
        ':eventID' => $eventID
    );
    $query = "UPDATE events SET 
                  name = :name, 
                  description = :description, 
                  location = :location, 
                  event_date = :event_date, 
                  category = :category,
                  starting_time = :starting_time,
                  image = :image,
                  video = :video
                  WHERE event_id = :eventID";
    $tp = $db->prepare($query);
    $tp->execute($exec_values);
    echo 'UPDATED';
}
function validate_date($data){
    //TODO: determine how to validate date from html5 inputs and strip stuff.
}

function addEvent($id,$name, $description, $location,$event_date,$category, $amount_of_tickets, $starting_time,$img,$video, $uploader_id){
    // TODO: Create a functionality for adding events.
    global $db;
    $stmt = $db-> prepare("INSERT INTO events(name, description, location, event_date, category, amount_tickets, starting_time, uploader_id, image, video) 
        VALUES (:name, :description, :location, :event_date, :category, :amount_tickets, :starting_time, :uploader_id, :image, :video)");
    $stmt -> bindValue(':name', $name, PDO::PARAM_STR);
    $stmt -> bindValue(':description', $description, PDO::PARAM_STR);
    $stmt -> bindValue(':location', $location, PDO::PARAM_STR);
    $stmt -> bindValue(':event_date', $event_date, PDO::PARAM_INT);
    $stmt -> bindValue(':category', $category, PDO::PARAM_STR);
    $stmt -> bindValue(':amount_tickets', $amount_of_tickets, PDO::PARAM_INT);
    $stmt -> bindValue(':starting_time', $starting_time, PDO::PARAM_INT);
    $stmt -> bindValue(':uploader_id', $uploader_id, PDO::PARAM_INT);
    $stmt -> bindValue(':image', $img, PDO::PARAM_STR);
    $stmt -> bindValue(':video', $video, PDO::PARAM_STR);

    $stmt ->execute();

}
?>