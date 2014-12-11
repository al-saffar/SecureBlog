<?php
require_once ('./config/autoLoader.php');
//login method with prepare statement and check agains bruteforce
function login($mail, $password, $mysqli) {
    $type = -1;
    if($stmt = $mysqli->prepare("SELECT id, firstname, lastname, type FROM users WHERE id = (SELECT user_id FROM prvlg WHERE email = ? AND www = ?)"))
    {
        $stmt->bind_param('ss', $mail, $password);
        $stmt->execute();
        $stmt->store_result();
        
        $stmt->bind_result($userID, $firstname, $lastname, $type);
        $stmt->fetch();
        
        //get IP
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        if($stmt->num_rows == 1)
        {
            if(checkbrute($ip, $mail, $mysqli) == true)
            {
                return -1;
            }
            else
            {
                // get browser info
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                
                // make sure it only contains numbers
                $userID = preg_replace("/[^0-9]+/", "", $userID);
                $_SESSION['userID'] = $userID; //save id into session
                
                // make sure it only contains numbers
                $type = preg_replace("/[^0-9]+/", "", $type);
                $_SESSION['type'] = $type; //save it into session
                
                // make sure it only contains letters and -
                $firstname = preg_replace("/[^a-zA-Z\-]+/", "", $firstname);
                $_SESSION['firstname'] = $firstname; //save in session
                
                // make sure it only contains letters and -
                $lastname = preg_replace("/[^a-zA-Z\-]+/", "", $lastname);
                $_SESSION['lastname'] = $lastname; //save in session
                
                $_SESSION['login_string'] = hash('sha512', $password . $user_browser); //generate a login_string(Hashed), so we can check if he is logged in(against session hijacking)

                // login successful.
                return $type;
            }
        }
        else {
            // password is not correct and save login attempts on db, to protect against bruteforce
            $now = time(); //get current time in seconds
            
            $mysqli->query("INSERT INTO login_attempts(ip, email, time)
                            VALUES ('$ip', '$mail' , '$now')");
            return -1;
        }
    }
}

//check if bruteforcing is happening and decline access
function checkbrute($ip, $mail, $mysqli) {
    // get current time in secs
    $now = time();
 
    // block in 5 min
    $valid_attempts = $now - (30 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE ip = ? AND mail = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('ss', $ip, $mail);
 
        $stmt->execute();
        $stmt->store_result();
 
        //check if we have tried to look in 3 times without success
        if ($stmt->num_rows > 3) {
            return true;
        } else {
            return false;
        }
    }
}

//check if we are logged in
function login_check($mysqli) {
    
    //are the session variables set
    if (isset($_SESSION['userID'], $_SESSION['login_string'])) {
 
        //get them
        $userID = $_SESSION['userID'];
        $login_string = $_SESSION['login_string'];
 
        // get browser
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        //get password for that user
        if ($stmt = $mysqli->prepare("SELECT www FROM prvlg WHERE userID = ? LIMIT 1")) {
           
            $stmt->bind_param('i', $userID);
            $stmt->execute(); 
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                
                //if the user exist save password in variable
                $stmt->bind_result($password);
                $stmt->fetch();
                
                //generate our login check (HASHING)
                $login_check = hash('sha512', $password . $user_browser);
 
                //if we get the same result, which means no session hijacking
                if ($login_check == $login_string) {
                    // then we are logged in
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

?>
