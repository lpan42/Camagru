<?php
class UserManager
{
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function register($email, $username, $password, $password_repeat)
    {
        if ($password != $password_repeat){
               throw new UserException('Password mismatch.');
        }
        $checkEmail = Db::query('SELECT id_user FROM users WHERE email = ?;', array($email));
        if($checkEmail){
            throw new UserException('This email has already been taken.');
        }
        $checkUsername = Db::query('SELECT id_user FROM users WHERE username = ?;', array($username));
        if($checkUsername){
            throw new UserException('This username has already been taken.');
        }

        $user = array(
            'email' => $email,
            'username' => $username,
            'password' => $this->passwordHash($password),
            'hash_active' => hash('md5', rand())
        );
        echo 'localhost:8081/Login/'.$user['username'].'/'.$user['hash_active'];
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
        }
    }

    public function modif_pwd($old_pwd, $new_pwd, $new_pwd_repeat)
    {
        // print_r($old_pwd);
        // print_r($$new_pwd);
        // print_r($new_pwd_repeat);
        if ($new_pwd != $new_pwd_repeat){
            throw new UserException('New password mismatch.');
        }
        $username = $this->getUsername();
        // print_r($username);
        $ver_old = Db::queryOne('
            SELECT password
            FROM users
            WHERE username = ?;', array($username));
        // print_r($ver_old['password']);
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
        unset($_SESSION['email']);
        unset($_SESSION['username']);
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