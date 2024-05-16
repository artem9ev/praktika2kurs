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
        setcookie('comission', $_POST['comission'], time() + 3600);
        setcookie('date1', $_POST['date1'], time() + 3600);
        setcookie('date2', $_POST['date2'], time() + 3600);
        setcookie('price1', $_POST['price1'], time() + 3600);
        setcookie('price2', $_POST['price2'], time() + 3600);
    }
    else if (!empty($_POST['groupTable'])){
        setcookie('groupTable', $_POST['groupTable'], time() + 3600);
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
    $tableString = array();
    $tableTitle = ''; // строка для заголовка таблицы
    $isGetted = false;

    $tableToGet = '';
    $formName = '';
    $tableToGroup = '';
    // проверяем нет ли текущих запросов от пользователя
    if (!empty($_COOKIE["getTable"])){
        $tableToGet = $_COOKIE["getTable"];
    }
    if (!empty($_COOKIE["form_name"])){
        $formName = $_COOKIE["form_name"];
    }
    if (!empty($_COOKIE["groupTable"])){
        $formName = $_COOKIE["groupTable"];
    }
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        // обраюотка запросов на полный вывод таблиц
        if($tableToGet == 'providers'){
            $select = "SELECT * FROM Providers";
            $result = $db->query($select);
            $tableString = array('ID', 'НАЗВАНИЕ');
            $tableTitle = "Получена таблица производителей";
        }
        else if($tableToGet == 'products'){
            $select = "SELECT * FROM Products";
            $result = $db->query($select);
            $tableString = array('ID', 'НАЗВАНИЕ', 'ВЕС', 'ЦЕНА ЗАКУПКИ', 'ЦЕНА ПРОДАЖИ', 'ID ПРОИЗВОДИТЕЛЯ');
            $tableTitle = "Получена таблица товаров";
        }
        else if($tableToGet == 'salesmans'){
            $select = "SELECT * FROM Salesmans";
            $result = $db->query($select);
            $tableString = array('ID', 'ФИО', 'ПРОЦЕНТ КОМИССИОННЫХ');
            $tableTitle = "Получена таблица продавцов";
        }
        else if($tableToGet == 'sales'){
            $select = "SELECT * FROM Sales";
            $result = $db->query($select);
            $tableString = array('ID', 'ID ТОВАРА', 'ID ПРОДАВЦА', 'ДАТА ПРОДАЖИ', 'КОЛИЧЕСТВО ПРОДАННЫХ ЕДИНИЦ ТОВАРА');
            $tableTitle = "Получена таблица продаж";
        }
        // обработка экранных форм
        else if($formName == 'form_1'){
            $name = '';
            if (!empty($_COOKIE['fio'])){
                $name = $_COOKIE['fio'];
            }
            $len = strlen($name) / 2;
            $select = "SELECT * FROM Salesmans WHERE SUBSTR(full_name, 1, $len) = '$name';";
            $result = $db->query($select);
            $tableString = array('ID', 'ФИО', 'ПРОЦЕНТ КОМИССИОННЫХ'); // добавляю первую строку в таблицу
            $tableTitle = "Получены продавцы содержащие в имени: '$name'";
        }
        else if($formName == 'form_2'){
            $com = 0;
            if (!empty($_COOKIE['comission'])){
                $com = $_COOKIE['comission'];
            }
            $select = "SELECT * FROM Salesmans WHERE commision_percentage > $com;";
            $result = $db->query($select);
            $tableString = array('ID', 'ФИО', 'ПРОЦЕНТ КОМИССИОННЫХ'); // добавляю первую строку в таблицу
            $tableTitle = "Получены продавцы с процентом комиссионных больше чем: $com";
        }
        else if($formName == 'form_3'){
            $name = '';
            if (!empty($_COOKIE['product'])){
                $name = $_COOKIE['product'];
            }
            $len = strlen($name) / 2;
            $select = "SELECT * FROM Products WHERE SUBSTR(name, 1, $len) = '$name';";
            $result = $db->query($select);
            $tableString = array('ID', 'НАЗВАНИЕ', 'ВЕС', 'ЦЕНА ЗАКУПКИ', 'ЦЕНА ПРОДАЖИ', 'ПРОИЗВОДИТЕЛЬ'); // добавляю первую строку в таблицу
            $tableTitle = "Получены продавцы содержащие в имени: '$name'";
        }
        else if($formName == 'form_4'){
            $date1 = '';
            $date2 = '';
            if (!empty($_COOKIE['date1']) && !empty($_COOKIE['date2'])){
                $date1 = $_COOKIE['date1'];
                $date2 = $_COOKIE['date2'];
            }
            $select = "SELECT p.name, o.name, p.buy_price, p.sale_price, s.number_of_units, sm.full_name, s.sale_date 
            FROM Products p, Salesmans sm, Sales s, Providers o
            WHERE p.id = s.product_id AND sm.id = s.salesman_id AND o.id = p.provider_id AND s.sale_date BETWEEN '$date1' AND '$date2';";
            $result = $db->query($select);
            $tableString = array('НАЗВАНИЕ', 'ПРОИЗВОДИТЕЛЬ', 'ЦЕНА ЗАКУПКИ', 'ЦЕНА ПРОДАЖИ', 'КОЛИЧЕСТВО', 'ПРОДАВЕЦ', 'ДАТА'); // добавляю первую строку в таблицу
            $tableTitle = "Получены продажи с датами от '$date1' и до '$date2'";
        }
        else if($formName == 'form_5'){
            $price1 = '';
            $price2 = '';
            if (!empty($_COOKIE['price1']) && !empty($_COOKIE['price2'])){
                $price1 = $_COOKIE['price1'];
                $price2 = $_COOKIE['price2'];
            }
            $select = "SELECT * FROM Products
            WHERE sale_price BETWEEN '$price1' AND '$price2';";
            $result = $db->query($select);
            $tableString = array('ID', 'НАЗВАНИЕ', 'ВЕС', 'ЦЕНА ЗАКУПКИ', 'ЦЕНА ПРОДАЖИ', 'ID ПРОИЗВОДИТЕЛЯ');
            $tableTitle = "Получены товары с ценами от '$price1' и до '$price2'";
        }
        // Группировки таблиц
        else if($tableToGroup == 'products'){
            $select = "SELECT name, AVG(buy_price), AVG(sale_price) FROM Products GROUP BY name";
            $result = $db->query($select);
            $tableString = array('НАЗВАНИЕ', 'СРЕДНЯЯ ЦЕНА ЗАКУПКИ', 'СРЕДНЯЯ ЦЕНА ПРОДАЖИ');
            $tableTitle = "Сгруппированная таблица продаж по названию товара";
        }
        else if($tableToGroup == 'sales'){
            $select = "SELECT s.product_id, p.name, MAX(s.number_of_units), MIN(s.number_of_units) 
            FROM Sales s, Products p GROUP BY s.product_id";
            $result = $db->query($select);
            $tableString = array('ID ТОВАРА', 'НАЗВАНИЕ ТОВАРА', 'МАКС. КОЛ-ВО ПРОДАННЫХ ЕД', 'МИН. КОЛ-ВО ПРОДАННЫХ ЕД');
            $tableTitle = "Сгруппированная таблица продаж по коду товара";
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
            //$messages[] = "Успешно полученно";
            $isGetted = true;
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
    setcookie('comission', '', time() - 3600);
    setcookie('date1', '', time() - 3600);
    setcookie('date2', '', time() - 3600);
    setcookie('price1', '', time() - 3600);
    setcookie('price2', '', time() - 3600);

    setcookie('groupTable', '', time() - 3600);

    include('Scripts/forms.php'); // загрузил файл с формами
    include('Scripts/main-page.php'); // загружаю основную страницу
}
?>