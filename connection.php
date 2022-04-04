<?php

// connecting to the server 
$server = "sql108.epizy.com";
$username = "epiz_31448064";
$password ="OS2TPwdIIvMa";
$dbname = "epiz_31448064_loginandregistration";

$conn = mysqli_connect($server,$username,$password,$dbname);

if(!$conn){
    die("connection failed:".mysqli_connect_error());
}

// end of connection to server

    // step4/5 we are storing variables in the gloabl scope 
    // these errors will have to be shown in the html side
    // we use a constant because we are repeating the same message
    // after they type in the wrong info we will supply another specific messsage
    define( 'REQUIRED_FIELD_ERROR', 'This field is required.');
    $errors = [];

    $username = '';
    $email = '';
    $password = '';
    $password_confirm = '';
    $cv_url = '';
    
    // step 1, we are checking if post data exists
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    // step 2/3 
    //here we are creating variables from input values after securing them
    $username = post_data('username');
    $email = post_data('email');
    $password = post_data('password');
    $password_confirm = post_data('password_confirm');
    $cv_url = post_data('cv_url');

    //echo '<pre>';
    //var_dump($username,$email,$password, $password_confirm, $cv_url);
    //echo '</pre>';

    // step 4 => step 5 would be to show these under their fields. / create classes and divs
    // what if these values arent submitted properly, we need
    // to show the errors to the users
 
    if(!$username){
        // if username doesnt exist, output this message
        $errors['username'] = REQUIRED_FIELD_ERROR;
    } else if( strlen($username) > 16 ||  strlen($username) < 6 ){
        $errors['username'] = 'Password must be inbetween 6 & 16 characters.';
    }

    if(!$email){
        // if email doesnt exist, output this message
        //validate email and output new error
       $errors['email'] = REQUIRED_FIELD_ERROR;
    } else if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
        $errors['email'] = 'Please use a valid email.';
    }
 
    if(!$password){
        // if username doesnt exist, output this message
         $errors['password'] = REQUIRED_FIELD_ERROR;
    }
    if(!$password_confirm){
        // if username doesnt exist, output this message
     $errors['password_confirm'] = REQUIRED_FIELD_ERROR;
    } 
    // this statement checks to see if the two fields exists and match
    if ($password && $password_confirm && strcmp($password, $password_confirm)!== 0){
        $errors['password_confirm'] = 'This must match the password field.';
    }

    // here the email is optional, so we take away the!
    if($cv_url && !filter_var($cv_url, FILTER_VALIDATE_URL )){
        // if username doesnt exist, output this message
        $errors['cv_url'] = 'Please provide valid link';
    } 

    //step 6 if nothing was written inside errors, this is where we would save the data
    // here we are just going to tell the users thank you.
    if(empty ($errors) ){
        echo 'Everything is good.'.'<br> <br>';
    }

}

    // step 2/3 we are securing data
    //if $field doesnt exist set it to empty, then make it secure through tests 
    // we run tests globally so that anything sent to the server wont be hacked. this is why it isnt inside the function above
    function post_data($field)
    {
        if (!isset($_POST[$field])) {
            return false;
        }
        $data = $_POST[$field];
        return htmlspecialchars(stripslashes(trim($data)));
    }
    ?>
