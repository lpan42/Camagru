<?php
class UserManager
{
    public function computeHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function register($email, $username, $password, $password_repeat)
    {
        if ($password != $passwordRepeat)
            throw new UserException('Password mismatch.');
        $user = array(
            'email' => $email,
            'username' => $username,
            'password' => $this->computeHash($password),
        );
        try
        {
            Db::insert('users', $user);
        }
        catch (PDOException $ex)
        {
            throw new UserException('This username/email has already been taken.');
        }
    }

    public function login($email, $password)
    {
        $user = Db::queryOne('
            SELECT id_user, email, username, password, email_prefer
            FROM users
            WHERE email = ?', array($email));
        if (!$user || !password_verify($password, $user['password']))
            throw new UserException('Invalid username or password.');
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $user['username'];
    }

    public function logoff()
    {
        unset($_SESSION['user']);
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