<?php

	include("../../Migration/Composition.php");
	
?>

<div style = "width: 640px; margin: 0 auto; background: #f7ffec; padding: 10px; padding-top: 24px; padding-bottom: 24px;">
				<div style = "position: relative; background: #fff url('<?php print $URL; ?>/Templates/simplicity/striped_border.png') repeat-x; width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 32px; font-family: Verdana; font-size: 12px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
				
<?php /*					<img src = "http://www.tigrisdev.net/youre-reinvited-stamp.png" alt = "You're Invited Stamp" style = "position: absolute; top:16px;right:16px;"/> */ ?>
				

				
					<div style = "font-size: 17px">You're Invited!</div>
					
					<p>You were sent a private invitation to subscribe to <?php print $NEWSLETTER_NAME; ?>.</p>
				
					<p>Your friend, who has been a reader of <a href = "<?php print $URL; ?>" style = "color:#6dc900 !important;"><?php print $NEWSLETTER_NAME; ?></a> weekly newsletter has invited you to check it out. It's a free online newsletter with educational articles.</p>
					
					<p>This invitation was sent by someone who used newsletter's "Invite" feature, because they liked our stories and were worthy of sharing with their friends!</p>
						
					<p>To accept the invitation, please click the button below and subscribe on the next page.</p>
						
					<div style = "height:8px"></div>
									
					<p><a href = '<?php print $URL; ?>' style = 'color:#7b7b7b !important; text-decoration:none;'><div style = 'margin: 0 auto; padding:0;position:relative;width:129px;height:35px;background: url(<?php print $URL; ?>/plugins/list/read-bg.png) no-repeat;background-position:center center;border:1px solid #b5b5b5;border-radius:7px;text-align:center;color:#7b7b7b; text-decoration:none;'><div style = 'height:11px;'></div>Subscribe Here</div></a></p>
						
					<div style = "height:8px"></div>
					

					<b>What is it about?</b>
					<ol>
					    <li><a href = "<?php print $URL; ?>" style = "color:#6dc900 !important;"><?php print $NEWSLETTER_NAME; ?></a> is not just a free newsletter, it's a community.</li>
					    <li>Meeting other like-minded professionals and hobbyists.</li>
					    <li>We have a Skype and Discord channels, if you want to meet new friends or simple network with others.</li>
					</ol>
					
					
					<b>Who should join?</b>
					<ol>
					    <li>Someone who wants to learn more about web design, development and how to make websites in general.</li>
					    <li>JavaScript, CSS, HTML programmers and web designers.</li>
					</ol>
						
					<div style = "height:8px"></div>

					<div style = "color:gray">
							<b>Why did you receive this message?</b>
							<ol>
								<li>One of the subscribers has used the "Invite" feature, which was sent to you as a message asking to check out the newsletter.</li>
								<li>If you believe you've received this message in error or it's not something you are intersted in, I apologize. Simply disregard this message.</li>
								<li>Greg Sidelnikov (greg.sidelnikov@gmail.com) is the author of <a href = "<?php print $URL; ?>" style = "color:#6dc900 !important;"><?php print $NEWSLETTER_NAME; ?></a>, an online publication series about learning how to make your own websites.</li>
							</ol>
							<br/><br/>
							<p style = "text-align: center; color: silver;"><img src = "http://www.tigrisdev.net/tn16.png" style = "margin-top:0;vertical-align:middle;" alt = "Tigris Network"/> Tigris Network</p>
							<p style = "text-align: center; color: silver;">&copy; <?php print date("Y", time()); ?></p>
					</div>
					
				
				</div>
</div>


