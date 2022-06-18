<?php

function mail_utf8($to, $from_user, $from_email,
                                             $subject = '(No subject)', $message = '')
   {
      $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
      $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

      $headers = "From: $from_user <$from_email>\r\n".
               "MIME-Version: 1.0" . "\r\n" .
               "Content-type: text/html; charset=UTF-8" . "\r\n";

     return mail($to, $subject, $message, $headers);
   }
   
    $name = htmlentities($_POST["name"]);
    $surname = htmlentities($_POST["surname"]);
    $patronymic = htmlentities($_POST["patronymic"]);
    $date = htmlentities($_POST["date"]);
    $email = htmlentities($_POST["email"]);
    $number = htmlentities($_POST["number"]);
    $message ="
        <html lang='en'>
          <body style='display: flex; flex-direction: column; justify-content: center; align-items: center; margin: 0 auto; width: 80%;'>
              <h1>Здравствуйте меня зовут $surname $name $patronymic</h1>
              <p>Моя дата рождения $date , и я очень хочу работать в вашей компаниии.</p>
              <p>Напишите мне на мою почту: $email</p>
              <p>Вы также можете мне перезвонить по номеру: $number</p>
          </body>
        </html>";

        $to = 'serafimcomru91@gmail.com'; 

        $subject = 'Письмо с сайта по поиску менеджера';
        
     
        mail_utf8($to, "arlift.com","arlift@gmail.com", $subject, $message);
        header("Location: ../../index.html");
        exit;
       
 ?>