
<div id = "modal1" class = "modalbg"></div>
<div id = "modal2" class = "modalbg">
    <div id = "modalmsg">

        <div style = "text-align: left; ">
            <b style = "color:gray"><img src = "item16.png" style = "vertical-align: middle;margin-top:-3px;"> Item Editor</b>
            <br><br>
            <div style = "position: absolute; top: 4px; right: 4px; cursor: pointer;">
                <img src = "close.png" onclick = "close_item_editor()" />
            </div>
        </div>

        <table>
            <tr>
                <td>Name</td>
                <td><input type = "text" id = "i_name" value = "Product name"/></td>
                <td rowspan = "77" style = "padding-left: 16px; " id = "ppic">
                    <div id = "ppic_prev">
                    </div><br/>
                    <?php /*<input type = "file" name = "file" id = "file" data-input="false" />*/ ?>
                    <br/>
                    <div id = "upload_status"></div>

                    <form id = "file_form" action="uploadimg.php" target="upload_iframe" method="post" enctype="multipart/form-data">
                        <input name="MAX_FILE_SIZE" value="12291456" type="hidden"/>
                        <input type="hidden" name="fileframe" value="true">
                        <input type="hidden" name="fkid" id="fkid" value="">
                        <input type="file" name="file" id="filebtn" onChange="$('#fkid').val(window.current_entry_id); $('#file_form').submit()">
                    </form>
                    <textarea rows="5" cols="20" name="description" id = "filedesc"
                            style = "display:none; width: 300px; height: 100px; font-family: Arial, sans-serif; font-size: 12px;"></textarea>
                    <iframe name="upload_iframe" style="display:none; width: 300px; "></iframe>

                </td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea type = "text" id = "i_desc"
                             style = "width: 300px; height: 150px; font-size:12px; line-height: 15px;">product description field</textarea></td>
            </tr>

            <style>
                table.json input { font-size: 11px; border: 0; background: #000; color: silver; padding-left: 4px !important; }
                table.json td { padding: 0; height: 18px; padding-right: 8px; }
                table.json td:nth-child(1) input { width: 100px; height: 22px; padding: 0; font-weight: bold; }
                table.json td:nth-child(2) input { width: 180px; height: 22px; padding: 0; }
            </style>

            <tr>
                <td>Misc.</td>
                <td>
                    <table class = "json" id = "misc">
                        <tr>
                            <td><input onclick = "get_json()" onkeypress = "get_json()" onkeyup = "get_json()" onblur = "get_json()" type = "text" placeholder = "Ex: Product Model" /></td>
                            <td><input onclick = "get_json()" onkeypress = "get_json()" onkeyup = "get_json()" onblur = "get_json()" type = "text" placeholder = "Ex: 1234567-ABCD" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Price USD</td>
                <td><input type = "text" id = "i_price" value = "$19.25"/></td>
            </tr>
            <tr>                             
                <td>Category<br/></td>
                <td>
                    <select id = "i_category">

                        <?php
                            if (empty($C[0]))
                            {
                                ?><option>None</option><?php
                            }
                            else
                            {
                                if (count($C) == 1)
                                {
                                    ?><option><?php print $C[0]["name"]; ?></option><?php

                                }
                                else
                                if (count($C[0]) > 1)
                                {
                                    for ($i=0;$i<count($C);$i++)
                                    {
                                        ?><option><?php print $C[$i]["name"]; ?></option><?php
                                    }
                                }
                            }
                        ?>

                    </select>
                </td>
            </tr>
            <tr>
            <td></td>
            <td style="text-align: right">
                <input class="filestyle" type = "button" value = "Save Changes" onclick = "save_item()">

            </td>
            </tr>
        </table>
    </div>
</div>