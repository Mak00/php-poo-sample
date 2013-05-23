<?php

/**
 * class Login 
 * login/registration/home
 * 
 * @author Malek <abdelmalek.beloula@gmail.com>
 * @version 1.0
 */
class Login {

    private $connection = null;                     // database connection   
    private $user_name = "";                       
    private $user_email = "";                       
    private $user_password = "";                       
    private $user_password_hash = "";                       
    private $user_is_logged_in = false;                    
    public $registered = false;
    public $view_user_name = "";
    public $view_user_email = "";
    
    // errors and messages
    public $errors = array();                    // collection of error messages
    public $messages = array();                  // collection of success and alterts

   /**
    * construct
    * @param Database $db
    */

    public function __construct(Database $db) {
       
        $this->connection = $db->getDatabaseConnection();          // get the connection          

        if ($this->connection) {                                    //check the connection
            session_start();                                        // create/read session

            if (isset($_POST["register"])) {

                $this->registerNewUser();
                
            } elseif (isset($_GET["logout"])) {

                $this->logout();
                
            } elseif (!empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)) {

                $this->loginWithSessionData();
                
            } elseif (isset($_POST["login"])) {

                if (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

                    $this->loginWithPostData();
                    
                } elseif (empty($_POST['user_name'])) {

                    $this->errors[] = "Empty User name.";
                    
                } elseif (empty($_POST['user_password'])) {

                    $this->errors[] = "Empty Password.";
                }
            }
        } else {

            $this->errors[] = "No MySQL connection.";
        }

        // cookie handling the user name
        if (isset($_COOKIE['user_name'])) {
            
            $this->view_user_name = strip_tags($_COOKIE["user_name"]);
            
        } else {
            
            $this->view_user_name = "Username";
        }
    }

    private function loginWithSessionData() {

        $this->user_is_logged_in = true;
    }

    private function loginWithPostData() {

        $this->user_name = $this->connection->real_escape_string($_POST['user_name']);
        $checklogin = $this->connection->query("SELECT user_name, user_email, user_password_hash FROM users WHERE user_name = '" . $this->user_name . "';");

        if ($checklogin->num_rows == 1) {

            $result_row = $checklogin->fetch_object();

            if (crypt($_POST['user_password'], $result_row->user_password_hash) == $result_row->user_password_hash) {

                /**
                 *  save the user data in the session
                 */
                $_SESSION['user_name'] = $result_row->user_name;
                $_SESSION['user_email'] = $result_row->user_email;
                $_SESSION['user_logged_in'] = 1;

                /**
                 *  write user data into COOKIE
                 */
                setcookie("user_name", $result_row->user_name, time() + (3600 * 24 * 100));
                setcookie("user_email", $result_row->user_email, time() + (3600 * 24 * 100));

                $this->user_is_logged_in = true;
                return true;
            } else {

                $this->errors[] = "Wrong password. Try again.";
                return false;
            }
        } else {

            $this->errors[] = "Unknown user.";
            return false;
        }
    }

    public function logout() {

        $_SESSION = array();
        session_destroy();
        $this->user_is_logged_in = false;
        $this->messages[] = "You have been logged out.";
    }

    public function isUserLoggedIn() {

        return $this->user_is_logged_in;
    }

    public function displayRegisterPage() {

        if (isset($_GET["register"])) {

            return true;
            
        } else {

            return false;
        }
    }
    
    private function registerNewUser() {

        if (empty($_POST['user_name'])) {

            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {

            $this->errors[] = "Empty Password";
        } elseif ($_POST['user_password_new'] != $_POST['user_password_repeat']) {

            $this->errors[] = "Password and password repeat are not the same";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password_new']) && !empty($_POST['user_password_repeat']) && ($_POST['user_password_new'] == $_POST['user_password_repeat'])) {

            // escapin' this
            $this->user_name = $this->connection->real_escape_string($_POST['user_name']);
            $this->user_password = $this->connection->real_escape_string($_POST['user_password_new']);
            $this->user_password_repeat = $this->connection->real_escape_string($_POST['user_password_repeat']);
            $this->user_email = $this->connection->real_escape_string($_POST['user_email']);

            // cut data down to max 64 chars to prevent database flooding
            $this->user_name = substr($this->user_name, 0, 64);
            $this->user_password = substr($this->user_password, 0, 64);
            $this->user_password_repeat = substr($this->user_password_repeat, 0, 64);
            $this->user_email = substr($this->user_email, 0, 64);


            function getSalt($length) {

                $options = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
                $salt = '';

                for ($i = 0; $i <= $length; $i++) {
                    $options = str_shuffle($options);
                    $salt .= $options [rand(0, 63)];
                }
                return $salt;
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $max_salt = CRYPT_SALT_LENGTH;
         
            //see: php.net/manual/en/function.crypt.php
            $hashing_algorithm = '$2a$10$';

            //get the longest salt
            $salt = getSalt($max_salt);
            $this->user_password_hash = crypt($this->user_password, $hashing_algorithm . $salt);

            $query_check_user_name = $this->connection->query("SELECT * FROM users WHERE user_name = '" . $this->user_name . "'");

            if ($query_check_user_name->num_rows == 1) {

                $this->errors[] = "Sorry, that user name is already taken.<br/>Please choose another one.";
            } else {

                $query_new_user_insert = $this->connection->query("INSERT INTO users (user_name, user_password_hash, user_email) VALUES('" . $this->user_name . "', '" . $this->user_password_hash . "', '" . $this->user_email . "')");

                if ($query_new_user_insert) {

                    $this->messages[] = "Your account was successfully created.<br/>Please <a href='index.php' class='green_link'>click here to login</a>.";
                    $this->registered = true;
                } else {

                    $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                }
            }
        }
    }

}