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

    $formName = '';
    if (!empty($_COOKIE["form_name"])){
        $formName = $_COOKIE["form_name"];
    }
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if($formName == 'form_1'){

        }
        else if($formName == 'form_2'){
            $name = '';
            if (!empty($_COOKIE['product'])){
                $name = $_COOKIE['product'];
            }
            $len = strlen($name) / 2;
            $select = "SELECT f.id, f.name, f.weight, f.buy_price, f.sale_price, s.name
             FROM Products f, Providers s WHERE SUBSTR(name, 1, $len) = '$name' AND f.provider_id = s.id;";
            $result = $db->query($select);
            $table_data[] = array('ID', 'НАЗВАНИЕ', 'ВЕС', 'ЦЕНА ЗАКУПКИ', 'ЦЕНА ПРОДАЖИ', 'ПОСТАВЩИК'); // добавляю первую строку в таблицу
            while($row = $result->fetch()){ // прохожу каждую строку таблицы из бд, которую получил в результате запроса
                $table_data[] = 
                    array($row['id'], $row['name'], $row['weight'], $row['buy_price'], $row['sale_price'], $row['provider_id']);
            }
            $messages[] = "Успешно полученно";
        }
        else if($formName == 'form_3'){
    
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