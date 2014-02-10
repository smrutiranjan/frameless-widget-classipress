<?php
/**
 * Frameless Widget Class
 *
 * @since 0.1
 */
class Frameless_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'Frameless_widget', 'description' => __('Frameless or HTML or Plain Text', Frameless_WIDGET_TEXT_DOMAIN));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('Frameless-widget', __('Frameless Widget', Frameless_WIDGET_TEXT_DOMAIN), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = do_shortcode(apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance ));
		echo $before_widget;
		if($text == 1){$this->form1($title);}
		if($text == 2){$this->form2($title);}
		if($text == 3){$this->form3($title);}
        echo $after_widget;
        }
	function form1($title)
	{
		?>
		  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css" />
          <link type="text/css" rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
          <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script-->
          <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
          <script src="<?php echo plugins_url('jquery.selectBoxIt.js', __FILE__);?>"></script> 
			<style>
            <?php echo get_option('form1_css');?>	
			.ui-datepicker .ui-datepicker-header {background:none repeat scroll 0 0 #026CD6;color:#FFFFFF}
			.frameless_widget_div ul li{background:none;padding:5px;margin:0;}
			.tabsidebar .ui-widget-content{	border:none;}
			.ui-tabs .ui-tabs-panel{padding:0;}
			.content_left .ui-tabs{padding:0;}
            </style>
			<script>
			jQuery( document ).ready(function($) {
			function getsc()
			{
				var widths=$(window).width();			
				var heights=$(window).height();
				if(widths <= 768){
				$('html').prepend($('#frameless_widget_section').html());
				$('#frameless_widget_section').hide();
				}
			   $('div .frameless_widget_div .selectBox-dropdown').hide();
				
			}
			function resizeDatepicker() {
    			setTimeout(function() {
					var widths=$(window).width();
					$("#ui-datepicker-div").width("250px");
					$("#ui-datepicker-div").css({margin:"40px 0 0 0"});
					$('.ui-datepicker-group').width('100%');
				}, 0);
			}	
				getsc();
			$("#PickupLocationID,#DropoffLocationID").selectBoxIt({
			
			// Uses the jQueryUI theme for the drop down
			theme: "jquerymobile",
			
			
			});
           $("#txtStartDate_div").datepicker({ 
				showOn: "button",
        		buttonImage: "<?php echo plugins_url('cal.gif', __FILE__);?>",
        		buttonImageOnly: true,									  
				 minDate: 0,
				 maxDate: '+18M +14D',
				 showAnim: 'fadeIn',
				 numberOfMonths: 3,
				 dateFormat: "dd/mm/yy",
				 showButtonPanel: true,
				 defaultDate: +2,
				 beforeShow: function(input, inst)
				{
					var widths=$(window).width();			
					var heights=$(window).height();
					if(widths <= 768){					
						$.datepicker._pos = $.datepicker._findPos(input); //this is the default position
						$.datepicker._pos[0] = $.datepicker._pos[0]-260; //left
						$.datepicker._pos[1] = '50'; //top
						resizeDatepicker();
					}
				},
				 onClose: function (dateText, picker) {
					document.getElementById('txtStartDate').value=dateText;					
				 }
				 });
			$("#txtEndDate_div").datepicker({ 
				showOn: "button",
        		buttonImage: "<?php echo plugins_url('cal.gif', __FILE__);?>",
        		buttonImageOnly: true,									  
				 minDate: 0,
				 maxDate: '+18M +14D',
				 showAnim: 'fadeIn',
				 numberOfMonths: 3,
				 defaultDate: +16,
				 dateFormat: "dd/mm/yy",
				 showButtonPanel: true,	
				beforeShow: function(input, inst)
				{
					var widths=$(window).width();			
					var heights=$(window).height();
					if(widths <= 768){					
						$.datepicker._pos = $.datepicker._findPos(input); //this is the default position
						$.datepicker._pos[0] = $.datepicker._pos[0]-260; //left
						$.datepicker._pos[1] = '50'; //top
						resizeDatepicker();
					}
				},
				 onClose: function (dateText, picker) {
					document.getElementById('txtEndDate').value=dateText;					
				 }
				 });
            });	
             function updatefield()
            {
				var startdate=document.getElementById('txtStartDate').value;
				var pickarr=startdate.split("/");
				document.getElementById('PickupDay').value=pickarr[0];
				document.getElementById('PickupMonth').value=pickarr[1];
				document.getElementById('PickupYear').value=pickarr[2];
				
				var enddate=document.getElementById('txtEndDate').value;
				var droparr=enddate.split("/");
				document.getElementById('DropoffDay').value=droparr[0];
				document.getElementById('DropoffMonth').value=droparr[1];
				document.getElementById('DropoffYear').value=droparr[2];            
            }
            </script>           
            <div class="textwidget" id="frameless_widget_section">
            <div class="clear5"></div>
            <div class="frameless_widget_div" data-role="content">
                <div class="form1">
                <form target="_blank" id="theform" action="https://secure.rentalcarmanager.com.au/ssl/AUTravelWheels107/bondi/webstep2.asp?refid=&amp;URL=" name="theform" method="post">				
                <?php
				if(get_option( 'form1_header_img')!=""){?>
                <div align="center"><img src="<?php echo plugins_url( 'frameless-widget/upload/'.get_option( 'form1_header_img') , dirname(__FILE__) );?>" border="0"/></div><?php } else {?><h1><?php echo $title; ?></h1><?php } ?>
                <div class="clear5"></div>                    
            <label>Pickup Location</label>
            <select  name="PickupLocationID" id="PickupLocationID">
               <option value="28">Adelaide &nbsp;</option>
               <option value="33">Brisbane &nbsp;</option>
               <option value="36">Cairns &nbsp;</option>
               <option value="12">Darwin &nbsp;</option>
               <option value="4">Melbourne &nbsp;</option>
               <option value="9">Perth &nbsp;</option>
               <option selected="selected" value="1">Sydney &nbsp;</option>
            </select>       
        <div class="clear5"></div>        
         <label>Pickup Date</label>
           <div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset ui-shadow ui-btn-up-c"> <input  type="text" id="txtStartDate" data-theme="a" value="<?php echo date("d/m/Y",strtotime("+2 day"));?>"/><input  type="hidden" id="txtStartDate_div"/></div>
       <!-- </div>-->
        <div class="clear5"></div>                  
            <label>Dropoff Location</label>
            <select name="DropoffLocationID" id="DropoffLocationID">               
               <option value="Same" selected="selected">Same As Pickup</option>
               <option value="28">Adelaide &nbsp;</option>
               <option value="33">Brisbane &nbsp;</option>
               <option value="36">Cairns &nbsp;</option>
               <option value="12">Darwin &nbsp;</option>
               <option value="4">Melbourne &nbsp;</option>
               <option value="9">Perth &nbsp;</option>
               <option value="1">Sydney &nbsp;</option>
            </select>
        <div class="clear5"></div>
         <label>Dropoff Date</label>
           <div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset ui-shadow ui-btn-up-c"><input type="text" id="txtEndDate" data-role="date" value="<?php echo date("d/m/Y",strtotime("+16 day"));?>"/><input type="hidden" id="txtEndDate_div"/></div>
        <!--</div>-->
         <div class="clear5"></div>
          <input type="hidden" value="9" name="CategoryTypeID"/>
		<img border="0" oldsrc="<?php echo plugins_url( 'frameless-widget/search.png' , dirname(__FILE__) );?>" srcover="<?php echo plugins_url( 'frameless-widget/search_ho.png' , dirname(__FILE__) );?>" src="<?php echo plugins_url( 'frameless-widget/search.png' , dirname(__FILE__) );?>" onclick="updatefield();document.getElementById('theform').submit();" style="box-shadow:none;border:none;border-radius:none;"/>
         <!--<input value="Search" data-theme="b" type="submit" style="width:100%" class="ui-button ui-widget ui-state-default ui-corner-all"/-->
         <input type="hidden" name="PickupDay" id="PickupDay"/><input type="hidden" name="PickupMonth" id="PickupMonth"/><input type="hidden" name="PickupYear" id="PickupYear"/>
         <input type="hidden" name="DropoffDay" id="DropoffDay"/><input type="hidden" name="DropoffMonth" id="DropoffMonth"/><input type="hidden" name="DropoffYear" id="DropoffYear"/>
         <div class="clear5"></div>
         </form>
    			</div>
			</div>
			<div class="clear5"></div>
			</div>
        <?php
	}
	function form2($title)
	{
		?>
       <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="<?php echo plugins_url('jquery.selectBox.js', __FILE__);?>"></script> 
			<style>
            <?php echo get_option('form2_css');?>
            </style>
			<script type="text/javascript">
            function getsc()
			{
				var widths=$(window).width();			
				var heights=$(window).height();
				if(widths <= 768){
				$('html').prepend($('#frameless_widget_section').html());
				$('#frameless_widget_section').hide();
				}
				
			}
			function resizeDatepicker() {
    			setTimeout(function() {
					var widths=$(window).width();
					$("#ui-datepicker-div").width("250px");
					$("#ui-datepicker-div").css({margin:"40px 0 0 0"});
					$('.ui-datepicker-group').width('100%');
				}, 0);
			}
            $(function() {	
				getsc();
              $('#txtStartDate,#txtEndDate').datepicker(
			   { 
				 minDate: 0,
				 maxDate: '+18M +14D',
				 showAnim: 'fadeIn',
				 numberOfMonths: 3,
				 dateFormat: "dd/mm/yy",
				beforeShow: function(input, inst)
				{
					var widths=$(window).width();			
					var heights=$(window).height();
					if(widths <= 768){					
						$.datepicker._pos = $.datepicker._findPos(input); //this is the default position
						$.datepicker._pos[0] = $.datepicker._pos[0]-260; //left
						$.datepicker._pos[1] = '50'; //top
						resizeDatepicker();
					}
				}
			   }); 
            	$( "#datepicker-btn" ).datepicker({
            	onSelect: function(date) {
            		document.getElementById('txtStartDate').value=date;
            		document.getElementById('datepicker-btn').value="Select Date";
            	},
            	 minDate: 0,
				 maxDate: '+18M +14D',
				 showAnim: 'fadeIn',
				 numberOfMonths: 3,
				 dateFormat: "dd/mm/yy",
				  beforeShow: function(input, inst)
				{
					var widths=$(window).width();			
					var heights=$(window).height();
					if(widths <= 768){					
						$.datepicker._pos = $.datepicker._findPos(input); //this is the default position
						$.datepicker._pos[0] = $.datepicker._pos[0]-260; //left
						$.datepicker._pos[1] = '50'; //top
						resizeDatepicker();
					}
				}
            });
            $( "#datepicker1-btn" ).datepicker({
            	onSelect: function(date) {
            	document.getElementById('txtEndDate').value=date;
            	document.getElementById('datepicker1-btn').value="Select Date";
            	},
           		 minDate: 0,
				 maxDate: '+18M +14D',
				 showAnim: 'fadeIn',
				 numberOfMonths: 3,
				 dateFormat: "dd/mm/yy",
				  beforeShow: function(input, inst)
				{
					var widths=$(window).width();			
					var heights=$(window).height();
					if(widths <= 768){					
						$.datepicker._pos = $.datepicker._findPos(input); //this is the default position
						$.datepicker._pos[0] = $.datepicker._pos[0]-260; //left
						$.datepicker._pos[1] = '50'; //top
						resizeDatepicker();
					}
				}
            });
            $('#PickupLocationID,').selectBox({
           		 mobile: true
            	});
            });
            function updatefield()
            {
				var startdate=document.getElementById('txtStartDate').value;
				var pickarr=startdate.split("/");
				document.getElementById('PickupDay').value=pickarr[0];
				document.getElementById('PickupMonth').value=pickarr[1];
				document.getElementById('PickupYear').value=pickarr[2];
				
				var enddate=document.getElementById('txtEndDate').value;
				var droparr=enddate.split("/");
				document.getElementById('DropoffDay').value=droparr[0];
				document.getElementById('DropoffMonth').value=droparr[1];
				document.getElementById('DropoffYear').value=droparr[2];            
            }
            </script>
            <div class="textwidget" id="frameless_widget_section">
            <div class="clear5"></div>
            <div class="frameless_widget_div" >
               <form target="_blank" id="theform" action="https://secure.rentalcarmanager.com.au/ssl/AUTravelWheels107/bondi/webstep2.asp?refid=&amp;URL=" name="theform" method="post">
    	 <?php
				if(get_option( 'form2_header_img')!=""){?>
                <div align="left"><img src="<?php echo plugins_url( 'frameless-widget/upload/'.get_option( 'form2_header_img') , dirname(__FILE__) );?>" border="0"/></div><?php } else {?><h1><?php echo $title; ?></h1><?php } ?>
        <div class="clear5"></div><div class="clear5"></div>                              
            <select  name="PickupLocationID" id="PickupLocationID" data-mini="true" class="sel">
               <option value="28">Adelaide &nbsp;</option>
               <option value="33">Brisbane &nbsp;</option>
               <option value="36">Cairns &nbsp;</option>
               <option value="12">Darwin &nbsp;</option>
               <option value="4">Melbourne &nbsp;</option>
               <option value="9">Perth &nbsp;</option>
               <option selected="selected" value="1">Sydney &nbsp;</option>
            </select>           
        <div class="clear5"></div>                 
        <input type="button" id="datepicker-btn" value="Select Date" class="ui-button ui-widget ui-state-default ui-corner-all" style="width:45%"/> &nbsp;&nbsp;          
        <div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset ui-shadow ui-btn-up-c" style="background: none repeat scroll 0 0 #FFFFFF;border-color: #DDDDDD;color: #333333;
    text-shadow: 0 1px 0 #F3F3F3;width:45%;display:block;float:right;margin:0;"><input type="text" id="txtStartDate" value="<?php echo date("d/m/Y",strtotime("+2 day"));?>"/></div>
        <div class="clear5"></div>
        <label><strong>STEP3:RETURNING</strong> </label>
        <div class="clear5"></div>
            <select name="DropoffLocationID" id="DropoffLocationID" data-mini="true" class="sel"> 
               <option value="Same" selected="selected">Same As Pickup</option>
               <option value="28">Adelaide &nbsp;</option>
               <option value="33">Brisbane &nbsp;</option>
               <option value="36">Cairns &nbsp;</option>
               <option value="12">Darwin &nbsp;</option>
               <option value="4">Melbourne &nbsp;</option>
               <option value="9">Perth &nbsp;</option>
               <option value="1">Sydney &nbsp;</option>
            </select>
            <div class="clear5"></div> 
       <input  type="button" id="datepicker1-btn" value="Select Date" class="ui-button ui-widget ui-state-default ui-corner-all" style="width:45%"/> &nbsp;&nbsp;          
         <div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset ui-shadow ui-btn-up-c" style="background: none repeat scroll 0 0 #FFFFFF;border-color: #DDDDDD;color: #333333;
    text-shadow: 0 1px 0 #F3F3F3;width:45%;display:block;float:right;margin:0;"><input type="text" id="txtEndDate" value="<?php echo date("d/m/Y",strtotime("+16 day"));?>"/></div>
       
         <div class="clear5"></div>
         <input type="hidden" value="9" name="CategoryTypeID"/>
         <input type="hidden" name="PickupDay" id="PickupDay"/><input type="hidden" name="PickupMonth" id="PickupMonth"/><input type="hidden" name="PickupYear" id="PickupYear"/>
         <input type="hidden" name="DropoffDay" id="DropoffDay"/><input type="hidden" name="DropoffMonth" id="DropoffMonth"/><input type="hidden" name="DropoffYear" id="DropoffYear"/>
         <input value="Search" class="ui-button ui-widget ui-state-default ui-corner-all" type="submit" onclick="updatefield()" style="width:100%"/>
         <div class="clear5"></div>
         </form>
			</div>
			<div class="clear5"></div>
		</div>
        <?php
	}
	function form3($title)
	{
		?>
        	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
            <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
            <script src="//code.jquery.com/jquery-1.10.2.js"></script>
            <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
            <script src="<?php echo plugins_url('jquery.selectric.js', __FILE__);?>"></script>            
			<style>
            <?php echo get_option('form3_css');?>
            </style>
			<script>
            function getsc()
			{
				var widths=$(window).width();			
				var heights=$(window).height();
				if(widths <= 768){
				$('html').prepend($('#frameless_widget_section').html());
				$('#frameless_widget_section').hide();
				}
				
			}
			function resizeDatepicker() {
    			setTimeout(function() {
					var widths=$(window).width();
					$("#ui-datepicker-div").width("250px");
					$("#ui-datepicker-div").css({margin:"40px 0 0 0"});
					$('.ui-datepicker-group').width('100%');
				}, 0);
			}
            $(function() {	
			getsc();
			  $("#txtStartDate_div").datepicker({ 
				showOn: "button",
        		buttonImage: "<?php echo plugins_url('cal1.gif', __FILE__);?>",
        		buttonImageOnly: true,									  
				 minDate: 0,
				 maxDate: '+18M +14D',
				 showAnim: 'fadeIn',
				 numberOfMonths: 3,
				 dateFormat: "dd/mm/yy",
				 showButtonPanel: true,
				  beforeShow: function(input, inst)
				{
					var widths=$(window).width();			
					var heights=$(window).height();
					if(widths <= 768){					
						$.datepicker._pos = $.datepicker._findPos(input); //this is the default position
						$.datepicker._pos[0] = $.datepicker._pos[0]-260; //left
						$.datepicker._pos[1] = '50'; //top
						resizeDatepicker();
					}
				},
				 onClose: function (dateText, picker) {
					document.getElementById('txtStartDate').value=dateText;					
				 }
				 });
			 $("#txtEndDate_div").datepicker({ 
				showOn: "button",
        		buttonImage: "<?php echo plugins_url('cal1.gif', __FILE__);?>",
        		buttonImageOnly: true,									  
				 minDate: 0,
				 maxDate: '+18M +14D',
				 showAnim: 'fadeIn',
				 numberOfMonths: 3,
				 dateFormat: "dd/mm/yy",
				 showButtonPanel: true,
				  beforeShow: function(input, inst)
				{
					var widths=$(window).width();			
					var heights=$(window).height();
					if(widths <= 768){					
						$.datepicker._pos = $.datepicker._findPos(input); //this is the default position
						$.datepicker._pos[0] = $.datepicker._pos[0]-260; //left
						$.datepicker._pos[1] = '50'; //top
						resizeDatepicker();
					}
				},
				 onClose: function (dateText, picker) {
					document.getElementById('txtEndDate').value=dateText;					
				 }
				 });
			  $('select').selectric();
            });	
			function updatefield()
            {
				var startdate=document.getElementById('txtStartDate').value;
				var pickarr=startdate.split("/");
				document.getElementById('PickupDay').value=pickarr[0];
				document.getElementById('PickupMonth').value=pickarr[1];
				document.getElementById('PickupYear').value=pickarr[2];
				
				var enddate=document.getElementById('txtEndDate').value;
				var droparr=enddate.split("/");
				document.getElementById('DropoffDay').value=droparr[0];
				document.getElementById('DropoffMonth').value=droparr[1];
				document.getElementById('DropoffYear').value=droparr[2];            
            }
            </script>
            <div class="textwidget" id="frameless_widget_section">
            <div class="clear5"></div>
            <div class="frameless_widget_div">
                <form target="_blank" id="theform" action="https://secure.rentalcarmanager.com.au/ssl/AUTravelWheels107/bondi/webstep2.asp?refid=&amp;URL=" name="theform" method="post" onsubmit="updatefield();">
    	<?php
				if(get_option( 'form3_header_img')!=""){?>
                <div align="left"><img src="<?php echo plugins_url( 'frameless-widget/upload/'.get_option( 'form3_header_img') , dirname(__FILE__) );?>" border="0"/></div><?php } else {?><h1><?php echo $title; ?></h1><?php } ?>
        <div class="clear5"></div><div class="clear5"></div>
        <div class="col1">            
            Pickup Location
            <select  name="PickupLocationID" id="PickupLocationID" data-mini="true" data-icon="arrow-d">               
               <option value="28">Adelaide &nbsp;</option>
               <option value="33">Brisbane &nbsp;</option>
               <option value="36">Cairns &nbsp;</option>
               <option value="12">Darwin &nbsp;</option>
               <option value="4">Melbourne &nbsp;</option>
               <option value="9">Perth &nbsp;</option>
               <option value="1" selected="selected">Sydney &nbsp;</option>
            </select>           
        </div>
        <div class="col2">         
         Pickup Date
         <div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset ui-shadow ui-btn-up-c" style="background: none repeat scroll 0 0 #FFFFFF;border-color: #DDDDDD;color: #333333;
    text-shadow: 0 1px 0 #F3F3F3;width:100%;padding:2px 0;display:block;float:right;margin:10px 0;"><input type="text" id="txtStartDate" value="<?php echo date("d/m/Y",strtotime("+2 day"));?>"/><input type="hidden" id="txtStartDate_div" /></div>
        </div>
        <div class="clear5"></div>
         <div class="col1">           
            Dropoff Location
            <select name="DropoffLocationID" id="DropoffLocationID" data-mini="true" data-icon="arrow-d"> 
               <option value="28">Adelaide &nbsp;</option>
               <option value="33">Brisbane &nbsp;</option>
               <option value="36">Cairns &nbsp;</option>
               <option value="12">Darwin &nbsp;</option>
               <option value="4">Melbourne &nbsp;</option>
               <option value="9">Perth &nbsp;</option>
               <option value="1" selected="selected">Sydney &nbsp;</option>
            </select>
        </div>
        <div class="col2">
         Dropoff Date
         <div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset ui-shadow ui-btn-up-c" style="background: none repeat scroll 0 0 #FFFFFF;border-color: #DDDDDD;color: #333333;
    text-shadow: 0 1px 0 #F3F3F3;width:100%;padding:2px 0;display:block;float:right;margin:10px 0;"><input type="text" id="txtEndDate" value="<?php echo date("d/m/Y",strtotime("+16 day"));?>"/><input type="hidden" id="txtEndDate_div" /></div>
        </div>
         <div class="clear5"></div>
          <input type="hidden" value="9" name="CategoryTypeID"/>
         <input value="Search" data-theme="a" type="submit" class="ui-button ui-widget ui-state-default ui-corner-all selectric" style="width:100%"/>
         <input type="hidden" name="PickupDay" id="PickupDay"/><input type="hidden" name="PickupMonth" id="PickupMonth"/><input type="hidden" name="PickupYear" id="PickupYear"/>
         <input type="hidden" name="DropoffDay" id="DropoffDay"/><input type="hidden" name="DropoffMonth" id="DropoffMonth"/><input type="hidden" name="DropoffYear" id="DropoffYear"/>
         <div class="clear5"></div>
         </form>
</div>
<div class="clear5"></div>
</div>
        <?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);		
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', Frameless_WIDGET_TEXT_DOMAIN); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p>Select Form Layout &nbsp;&nbsp;<select id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>">
        	<option value="1" <?php if($instance['text'] == '1'){ echo 'selected';}?>>Layout1</option>
            <option value="2" <?php if($instance['text'] == '2'){ echo 'selected';}?>>Layout2</option>
            <option value="3" <?php if($instance['text'] == '3'){ echo 'selected';}?>>Layout3</option>
        </select>
        </p>
		<!--<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs', Frameless_WIDGET_TEXT_DOMAIN); ?></label></p>-->
<?php
	}
}
?>