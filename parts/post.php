<?php

$typebuilding = $_POST["typebuilding"];
$phonenumber = $_POST["phonenumber"];

$to= "Andrei <andreisizyi@gmail.com>" . ", " ;
$to .= "Andrei <andrewsiziy@gmail.com>";

$subject = "Запит з сайту «Макропроект»";

$message = ' <p>Надіслано новий запит:</p><br>
            <b>Тип споруди який цікавить: </b>'.$typebuilding.'<br>
            <b>Номер телефону: </b>'.$phonenumber;

$headers  = "Content-type: text/html; charset=utf-8";
$headers .= "From: Макропроект <no-reply@macroproject.com>\r\n"; 

mail($to, $subject, $message, $headers); 

?>