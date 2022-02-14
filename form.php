<?php

$to = 'info@elementautoservice.ru';

function getJson()
{
    $json = file_get_contents('php://input');
    return json_decode($json, true);
}

function response($text)
{
    echo $text;
    die;
}

$json = getJson();

if (!isset($json['name']) || !isset($json['phone']) || !isset($json['form_name']))
    response('Указаны не все данные');

$name = $json['name'];
$phone = $json['phone'];
$comment = $json['comment'] ? $json['comment'] : '';
$formName = $json['form_name'];

if (!trim($name) || !trim($phone) || !trim($formName))
    response('Указаны не все данные');

$subject = 'Заявка с сайта ' . $_SERVER['SERVER_NAME'];
$message = "Форма: {$formName} <br> Имя: {$name} <br> Номер телефона: {$phone} <br> {$comment}";
$headers
    = "Content-type: text/html; charset=utf-8 \r\n"
    . "From: {$to}\r\n"
    . "Reply-To: {$to}\r\n";

$isMailSuccess = mail($to, $subject, $message, $headers);

if ($isMailSuccess)
    response('Ваше сообщение отправлено!');
else
    response('Ошибка отправки сообщения. Попробуйте позже');
