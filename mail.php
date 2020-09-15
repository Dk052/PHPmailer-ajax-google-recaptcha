<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; // For SMTP must enable
use PHPMailer\PHPMailer\Exception;

// Load Now
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php'; // For SMTP must enable



    function died($error)
    {
        // your error code
        echo "Sorry Error encoured ";
        echo "<br /><br />".$error;
        die();
    }
    if (!empty($_POST['email'])) { //set a required field here for condition


        // extending validation and checking if expected data exists or not
        if (empty($_POST['name']) ||
               empty($_POST['email']) ||
               empty($_POST['message'])
           ) {
            died('Please fill required fields');
        }



        // Cooking to make it
        $name = $_POST['name'];
        $email= $_POST['email'];
        $message= $_POST['message'];

        //change
        $subject = 'Contact Form - mysite';



        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        // $mail->isSendmail();                                            // for phpsendMail
        $mail->isSMTP();                                                       // Send using SMTP


    //Server settings for SMTP

    $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'yourgmailaccount';                     // SMTP username
    $mail->Password   = 'yourpassword';                         // SMTP password
    $mail->SMTPSecure = 'ssl';                                  // TLS OR SSL
    $mail->Port       = 465;                                    // TCP port


    $mail->setFrom('from@email.com');     // From mail
    $mail->addAddress('recipient@email.com');     // Add a recipient mail
    // $mail->addAddress('test@test.com');
    // $mail->addReplyTo('info@test.com', 'Information');
    // $mail->addCC('cc@test.com');
    // $mail->addBCC('bcc@test.com');

    //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');              // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');         // Optional name



        // is reCAPTCHA box validated?
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

            //-------------- Google reCAPTCHA API secret key-----------------
            $secretKey = 'SECRETKEY';

            if (isset($_POST['g-recaptcha-response'])) {
                $captcha=$_POST['g-recaptcha-response'];
            }


            // Function url_get_contents if native options are disabled by Hosting
            function url_get_contents($url)
            {
                if (function_exists('curl_exec')) {
                    $conn = curl_init($url);
                    curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
                    curl_setopt($conn, CURLOPT_FRESH_CONNECT, true);
                    curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
                    $url_get_contents_data = (curl_exec($conn));
                    curl_close($conn);
                } elseif (function_exists('file_get_contents')) {
                    $url_get_contents_data = file_get_contents($url);
                } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
                    $handle = fopen($url, "r");
                    $url_get_contents_data = stream_get_contents($handle);
                } else {
                    $url_get_contents_data = false;
                }
                return $url_get_contents_data;
            }

            // Verify the reCAPTCHA response
            $verifyResponse = url_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' .$_POST['g-recaptcha-response']);


            // Decode json data
            $resp = json_decode($verifyResponse, true);




            // If reCAPTCHA response is valid
            if ($resp["success"]) {

                // Set email format to HTML
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = '
                                <p>Title: '.$subject.'</p>
                                <p>First Name: '.$name.'</p>
                                <p>Email: '.$email.'</p>
                                <p>Message: '.$message.'</p>
                                <b>Message has been sent from Contact Page!</b>';


                if (!$mail->send()) {
                    echo 'Error while sending your Mail:'. $mail->ErrorInfo.'<br>';
                    died('Problem encoured');
                } else {
                    //
                }
            } else {
                died('Mail not delivered.');  //json data verification failed
            }
        }
    }
