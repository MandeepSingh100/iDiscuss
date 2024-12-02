<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $loginEmail = $_POST['loginEmail'];
    $loginPass = $_POST['loginPass'];

    $sql = "select * from users where user_email='$loginEmail'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($loginPass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['useremail'] = $loginEmail;
            echo "logged in ". $loginEmail;
        } 
        header("Location: /phpt/forum/index.php");  
    }
   header("Location: /phpt/forum/index.php");  
}

?>