<!DOCTYPE html>
<html lang="ru">

<head>
    <title>task 4</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="mainStyle.css" media="screen" />
    <script>
        var formlist = ['form_1', 'form_2', 'form_3', 'form_4', 'form_5', 'form_6', 'form_7'];
        // var formBlock = document.getElementById(element);
        // formBlock.classList.add('invisible');
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
    <h3>Главная страница</h3>
    <hr><br>

    <button onclick="ShowForm('form_1')" name="button1">Form1</button>
    <button onclick="ShowForm('form_2')" name="button2">Form2</button>
    <button onclick="ShowForm('form_3')" name="button3">Form3</button>

    <div class="formContainer">
        <div id="form_1" class="invisible">
            <form action="index.php" method="POST" id="svyaz">
                <label>
                    <strong> Фамилия имя отчество:</strong>
                    <br>
                    <input name="fio" type="text" placeholder="ФИО" />
                </label>
                <!-- <br>
                <label>
                    <strong>Должность: </strong>
                    <br>
                    <input name="job" type="text" placeholder="должность" />
                </label> -->
                <input type="submit" value="Найти сотрудника" />
            </form>
        </div>
        <div id="form_2" class="invisible">
            <form action="index.php" method="POST" id="svyaz">
                <label>
                    <strong>Товар:</strong>
                    <br>
                    <input name="product" type="text" placeholder="название товара" />
                </label>
                <!-- <br>
                <label>
                    <strong>Цена: </strong>
                    <br>
                    <input name="price" type="text" placeholder="цена товара" />
                </label> -->
                <br>
                <input type="submit" value="Найти товар" />
            </form>
        </div>
        <div id="form_3" class="invisible">
            <form action="index.php" method="POST" id="svyaz">
                <label>
                    <strong>Должность:</strong>
                    <br>
                    <input name="job" type="text" placeholder="название должности" />
                </label>
                <br>
                <input type="submit" value="Найти людей с должностью" />
            </form>
        </div>
    </div>
</body>

</html>