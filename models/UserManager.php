<?php
class UserManager
{
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function auth_pwd($password){
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            throw new UserException('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
        }
    }

    public function register($email, $username, $password, $password_repeat)
    {
        if ($password != $password_repeat){
            throw new UserException('Password mismatch.');
        }
        if(strlen($username) < 3 || strlen($username) > 15){
            throw new UserException('Username should have at least 3 and no more than 15 characters.');
        }
        $checkEmail = Db::query('SELECT id_user FROM users WHERE email = ?;', array($email));
        if($checkEmail){
            throw new UserException('This email has already been taken.');
        }
        $checkUsername = Db::query('SELECT id_user FROM users WHERE username = ?;', array($username));
        if($checkUsername){
            throw new UserException('This username has already been taken.');
        }
        $this->auth_pwd($password);
        $user = array(
            'email' => $email,
            'username' => $username,
            'password' => $this->passwordHash($password),
            'hash_active' => hash('md5', rand())
        );
        echo 'localhost:8081/Login/'.$user['username'].'/'.$user['hash_active'];//
        try
        {
            Db::insert('users', $user);
            EmailSender::send(
                $user['email'], 
                'Active your account before login Camegru', 
                'localhost:8081/Login/'.$user['username'].'/'.$user['hash_active']
            );
            
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function active($username, $ranstr)
    {
        $hash_active = Db::queryone('
            SELECT hash_active FROM users WHERE username = ?;', array($username));
        if($ranstr == $hash_active['hash_active']){
            $active = array('active' => TRUE);
            Db::update('users', $active, 'WHERE username = ?', array($username));
        }
        else
            throw new UserException('Invalid link.');

    }

    public function auth_reset_hash($username, $ranstr)
    {
        $hash_pwd = Db::queryone('
            SELECT hash_pwd FROM users WHERE username = ?;', array($username));
        if($ranstr !== $hash_pwd['hash_pwd']){
            throw new UserException('Invalid link.');
        }
    }

    public function login($login, $password)
    {
        $email = Db::queryOne('
            SELECT id_user, email, username, password, active, email_prefer, admin
            FROM users
            WHERE email = ?;', array($login));
        if($email)//if the login use email
        {
            if (!password_verify($password, $email['password']))
                throw new UserException('Invalid email or password.');
            if ($email['active'] == FALSE)
                throw new UserException('You account has not been actived yet, please check your email and active your account first.');
            $_SESSION['email'] = $email['email'];
            $_SESSION['username'] = $email['username'];
            $_SESSION['id_user'] = $email['id_user'];
        }
        else if(!$email)//if the login use username
        {
            $username = Db::queryOne('
                SELECT id_user, email, username, password, active, email_prefer, admin
                FROM users
                WHERE username = ?;', array($login));
            if (!$username || !password_verify($password, $username['password']))
                throw new UserException('Invalid username or password.');
            if ($username['active'] == FALSE)
                throw new UserException('You account has not been actived yet, please check your email and active your account first.');
            $_SESSION['email'] = $username['email'];
            $_SESSION['username'] = $username['username'];
            $_SESSION['id_user'] = $username['id_user'];
        }
    }

    public function forget_pwd($login)
    {
        $email = Db::queryOne('
            SELECT id_user, email, username, password, active, email_prefer, admin
            FROM users
            WHERE email = ?;', array($login));
        if($email)//if the login use email
        {
            $emailadd = $email['email'];
            $user = $email['username'];
        }
        else if(!$email)//if the login use username
        {
            $username = Db::queryOne('
                SELECT id_user, email, username, password, active, email_prefer, admin
                FROM users
                WHERE username = ?;', array($login));
            if (!$username){
                throw new UserException('Invalid username or password.');
            }
            else{
                $emailadd = $username['email'];
                $user = $username['username'];
            }
        } 
        $reset_email = array(
            'hash_pwd' => hash('md5', rand())
        );
        echo 'localhost:8081/Modify/'.$user.'/'.$reset_email['hash_pwd'];//
        try
        {
            Db::update('users', $reset_email, 'WHERE username = ?', array($user));
            
            EmailSender::send(
                $emailadd, 
                'Reset your password on Camegru', 
                'localhost:8081/Modify/'.$user.'/'.$reset_email['hash_pwd']
            );
            
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function reset_pwd($username, $new_pwd, $new_pwd_repeat){
        if ($new_pwd != $new_pwd_repeat){
            throw new UserException('New password mismatch.');
        }
        $this->auth_pwd($password);
        try{
            $hash_new_pwd = array('password' => $this->passwordHash($new_pwd));
            Db::update('users', $hash_new_pwd, 'WHERE username = ?', array($username));
        }
       catch (PDOException $e)
       {
           echo $e->getMessage();
       }
    }
    
    public function modif_pwd($old_pwd, $new_pwd, $new_pwd_repeat)
    {
        if ($new_pwd != $new_pwd_repeat){
            throw new UserException('New password mismatch.');
        }
        $this->auth_pwd($password);
        $username = $this->getUsername();
        $ver_old = Db::queryOne('
            SELECT password
            FROM users
            WHERE username = ?;', array($username));
        if (!password_verify($old_pwd, $ver_old['password']))
            throw new UserException('Old password is wrong.');
        else{
           try{
                $hash_new_pwd = array('password' => $this->passwordHash($new_pwd));
                Db::update('users', $hash_new_pwd, 'WHERE username = ?', array($username));
           }
           catch (PDOException $e)
           {
               echo $e->getMessage();
           }
        }
    }
    
    public function getCurrentPrefer($username)
    {
		try{
			$current = Db::queryOne(
                'SELECT email_prefer
                FROM users
                WHERE username = ?;', array($username));
			return ($current);
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
    }

    public function modif_EmailPrefer($username, $changeto)
    {
		try{
			$new_prefer = array('email_prefer' => $changeto);
			Db::update('users', $new_prefer, 'WHERE username = ?', array($username));
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
    }

    public function logout()
    {
        session_unset();
    }

    public function getUsername()
    {
        if (isset($_SESSION['username']))
            return $_SESSION['username'];
        return null;
    }

    public function getEmail()
    {
        if (isset($_SESSION['email']))
            return $_SESSION['email'];
        return null;
    }

}
?>