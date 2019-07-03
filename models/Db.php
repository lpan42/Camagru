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
                echo "success";
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
    public static function queryOne($query, $args = array())
    {
        $result = self::$connection->prepare($query);
        $result->execute($args);
        return $result->fetch();
    }

    public static function insert($table, $args = array())
    {
        return self::query("INSERT INTO `$table` (`".implode('`, `', array_keys($args))."`) VALUES (".str_repeat('?,', sizeof($args)-1)."?)",
            array_values($args));
	}
	
}
?>