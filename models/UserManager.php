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
            throw new UserException('Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter and one number.');
        }
    }

    public function register($email, $username, $password, $password_repeat)
    {
        $escape_username =  htmlspecialchars($username);
        $escape_email =  htmlspecialchars($email);
        if ($escape_username !== $username)
        {
            throw new UserException('Invalid username');
        }
        if ($escape_email !== $email)
        {
            throw new UserException('Invalid email');
        }
        $username = $escape_username;
        $email = $escape_email;
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
        // echo 'localhost:8081/Login/'.$user['username'].'/'.$user['hash_active'];//
        try
        {
            Db::insert('users', $user);
            EmailSender::send(
                $user['email'], 
                'Active your account on Camegru',
                'You account on Camagru has been successfully created, click the link to active<br>'
                .'<a href="'.'http://localhost:8081/Login/'.$user['username'].'/'.$user['hash_active']
                .'">activate my account</a>'
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
            SELECT id_user, email, username, password, active, email_prefer
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
                SELECT id_user, email, username, password, active, email_prefer
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
            SELECT id_user, email, username, password, active, email_prefer
            FROM users
            WHERE email = ?;', array($login));
        if($email)//if the login use email
        {
            if($email['active'] == 1){
                $emailadd = $email['email'];
                $user = $email['username'];
            }
            else{
                throw new UserException('Your account has not been actived yet.');
            }
        }
        else if(!$email)//if the login use username
        {
            $username = Db::queryOne('
                SELECT id_user, email, username, password, active, email_prefer
                FROM users
                WHERE username = ?;', array($login));
            if (!$username){
                throw new UserException('Invalid username or password.');
            }
            if($username['active'] !== 1){
                throw new UserException('Your account has not been actived yet.');
            }
            else{
                $emailadd = $username['email'];
                $user = $username['username'];
            }
        } 
        $reset_email = array(
            'hash_pwd' => hash('md5', rand())
        );
        // echo 'localhost:8081/Modify/'.$user.'/'.$reset_email['hash_pwd'];//
        try
        {
            Db::update('users', $reset_email, 'WHERE username = ?', array($user));
            
            EmailSender::send(
                $emailadd, 
                'Reset your password on Camegru', 
                'You request to reset your password on Camagru, click the link to finish resetting<br>'
                .'<a href="'.'http://localhost:8081/Modify/'.$user.'/'.$reset_email['hash_pwd'].'">reset my password</a>'
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
        $this->auth_pwd($new_pwd);
        try{
            $hash_new_pwd = array(
                'password' => $this->passwordHash($new_pwd),
                'hash_pwd' => NULL
        );
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
        $this->auth_pwd($new_pwd);
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
    
    public function modif_username($old_name, $new_name, $new_name_repeat)
    {
        $escape_username =  htmlspecialchars($new_name);
        if ($escape_username !== $new_name)
        {
            throw new UserException('Invalid username');
        }
        $new_name = $escape_username;
        if ($new_name != $new_name_repeat){
            throw new UserException('New username mismatch.');
        }
        $username = $this->getUsername();
        if($old_name != $username){
            throw new UserException('Old username is different with current login user.');
        }
        if(strlen($new_name) < 3 || strlen($new_name) > 15){
            throw new UserException('Username should have at least 3 and no more than 15 characters.');
        }
        $checkUsername = Db::query('SELECT id_user FROM users WHERE username = ?;', array($new_name));
        if($checkUsername){
            throw new UserException('This username has already been taken.');
        }
        try{
            $new_username = array('username' => $new_name);
            Db::update('users', $new_username, 'WHERE username = ?', array($username));
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function modif_eadd($old_eadd, $new_eadd, $new_eadd_repeat)
    {
        $escape_email =  htmlspecialchars($new_eadd);
        if ($escape_email !== $new_eadd)
        {
            throw new UserException('Invalid email');
        }
        $new_eadd = $escape_email;
        if ($new_eadd != $new_eadd_repeat){
            throw new UserException('New email mismatch.');
        }
        $username = $this->getUsername();
        if($old_eadd != $_SESSION['email']){
            throw new UserException('Old email is different with current login user.');
        }
        $checkEmail = Db::query('SELECT id_user FROM users WHERE email = ?;', array($new_eadd));
        if($checkEmail){
            throw new UserException('This email has already been taken.');
        }
        try{
            $new_email = array('email' => $new_eadd);
            Db::update('users', $new_email, 'WHERE username = ?', array($username));
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
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

    public function get_post_username($id_gallery){
        try{
            $user = Db::queryOne(
            'SELECT `username`
            FROM `users` JOIN `gallery`
            on `gallery`.`id_user` = `users`.`id_user`
            WHERE `gallery`.`id_gallery` =?', array($id_gallery));
            return ($user);
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
}
?>