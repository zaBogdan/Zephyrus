<?php


class Users extends \Core\DbModel{
    protected static $db_table = "users";
    protected static $db_fields = array('id', 'uuid', 'username', 'email', 'password', 'firstname', 'lastname', 'registration_date', 'notifications','confirmedStatus');

    private static $token_reset = "reset_password";
    private $token_confirm = "confirm_email";

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
        $data['email']=strtolower($data['email']);
        if(self::find_by_attribute("email",$data['email']))
            return "Email already exists!";
        if(self::find_by_attribute("username",$data['username']))
            return "Username already exists";

        $this->username = $data['username'];
        $this->email = $data['email'];
        
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];

        //security for user
        $this->password = $this->hashPassword($data['password']);
        $this->uuid = \Core\TokenAuth::getUUID();
        $this->registration_date = date('d-m-Y');
        $this->confirmedStatus = false;

        return true;
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

        $tokenAuth = new \Core\TokenAuth();
        $token = $tokenAuth->linkToken($this->uuid, $expiry_date,$this->token_confirm,20);

        $to = $this->email;
        $subject = "zaEngine -> Confirm email!";
        $link = "http://zaengine.php/admin/auth/confirm-email/$token";
        $args = array(
            'username' => $this->username,
            'p_one'     => "You are now registered on our site, but you need to do one more step! You need to activate your account",
            'p_two'    => "To do this, please click the link below!",
            'link' => $link,
            'button' => "Confirm email",
        );
        EmailHandler::send($to,$subject,$args);
        return true;
    }
    public static function send_forgot_password(String $email){
        $user = self::find_by_attribute("email",$email);
        if(!empty($user)){
            $expiry_date = time() + (2 * 60 * 60); // 2 hours

            $tokenAuth = new \Core\TokenAuth();
            $token = $tokenAuth->linkToken($user->uuid, $expiry_date,self::$token_reset,20);

            $to = $email;
            $link = "http://zaengine.php/admin/auth/reset-password/$token";
            $subject = "zaEngine -> Reset your password!";
            $args = array(
                'username' => $user->username,
                'p_one'     => "Here you have your reset password link!",
                'p_two'    => "<b>Note:</b> This link is available for 2 hours!",
                'link' => $link,
                'button' => "Reset password",
            );
            \Core\EmailHandler::send($to,$subject,$args);
            return true;
        }
        return false;
    }
    public function hashPassword($password){
        return password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
    }
}