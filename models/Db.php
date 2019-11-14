<?php
require_once 'config/setup.php';
require_once 'config/database.php';
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
                setup_db();
            }
        }
    }
    public static function queryOne($query, $args = array())
    {
		$result = self::$connection->prepare($query);
		$result->execute($args);
        return $result->fetch();
    }

    //return an array of rows that match a given query
    public static function queryAll($query, $args = array())
    {
        $result = self::$connection->prepare($query);
        $result->execute($args);
        return $result->fetchAll();
    }
    
    // Executes a query and returns the number of affected rows
	public static function query($query, $args = array())
	{
        foreach ($args as $key => $v) {
            $args[$key] = htmlspecialchars($v);
        }
		$result = self::$connection->prepare($query);
		$result->execute($args);
		return $result->rowCount();
    }
    
    public static function insert($table, $args = array())
    {
	   return self::query("INSERT INTO `$table` (`".implode('`, `', array_keys($args))."`) VALUES (".str_repeat('?,', sizeof($args)-1)."?)",
		array_values($args));
	}
    
    public static function update($table, $values = array(), $condition, $args = array())
	{
		return self::query("UPDATE `$table` SET `".implode('` = ?, `', array_keys($values))."` = ? " . $condition,
			array_merge(array_values($values), $args));
    }

     // Only for query pages in gallery
	public static function queryPages($query, $offset_nbr)
	{
        $result = self::$connection->prepare($query);
        $result->bindValue(':offset', (int)$offset_nbr, PDO::PARAM_INT);
		$result->execute();
        return $result->fetchAll();
    }
}
?>