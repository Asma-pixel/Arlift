<?php
$project_name = trim($_POST["project_name"]);
$admin_email  = trim($_POST["admin_email"]);
$form_subject = trim($_POST["form_subject"]);

$file_attach = array();

// Если поле выбора вложения не пустое - закачиваем его на сервер
if (!empty($_FILES)) {
    foreach ($_FILES["files"]["name"] as $key => $file) {
        $path = __DIR__ . "/upload-files/" . $file; // путь загрузки файла

        if (copy($_FILES["files"]["tmp_name"][$key], $path)) {
            $file_attach[] = $path;
        }
    }
}

$c = true;
foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        $value = implode(", ", $value);
    }
    if (
        $value != "" &&
        $key != "project_name" &&
        $key != "admin_email" &&
        $key != "form_subject" &&
        $key != "file_attach"
    ) {
        $message .= (($c = !$c) ? "<tr>" : "<tr style='background-color: #f8f8f8;'>") . "
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
        </tr>";
    }
}

$message = '<table style="width: 100%;">
    <tr>
        <td style="padding:10px; border:#e9e9e9 1px solid; text-align:center" colspan="2">
            <big>$project_name</big>. $form_subject
        </td>
    </tr>
    ' . $message . '
</table>';

// Отправляем сообщение
if (empty($file_attach)) {
    $headers = "MIME-Version: 1.0" . PHP_EOL .
        "Content-Type: text/html; charset=utf-8" . PHP_EOL .
        "From: " . $project_name . " <" . $admin_email . ">" . PHP_EOL .
        "Reply-To: " . $admin_email . "" . PHP_EOL;
    mail($admin_email, $form_subject, $message, $headers); # отправка текста
} else {
    send_mail($admin_email, $form_subject, $message, $file_attach); # отправка файлов
}

// Функция для отправки сообщения с вложением
function send_mail($to, $form_subject, $html, $paths)
{
    $boundary = "--" . md5(uniqid(time())); // генерируем разделитель

    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";

    $multipart = "--$boundary\n";

    $multipart .= "Content-Type: text/html; charset='utf-8'\n";
    $multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n";
    $multipart .= "$html\n\n";

    $message_part = "";

    foreach ($paths as $path) {
        $fp = fopen($path, "r");

        if (!$fp) {
            echo "Файл $path не может быть прочитан";
            exit();
        }

        $file = fread($fp, filesize($path));
        fclose($fp);

        $message_part .= "--$boundary\n";
        $message_part .= "Content-Type: application/octet-stream\n";
        $message_part .= "Content-Transfer-Encoding: base64\n";
        $message_part .= "Content-Disposition: attachment; filename = \"" . $path . "\"\n\n";
        $message_part .= chunk_split(base64_encode($file)) . "\n";
    }

    $multipart .= $message_part . "--$boundary--\n";

    if (!mail($to, $form_subject, $multipart, $headers)) {
        echo "К сожалению, письмо не отправлено";
        exit();
    }
}
   
    // $name = htmlentities($_POST["name"]);
    // $surname = htmlentities($_POST["surname"]);
    // $link = htmlentities($_POST["link"]);
    // $date = htmlentities($_POST["date"]);
    // $email = htmlentities($_POST["email"]);
    // $number = htmlentities($_POST["number"]);
    // $patronymic = htmlentities($_POST["patronymic"]);
    // $message ="
    //     <html lang='en'>
    //       <body style='margin: 0 auto; width: 80%;'>
    //           <h1>Здравствуйте меня зовут $surname $name $patronymic</h1> <br><br>
    //           <p>Моя дата рождения $date , и я очень хочу работать в вашей компаниии.</p><br><br>
    //           <p>Ссылка на мое резюме: $link.</p><br><br>
    //           <p>Напишите мне на мою почту: $email</p><br><br>
    //           <p>Вы также можете мне перезвонить по номеру: $number</p><br><br>
    //       </body>
    //     </html>";

    //     $to = 'karina.polonina@yandex.ru'; 

    //     $subject = 'Письмо с сайта по поиску менеджера';
        
     
    //     mail_utf8($to, "arlift.com","arlift@gmail.com", $subject, $message);
    //     header("Location: ../../index.html");
    //     exit;
       
 ?>