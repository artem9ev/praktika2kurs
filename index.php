<?php
header('Cache-Control: no-cache, must-revalidate');
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST['form_name'])){
        setcookie('form_name', $_POST['form_name'], time() + 3600);
        setcookie('product', $_POST['product'], time() + 3600);
        header('Location: index.php'); // Делаем перенаправление.
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $messages = array();

    include('Scripts/SecretData.php');
    $servername = "localhost";
    $username = user;
    $password = pass;
    $dbname = user;
    $table_data = array(); // делаю массив для сохранения таблицы из бд

    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if($_POST["form_name"] == 'form_1'){

        }
        else if($_POST["form_name"] == 'form_2'){
            $len = strlen($_COOKIE['product']);
            $name = $_COOKIE['product'];
            $select = "select * from Products WHERE SUBSTR(name, 1, $len) = '$name';";
            $result = $db->query($select);
            $table_data[] = array('id', 'name', 'weight', 'buy_price', 'sale_price', 'provider_id'); // добавляю первую строку в таблицу
            while($row = $result->fetch()){ // прохожу каждую строку таблицы из бд, которую получил в результате запроса
                $table_data[] = array($row['id'], $row['name'], $row['weight'], $row['buy_price'], $row['sale_price'], $row['provider_id']);
                echo "yy - " . $row['id'] . " " . $row['name']. " " . $row['weight']. " " . $row['buy_price']. " " . $row['sale_price']. " " . $row['provider_id'] . '<br>';
            }
            $messages[] = "Успешно полученно";
        }
        else if($_POST["form_name"] == 'form_3'){
    
        }
    }
    catch(PDOException $e){
        $messages[] = 'Error : ' . $e->getMessage();
        echo 'Error : ' . $e->getMessage() . '<br>';
    }

    $selectedForm = "";
    if(!empty($_COOKIE['form_name'])){
        $selectedForm = $_COOKIE['form_name']; // сохраняем то какая форма была открыта
    }
    setcookie('form_name', '', time() - 3600);

    include('Scripts/forms.php'); // загрузил файл с формами
    include('Scripts/main-page.php'); // загружаю основную страницу
}
?>