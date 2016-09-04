<?php

require_once (realpath(dirname( __FILE__ )) . '/../Config.php');


use Config as Conf;


require_once (Conf::getDatabasePath() . 'MyDataAccessPDOSqlFactory.php');


use MyDataAccessPDOSqlFactory as MyHelper;


abstract class MyDataAcessPDOBase {

    const ERRORMSG_INVALID_CONNECTION = "A conexão enviada é invalida!!";

    private $connection = null;

   
    private $connectionOptions = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
    );

   
    const DSN_HOST_TAG = '{host}';
    const DSN_DATABASENAME_TAG = '{databaseName}';
    const DSN_MYSQL = 'mysql:host={host};dbname={databaseName}';

    
    public function __construct($host, $databaseName, $userName, $password) {

        $dsn = $this->getDSNMySQL($host, $databaseName);

        try {
            $this->setConnection(new PDO($dsn, $userName, $password, $this->getConnectionOptions()));
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    private function getDSNMySQL(&$host, &$databaseName) {
        $dsn = self::DSN_MYSQL;

        MyHelper::replaceStringTag(self::DSN_HOST_TAG, $dsn, $host);
        MyHelper::replaceStringTag(self::DSN_DATABASENAME_TAG, $dsn, $databaseName);

        return $dsn;
    }

   
    protected function getConnection() {
        return $this->connection;
    }

   
    protected function setConnection(PDO &$connection) {
        if (($connection == null) || !($connection instanceof PDO)) {
            throw new PDOException(self::ERRORMSG_INVALID_CONNECTION);
        }
        $this->connection = $connection;
    }

    
    private function getConnectionOptions() {
        return $this->connectionOptions;
    }

    
    public function beginTransaction() {
        $this->connection->beginTransaction();
    }

    
    public function endTransaction() {
        $this->connection->endTransaction();
    }

   
    protected function prepareStatement(&$sql, Array &$dataParameters = null) {
        $q = $this->getConnection()->prepare($sql);
        $q->execute($dataParameters);
        return $q;
    }

}
