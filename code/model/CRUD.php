<?php

require_once "DBInit.php";

abstract class CRUD {
    public static $table_name = "";
    public static $table_columns = [];

    public static function getAll() {
        $db = DBInit::getInstance();
        $table_name = static::$table_name;
        $statement = $db->prepare("SELECT * FROM $table_name");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get($id) {
        $db = DBInit::getInstance();
        $table_name = static::$table_name;
        $statement = $db->prepare("SELECT * FROM $table_name WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $item = $statement->fetch(PDO::FETCH_ASSOC);

        if ($item != null) {
            return $item;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getWhere($values) {
        $db = DBInit::getInstance();
        $table_name = static::$table_name;
        $table_columns = static::$table_columns;
        $params = "";
        foreach ($values as $column => $_) {
            $params .= "$column = :$column, ";
        }
        $params = rtrim($params, ", ");
        $statement = $db->prepare("SELECT * FROM $table_name WHERE $params");
        foreach ($values as $column => $value) {
            $statement->bindParam(":$column", $value, $table_columns[$column]);
        }
        $statement->execute();

        $items = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($items != null) {
            return $items;
        } else {
            return [];
        }
    }

    public static function insert($values) {
        $db = DBInit::getInstance();
        $table_name = static::$table_name;
        $table_columns = static::$table_columns;
        $columns = "";
        $params = "";
        foreach ($values as $column => $_) {
            $columns .= "$column, ";
            $params .= ":$column, ";
        }
        $columns = rtrim($columns, ", ");
        $params = rtrim($params, ", ");
        $statement = $db->prepare("INSERT INTO $table_name ($columns) VALUES ($params)");
        foreach ($values as $column => $value) {
            $statement->bindParam(":$column", $value, $table_columns[$column]);
        }
        if (!$statement->execute($values)) {
            return null;
        }
        return $db->lastInsertId();
    }

    public static function update($id, $values) {
        $db = DBInit::getInstance();
        $table_name = static::$table_name;
        $table_columns = static::$table_columns;
        $set = "";
        foreach ($values as $column => $_) {
            $set .= "$column = :$column, ";
        }
        $set = rtrim($set, ", ");
        $statement = $db->prepare("UPDATE $table_name SET $set WHERE id = :id");
        $statement->bindParam(":id", $id);
        foreach ($values as $column => $value) {
            $statement->bindParam(":$column", $value, $table_columns[$column]);
        }
        return $statement->execute();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();
        $table_name = static::$table_name;

        $statement = $db->prepare("DELETE FROM $table_name WHERE id = :id");
        $statement->bindParam(":id", $id);
        return $statement->execute();
    }

    public static function deleteWhere($values) {
        $db = DBInit::getInstance();
        $table_name = static::$table_name;
        $table_columns = static::$table_columns;
        $where = "";
        foreach ($values as $column => $_) {
            $where .= "$column = :$column, ";
        }
        $where = rtrim($where, ", ");
        $statement = $db->prepare("DELETE FROM $table_name WHERE $where");
        foreach ($values as $column => $value) {
            $statement->bindParam(":$column", $value, $table_columns[$column]);
        }
        return $statement->execute();
    }
}
