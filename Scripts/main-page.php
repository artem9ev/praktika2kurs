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
        var formlist = ['form_1', 'form_2', 'form_3', 'form_4', 'form_5', 'form_6', 'form_7'];
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
        <h3>Оптовый магазин</h3>
        <hr><br>   
    </div>

    <div class="main-content">
        <div class="links-container">
            Вывести таблицы:
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
            Экранные формы:
            <button class="link-item" onclick="ShowForm('form_1')" name="button1">Form1</button>
            <button class="link-item" onclick="ShowForm('form_2')" name="button2">Form2</button>
            <button class="link-item" onclick="ShowForm('form_3')" name="button3">Form3</button>
        </div>
        <div class="content-container">
            <div class="form-item">
                <div class="">
                    <?php foreach($forms as $form){ // добавляю формы из forms.php
                        echo $form;
                    } ?>
                </div>
            </div>
            <div class="table-item"> 
                <div class="">
                    <?php echo $tableTitle ?>
                    <table>
                        <?php foreach($table_data as $row){ // прохожусь по массиву, доставая из него табличку
                            echo '<tr>';
                            foreach($row as $cell){
                                echo '<td>' . $cell . '</td>';
                            }
                            echo '</tr>';
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>SelectFormOnGet()</script>
    <?php
    if (!empty($messages)) {
      print('<div id="messages">');
      foreach ($messages as $message) {
        print($message);
      }
      print('</div>');
    }
    ?>
</body>

</html>