<?php

// The main database methods are:

//     delete()
//     insert()
//     set()
//     get()

// Simple!

final class db {

    public $m_connected;
    public $m_objDatabase;
    private $m_container;

    function __construct() {
        $this->m_connected = false;
        if (($this->m_objDatabase = mysql_connect( MysqlConfig2::$HOST, MysqlConfig2::$USER, MysqlConfig2::$PASSWORD )) != FALSE) {

            mysql_set_charset('utf8', $this->m_objDatabase);

            if ( !mysql_select_db( MysqlConfig2::$CATALOG ) ) {

                $this->disconnect();
                print "MysqlDatabase::~ctor() -> mysql_select_db(); error: " . mysql_error();
                //exit;
            }

        } else
        { print "MysqlDatabase::~ctor() -> mysql_connect(); error: " . mysql_error();
        //exit;
        }

        $this->m_connected = true; // If we are still here, we must be connected
    }

    function __destruct() { $this->disconnect(); }
    public function isReady() { return $this->m_connected; }
    public function disconnect() { $this->m_connected = false; if ($this->m_objDatabase) { mysql_close($this->m_objDatabase); $this->m_objDatabase = NULL; } }
    public function getLastInsertID() { $Query = "SELECT LAST_INSERT_ID()"; if (($Resource = mysql_query( $Query )) != FALSE) if (($row = mysql_fetch_row( $Resource )) != FALSE) return $row[0]; return -1; }

    // Delete row
    public function delete($table, $where) {
        $q = "DELETE FROM $table WHERE $where";
        if (mysql_query($q) != FALSE) return true;
        print mysql_error();
        return false;
    }

    // Insert row
    public function insert($table, $columns, $values) {
        if (!$table || !$columns || !$values) { print "insert_table_data($table, $columns, $values); has failed! insufficient parameters"; return false; }
        $cols = array_to_list($columns,"`");
        $vals = array_to_list($values,"'");
        $query = "INSERT INTO $table ($cols) VALUES ($vals)";
        if (get_magic_quotes_gpc() == 1) { $query = str_replace("\'", "'", $query); $query = str_replace("\\\"", "\"", $query); }
        if (mysql_query($query) != FALSE) return mysql_insert_id();
        return false;
    }

    // Execute mysql command
    public function mysql($query)
    {
        return mysql_query($query);
    }

    // Set row
    public function set($table, $columns, $values, $where="", $limit="") { return set_table_data($table, $columns, $values, $where, $limit); }

    // Count entries
    public function count($table, $where)
    {
        $mysql = "SELECT COUNT(*) FROM `$table`";

        if (isset($where) && $where != "")
            $mysql = "SELECT COUNT(*) FROM `$table` WHERE $where";

        if (get_magic_quotes_gpc() == 1) { $mysql = str_replace("\'", "'", $mysql); $mysql = str_replace("\\\"", "\"", $mysql); }
        $Resource = mysql_query($mysql);

        $QueryResults = db::extractRowsFrom( $Resource );
        return $QueryResults;
    }

    // Get table data
    public function get(
        $paramTable,
        $paramColumns,                           // [Required Arguments]
        $paramWhere = "",
        $paramOrder = "",
        $paramLimit = "",
        $paramIndex = "") // [Default Arguments] see below
    {
            // Types of commands supported by this function argument list, must be preceded by a space
        $query_command = array( " WHERE", " ORDER BY", " LIMIT" );

            // Row container to hold query results
        $QueryResults = array();

        if (!isset($paramColumns))
            $paramColumns = "*"; // not specified? get everything

            // Are we joining two tables? or only one table is specified...?
        $tableEnumeration = explode(",", $paramTable);

        if (count($tableEnumeration) == 1) // we have a single table specified
        {
            //paramTable remains same as in the parameter list

            // If paramColumns is empty, just get all entries - but only if we have 1 table (no join)
            if ($paramColumns == "")
                $paramColumns = get_all_from( $paramTable );

            if ($paramColumns == "*") // same as above, but shown explicitly with an asterisk, to avoid confusion in the code
                $paramColumns = get_all_from( $paramTable );
        }
        else
        {
            $FinalTableNames = "";
            for ($i = 0; $i < count($tableEnumeration); $i++) {
                $FinalTableNames .= "" . trim($tableEnumeration[$i]) . "";
                if ($i + 1 < count($tableEnumeration))
                    $FinalTableNames .= ",";
            }
            $paramTable = $FinalTableNames;
        }

            // Construct the query call from function arguments
        $Query = "SELECT $paramColumns FROM $paramTable";



            // How many default arguments were passed?
        $funcExtraArgs = func_num_args() - 2;

            // At least one [Default Argument] has been passed
        if ( $funcExtraArgs > 0 )
            for ($i = 0; $i < $funcExtraArgs - 1; $i++) // Append all default args to the query string to complete it
            if (func_get_arg($i + 2) != "")       // We are allowed to purposely pass "" as an argument to skip that argument and go to the next
                $Query .= $query_command[$i] . " " . func_get_arg($i + 2);

            //print $Query."\r\n\r\n";

        if (get_magic_quotes_gpc() == 1) { $Query = str_replace("\'", "'", $Query); $Query = str_replace("\\\"", "\"", $Query); }

        // Can we get a resource from the constructed query?
        if (($Resource = mysql_query( $Query )) != FALSE)
        {
            $QueryResults = db::extractRowsFrom( $Resource );

            if (db::containsData( $QueryResults ))
                return db::extractColumns( $paramColumns, $QueryResults, $paramLimit, $paramIndex);
        }
        else
            print "MYSQL GET FAILED FOR QUERY = [" . $Query . "] > " . mysql_error();

        return false; // We are here when the resulting array contains no data or there is a mysql error
    }

    // func  extractColumns
    // Extract column names from parameter list (string) and pair them with the values. Store as associative array such as data[i][string_name]
    private function extractColumns( $ParameterList, array $ColumnValues, $paramLimit, $paramIndex)
    {

        //print "<br/>private function extractColumns: $ParameterList | ColumnValues: " . print_r($ColumnValues);

        /* remove ` or ' or " */
        $ParameterList = preg_replace("/`|\"|'/", "", $ParameterList);

        $ParameterList = explode( ",", $ParameterList );

        $Data = array();

        for ($i = 0; $i < count( $ColumnValues ); $i++)
        {
            for ($j = 0; $j < count( $ParameterList ); $j++)
            {
                $name = trim($ParameterList[ $j ]);

                if ($paramLimit == 1)
                {
                    if ($paramIndex == 1)
                        $Data[$name] = $ColumnValues[$i][$j];
                    else
                        $Data[0][$name] = $ColumnValues[$i][$j];
                }
                else
                {
                    $Data[$i][$name] = $ColumnValues[$i][$j];
                }
            }
        }

        return $Data;
    }

    // func  extractRowsFrom
    // Extract available rows from an available mysql resource and puts it into a container
    private function extractRowsFrom( $Resource )
    {
        $Container = array();

        $index = 0;

        while (( $row = mysql_fetch_row( $Resource ) ) != FALSE)
        $Container[ $index++ ] = $row;

        return $Container;
    }

    // func  containsData
    // Check if an array is empty, currently only checks arrays
    private function containsData( $paramData )
    {
        if (is_array( $paramData ))        // Do we have an array?
        {
            if (count( $paramData ) > 0)     // Are there items in this array?
            {
                return true;
            }
        }
            // Not an array, or array is empty
        return false;
    }

    public function Authorize($User)
    {
        //print "Connection->Authorize with: User = [" . $User->username . ", " . $User->password . "]\r\n";

        if ($this->isReady())
            $User->SignIn($this);
    }

}

// end class MysqlDatabase

?>