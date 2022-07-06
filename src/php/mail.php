<?php
    require '../../PHPMailer-6.6.3/PHPMailer.php';

    $name = htmlentities($_POST["name"]);
    $surname = htmlentities($_POST["surname"]);
    $link = htmlentities($_POST["link"]);
    $date = htmlentities($_POST["date"]);
    $email = htmlentities($_POST["email"]);
    $number = htmlentities($_POST["number"]);
    $patronymic = htmlentities($_POST["patronymic"]);
    $file = $_FILES['files'];
    $body ="
        <html lang='en'>
          <body style='margin: 0 auto; width: 80%;'>
              <h1>Здравствуйте меня зовут $surname $name $patronymic</h1> <br><br>
              <p>Моя дата рождения $date , и я очень хочу работать в вашей компаниии.</p><br><br>
              <p>Напишите мне на мою почту: $email</p><br><br>
              <p>Вы также можете мне перезвонить по номеру: $number</p><br><br>
              <p>Резюме во вложении</p><br><br>
          </body>
        </html>";
        

      
       

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
  
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};



    $mail->setLanguage("ru","../../PHPMailer-6.6.3/language/phpmailer.lang-ru.php");
    $mail->setFrom('arlift@gmail.com', 'arlift');
    $mail->addAddress('serafimcomru91@gmail.com', 'FirstLast');
    $mail->Subject = 'Mail from vacation';

    // Прикрипление файлов к письму
    if (!empty($file['name'][0])) {
        for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
            $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
            $filename = $file['name'][$ct];
            if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
                $mail->addAttachment($uploadfile, $filename);
                $rfile[] = "Файл $filename прикреплён";
            } else {
                $rfile[] = "Не удалось прикрепить файл $filename";
            }
        }   
    }
    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Body = $body;    

    // Проверяем отравленность сообщения
    if ($mail->send()) {$result = "success";} 
    else {$result = "error";}

    } catch (Exception $e) {
        $result = "error";
        $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
    }

    // Отображение результата
    echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
 ?>