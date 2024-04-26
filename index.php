<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $messages = array();
    $selectedForm = "''";
    session_start();
    if(isset($_SESSION['form_name'])){
        $selectedForm = "'" . $_SESSION['form_name'] . "'";
    }
    if(isset($_SESSION['mas'])){
        $mas = $_SESSION['mas'];
        foreach($mas as $m){
            $messages[] = $m;
        }
    }
    $_SESSION['form_name'] = '';
    session_destroy();
    $table = empty($_COOKIE['table']) ? array() : unserialize($_COOKIE['table']);
    setcookie('table', '', time() -1000);
    include('forms.php');
    include('main-page.php');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include('../../web-backend/SecretData.php');
    $servername = "localhost";
    $username = user;
    $password = pass;
    $dbname = user;
    $mas = array();
    $table_data = array();
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if($_POST["form_name"] == 'form_1'){
    
        }
        else if($_POST["form_name"] == 'form_2'){
            //select * from Products where substr(name_prod, 1, 1) = 'c';
            $select = "select * from Products where substr(name_prod, 1, :lengthName) = ':productName';";
            $result = $db->query($select);
            $str_len = strlen($_POST['product']);
            $result->bindParam(":lengthName", $str_len);
            $result->bindParam(":productName", $_POST['product']);
            $table_data[] = array('id', 'name', 'price');
            while($row = $result->fetch()){
                $newrow = array();
                $newrow[] = $row['id_prod'];
                $newrow[] = $row['name_prod'];
                $newrow[] = $row['price_prod'];
                $table_data[] = $newrow;
            }
            setcookie('table', serialize($table_data));
            $mas[] = "Успешно полученно";
        }
        else if($_POST["form_name"] == 'form_3'){
    
        }
    }
    catch(PDOException $e){
        $mas[] = 'Error : ' . $e->getMessage();
        exit();
    }
    session_start();
    $_SESSION['form_name'] = $_POST['form_name'];
    $_SESSION['mas'] = $mas;
    //session_destroy();
    header('Location: index.php'); // Делаем перенаправление.
}
?>