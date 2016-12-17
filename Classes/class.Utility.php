<?php /* Defines utility functions  */
final class Utility
    {
    static public function GetSelfUrl()
    {
        $Protocol = "http";
        return $Protocol . "://www." . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }
}

?>