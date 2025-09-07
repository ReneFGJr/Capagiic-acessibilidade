<?php
if (!function_exists('send_email')) {
    function send_email($to, $subject, $message)
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);

        return $email->send();
    }
}
