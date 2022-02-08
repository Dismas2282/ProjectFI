<?php

session_start();

require 'config/db.php';
require_once 'emailController.php';

$errors = array();
$username='';
$email='';

//=============================================================================
//===============================| REGISTER |==================================
//=============================================================================

if(isset($_POST['signup-btn']))
{
    $username = $_POST['username'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $passwordConf= $_POST['passwordConf'];

    if(empty($username)){
        $errors['username'] = "Username required";
    }
    if(empty($email)){
        $errors['email'] = "Email required";
    }

    if(!filter_var($email,FILTER_VALIDATE_EMAIL))    $errors['email'] = "Email adress is invalid";

    if(empty($password)){
        $errors['password'] = "Password required";
    }
    if($password != $passwordConf){
        $errors['passwordConf'] = "Both passwords must match up!";
    }

    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt ->bind_param('s', $email);
    $stmt -> execute();
    $result= $stmt -> get_result();
    $userCount = $result->num_rows;

    if($userCount > 0){
        $error['email'] = "Emial already exists";
    }

    if(count($errors) === 0){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = false;

        $sql = "INSERT INTO users (username, email, verified, token, password) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt ->bind_param('ssbss', $username, $email, $verified, $token, $password);

        if($stmt->execute()){

            $user_id = $conn->insert_id;
            $_SESSION['id'] = $user_id; 
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = $verified;

            sendVerficationEmail($email, $token);

            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert-success";
            header('Location: index.php');
            exit();
        }else{
            $errors['db_error'] = "Database error: failed to register";
        }

    }
}

//=============================================================================
//==================================| LOGIN |==================================
//=============================================================================

if(isset($_POST['login-btn']))
{
    $username = $_POST['username'];
    $password= $_POST['password'];

    if(empty($username)){
        $errors['username'] = "Username required";
    }

    if(empty($password)){
        $errors['password'] = "Password required";
    }

    if(count($errors) === 0)
    {
        $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $result = $stmt -> get_result();
        $user= $result->fetch_assoc();

        if(password_verify($password, $user['password'])  )
        {
            $_SESSION['id'] = $user['id']; 
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = $user['verified'];

            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert-success";
            header('Location: index.php');
            exit();
        }
        else{
            $errors['login_fail']="Invalid password :(";
        }
    }

}

    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['email']);
        unset($_SESSION['verified']);

        unset($_SESSION['val']);
        unset($_SESSION['watchedFlash']);
        header('Location: login.php');
        exit();
    }
//=============================================================================
//======================| User verification by token |=========================
//=============================================================================

    function verifyUser($token)
    {
        global $conn;
        $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $user = mysqli_fetch_assoc($result);
            $update_query = "UPDATE users SET verified=1 WHERE token='$token'";
            
            if(mysqli_query($conn, $update_query ))
            {

                $_SESSION['id'] = $user['id']; 
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = 1;

                $_SESSION['message'] = "Your email address was successfuly verified!";
                $_SESSION['alert-class'] = "alert-success";
                header('Location: index.php');
                exit();

            }

        }else
        echo 'User not found';

    }