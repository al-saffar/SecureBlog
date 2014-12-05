<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/Web-Security/config/secure_session.php';
//login method with prepare statement and check agains bruteforce
function login($username, $password, $mysqli) {
    if($stmt = $mysqli->prepare("SELECT userID, firstname FROM users WHERE username = ? AND password = ?"))
    {
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $stmt->store_result();
        
        $stmt->bind_result($userID, $firstname);
        $stmt->fetch();
        
        if($stmt->num_rows == 1)
        {
            if(checkbrute($ip, $username, $mysqli) == true)
            {
                return false;
            }
            else
            {
                // get browser info
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                
                // make sure it only contains numbers
                $userID = preg_replace("/[^0-9]+/", "", $userID);

                $_SESSION['userID'] = $userID; //save id into session
                
                // make sure it only contains letters and -
                $firstname = preg_replace("/[^a-zA-Z\-]+/", "", $firstname);

                $_SESSION['firstname'] = $firstname; //save in session
                
                $_SESSION['login_string'] = hash('sha512', $password . $user_browser); //generate a login_string(Hashed), so we can check if he is logged in(against session hijacking)

                // login successful.
                return true;
            }
        }
        else {
            // password is not correct and save login attempts on db, to protect against bruteforce
            $now = time(); //get current time in seconds
            
            //get IP
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            
            $mysqli->query("INSERT INTO login_attempts(IP, username, time)
                            VALUES ('$ip', '$username' , '$now')");
            return false;
        }
    }
}

//check if bruteforcing is happening and decline access
function checkbrute($ip, $username, $mysqli) {
    // get current time in secs
    $now = time();
 
    // block in 5 min
    $valid_attempts = $now - (5 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE ip = ? AND username = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('ss', $ip, $username);
 
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
    if (isset($_SESSION['userID'], $_SESSION['firstname'], $_SESSION['login_string'])) {
 
        //get them
        $userID = $_SESSION['userID'];
        $login_string = $_SESSION['login_string'];
        $firstname = $_SESSION['firstname'];
 
        // get browser
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        //get password for that user
        if ($stmt = $mysqli->prepare("SELECT password FROM users WHERE userID = ? LIMIT 1")) {
           
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
