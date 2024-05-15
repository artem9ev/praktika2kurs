<?php
header('Cache-Control: no-cache, must-revalidate');
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST['getTable'])){
        setcookie('getTable', $_POST['getTable'], time() + 3600);
    }
    else if (!empty($_POST['form_name'])){
        setcookie('form_name', $_POST['form_name'], time() + 3600);
        setcookie('product', $_POST['product'], time() + 3600);
        setcookie('fio', $_POST['fio'], time() + 3600);
    }

    header('Location: index.php'); // Делаем перенаправление.
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $messages = array();

    include('Scripts/SecretData.php');
    $servername = "localhost";
    $username = user;
    $password = pass;
    $dbname = user;
    $table_data = array(); // делаю массив для сохранения таблицы из бд
    $tableTitle = ''; // строка для заголовка таблицы

    $tableToGet = '';
    $formName = '';
    // проверяем нет ли текущих запросов от пользователя
    if (!empty($_COOKIE["getTable"])){
        $tableToGet = $_COOKIE["getTable"];
    }
    if (!empty($_COOKIE["form_name"])){
        $formName = $_COOKIE["form_name"];
    }
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        // обраюотка запросов на полный вывод таблиц
        if($tableToGet == 'providers'){
            $select = "SELECT * FROM Providers";
            $result = $db->query($select);
            $table_data[] = array('ID', 'НАЗВАНИЕ');
            $tableTitle = "Получена таблица производителей";
        }
        else if($tableToGet == 'products'){
            $select = "SELECT * FROM Products";
            $result = $db->query($select);
            $table_data[] = array('ID', 'НАЗВАНИЕ', 'ВЕС', 'ЦЕНА ЗАКУПКИ', 'ЦЕНА ПРОДАЖИ', 'ID ПОСТАВЩИКА');
            $tableTitle = "Получена таблица товаров";
        }
        else if($tableToGet == 'salesmans'){
            $select = "SELECT * FROM Salesmans";
            $result = $db->query($select);
            $table_data[] = array('ID', 'ФИО', 'ПРОЦЕНТ КОМИССИОННЫХ');
            $tableTitle = "Получена таблица продавцов";
        }
        else if($tableToGet == 'sales'){
            $select = "SELECT * FROM Sales";
            $result = $db->query($select);
            $table_data[] = array('ID', 'ID ТОВАРА', 'ID ПРОДАВЦА', 'ДАТА ПРОДАЖИ', 'КОЛИЧЕСТВО ПРОДАННЫХ ЕДИНИЦ ТОВАРА');
            $tableTitle = "Получена таблица продаж";
        }
        // обработка экранных форм
        else if($formName == 'form_1'){
            $name = '';
            if (!empty($_COOKIE['fio'])){
                $name = $_COOKIE['fio'];
            }
            $len = strlen($name) / 2;
            $select = "SELECT * FROM Salesmans WHERE SUBSTR(name, 1, $len) = '$name';";
            $result = $db->query($select);
            $table_data[] = array('ID', 'ФИО', 'ПРОЦЕНТ КОМИССИОННЫХ'); // добавляю первую строку в таблицу
            $tableTitle = "Получены продавцы содержащие в имени: $name";
        }
        else if($formName == 'form_2'){
            $name = '';
            if (!empty($_COOKIE['product'])){
                $name = $_COOKIE['product'];
            }
            $len = strlen($name) / 2;
            $select = "SELECT f.id, f.name, f.weight, f.buy_price, f.sale_price, s.name AS provider_name
             FROM Products f, Providers s WHERE SUBSTR(f.name, 1, $len) = '$name' AND f.provider_id = s.id;";
            $result = $db->query($select);
            $table_data[] = array('ID', 'НАЗВАНИЕ', 'ВЕС', 'ЦЕНА ЗАКУПКИ', 'ЦЕНА ПРОДАЖИ', 'ПОСТАВЩИК'); // добавляю первую строку в таблицу
            $tableTitle = "Получены товары начинающиеся на: $name";
        }
        else if($formName == 'form_3'){
    
        }

        // если есть результат, то заполняю таблицу для выводв данных
        if(!empty($result)){
            while($row = $result->fetch()){ // прохожу каждую строку таблицы из бд, которую получил в результате запроса
                $newRow = array();
                for($i = 0; $i < count($row) / 2; $i++){
                    $newRow[] = $row[$i];
                }
                $table_data[] = $newRow;
            }
            $messages[] = "Успешно полученно";
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
    setcookie('getTable', '', time() - 3600);
    setcookie('form_name', '', time() - 3600);
    setcookie('product', '', time() - 3600);
    setcookie('fio', '', time() - 3600);

    include('Scripts/forms.php'); // загрузил файл с формами
    include('Scripts/main-page.php'); // загружаю основную страницу
}
?>