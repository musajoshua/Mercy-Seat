<?php

    class Mailing{

        private $mail;

        public function mail_verification($email) {

                require __DIR__ . '/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

                // TCP port to connect to
                $this->mail = new PHPMailer(true);  
                //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                $this->mail->isSMTP();                                      // Set mailer to use SMTP
                //add these codes if not written
                $this->mail->SMTPAuth   = true;  
                $this->mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
                $this->mail->Username = 'gidijosh@gmail.com';                 // SMTP username
                $this->mail->Password = '41ea45df21fdeccb';                           // SMTP password
                $this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $this->mail->Port = 25;
                // $this->mail->setFrom('cseweek@lmu.edu.ng', 'CSE Week Voting  - Verification Email');
                
                $this->mail->addAddress($email, ''); 
        // Add attachments
                    // Optional name                               // Set email format to HTML

                $this->mail->Subject = 'Mercy Seat Chapel Welcome !';
                $this->mail->From = "mercyseat@a.com";
                $this->mail->FromName = "Mercy Seat Chapel";
                $msg = '<html>
                        <head>
                            <title>Activation Email</title>
                        </head>
                        <body>  
                            <h1>HELLO WORLD</h1>
                        </body>
                        </html>';
                
                // echo $this->mail->Body;
                $this->mail->Body = $msg;
                $this->mail->IsHTML(true);

                if(!$this->mail->send()) {
                    return false;
                } else {
                    return true;
                }

        }
    }

    $mail = new Mailing();
    
    if($mail->mail_verification('gidijosh@gmail.com')){
        echo 'sent';
    }else{
        echo 'not sent';
    }
?>