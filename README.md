# PHPmailer-ajax-google-recaptcha
Send Mail with PHPMailer + google SMTP + google recaptcha + AJAX

1.) install PHPMailer (https://github.com/PHPMailer/PHPMailer)

2.) get Google reCaptcha key (https://www.google.com/recaptcha/admin) (i used v2 checkbox)

3.) Configure index.html On Line 48 put your google reCaptcha Site Key.

4.) Configure mail.php on Line 77 put your SECRET KEY from Google reCaptcha.

5.) Edit mail.php     
//Server settings for SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'yourgmailaccount';                     // SMTP username
    $mail->Password   = 'yourpassword';                         // SMTP password
    $mail->SMTPSecure = 'ssl';                                  // TLS OR SSL
    $mail->Port       = 465;  

6.) Also make sure you have activated Less Secure Apps on your Google Account (https://myaccount.google.com/lesssecureapps)


7.) Test it :)

