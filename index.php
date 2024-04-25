<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $selectedForm = "''";
    session_start();
    if(isset($_SESSION['form_name'])){
        $selectedForm = "'" . $_SESSION['form_name'] . "'";
    }
    $_SESSION['form_name'] = '';
    session_destroy();
    include('forms.php');
    include('main-page.php');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include('../../web-backend/SecretData.php');
    $servername = "localhost";
    // $username = user;
    // $password = pass;
    // $dbname = user;
    if($_POST["form_name"] == 'form_1'){
    
    }
    else if($_POST["form_name"] == 'form_2'){

    }
    else if($_POST["form_name"] == 'form_3'){

    }
    session_start();
    $_SESSION['form_name'] = $_POST['form_name'];
    //session_destroy();
    header('Location: index.php'); // Делаем перенаправление.
}
?>