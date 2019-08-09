<?php


class Users extends DbModel{
    protected static $db_table = "users";
    protected static $db_fields = array('id', 'uuid', 'username', 'email', 'password', 'firstname', 'lastname', 'registration_date', 'notifications','confirmedStatus');

    public $id;
    public $uuid;
    public $username;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $registration_date;
    public $confirmedStatus;
    public $notifications;


    public function create_user(Array $data){
        //user and email must be unique. 
        if(self::find_by_attribute("email",$data['email']))
            return "Email already exists!";
        if(self::find_by_attribute("username",$data['username']))
            return "Username already exists";
            // "Username already exists!"

        $this->username = $data['username'];
        $this->email = $data['email'];
        
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];

        //security for user
        $this->password = $this->hashPassword($data['password']);
        $this->uuid = TokenAuth::getUUID();
        $this->registration_date = date('d-m-Y');
        $this->confirmedStatus = false;

        return "OK";
    }

    public static function send_forgot_password(String $email){
        $user = self::find_by_attribute("email",$email);
        if(!empty($user)){
            $expiry_date = time() + (2 * 60 * 60); // 2 hours

            $tokenAuth = new TokenAuth();
            $token = $tokenAuth->linkToken($user->uuid, $expiry_date,20);

            $to = $email;
            $link = "http://zaengine.php/admin/auth/reset_password.php?id=$token";
            $subject = "zaEngine -> Reset your password!";
            $args = array(
                'username' => $user->username,
                'text'     => "Here you have your reset password link!",
                'text2'    => "<b>Note:</b> This link is available for 2 hours!",
                'button_link' => $link,
                'button_text' => "Reset password",
            );
            EmailHandler::send($to,$subject,'2_paragraph',$args);
            return true;
        }
        return false;
    }

    public static function check_user(String $username, String $password){
        $user = self::find_by_attribute("username",$username);
        if(!empty($user)){
            if(password_verify($password,$user->password)){
                return $user;
            }
        }
        return false;
    }
    public function send_confirmation(){
        $expiry_date = time() + (2 * 60 * 60); // 2 hours

        $tokenAuth = new TokenAuth();
        $token = $tokenAuth->linkToken($this->uuid, $expiry_date,20);

        $to = $this->email;
        $subject = "zaEngine -> Confirm email!";
        $link = "http://zaengine.php/admin/auth/confirm_user.php?id=$token";
        $args = array(
            'username' => $this->username,
            'text'     => "You are now registered on our site, but you need to do one more step! You need to activate your account",
            'text2'    => "To do this, please click the link below!",
            'button_link' => $link,
            'button_text' => "Confirm email",
        );
        EmailHandler::send($to,$subject,'2_paragraph',$args);
        return true;
    }
    public function hashPassword($password){
        return password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
    }
}