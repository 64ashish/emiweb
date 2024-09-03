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

function getTime($date){
    $date = \Carbon\Carbon::parse($date);
    $now = \Carbon\Carbon::now();
    $relativeTime = '';

    $diffInMinutes = $now->diffInMinutes($date);
    $diffInHours = $now->diffInHours($date);
    $diffInDays = $now->diffInDays($date);
    $diffInWeeks = $now->diffInWeeks($date);
    $diffInMonths = $now->diffInMonths($date);
    $diffInYears = $now->diffInYears($date);

    if ($diffInYears > 0) {
        $relativeTime = $diffInYears . ' year' . ($diffInYears > 1 ? 's' : '') . ' ago';
    } elseif ($diffInMonths > 0) {
        $relativeTime = $diffInMonths . ' month' . ($diffInMonths > 1 ? 's' : '') . ' ago';
    } elseif ($diffInWeeks > 0) {
        $relativeTime = $diffInWeeks . ' week' . ($diffInWeeks > 1 ? 's' : '') . ' ago';
    } elseif ($diffInDays > 0) {
        $relativeTime = $diffInDays . ' day' . ($diffInDays > 1 ? 's' : '') . ' ago';
    } elseif ($diffInHours > 0) {
        $relativeTime = $diffInHours . ' hour' . ($diffInHours > 1 ? 's' : '') . ' ago';
    } elseif ($diffInMinutes > 0) {
        $relativeTime = $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '') . ' ago';
    } else {
        $relativeTime = 'just now';
    }

    return $relativeTime;
}