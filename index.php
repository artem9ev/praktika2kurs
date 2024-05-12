<?php
header('Cache-Control: no-cache, must-revalidate');
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $messages = array();
    $selectedForm = "''";
    if(!empty($_COOKIE['form_name'])){
        $selectedForm = "'" . $_COOKIE['form_name'] . "'";
    }
    setcookie('form_name', '', time() - 3600);

    if(!empty($_COOKIE['mas'])){
        $mas = unserialize($_COOKIE['mas']);
        foreach($mas as $m){
            $messages[] = $m;
        }
    }
    $table = empty($_COOKIE['table']) ? array() : unserialize($_COOKIE['table']);
    setcookie('table', '', time() -1000);
    include('Scripts/forms.php'); // загрузил файл с формами
    include('Scripts/main-page.php'); // загружаю основную страницу
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include('Scripts/SecretData.php');
    $servername = "localhost";
    $username = user;
    $password = pass;
    $dbname = user;
    $mas = array();
    $table_data = array(); // делаю массив для сохранения таблицы из бд
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if($_POST["form_name"] == 'form_1'){
            (name, weight, buy_price, sale_price, provider_id)
        }
        else if($_POST["form_name"] == 'form_2'){
            $len = strlen($_POST['product']);
            $name = $_POST['product'];
            $select = "select * from Products where substr(name, 1, $len) = '$name';";
            $result = $db->query($select);
            $table_data[] = array('id', 'name', 'weight', 'buy_price', 'sale_price', 'provider_id'); // добавляю первую строку в таблицу
            while($row = $result->fetch()){ // прохожу каждую строку таблицы из бд, которую получил в результате запроса
                $table_data[] = array($row['id'], $row['name'], $row['weight'], $row['buy_price'], $row['sale_price'], $row['provider_id']);
            }
            setcookie('table', serialize($table_data)); // сохраняю табличку в куки
            $mas[] = "Успешно полученно";
        }
        else if($_POST["form_name"] == 'form_3'){
    
        }
    }
    catch(PDOException $e){
        $mas[] = 'Error : ' . $e->getMessage();
        echo 'Error : ' . $e->getMessage() . '<br>';

        exit();
    }
    setcookie('form_name', $_POST['form_name']); // 
    setcookie('mas', serialize($mas));
    //session_destroy();
    header('Location: index.php'); // Делаем перенаправление.
}
?>