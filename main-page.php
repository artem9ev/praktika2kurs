<!DOCTYPE html>
<html lang="ru">

<head>
    <title>task 4</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="mainStyle.css" media="screen" />
    <?php echo "<script>var selectedForm=$selectedForm</script>"; ?>
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
    <h3>Главная страница</h3>
    <hr><br>

    <button onclick="ShowForm('form_1')" name="button1">Form1</button>
    <button onclick="ShowForm('form_2')" name="button2">Form2</button>
    <button onclick="ShowForm('form_3')" name="button3">Form3</button>

    <div class="formContainer">
        <?php foreach($forms as $form){ // добавляю формы из forms.php
            echo $form;
        } ?>
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