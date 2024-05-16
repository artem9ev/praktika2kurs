<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Практика</title>
    <meta charset="UTF-8">
    <?php 
    $v = rand();
    echo "<link rel='stylesheet' type='text/css' href='Data/mainStyle.css?v=$v' media='screen' />";
    echo "<link rel='stylesheet' type='text/css' href='Data/tables.css?v=$v' media='screen' />";
    echo "<script>var selectedForm='$selectedForm'</script>"; 
    ?>
    <script>
        var formlist = ['form_1', 'form_2', 'form_3', 'form_4', 'form_5', 'form_6', 'form_7', 'form_8'];
        function SelectFormOnGet(){
            if (selectedForm!=''){
                var formBlock = document.getElementById(selectedForm);
                formBlock.classList.remove('invisible');
            }
        }
        function ShowForm(formID) {
            formlist.forEach(element => {
                var formBlock = document.getElementById(element);
                if (element == formID) {
                    formBlock.classList.remove('invisible');
                }
                else {
                    formBlock.classList.add('invisible');
                }
            });
        }
    </script>
</head>

<body>
    <div>
        <h1>Оптовый магазин</h1>
        <hr><br>   
    </div>

    <div class="main-content">
        <div class="links-container">
            <h3>Вывод таблиц:</h3>
            <form class="getTableForm" action="index.php" method="POST">
                <input type="hidden" name="getTable" value="providers">
                <input class="link-item" type="submit" value="Отобразить производителей" />
            </form>
            <form class="getTableForm" action="index.php" method="POST">
                <input type="hidden" name="getTable" value="products">
                <input class="link-item" type="submit" value="Отобразить товары" />
            </form>
            <form class="getTableForm" action="index.php" method="POST">
                <input type="hidden" name="getTable" value="salesmans">
                <input class="link-item" type="submit" value="Отобразить продавцов" />
            </form>
            <form class="getTableForm" action="index.php" method="POST">
                <input type="hidden" name="getTable" value="sales">
                <input class="link-item" type="submit" value="Отобразить продажи" />
            </form>
            <h3>Экранные формы:</h3>
            <button class="link-item" onclick="ShowForm('form_1')" name="button1">Поиск сотрудников по ФИО</button>
            <button class="link-item" onclick="ShowForm('form_2')" name="button2">Поиск сотрудников по комиссионным</button>
            <button class="link-item" onclick="ShowForm('form_3')" name="button3">Поиск товаров</button>
            <button class="link-item" onclick="ShowForm('form_4')" name="button4">Продажи по датам</button>
            <button class="link-item" onclick="ShowForm('form_5')" name="button5">Товары по ценам</button>
            <h3>Вывести сгруппированные данные:</h3>
            <form class="getTableForm" action="index.php" method="POST">
                <input type="hidden" name="groupTable" value="products">
                <input class="link-item" type="submit" value="Сгруппировать товары по названиям" />
            </form>
            <form class="getTableForm" action="index.php" method="POST">
                <input type="hidden" name="groupTable" value="sales">
                <input class="link-item" type="submit" value="Сгруппировать продажи по товарам" />
            </form>
        </div>
        <div class="content-container">
            <div class="form-item">
                <div class="">
                    <?php foreach($forms as $form){ // добавляю формы из forms.php
                        echo $form;
                    } ?>
                </div>
            </div>
            <?php
            if (!empty($messages)) {
                print('<div id="messages">');
                foreach ($messages as $message) {
                    print($message);
                }
                print('</div>');
            }
            ?>
            <div class="table-item"> 
                <div class="">
                    <h2><?php echo $tableTitle ?></h2>
                    <table>
                        <?php 
                        if(!empty($table_data)){
                            echo '<tr>';
                            foreach($tableString as $cell){
                                echo '<td>' . $cell . '</td>';
                            }
                            echo '</tr>';
                            foreach($table_data as $row){ // прохожусь по массиву, доставая из него табличку
                                echo '<tr>';
                                foreach($row as $cell){
                                    echo '<td>' . $cell . '</td>';
                                }
                                echo '</tr>';
                            }
                        }
                        else if($isGetted){
                            echo '<h2><strong>Нет результатов</strong></h2>';
                        }
                        else {
                            echo 'пусто';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>SelectFormOnGet()</script>
</body>

</html>