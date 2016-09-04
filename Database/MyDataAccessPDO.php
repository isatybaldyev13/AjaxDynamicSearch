<?php

require_once (realpath(dirname( __FILE__ )) . '/../Config.php');

use Config as Conf;

require_once (Conf::getDatabasePath() . 'MyDataAccessPDOBase.php');
require_once (Conf::getDatabasePath() . 'MyDataAccessPDOSqlFactory.php');


class MyDataAccessPDO extends MyDataAcessPDOBase {

    const SELECT_OPERATION = 1;
    const INSERT_OPERATION = 2;
    const UPDATE_OPERATION = 3;
    const DELETE_OPERATION = 4;

    public function __construct($host = Conf::SGBD_HOST_NAME,
                                $databaseName = Conf::SGBD_DATABASE_NAME,
                                $userName = Conf::SGBD_USERNAME, $password = Conf::SGBD_PASSWORD) {
        parent::__construct($host, $databaseName, $userName, $password);
    }


    protected function getRecords($table, Array $where = null,
                                  Array $order = null) {

        try {
            $sql = MyDataAccessPDOSQLFactory::buildSQL(self::SELECT_OPERATION,
                $table, $where, $order);
            $q = $this->prepareStatement($sql, $where);
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }

        $q->setFetchMode(PDO::FETCH_BOTH);
        return $q->fetchAll();
    }

    protected function getRecordsByUserQuery($sql) {
        try {
            $q = $this->prepareStatement($sql);
            $q->setFetchMode(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        return $q->fetchAll();
    }

    protected function insert($table, Array $fields) {
        $sql = MyDataAccessPDOSQLFactory::buildSQL(self::INSERT_OPERATION,
            $table, $fields);
        try {
            $this->prepareStatement($sql, $fields);
        } catch (Exception $e) {
            throw $e;
        }
    }


    protected function update($table, Array $fields, Array $where = null) {
        $sql = MyDataAccessPDOSQLFactory::buildSQL(self::UPDATE_OPERATION, $table, $fields, $where);
        try {
            $this->prepareStatement($sql, $fields);
        } catch (Exception $e) {
            throw $e;
        }
    }

  
    protected function delete($table, Array $where = null) {
        $sql = MyDataAccessPDOSQLFactory::buildSQL(self::DELETE_OPERATION,
            $table, $where);
        try {
            $this->prepareStatement($sql, $where);
        } catch (Exception $e) {
            throw $e;
        }
    }

}