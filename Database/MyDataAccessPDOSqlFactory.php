<?php

class MyDataAccessPDOSqlFactory {

    const STRING_EMPTY_VALUE = '';

    const SQL_TABLE_NAME_TAG = '{TABLE_NAME}';
    const SQL_WHERE_CLAUSE_TAG = '{WHERE_CLAUSE}';
    const SQL_ORDERBY_CLAUSE_TAG = '{ORDERBY_CLAUSE}';
    const SQL_INSERT_FIELDS_TAG = '{INSERT_FIELDS}';
    const SQL_INSERT_VALUES_TAG = '{INSERT_VALUES}';
    const SQL_UPDATE_FIELDS_VALUES_TAG = '{UPDATE_FIELDS_VALUES}';

    const SQL_SELECT_STATEMENT_BASE = 'SELECT * FROM {TABLE_NAME} {WHERE_CLAUSE} {ORDERBY_CLAUSE}';
    const SQL_INSERT_STATEMENT_BASE = 'INSERT INTO {TABLE_NAME} ({INSERT_FIELDS}) VALUES({INSERT_VALUES})';
    const SQL_UPDATE_STATEMENT_BASE = 'UPDATE {TABLE_NAME} SET {UPDATE_FIELDS_VALUES} {WHERE_CLAUSE}';
    const SQL_DELETE_STATEMENT_BASE = 'DELETE FROM {TABLE_NAME} {WHERE_CLAUSE}';

    const SQL_FIELD_VALUES_SEPARATOR = ', ';
    const PDO_PLACEHOLDER_PRECHAR = ':';

    public static function buildPDOPlaceHolderKey($key){
        return self::PDO_PLACEHOLDER_PRECHAR . $key;
    }

    public static function replaceStringTag($TAG, &$stringBase, &$value){
        $stringBase = str_replace($TAG, $value, $stringBase);
    }

    protected static function buildSQLClauseWhere(Array &$where = null){
        $whereClause = self::STRING_EMPTY_VALUE;

        if ($where != null) {
            foreach (array_keys($where) as $key) {
                $whereClause =  $whereClause .
                    ($whereClause == self::STRING_EMPTY_VALUE ? self::STRING_EMPTY_VALUE : ' AND ') .
                    $key . ' = ' . self::buildPDOPlaceHolderKey($key);
            }
            $whereClause = ' WHERE ' . $whereClause;
        }

        return $whereClause;
    }

    protected static function buildSQLClauseOrderBy(Array &$order = null){

        $orderClause = self::STRING_EMPTY_VALUE;

        if ($order   != null) {
            $orderClause = 'ORDER BY ' . implode(self::SQL_FIELD_VALUES_SEPARATOR, $order);
        }

        return $orderClause;
    }

    protected static function buildSQLClauseInsertValues(Array &$fields, &$InsertFields, &$InsertValues  ){
        foreach (array_keys($fields) as $key) {
            $InsertFields =  $InsertFields .
                ($InsertFields == self::STRING_EMPTY_VALUE ? self::STRING_EMPTY_VALUE : self::SQL_FIELD_VALUES_SEPARATOR) . $key;
            $InsertValues =  $InsertValues .
                ($InsertValues == self::STRING_EMPTY_VALUE ? self::STRING_EMPTY_VALUE : self::SQL_FIELD_VALUES_SEPARATOR) . self::buildPDOPlaceHolderKey($key);
        }
    }

    protected static function buildSQLClauseUpdateValues(Array &$fields){

        $data = self::STRING_EMPTY_VALUE;

        foreach (array_keys($fields) as $key) {
            $data =  $data . ($data == self::STRING_EMPTY_VALUE ? self::STRING_EMPTY_VALUE : self::SQL_FIELD_VALUES_SEPARATOR) . $key . ' = ' . self::buildPDOPlaceHolderKey($key);
        }

        return $data;
    }

    protected static function buildSQLSelect(&$table, Array &$where = null, Array &$order = null) {

        $sql = self::SQL_SELECT_STATEMENT_BASE;

        $whereClause = self::buildSQLClauseWhere($where);
        $orderClause = self::buildSQLClauseOrderBy($order);

        self::replaceStringTag(self::SQL_TABLE_NAME_TAG, $sql, $table);
        self::replaceStringTag(self::SQL_WHERE_CLAUSE_TAG, $sql, $whereClause);
        self::replaceStringTag(self::SQL_ORDERBY_CLAUSE_TAG, $sql, $orderClause);

        return $sql;
    }

    protected static function buildSQLInsert(&$table, Array &$fields) {
        $sql = self::SQL_INSERT_STATEMENT_BASE;

        $insertFields = $insertValues = self::STRING_EMPTY_VALUE ;

        self::buildSQLClauseInsertValues($fields, $insertFields, $insertValues);

        self::replaceStringTag(self::SQL_TABLE_NAME_TAG, $sql, $table);
        self::replaceStringTag(self::SQL_INSERT_FIELDS_TAG, $sql, $insertFields);
        self::replaceStringTag(self::SQL_INSERT_VALUES_TAG, $sql, $insertValues);

        return $sql;
    }

    protected static function buildSQLUpdate(&$table, Array &$fields, Array &$where) {
        $sql = self::SQL_UPDATE_STATEMENT_BASE;

        $updateFieldsValues = self::buildSQLClauseUpdateValues($fields);
        $whereClause = self::buildSQLClauseWhere($where);

        self::replaceStringTag(self::SQL_TABLE_NAME_TAG, $sql, $table);
        self::replaceStringTag(self::SQL_UPDATE_FIELDS_VALUES_TAG, $sql, $updateFieldsValues);
        self::replaceStringTag(self::SQL_WHERE_CLAUSE_TAG, $sql, $whereClause);

        return $sql;
    }

    protected static function buildSQLDelete(&$table, Array &$where) {
        $sql = self::SQL_DELETE_STATEMENT_BASE;

        $whereClause = self::buildSQLClauseWhere($where);

        self::replaceStringTag(self::SQL_TABLE_NAME_TAG, $sql, $table);
        self::replaceStringTag(self::SQL_WHERE_CLAUSE_TAG, $sql, $whereClause);

        return $sql;
    }

    public static function buildSQL($op, &$table, Array &$data = null, Array &$dataOptional = null){
        $sql = self::STRING_EMPTY_VALUE;

        switch ($op) {
            case MyDataAccessPDO::SELECT_OPERATION:
                $sql = self::buildSQLSelect($table, $data, $dataOptional);
                break;
            case MyDataAccessPDO::INSERT_OPERATION:
                $sql = self::buildSQLInsert($table, $data);
                break;
            case MyDataAccessPDO::UPDATE_OPERATION:
                $sql = self::buildSQLUpdate($table, $data, $dataOptional);
                break;
            case MyDataAccessPDO::DELETE_OPERATION:
                $sql = self::buildSQLDelete($table, $data);
                break;
            default:
                throw new Exception('Invalid SQL Operation!!!');
        }

        return $sql;
    }
}
