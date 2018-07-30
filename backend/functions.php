<?php 
    class Utility{
        protected $conn;

        function __construct(){
            require_once __DIR__ . '/db/db.php';
            $db = new DB();
            $this->conn = $db->connect();
        }

        public function clean($in){
            $res = stripslashes($in);
            $res = trim($res);
            return $res;
        }

        public function unset(){
            unset($_SESSION['message']);
            unset($_SESSION['messageType']);
        }

        public function redirect($location){
            header("Location:$location");
        }

        public function isExist($email){
            try {
                $stmt = $this->conn->prepare("SELECT * FROM `visitors` WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(PDOException $e){
                return NULL;
            }
        }

        protected function loop($req){
            $res = array();
            foreach($req as $re){
                $temp = array();
                $temp['fullname'] = $re['fullname'];
                $temp['username'] = $re['username'];
                $temp['password'] = $re['password'];
                array_push($res,$temp);
            }
            return $res;
        }
    }

    class Auth extends Utility{
        function __construct(){
            parent::__construct();
        }

        public function hashpass($pass){
            return password_hash($pass, PASSWORD_BCRYPT);
        }

        public function verifypass($pass,$hash){
            if(password_verify($pass,$hash)){
                return TRUE;
            }else{
                return FALSE;
            }
        }

        public function login($username,$password){
            try{
                $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE username = :username LIMIT 1");
                $stmt->execute([':username' => $username]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() == 1){
                    if($this->verifypass($password,$res['password'])){
                        session_start();
                        $_SESSION['user_id'] = $res['id'];
                        $_SESSION['username'] = $res['username'];
                        $_SESSION['timestamp']=time();
                        $this->redirect('./dashboard/index.php');
                    }else{
                        $_SESSION['message'] = 'Invalid Password';
                        $_SESSION['messageType'] = 'alert alert-danger display';
                    }
                }else{
                    $_SESSION['message'] = 'Invalid Username';
                    $_SESSION['messageType'] = 'alert alert-danger display';
                    // return;
                }
            } catch(PDOException $e){
                return NUll;
            }
        }

        public function logout(){
            session_unset();
            session_destroy();
            // $this->redirect('index.php');
        }

        public function register($req){
            try{
                $stmt = $this->conn->prepare("INSERT INTO   `users` (`username`, `password`) VALUES (:username, :password)");
                if($stmt->execute([':username' => $req['username'], ':password' => $this->hashpass($req['password'])])){
                    echo 'registered successful';
                }else{
                    echo 'registration failed';
                }

            } catch (PDOException $e){
                echo 'NULL';
            }
        }
    }

    class CRUD extends Utility {
        function __construct(){
            parent::__construct();
        }

        public function register($req){
            if($this->isExist($req['email']) == false){
                try{
                    $sql = "INSERT INTO `visitors` (`title`, `first_name`, `last_name`, `other_name`, `date_of_birth`, `street_address`, `apt_no`, `city`, `zip`, `state`, `age_group`, `sex`, `phone_no`, `marital_status`, `email`, `isMember`, `informative`) VALUES (:title, :first_name, :last_name, :other_name, :date_of_birth, :street_address, :apt_no, :city, :zip, :state, :age_group, :sex, :phone_no, :marital_status, :email, :isMember, :informative)";
                    $stmt = $this->conn->prepare($sql);
                    $mail =  new Mailing();
                    if ($mail->mail_verification($this->clean($req['email']))) {
                        if($stmt->execute([':title' => $req['title'], ':first_name' => $req['first_name'], ':last_name' => $req['last_name'], ':other_name' => $req['other_name'], ':date_of_birth' => $req['date_of_birth'], ':street_address' => $req['street_address'], ':apt_no' => $req['apt_no'], ':city' => $req['city'], ':zip' => $req['zip'], ':state' => $req['state'], ':age_group' => $req['age_group'], ':sex' => $req['sex'], ':phone_no' => $req['phone_no'], ':marital_status' => $req['marital_status'], ':email' => $req['email'], ':isMember' => $req['isMember'], ':informative' => $req['informative']])){       
                            $_SESSION['message'] = "Registered Successfully";
                            $_SESSION['messageType'] = "alert alert-success display";
                        }else{
                            $_SESSION['message'] = "Registration failed";
                            $_SESSION['messageType'] = "alert alert-danger display";
                        }
                    }else{
                        $_SESSION['message'] = "Error Sending Mail";
                        $_SESSION['messageType'] = "alert alert-danger display";
                    }

                } catch (PDOException $e){
                    $_SESSION['message'] = "Registration failed";
                    $_SESSION['messageType'] = "alert alert-danger display";
                }
            }else{
                $_SESSION['message'] = "E-mail already exist";
                $_SESSION['messageType'] = "alert alert-danger display";
            }
        }

        public function getVisitors(){
            try{
                $stmt = $this->conn->prepare("SELECT * FROM `visitors`");
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    return($res);
                }else{
                    return;
                }
            }catch(PDOException $e){
                return NULL;
            }
        }

        public function filterSex($sex){
            try{
                $stmt = $this->conn->prepare("SELECT * FROM `visitors` WHERE sex = :sex");
                $stmt->execute([':sex' => $sex]);
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    return($res);
                }else{
                    return;
                }
            }catch(PDOException $e){
                return NULL;
            }
        }

        public function getVisitor($id){
            try{
                $stmt = $this->conn->prepare("SELECT * FROM `visitors` WHERE id = :id LIMIT 1");
                $stmt->execute([':id' => $id]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    return $res;
                }else{
                    return;
                }
            }catch(PDOException $e){
                return NULL;
            }
        }

        public function delete($id){
            try{
                $stmt = $this->conn->prepare("DELETE FROM `visitors` WHERE id = :id"); 
                if($stmt->execute([':id' => $id])){
                    echo 'deleted';
                }else{
                    echo 'no data';
                }
            }catch(PDOException $e){
                return NULL;
            }
        }

        public function update($req,$id){
            try{
                $sql = "UPDATE `visitors` SET `title` = :title, `first_name` = :first_name, `last_name` = :last_name, `other_name` = :other_name, `date_of_birth` = :date_of_birth, `street_address` = :street_address, `apt_no` = :apt_no, `city` = :city, `zip` = :zip, `state` = :state, `age_group` = :age_group, `sex` = :sex, `phone_no` = :phone_no, `marital_status` = :marital_status, `email` = :email, `isMember` = :isMember, `informative` = :informative WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                
                if($stmt->execute([':title' => $req['title'], ':first_name' => $req['first_name'], ':last_name' => $req['last_name'], ':other_name' => $req['other_name'], ':date_of_birth' => $req['date_of_birth'], ':street_address' => $req['street_address'], ':apt_no' => $req['apt_no'], ':city' => $req['city'], ':zip' => $req['zip'], ':state' => $req['state'], ':age_group' => $req['age_group'], ':sex' => $req['sex'], ':phone_no' => $req['phone_no'], ':marital_status' => $req['marital_status'], ':email' => $req['email'], ':isMember' => $req['isMember'], ':informative' => $req['informative'], ':id' => $id])){
                    echo 'update successful';
                }else{
                    echo 'update failed';
                }

            } catch (PDOException $e){
                echo 'NULL';
            }
        }
    }
    
    class Mailing{

        private $mail;

        public function mail_verification($email) {
            require_once __DIR__ . '/db/dbconfig.php';
            require_once(__DIR__.'/vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
            // TCP port to connect to
            $this->mail = new PHPMailer;
                //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                $this->mail->isSMTP();                                      // Set mailer to use SMTP
                //add these codes if not written
                $this->mail->IsSMTP();
                $this->mail->SMTPAuth   = true;  
                $this->mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
                $this->mail->Username = SMTP_USER;                 // SMTP username
                $this->mail->Password = SMTP_PASS;                           // SMTP password
                $this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $this->mail->Port = 587;
                $this->mail->setFrom('hello@gmail.com', 'HELLO WORLD');
                
                $this->mail->addAddress($email); 
        // Add attachments
                    // Optional name
                $this->mail->isHTML(true);                                  // Set email format to HTML

                $this->mail->Subject = 'Mercy Seat Chapel Welcome !';
                $this->mail->From = "mercyseat@a.com";
                $this->mail->FromName = "Mercy Seat Chapel";
                $msg = '<html>
                            <head>
                                <title>Welcome</title>
                            </head>
                            <body>  
                                <h1>HELLO WORLD</h1>
                            </body>
                            </html>';
                $this->mail->Body = $msg;
                $this->mail->IsHTML(true);

                if($this->mail->send()) {
                    return true;
                } else {
                    return false;
                }

        }
    }

    // $arr = array('username' => "admin", 'password' => "abcd1234");
    // echo $utility->verifypass($arr['password'],'$2y$10$AQxF4/8yMywMDrPD5RL5s.wnJ/drvYDFL42YTPaUedApXXEp8MrD2');
?>