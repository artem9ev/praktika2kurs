<?php ob_start();
$forms = array(); ?>
<div id="form_1" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_1">
        <label>
            <strong>Поиск продавцов:</strong>
            <br>
            <input class="formfield" name="fio" type="text" placeholder="ФИО" />
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти сотрудника" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
ob_start(); 
?>
<div id="form_2" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_2">
        <label>
            <strong>Товар:</strong>
            <br>
            <input class="formfield" name="product" type="text" placeholder="название товара" />
        </label>
        <br>
        <input type="submit" value="Найти товар" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
ob_start(); 
?>
<div id="form_3" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_3">
        <label>
            <strong>Должность:</strong>
            <br>
            <input class="formfield" name="job" type="text" placeholder="название должности" />
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти людей с должностью" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
?>