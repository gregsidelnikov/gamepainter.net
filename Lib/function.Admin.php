<?php
    function PrintAdminNewsBlock($d, $s, $id)
    {
        global $URL; ?>

            <div id = "main_news_<?php print $id; ?>_container">
                <div style = "width: auto; float: right; background: #fff;">
                    <a href = "#" onclick = "switch_news_to_editable(<?php print $id; ?>)"><img src = "<?php print $URL; ?>/Images/EditButton.png" alt = "Edit this news story" border = "0"/></a>
                    <a href = "#" onclick = "if (confirm('Are you sure you want to delete this news item?\r\n\r\nPress Ok to Delete\r\n')) ajax.httpExecute(SuccessEvent_DeleteNews, DELETENEWS, <?php print $id; ?>)"><img src = "<?php print $URL; ?>/Images/DeleteButton.png" alt = "Delete this news story" border = "0"/></a>
                </div>
                <p><b><?php print $d; ?></b></p>
                <div style = "display: block;" id = "news_id_<?php print $id; ?>_solid"><p><?php print $s; ?></p></div>
                <div style = "display: none;" id = "news_id_<?php print $id; ?>_editable">
                    <textarea class = "NewsUpdateTextarea" id = "news_id_<?php print $id; ?>_update_text"><?php print $s; ?></textarea>
                    <div style = "text-align: center">
                        <a href = "#" onclick = "var v = gbi('news_id_<?php print $id; ?>_update_text').value; var arr = [<?php print $id; ?>,v]; ajax.httpExecute(SuccessEvent_UpdateNews, UPDATENEWS, arr);"><img src = "<?php print $URL; ?>/Images/UpdateButton.png" alt = "Update this news story" border = "0"/></a>
                    </div>
                </div>
                <hr>
            </div>
            
        <?php
    }

    function AdminDisplayNewsList()
    {
        global $URL;

        $News = MysqlDatabase::getTableData("site_news", "`key`, `timestamp`, `story`", "", "`timestamp` DESC", 50);

        for ($i = 0; $i < count($News); $i++)
            PrintAdminNewsBlock( date("F j, Y", $News[$i]['timestamp']) . "<br/><i>" . tval(time(), $News[$i]['timestamp']) . " ago</i>", $News[$i]['story'], $News[$i]['key']);
    }

?>
