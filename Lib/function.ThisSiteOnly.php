<?php
    function inc_mindset_fixed($type)
    {
        insert_table_data("mindset_type_counter", array("mindset_type"), array("$type"));
    }
?>