<?php
class Account {
    // Properties
    private $username;
    private $userRole;

    // Methods
    function get_name() {
        return $this->$username;
    }



    function login($email, $ps){
        global $db;
        $query = "SELECT * FROM accounts WHERE  email = :email";
        $tp = $db->prepare($query);
        $tp->execute([':email' => validate_input($email)]);
        $res = $tp->fetch();
        if (password_verify($ps, $res['password'])) { // password from db here is hashed.
            $this->username = $res['username'];
            $this->userRole = $res['roles'];
            $_SESSION['UserID'] = $res['account_id'];
            $_SESSION['token'] = $res['password'];
            return $res;
        }
        else {
            return null;
        }
    }
    function check_username($username){ // checks to see if the username is valid before upload.
        global $db;
        $query = "SELECT * FROM accounts WHERE  username = :username";
        $tp = $db->prepare($query);
        $tp->execute([':username' => validate_input($username)]);
        $res = $tp ->fetch();

    }

    function getUserRole(){
        return $this->userRole;
    }
}