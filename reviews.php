<form action="" method="post" enctype="multipart/form-data" class="form-rew">
	<input type="text" placeholder="Введите ваше имя" name="NAME" class="text">
	<input type="text" placeholder="Введите ваш электронный адрес" name="EMAIL" class="text"><br><br>
	<input type="text" placeholder="Введите ваш телефон" name="PHONE" class="text">
	<textarea placeholder="Введите ваш отзыв" name="REVIEWS" class="text-mess"></textarea><br>
	<input type="submit" class="submit" value="Отправить" name="OK">
</form>

<?
if($_POST["OK"]){
    if(CModule::IncludeModule("iblock")){   
        if($_POST["NAME"]!="" && $_POST["EMAIL"]!="" && $_POST["REVIEWS"]!="" && $_POST["PHONE"]!=""){
            echo "Спасибо, Ваше сообщение отправлено! В ближайшее время его проверят";
            $el = new CIBlockElement;
            $arLoadProductArray = Array(
              "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
              "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
              "IBLOCK_ID"      => 5, // id инфоблока, который вы создали
              "NAME"           => $_POST["NAME"], // имя пользователя будет именем элемента
              "ACTIVE"         => "Y",            // убираем активность
              "PREVIEW_TEXT"   => $_POST["REVIEWS"], // отзыв клиента
              "DETAIL_TEXT"    => "E-Mail: " . $_POST["EMAIL"] . "\nТелефон: " . $_POST["PHONE"], // контактные данные клиента
              "PREVIEW_PICTURE" => CFile::MakeFileArray($fileID)
              );
            if($PRODUCT_ID = $el->Add($arLoadProductArray))
              echo "";
            else
              echo "";   
        }else{
            echo "Заполнены не все поля";
        }
    }
        // Переменные с формы
    $name = $_POST['NAME'];
    $text = $_POST['REVIEWS'];
    $phone = $_POST['PHONE'];
    $email = $_POST['EMAIL'];

    
    // Параметры для подключения
    $db_host = "localhost"; 
    $db_user = "root"; // Логин БД
    $db_password = "91WHAcFuPZ"; // Пароль БД
    $db_base = 'test_bx'; // Имя БД
    $db_table = "test_bx_reviews"; // Имя Таблицы БД
    
    // Подключение к базе данных
    $mysqli = new mysqli($db_host,$db_user,$db_password,$db_base);

    // Если есть ошибка соединения, выводим её и убиваем подключение
    if ($mysqli->connect_error) {
        die('Ошибка : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }
    
    $result = $mysqli->query("INSERT INTO ".$db_table." (NAME,REVIEWS,PHONE,EMAIL) VALUES ('$name','$text','$phone','$email')");
    
    if ($result == true){
        echo "Информация занесена в базу данных";
    }else{
        echo " <br> Информация не занесена в базу данных";
    }
}
?>