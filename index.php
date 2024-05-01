<?php
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
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        echo "Database connection<br>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . '<br>';
    }
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if($_POST["form_name"] == 'form_1'){
    
        }
        else if($_POST["form_name"] == 'form_2'){
            $len = strlen($_POST['product']);
            $name = $_POST['product'];
            $select = "select * from Products where substr(name_prod, 1, $len) = '$name';";
            $result = $db->query($select);
            $table_data[] = array('id', 'name', 'price'); // добавляю первую строку в таблицу
            echo 'Пытаюсь взять строку<br>';
            while($row = $result->fetch()){ // прохожу каждую строку таблицы из бд, которую получил в результате запроса
                $newrow = array();
                $newrow[] = $row['id_prod']; // присваиваю значения по именам столбцов из таблицы в бд
                $newrow[] = $row['name_prod'];
                $newrow[] = $row['price_prod'];
                $table_data[] = $newrow;
            }
            setcookie('table', serialize($table_data)); // сохраняю табличку в куки
            $mas[] = "Успешно полученно";
            echo 'Успешно полученно<br>';
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