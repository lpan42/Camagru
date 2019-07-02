<?php
class Db
{
    private static $connection;

    private static $settings = array(
        PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
    );

    public static function connect($dsn, $user, $password)
    {
        if (!isset(self::$connection))
        {
            try{
                self::$connection = new PDO($dsn,$user,$password,self::$settings);
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
}
?>