<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function pre($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

function mailSend($user){
    $view = view('emails.warningMail',compact('user'))->render();
    $subject =  __('Subscription expire shortly');
    $mail = new PHPMailer(true); 
    try {
        $mail->isSMTP(); 
        $mail->CharSet = "utf-8"; 
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = env('MAIL_HOST');
        $mail->Port = env('MAIL_PORT'); 
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->setFrom(env('MAIL_FROM_ADDRESS'));
        $mail->Subject = $subject;
        $mail->MsgHTML($view);
        $mail->addAddress($user->email);
        $mail->send();
    } catch (phpmailerException $e) {
        dd($e);
    } catch (Exception $e) {
        dd($e);
    }
}