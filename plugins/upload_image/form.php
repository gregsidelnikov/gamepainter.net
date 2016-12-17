					<style type = "text/css">
						#filebtn { position: fixed; top: -1000px; }
						.myLabel span { display: block; position: relative; width: 100px; height: 100px; border: 2px solid red; background: black; }
					</style>

                    <form id = "file_form"
	                    action="<?php print $URL; ?>/plugins/upload_image/uploadimg.php"
    	                target="upload_iframe" method="post"
        	            enctype="multipart/form-data"
            	        style = "">
                        <input name="MAX_FILE_SIZE" value="4000000" type="hidden"/>
                        <input type="hidden" name="fileframe" value="true"/>
                        <input type="hidden" name="fkid" id="fkid" value=""/>
                        
                        <label class="myLabel">
    	                    <input type="file" required style = "font-family: Arial !important; color:white !important;" name="file"
	    	                    id="filebtn" onChange="$('#fkid').val(window.passport_user_id); $('#file_form').submit()" />
						    <span>Upload Avatar</span>
						</label>
                        
                    </form>
                    
                    <div id = "upload_status"></div>
                    <textarea rows="5" cols="20" name="description" id = "filedesc" style = "display:none; width: 300px; height: 100px; font-family: Arial, sans-serif; font-size: 12px;"></textarea>
                    <iframe name="upload_iframe" style="display:none; width: 300px; border:1px solid red; "></iframe>