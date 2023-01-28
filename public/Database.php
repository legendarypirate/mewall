<?php
require_once("config.php");

class Database
{
    private string $host = DB_HOST;
    private string $user = DB_USER;
    private string $pass = DB_PASS;
    private string $dbname = DB_NAME;


    public mysqli $link;
    public string $error;

    public function __construct()
    {
        $this->connectDB();

    }

    private function connectDB()
    {
        $this->link = new mysqli($this->host, $this->user, $this->pass);
        $this->link->set_charset("utf8");
        if (!$this->link) {
            $this->error = "Connection fail" . $this->link->connect_error;
            return false;
        } else {
            return true;
        }
    }

    public function createDB($dbname)
    {
        $query = "CREATE DATABASE $dbname CHARSET=utf8";
        $result = $this->link->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param string $dbname
     * @param string $table
     * @param array $column_type
     * @param bool $alter
     * @return bool
     */
    public function createTable(string $dbname, string $table, array $column_type, bool $alter = false)
    {
        $query = null;
        $column_type_query = null;
        $last_key_colType = $this->link->real_escape_string(array_key_last($column_type));
        foreach ($column_type as $key => $value) {
            if ($key != $last_key_colType) {
                $column_type_query .= " " . $this->link->real_escape_string($key) . " " . $this->link->real_escape_string($value) . ", ";
            } else {
                $column_type_query .= " " . $this->link->real_escape_string($key) . " " . $this->link->real_escape_string($value) . " ";
            }
        }

        if ($alter) {
            $query = "ALTER TABLE `" . $dbname . "`.`" . $this->link->real_escape_string($table) . "` ADD " . $column_type_query;
        } else {
            $query = "CREATE TABLE IF NOT EXISTS `$dbname`.`" . $this->link->real_escape_string($table) . "` (" . $column_type_query . ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        }
        return $this->link->query($query) or die($this->link->error . __LINE__);

    }


    public function select(string $dbname, string $table, array $select = null, array $condition = null, string $order = null, string $limit = null)
    {
        $condition_spread = " ";
        if ($condition) {
            $condition_spread = "WHERE ";
            foreach ($condition as $key => $value) {
                if ((strtolower($value) == "and" || strtolower($value) == "or")) {
                    $condition_spread .= $this->link->real_escape_string($value) . " ";
                } elseif (preg_match("/like/i", $key) == true) {
                    $condition_spread .= " " . $this->link->real_escape_string($key) . " '%" . $this->link->real_escape_string($value) . "%' ";
                } else {
                    $condition_spread .= " " . $this->link->real_escape_string($key) . " = " . "'" . $this->link->real_escape_string($value) . "' ";
                }
            }
        }
        $limit_query = " ";
        if ($limit) {
            $limit_query .= " LIMIT " . $limit;
        }

        $order_query = " ";
        if ($order) {
            $order_query .= " ORDER BY " . $order;
        }
        $select_query = "*";
        if ($select) {
            $select_query = implode(", ", array_values($select));
        }

        $query = "SELECT " . $select_query . " FROM " . $dbname . ".`" . $table . "` " . $condition_spread . " " . $order_query . " " . $limit_query . ";";
        $result = $this->link->query($query) or die($this->link->error . __LINE__);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function selectByGroup(string $dbname, string $table, array $select = null, array $condition = null, string $order = null, string $groupBy = null, string $limit = null)
    {
        $condition_spread = " ";
        if ($condition) {
            $condition_spread = "WHERE ";
            foreach ($condition as $key => $value) {
                if ((strtolower($value) == "and" || strtolower($value) == "or")) {
                    $condition_spread .= $this->link->real_escape_string($value) . " ";
                } elseif (preg_match("/like/i", $key) == true) {
                    $condition_spread .= " " . $this->link->real_escape_string($key) . " '%" . $this->link->real_escape_string($value) . "%' ";
                } else {
                    $condition_spread .= " " . $this->link->real_escape_string($key) . " = " . "'" . $this->link->real_escape_string($value) . "' ";
                }
            }
        }
        $limit_query = " ";
        if ($limit) {
            $limit_query .= " LIMIT " . $limit;
        }
        $group_query = " ";
        if ($groupBy) {
            $group_query .= " GROUP BY " . $groupBy;
        }
        $order_query = " ";
        if ($order) {
            $order_query .= " ORDER BY " . $order;
        }
        $select_query = "*";
        if ($select) {
            $select_query = implode(", ", array_values($select));
        }
        $query = "SELECT " . $select_query . " FROM " . $dbname . ".`" . $table . "` " . $condition_spread . " " . $group_query . " " . $order_query . " " . $limit_query . ";";
        $result = $this->link->query($query) or die($this->link->error . __LINE__);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }


    public function innerJoin(string $dbname, string $table, string $joinTable, array $selectTable = null, array $joinCondition = null, array $condition = null,
                              string $order = null, string $limit = null)
    {
        $selectTable_query = " * ";
        if ($selectTable) {
            $selectTable_query = implode(", ", array_values($selectTable));
        }
        $condition_spread = " ";
        if ($condition) {
            $condition_spread = "WHERE ";
            foreach ($condition as $key => $value) {
                if ((strtolower($value) == "and" || strtolower($value) == "or")) {
                    $condition_spread .= $this->link->real_escape_string($value) . " ";
                } else {
                    $condition_spread .= " " . $this->link->real_escape_string($key) . " = " . "'" . $this->link->real_escape_string($value) . "' ";
                }
            }
        }
        $joinCondition_spread = " ";
        if ($joinCondition) {
            $joinCondition_spread = " ON ";
            foreach ($joinCondition as $key => $value) {
                if ((strtolower($value) == "and" || strtolower($value) == "or")) {
                    $joinCondition_spread .= $value . " ";
                } else {
                    $joinCondition_spread .= " " . $this->link->real_escape_string($key) . " = " . $value . " ";
                }
            }
        }
        $limit_query = " ";
        if ($limit) {
            $limit_query .= " LIMIT " . $limit;
        }
        $order_query = " ";
        if ($order) {
            $order_query .= " ORDER BY " . $order;
        }
        $query = "SELECT " . $selectTable_query . " FROM " . $dbname . ".`" . $table . "` INNER JOIN " . $dbname . ".`" . $joinTable . "`" . $joinCondition_spread . " " . $condition_spread . " " . $order_query . " " . $limit_query . ";";
        $result = $this->link->query($query) or die($this->link->error . __LINE__);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }

    }

    public function selectQ($query)
    {
        $result = $this->link->query($query) or die($this->link->error . __LINE__);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * @param string $dbname
     * @param string $table
     * @param array $column_values
     * @return bool|mysqli_result
     */

    public function insert(string $dbname, string $table, array $column_values)
    {
        $values = null;
        $column = null;
        $last_key_colVal = $this->link->real_escape_string(array_key_last($column_values));
        foreach ($column_values as $key => $value) {
            if ($key != $last_key_colVal) {
                $column .= " " . $this->link->real_escape_string($key) . ", ";
                $values .= " '" . $this->link->real_escape_string($value) . "', ";
            } else {
                $column .= " " . $this->link->real_escape_string($key) . " ";
                $values .= " '" . $this->link->real_escape_string($value) . "' ";
            }
        }
        $query = "INSERT INTO `" . $dbname . "`.`" . $table . "` (" . $column . ") VALUES (" . $values . ")";
        $insert_row = $this->link->query($query) or die($this->link->error . __LINE__);
        return $insert_row;
    }

    /**
     * @param string $dbname
     * @param string $table
     * @param array $column_values
     * @param array $condition
     * @return bool|mysqli_result
     * @uses $condition array( "field_name" => "field_value", "operator" => "AND", "version" => "1.0"
     */

    public function update(string $dbname, string $table, array $column_values, array $condition)
    {
        $tableNvalue = null;
        $last_key_colVal = mysqli_real_escape_string($this->link, array_key_last($column_values));
        foreach ($column_values as $key => $value) {
            if ($key != $last_key_colVal) {
                $tableNvalue .= " " . $this->link->real_escape_string($key) . " = " . "'" . $this->link->real_escape_string($value) . "', ";
            } else {
                $tableNvalue .= " " . $this->link->real_escape_string($key) . " = " . "'" . $this->link->real_escape_string($value) . "' ";
            }
        }
        $condition_spread = null;
        foreach ($condition as $key => $value) {
            if ((strtolower($value) == "and" || strtolower($value) == "or")) {
                $condition_spread .= $this->link->real_escape_string($value) . " ";
            } else {
                $condition_spread .= " " . $this->link->real_escape_string($key) . " = " . "'" . $this->link->real_escape_string($value) . "' ";
            }
        }
        $query = "UPDATE `" . $dbname . "`.`" . $this->link->real_escape_string($table) . "` SET " . $tableNvalue . " WHERE `" . $table . "`." . $condition_spread;
        $update_row = $this->link->query($query) or die($this->link->error . __LINE__);
        return $this->link->affected_rows;
    }

    public function isTableExists(string $dbname, string $table)
    {
        $table_exists = "SELECT * FROM information_schema.tables
                        WHERE table_schema = '$dbname' AND table_name = '$table' LIMIT 1;";
        $result = $this->link->query($table_exists) or die($this->link->error . __LINE__);
        if ($result->num_rows <= 0) {
            return false;
        }
        return true;
    }

    /**
     * @param string $dbname
     * @param string $table
     * @param array $condition
     * @param int $limit
     * @return bool
     */
    public function delete(string $dbname, string $table, array $condition, int $limit = 1)
    {
        $condition_spread = null;
        foreach ($condition as $key => $value) {
            if ((strtolower($value) == "and" || strtolower($value) == "or")) {
                $condition_spread .= $this->link->real_escape_string($value) . " ";
            } else {
                $condition_spread .= " " . $this->link->real_escape_string($key) . " = " . "'" . $this->link->real_escape_string($value) . "' ";
            }
        }
        $query = "DELETE FROM `" . $dbname . "`.`" . $table . "` WHERE `" . $table . "`." . $condition_spread . " LIMIT " . $limit;
        $delete_row = $this->link->query($query) or die($this->link->error . __LINE__);
        return $this->link->affected_rows;
    }

}