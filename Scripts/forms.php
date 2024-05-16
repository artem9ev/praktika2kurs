<?php ob_start();
$forms = array(); ?>
<div id="form_1" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_1">
        <label>
            <h2><strong>Поиск продавцов:</strong></h2><br>
            <input class="formfield" name="fio" type="text" placeholder="ФИО" required/>
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти сотрудников" />
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
            <h2><strong>Выбор продавцов по значению комиссионных:</strong></h2><br>
            <input class="formfield" name="comission" type="text" placeholder="0" required/>
        </label>
        <br>
        <input type="submit" value="Найти сотрудников" />
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
            <h2><strong>Поиск товаров:</strong></h2><br>
            <input class="formfield" name="product" type="text" placeholder="название должности" required/>
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти товары" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
ob_start(); 
?>
<div id="form_4" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_4">
        <label>
            <h2><strong>Продажи по датам:</strong></h2><br>
            От: <input class="formfield" name="date1" type="date" placeholder="" /><br>
            До: <input class="formfield" name="date2" type="date" placeholder="" />
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти товары" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
ob_start(); 
?>
<div id="form_5" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_3">
        <label>
            <h2><strong>Поиск товаров:</strong></h2><br>
            <input class="formfield" name="product" type="text" placeholder="название должности" />
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти товары" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
ob_start(); 
?>
<div id="form_6" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_3">
        <label>
            <h2><strong>Поиск товаров:</strong></h2><br>
            <input class="formfield" name="product" type="text" placeholder="название должности" />
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти товары" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
ob_start(); 
?>
<div id="form_7" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_3">
        <label>
            <h2><strong>Поиск товаров:</strong></h2><br>
            <input class="formfield" name="product" type="text" placeholder="название должности" />
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти товары" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
ob_start(); 
?>
<div id="form_8" class="invisible">
    <form action="index.php" method="POST">
        <input type="hidden" name="form_name" value="form_3">
        <label>
            <h2><strong>Поиск товаров:</strong></h2><br>
            <input class="formfield" name="product" type="text" placeholder="название должности" />
        </label>
        <br>
        <input class="formfield" type="submit" value="Найти товары" />
    </form>
</div>
<?php 
$forms[] = ob_get_contents();
ob_end_clean();
?>