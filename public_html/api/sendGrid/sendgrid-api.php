<?php
// using SendGrid's PHP Library
// https://github.com/sendgrid/sendgrid-php
// If you are using Composer (recommended)

require 'vendor/autoload.php';

// If you are not using Composer
// require("path/to/sendgrid-php/sendgrid-php.php");

$from = new SendGrid\Email("Joseph", "josephjramirezwd@gmail.com");
$subject = "Sending with SendGrid is Fun";
$to = new SendGrid\Email("joseph", "inkajjr@gmail.com");
$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$apiKey = getenv('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');
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
echo $response->headers();
echo $response->body();