<?php require("../../Migration/Composition.php");

    $db = new db();

    if ($db->isReady()) {
        if (($I = $db->set($plugin_table_cart,
            array("name","description","price","category","json"),
            array(addslashes($_REQUEST['name']),
                  addslashes($_REQUEST['desc']),
                  addslashes($_REQUEST['price']),
                  addslashes($_REQUEST['category']),
                  addslashes($_REQUEST['json'])),
            "`key`='".$_REQUEST['key']."'"))!=FALSE) {

            // Get same item:
            $I = $db->get($plugin_table_cart, get_all_from($plugin_table_cart), "`key`='" . $db->getLastInsertID() . "'");

            ?>

            <td class = "j"><?php print $_REQUEST['key']; ?></td>
            <td><div id = "img_prev<?php print $_REQUEST['key']; ?>" class = "img_prev" style = "background: url('<?php print $URL; ?>/plugins/cart/pictures/32/<?php print $_REQUEST['key']; ?>.jpg') no-repeat;"></div></td>
            <td style="font-weight: bold; width: 180px;"><?php print $_REQUEST['name']; ?></td>
            <td class = "res" style="text-align: center;"><a href = "<?php print $URL; ?>/plugins/cart/viewitem.php?id=<?php print $_REQUEST['key']; ?>" target = "_blank"><img src = "view.png" style = "border:0;" /></a></td>
            <td style = "width: 370px; height: 28px; color: gray;">
               <?php $full_desc = $_REQUEST['desc'];
                     $full_len = strlen($full_desc);
                     if ($full_len != 1) $s = "s"; else $s = "";
                     if ($full_len > 70)
                         $full_desc = substr($full_desc,0,70) . " (<i>$full_len letter$s</i>)...";
                     print $full_desc;
               ?>
            </td>
            <td style = "padding-right: 8px; color: #dec476">$<?php print $_REQUEST['price']; ?></td>
            <td nowrap>
                <?php print $_REQUEST['category']; ?>
            </td>
            <td onclick = "delete_item(<?php print $_REQUEST['key']; ?>, this)"
                  class = "res"
                  style = "text-align: center; background: #000; z-index: 1000; position: relative;"
                onmouseover = "$('img', this).attr('src', 'trash2.png')"
                onmouseout = "$('img', this).attr('src', 'trash1.png')">
                <img src = "trash1.png" style = "margin-top:-4px;"/>
            </td>
            <td class = "res conf">
                <a href = "#" onclick = "confirm_delete_item(<?php print $_REQUEST['key']; ?>); return false;">Confirm</a>
            </td>
            <?php /*<td><a href = "#?id=<?php print $I[$i]['key']; ?>" onclick = "open_item_editor(<?php print $I[$i]["key"]; ?>); return false;">Edit</a></td>*/ ?>

            <?php

        }
    }
?>