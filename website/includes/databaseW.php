<?php
/**
 * Class: MySQLi database connection.
 * @author Seth Hobson
 */

require_once("initializeW.php");
require_once(RET_LIB_PATH.DS."config.php");

class Database
{
    private $connection;
    private $magic_quotes_active;
    private $real_escape_string_exists;
    public $last_query;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->real_escape_string_exists = function_exists("mysqli_real_escape_string");
        // Error handling.
        if (mysqli_connect_error())
            trigger_error('Failed to connect to MySQL: ' . mysqli_connect_error(), E_USER_ERROR);
    }

    /**
     * Method: Prevents cloning of this class by leaving it empty.
     */
    private function __clone() {}

    /**
     * Method: Accessor for the MySQL connection.
     * @return mysqli the MySQL connection.
     */
    public function get_connection()
    {
        return $this->connection;
    }

    /**
     * Method: Queries the database for a given SQL statement.
     * @param $sql
     * @return bool|mysqli_result the returned data from the database
     */
    public function query($sql)
    {
        $this->last_query = $sql;
        $result = $this->connection->query($sql);
        $this->confirm_query($result);
        return $result;
    }

    /**
     * Method: Escapes a form value for sanitation before inserting into the database to protect against
     * SQL injection.
     * @param $value
     * @return string the escaped string
     */
    public function escape_value($value) 
    {
        if ($this->real_escape_string_exists) { // PHP v4.3.0 or higher
            // undo any magic quote effects so mysql_real_escape_string can do the work
            if ($this->magic_quotes_active) { 
                $value = stripslashes($value);
            }
            $value = $this->connection->real_escape_string($value);
        } else { // before PHP v4.3.0
            // if magic quotes aren't already on then add slashes manually
            if (!$this->magic_quotes_active) { 
                $value = addslashes($value);
            }
            // if magic quotes are active, then the slashes already exist
        }
        return $value;
    }

    /**
     * Method: Utility helper to check that a given query result has returned something.
     * @param $result
     */
    private function confirm_query($result)
    {
        if (!$result) {
            $output = "Database query failed: " . mysqli_error($this->connection) . "<br /><br />";
            //$output .= "Last SQL query: " . $this->last_query;
            die($output);
        }
    }
}

// create a new database object for use in other classes
// TODO: antipattern - consider refactoring (singleton?)
$database = new Database();
$db =& $database;
