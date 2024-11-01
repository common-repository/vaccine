<?php
if(!current_user_can('manage_options')){
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
}
global $vaccine;
$statusOK = true;
$versionOK = true;
$prefixOK = true;
if($wpdb->base_prefix=="wp_"){
	$prefixOK = false;
	$statusOK = false;
}
?>

<style>
#vaccineNews{
	display:none;
}
#vaccineOverlay{
	position:fixed;
	top:0px;
	left:0px;
	width:100%;
	height:100%;
	opacity:0.8;
	background:#000;
	z-index:9999;
	display:none;
}
#vaccineOverlayInner{
	position:fixed;
	top:0px;
	left:0px;
	background:#000;
	z-index:10000;
	display:none;
}
#vaccineInterface{
	width:600px;
	padding:10px;
	margin:auto;
	margin-top:30px;
	background:#FFF no-repeat url(<?php print plugins_url('vaccine/assets/images/background.jpg') ?>);
	-webkit-box-shadow:0 0 5px #1e1e1e;
	-moz-box-shadow: 0 0 5px #1e1e1e;
	box-shadow:0 0 5px #1e1e1e;
	-moz-border-radius: 5px;
	border-radius: 5px;
	background-color: #191919;
	color:#CCC;
}
#vaccineInterface h2{
	text-shadow:none;
	color:#F90;
}
#vaccineInterface h3{
	padding:0px;
	margin:0px;
	color:#F90;
}
.vaccineWidget{
	-moz-border-radius: 5px;
	border-radius: 5px;
	background-color: #000;
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#323232), to(#000));
	background-image: -webkit-linear-gradient(top, #323232, #000);
	background-image:    -moz-linear-gradient(top, #323232, #000);
	background-image:     -ms-linear-gradient(top, #323232, #000);
	background-image:      -o-linear-gradient(top, #323232, #000);
	position:relative;
	opacity: 0.8;
	margin-bottom:10px;
}
.vaccineWidget .rightBlock{
	margin-left:160px;
	padding:10px;
}
.vaccineMessage{
	padding:10px;
	margin:auto;
	margin-top:10px;
	margin-bottom:10px;
	margin-left:160px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	background-color: #282828;
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#505050), to(#282828));
	background-image: -webkit-linear-gradient(top, #505050, #282828);
	background-image:    -moz-linear-gradient(top, #505050, #282828);
	background-image:     -ms-linear-gradient(top, #505050, #282828);
	background-image:      -o-linear-gradient(top, #505050, #282828);
	opacity: 0.8;
}
.vaccineWidget .leftBlock{
	-moz-border-radius: 5px;
	border-radius: 5px;
	background-color: #282828;
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#505050), to(#282828));
	background-image: -webkit-linear-gradient(top, #505050, #282828);
	background-image:    -moz-linear-gradient(top, #505050, #282828);
	background-image:     -ms-linear-gradient(top, #505050, #282828);
	background-image:      -o-linear-gradient(top, #505050, #282828);
	position:absolute;
	left:0px;
	width:140px;
	top:0px;
	padding:10px;
}
#vaccineHeader{
	position:relative;
}
#vaccineHeader .leftBlock{
	position:absolute;
	left:0px;
	width:140px;
	top:0px;
	padding:10px;
	text-align:center;
}
.vaccineHidden{
	display:none;
}
.slideIn{
	display:none;
}
#vaccineInterface input[type=submit], #scanRailPercent {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #050505;
	padding: 10px 20px;
	background: -moz-linear-gradient(
		top,
		#ffffff 0%,
		#f09c0c 50%,
		#cf970b 50%,
		#fcab08);
	background: -webkit-gradient(
		linear, left top, left bottom, 
		from(#ffffff),
		color-stop(0.50, #f09c0c),
		color-stop(0.50, #cf970b),
		to(#fcab08));
	border-radius: 14px;
	-moz-border-radius: 14px;
	-webkit-border-radius: 14px;
	border: 1px solid #6d8000;
	-moz-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	-webkit-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	text-shadow:
		0px -1px 0px rgba(000,000,000,0.2),
		0px 1px 0px rgba(255,255,255,0.4);
}
#scanRailPercent{
	height:10px;
	width:0px;
	padding:0px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	margin-top:10px;
	margin-bottom:10px;
}
#scanVision{
	display:none;
}
</style>
<div id="vaccineOverlay"></div>
<div id="vaccineOverlayInner"></div>
<div id="vaccineInterface" class="wrap">
  <div class="icon32" id="icon-vaccine"><img src="<?php print plugins_url('vaccine/assets/images/icon-32.png') ?>" /></div><h2>Welcome to Vaccine</h2>
  <p>This is a beta, please be aware it does not actuall perform any changes to your WordPress installation</p>
  <p>It is better to try to keep a bad thing from happening than it is to fix the bad thing once it has happened.</p>
  <div id="vaccineHeader">
  <div class="vaccineMessage">
    <?php
    if($statusOK){
		?><div class="icon32" id="icon-vaccine"><img src="<?php print plugins_url('vaccine/assets/images/tick-32.png') ?>" /></div><h2>Secured</h2>
		<p>Your WordPress installation is now fully protected by Vaccine.</p>
		<?php
	}else{
		?><div class="icon32" id="icon-vaccine"><img src="<?php print plugins_url('vaccine/assets/images/exclamation.png') ?>" /></div><h2>Attention</h2>
		<p>Your WordPress installation is not fully protected.<br />Please work through the recommended steps.</p>
		<?php
	}
	?>
  </div>
  <div class="leftBlock" id="ajaxLoader">
  <img src="<?php print plugins_url('vaccine/assets/images/ajaxLoader.gif') ?>" />
  </div>
  </div>
  <div id="vaccineReport" class="vaccineWidget slideIn">
    <div class="rightBlock">
    <div><img src="<?php print plugins_url('vaccine/assets/images/tick.png') ?>" align="absmiddle" /> Wordpress Version </div>
    <?php if($prefixOK){ ?>
    <div><img src="<?php print plugins_url('vaccine/assets/images/tick.png') ?>" align="absmiddle" /> Table Prefix</div>
    <?php }else{ ?>
    <div><img src="<?php print plugins_url('vaccine/assets/images/cross.png') ?>" align="absmiddle" /> Table Prefix, suggest changing from default</div>
    <?php } ?>
    <?php if(!$wpdb->show_errors){ ?>
    <div><img src="<?php print plugins_url('vaccine/assets/images/tick.png') ?>" align="absmiddle" /> Database errors hidden</div>
    <?php }else{ ?>
    <div><img src="<?php print plugins_url('vaccine/assets/images/cross.png') ?>" align="absmiddle" /> Database errors are not hidden</div>
    <?php } ?>
    
    </div>
    <div class="leftBlock">
      <h3><?php echo htmlentities(get_bloginfo('title'));?></h3>
    </div>
  </div>
  <div id="vaccineSpam" class="vaccineWidget slideIn">
    <div class="rightBlock">
      <input type="submit" value="Scan WordPress" id="scanWP" />
      <div id="scanVision">
      <div id="scanRail"><div id="scanRailPercent"></div></div>
      <div id="scanWindow">&nbsp;</div>
      </div>
    </div>
    <div class="leftBlock">
      <h3>File Scan</h3>
    </div>
  </div>
  <div id="vaccineSpam" class="vaccineWidget slideIn">
    <div class="rightBlock">
      <?php print $vaccine->fetchSpamCount() ?>
    </div>
    <div class="leftBlock">
      <h3>Spam</h3>
    </div>
  </div>
  <div id="vaccineNews" class="vaccineWidget">
    <div class="rightBlock">Loading
    </div>
    <div class="leftBlock">
      <h3>News</h3>
    </div>
  </div>
</div>
<script>
jQuery(document).ready(function(){
	jQuery("#ajaxLoader").fadeOut("slow");
	jQuery(".slideIn").slideDown("slow");
	jQuery("#vaccineOverlay").click(function(){
		jQuery("#vaccineOverlayInner").fadeOut("slow", function(){
			jQuery("#vaccineOverlay").fadeOut("slow");
		});
	});
	jQuery("#ajaxLoader").fadeIn("slow");
	jQuery.get("<?php print plugins_url('vaccine/assets/ajax/news.php') ?>", function(data){
		if(data!=""){
			jQuery("#vaccineNews .rightBlock").html(data);
			jQuery("#vaccineNews").slideDown("slow");
		}
		jQuery("#ajaxLoader").fadeOut("slow");
	});
//	modalBox("<?php print plugins_url('vaccine/assets/ajax/news.php') ?>");
	jQuery("#scanWP").click(function(){
		jQuery("#scanVision").slideDown("slow", function(){
			scanFile(0);		
		});
	});
});
function scanFile(id){
	var totalSteps = <?php print count($vaccine->scanFiles["perm"]) ?>;
	var pointStep = 100 / totalSteps;
	jQuery("#scanRailPercent").css("width", (pointStep*id) + "%");
	if(id==0){
		jQuery("#ajaxLoader").fadeIn("slow");
		jQuery("#scanWindow").html("");
	}
	if(id!=totalSteps){
		jQuery.get("<?php print plugins_url('vaccine/assets/ajax/scan.php') ?>?id=" + id, function(data){
			jQuery("#scanWindow").html(jQuery("#scanWindow").html() + data + "<br />");
				scanFile(id+1);
		});
	}else{
		jQuery("#scanWindow").html(jQuery("#scanWindow").html() + "Scan Complete");
		jQuery("#ajaxLoader").fadeOut("slow");
	}
}
function modalBox(url){
	jQuery("#ajaxLoader").fadeIn("slow");
	jQuery.get(url, function(data){
		jQuery("#vaccineOverlayInner").html(data);
		jQuery("#vaccineOverlay").fadeIn("slow", function(){
			jQuery("#vaccineOverlayInner").center().fadeIn("slow");
			jQuery("#ajaxLoader").fadeOut("slow");
		});
	});
}
jQuery.fn.center = function () {
	this.css("position","absolute");
	this.css("top", ( jQuery(window).height() - this.height() ) / 2+jQuery(window).scrollTop() + "px");
	this.css("left", ( jQuery(window).width() - this.width() ) / 2+jQuery(window).scrollLeft() + "px");
	return this;
}
</script>