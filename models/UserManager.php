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
        $user = array(
            'email' => $email,
            'username' => $username,
            'password' => $this->passwordHash($password),
            'hash_active' => hash('whirlpool', rand())
        );
        try
        {
            Db::insert('users', $user);
        }
        catch (PDOException $e)
        {
            throw new UserException('This username/email has already been taken.');
        }
    }

    public function login($login, $password)
    {
        $email = Db::queryOne('
            SELECT id_user, email, username, password, email_prefer, admin
            FROM users
            WHERE email = ?;', array($login));
        if($email)//if the login use email
        {
            if (!password_verify($password, $email['password']))
            	throw new UserException('Invalid email or password.');
            $_SESSION['email'] = $email['email'];
            $_SESSION['username'] = $email['username'];
        }
        else if(!$email)//if the login use username
        {
            $username = Db::queryOne('
                SELECT id_user, email, username, password, email_prefer, admin
                FROM users
                WHERE username = ?;', array($login));
            if (!$username || !password_verify($password, $username['password']))
            	throw new UserException('Invalid username or password.');
            $_SESSION['email'] = $username['email'];
            $_SESSION['username'] = $username['username'];
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