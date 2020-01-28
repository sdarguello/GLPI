<?php
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");
include (GLPI_ROOT . "/config/config.php");

global $DB;

Session::checkLoginUser();
//Session::checkRight("profile", "r");

# entity in index
$sql_e = "SELECT value FROM glpi_plugin_dashboard_config WHERE name = 'entity' AND users_id = ".$_SESSION['glpiID']."";
$result_e = $DB->query($sql_e);
$sel_ent = $DB->result($result_e,0,'value');

if($sel_ent == '' || $sel_ent == -1) {
	$sel_ent = 0;
	$ent_name = __('Tickets Statistics','dashboard');
}

else {
	$query = "SELECT name FROM glpi_entities WHERE id IN (".$sel_ent.") ";
	$result = $DB->query($query);
	$ent_name1 = $DB->result($result,0,'name');
	$ent_name = __('Tickets Statistics','dashboard')." :  ". $ent_name1 ;
	}

# years in index
$sql_y = "SELECT value FROM glpi_plugin_dashboard_config WHERE name = 'num_years' AND users_id = ".$_SESSION['glpiID']."";
$result_y = $DB->query($sql_y);
$num_years = $DB->result($result_y,0,'value');

if($num_years == '') {
	$num_years = 0;
}

# color theme
$sql_theme = "SELECT value FROM glpi_plugin_dashboard_config WHERE name = 'theme' AND users_id = ".$_SESSION['glpiID']."";
$result_theme = $DB->query($sql_theme);
$theme = $DB->result($result_theme,0,'value');
$style = $theme;

if($theme == '' || substr($theme,0,5) == 'skin-' ) {
	$theme = 'material.css';
	$style = 'material.css';
}

$_SESSION['theme'] = $theme;
$_SESSION['style'] = $theme;


# background
$sql_back = "SELECT value FROM glpi_plugin_dashboard_config WHERE name = 'back' AND users_id = ".$_SESSION['glpiID']."";
$result_back = $DB->query($sql_back);
$back = $DB->result($result_back,0,'value');

if($back == '') {
	$back = 'bg1.jpg';	
}
$_SESSION['back'] = $back;


# charts colors 
$sql_colors = "SELECT value FROM glpi_plugin_dashboard_config WHERE name = 'charts_colors' AND users_id = ".$_SESSION['glpiID']."";
$result_colors = $DB->query($sql_colors);
$colors = $DB->result($result_colors,0,'value');

if($colors == '') {
	$colors = 'grid-light.js';	
}
$_SESSION['charts_colors'] = $colors;

     switch (date("m")) {
    case "01": $mes = __('January','dashboard'); break;
    case "02": $mes = __('February','dashboard'); break;
    case "03": $mes = __('March','dashboard'); break;
    case "04": $mes = __('April','dashboard'); break;
    case "05": $mes = __('May','dashboard'); break;
    case "06": $mes = __('June','dashboard'); break;
    case "07": $mes = __('July','dashboard'); break;
    case "08": $mes = __('August','dashboard'); break;
    case "09": $mes = __('September','dashboard'); break;
    case "10": $mes = __('October','dashboard'); break;
    case "11": $mes = __('November','dashboard'); break;
    case "12": $mes = __('December','dashboard'); break;
    }

   switch (date("w")) {
    case "0": $dia = __('Sunday','dashboard'); break;    
    case "1": $dia = __('Monday','dashboard'); break;
    case "2": $dia = __('Tuesday','dashboard'); break;
    case "3": $dia = __('Wednesday','dashboard'); break;
    case "4": $dia = __('Thursday','dashboard'); break;
    case "5": $dia = __('Friday','dashboard'); break;
    case "6": $dia = __('Saturday','dashboard'); break;  
    }
    
//redirect tech profile
if(Session::haveRight("profile", "r"))
	{
		$redir = '<meta http-equiv="refresh" content= "120"/>';
	}
else {		
		$redir = '<meta http-equiv="refresh" content="0; url=graficos/graf_tech.php?con=1" />'; 
	}    
?>

<!DOCTYPE html>
<html>
<head>
    <title>GLPI - Dashboard - Home</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <meta http-equiv="Pragma" content="public">
    <?php echo $redir; ?>        
    
    <link rel="icon" href="img/dash.ico" type="image/x-icon" />
	 <link rel="shortcut icon" href="img/dash.ico" type="image/x-icon" />    
    <link href="css/bootstrap.css" rel="stylesheet"> 

    <!-- Styles -->   
    <!-- Color theme -->       		   
    <link rel="stylesheet" type="text/css" href="css/layout.css">

    <!-- Custom Styles -->
    <link href="css/custom.css" rel="stylesheet">
    
     <!-- this page specific styles -->
    <link rel="stylesheet" href="css/compiled/index.css" type="text/css" media="screen" />    

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <link href="css/style-dash.css" rel="stylesheet" type="text/css" />
    <link href="css/dashboard.css" rel="stylesheet" type="text/css" /> 
    
    <!-- odometer -->
	<link href="css/odometer.css" rel="stylesheet">
	<script src="js/odometer.js"></script>
	
<!--	
<script type="text/javascript">
	$(function($) {
		var options = {
		timeNotation: '24h',
		am_pm: false,
		fontFamily: 'Open Sans',
		fontSize: '10pt',
		foreground: '#FFF'
	}
		$('#clock').jclock(options);
	});
</script> 
 -->   
   <!-- <link href="less/style.less" rel="stylesheet"  title="lessCss" id="lessCss"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
     <![endif]-->         
     <!-- <link href="fonts/fonts.css" rel="stylesheet" type="text/css" /> -->
     
  	 <?php 
 	 	echo '<link rel="stylesheet" type="text/css" href="./css/skin-'.$theme.'">'; 
	 	echo '<link rel="stylesheet" type="text/css" href="./css/style-'.$style.'">';
 	 ?> 
 	 
 	 <script src="js/jquery.js"></script> 
 	 
 	  	<!-- gauge -->
	<script src="js/raphael.2.1.0.min.js"></script>
	<script src="js/justgage.1.0.1.min.js"></script>

</head>

	<?php
	if($theme == 'trans.css') {		
   	echo "<body style=\"background: url('./img/".$back."') no-repeat top center fixed; \">";
   	}
   else {
   	echo "<body style='background-color: #FFF;' >";
   	}	 
   ?>

<div class="site-holder">
<!-- top -->
                                               
<?php     
$ano = date("Y");
$month = date("Y-m");
$hoje = date("Y-m-d");


//select entity
if ($sel_ent == 0) {
	$entidade = "";
	$entidade_u = "";
}

else {
	$entidade = "AND glpi_tickets.entities_id IN (".$sel_ent.") ";
	$entidade_u = "AND glpi_users.entities_id IN (".$sel_ent." )";
}

//selecionar anos 
if($num_years == 0) {
	
	$query_y = "SELECT DISTINCT DATE_FORMAT( date, '%Y' ) AS year
	FROM glpi_tickets
	WHERE glpi_tickets.is_deleted = '0'
	AND date IS NOT NULL	
	ORDER BY year ASC ";
}

if($num_years == 1) {
	
	$query_y = "SELECT DISTINCT DATE_FORMAT( date, '%Y' ) AS year
	FROM glpi_tickets
	WHERE glpi_tickets.is_deleted = '0'
	AND date IS NOT NULL
	ORDER BY year DESC
	LIMIT ".$num_years."";
}

if($num_years > 1) {
	
	$query_y = "SELECT DISTINCT DATE_FORMAT( date, '%Y' ) AS year
	FROM glpi_tickets
	WHERE glpi_tickets.is_deleted = '0'
	AND date IS NOT NULL
	ORDER BY year DESC
	LIMIT ".$num_years."";
	
}

$result_y = $DB->query($query_y);

//numero de anos para eixos Y
$conta_y = $DB->numrows($result_y);

$arr_years = array();

while ($row_y = $DB->fetch_assoc($result_y))		
	{ 
		$arr_years[] = $row_y['year'];			
	} 


if($num_years > 1) {
	$arr_years = array_reverse($arr_years);
	$years = implode(",", $arr_years);
}
else {
	$years = implode(",", $arr_years);
}


//chamados ano
$sql_ano =	"SELECT COUNT(glpi_tickets.id) as total        
      FROM glpi_tickets
      LEFT JOIN glpi_entities ON glpi_tickets.entities_id = glpi_entities.id
      WHERE glpi_tickets.is_deleted = '0' 
      AND DATE_FORMAT( glpi_tickets.date, '%Y' ) IN (".$years.") 
      ".$entidade." ";

$result_ano = $DB->query($sql_ano);
$total_ano = $DB->fetch_assoc($result_ano);
      
//chamados mes
$sql_mes =	"SELECT COUNT(glpi_tickets.id) as total        
      FROM glpi_tickets
      LEFT JOIN glpi_entities ON glpi_tickets.entities_id = glpi_entities.id
      WHERE glpi_tickets.date LIKE '$month%'      
      AND glpi_tickets.is_deleted = '0' 
      ".$entidade." ";

$result_mes = $DB->query($sql_mes);
$total_mes = $DB->fetch_assoc($result_mes);

//chamados dia
$sql_hoje =	"SELECT COUNT(glpi_tickets.id) as total        
      FROM glpi_tickets
      LEFT JOIN glpi_entities ON glpi_tickets.entities_id = glpi_entities.id
      WHERE glpi_tickets.date like '$hoje%'      
      AND glpi_tickets.is_deleted = '0'
      ".$entidade." ";

$result_hoje = $DB->query($sql_hoje);
$total_hoje = $DB->fetch_assoc($result_hoje);

// total users
$sql_users = "SELECT COUNT(id) AS total
				FROM `glpi_users`
				WHERE is_deleted = 0
				".$entidade_u."
				AND is_active = 1";

$result_users = $DB->query($sql_users);
$total_users = $DB->fetch_assoc($result_users);
?>

<!-- .box-holder -->
<!-- .content -->
<div class="content animated fadeInBig corpo" style="margin-left:-60px;">
    <!-- main-content -->
   <div class="main-content masked-relative masked">
      
						<div class="row" style="margin-left: 3%;">
							<!-- COLUMN 1 -->															
								  <div class="col-sm-3 col-md-3 stat">
									 <div class="dashbox shad panel panel-default db-blue">
										<div class="panel-body">
										   <div class="panel-left red">
												<i class="fa fa-calendar-o fa-3x"></i>
										   </div>
										   <div class="panel-right right">
										     <div id="odometer1" class="odometer" style="font-size: 25px;">   </div><p></p>
                        				<span class="chamado"><?php echo __('Tickets','dashboard'); ?></span><br>
                        				<span class="date"><b><?php echo __('Today','dashboard'); ?></b></span>												
										   </div>
										</div>
									 </div>
								  </div>
								  
								  <div class="col-sm-3 col-md-3">
									 <div class="dashbox shad panel panel-default db-green">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-calendar fa-3x fa-calendar-index"></i>
										   </div>
										   <div class="panel-right  right">										 
											<div id="odometer2" class="odometer" style="font-size: 25px;">   </div><p></p>
                        				<span class="chamado"><?php echo __('Tickets','dashboard'); ?></span><br>
                        				<span class="date"><b><?php echo $mes ?></b></span>
										   </div>
										</div>
									 </div>
								  </div>																		
                     								
								  <div class="col-sm-3 col-md-3">
									 <div class="dashbox shad panel panel-default db-red">
										<div class="panel-body">
										   <div class="panel-left yellow">
												<i class="fa fa-plus-square fa-3x"></i>
										   </div>
										   <div class="panel-right  right">
												<div id="odometer3" class="odometer" style="font-size: 25px;">   </div><p></p>
                        				<span class="chamado"><?php echo __('Tickets','dashboard'); ?></span><br>
                        				<span class="date"><b><?php echo __('Total','dashboard'); ?></b></span>
										   </div>										   
										</div>
									 </div>
								  </div>
								  <div class="col-sm-3 col-md-3">
									 <div class="dashbox shad panel panel-default db-orange">
										<div class="panel-body">
										   <div class="panel-left green">
												<i class="fa fa-users fa-3x"></i>
										   </div>
								   		<div class="panel-right  right">
												<div id="odometer4" class="odometer" style="font-size: 25px;">   </div><p></p>
                        				<span class="chamado"><?php echo __('users','dashboard'); ?></span><br>
                        				
										   </div>
										</div>
									 </div>
								  </div>																	                          				                           							
						</div>        
                
<div class="container-fluid">            
  
<script type="text/javascript" >
window.odometerOptions = {
   format: '( ddd).dd'
};

setTimeout(function(){
    odometer1.innerHTML = <?php echo $total_hoje['total']; ?>;
    odometer2.innerHTML = <?php echo $total_mes['total']; ?>;
    odometer3.innerHTML = <?php echo $total_ano['total']; ?>;
    odometer4.innerHTML = <?php echo $total_users['total']; ?>;
}, 1000);

</script> 

<div id='content' class="container-fluid" style="margin-left:55px;"> 
 
<!-- <div id="pad-wrapper"> -->

	<?php 
	
		// server info
		$query_info = "SELECT value FROM glpi_plugin_dashboard_config WHERE name = 'info' AND users_id = ".$_SESSION['glpiID']." ";																
		$result_info = $DB->query($query_info);		
		$info = $DB->result($result_info,0,'value');
		
		//server OS
		if($info == 1 || $info == "") {
			if(file_exists('/etc/hosts')) { $width_os = '80%'; } 
			else { $width_os = '100%'; }
		}			
	?>

	<div class="row-fluid" style="margin-top: 30px;" >
      <h4> <?php echo __('Tickets Evolution','dashboard'); ?> </h4>
 		<p id="choices" style=" margin-right: 20px; margin-top: 5px; text-align:right; width:<?php echo $width_os; ?>;"></p>	  	
		<div class="demo-container" style="margin-bottom:40px;">				
		
			<div id="graflinhas1" class="demo-placeholder" style="float:left; width: <?php echo $width_os; ?> ;"></div>
							<div id="srvinfo">					
					<?php	
					
					if($info == 1 || $info == "") {									
					if(file_exists('/etc/hosts')) { 
					        
						echo '<h5 class="label1 label-default"> <i class="fa fa-info-circle"></i>&nbsp;  Server Info</h5>
							
							<ul class="list-unstyled list-info-sidebar" style="color: #cecece; width:100%;">
								<li class="data-row">
									<span class="data-name" >OS:</span>
									<span class="data-value">'; include './sh/issue.php'; 
								
						echo		'</span>
								</li>
						
								<li class="data-row">
									<span class="data-name" >UP:</span>
									<span class="data-value">'; include './sh/uptime.php'; 
									
						echo		'</span>
								</li>
						
						<li class="data-row">
									<span class="data-name"  style="display:none;" >MEM:</span> 
									<span class="data-value"  style="display:none;" >'; include 'sh/mem.php'; 
						
						echo '</span> <!-- <div class="progress" style="height: 5px;"> </div> -->
								  	<div id="mem" style="width:100%; height:100px; margin-left: 0px;"></div>
							    		<!-- gauge -->
									    <script>
									    var g = new JustGage({
									    id: "mem",
									    value: '.$usedmem.',
									    min: 0,
									    max: '.$totalmem.',
									    title: "'.$titlem.'",
									    label: "'.$umem.' %",
									    //startAnimationType:bounce,
									    //levelColorsGradient: false									    
									      /* levelColors: [
									       	"#9FCA0C",
									       	"#F9C800",
									       	"#FB8300",
									         "#ff0000"									          
									        ] */
									
									    });
									    </script>
											
								</li>
						
								<li class="data-row">
									<span class="data-name"  style="display:none;" >DISK:</span>
									<span class="data-value"  style="display:none;" >'; include './sh/df.php'; 
						
						echo '</span> 
						    		<div id="disk" style="width:100%; height:100px; margin-left: 0px; margin-top:70px;"></div>
						    			<!-- gauge -->
									    <script>
									    var g = new JustGage({
									    id: "disk",
									    value: ' . $usedd . ',
									    min: 0,
									    max: '.$totald.',
									    title: "'.$titled.'",
									    label: "'.$udisk.' %",		
									    //startAnimationType:bounce,
										 //levelColorsGradient: false						       
									      /* levelColors: [
									       	"#9FCA0C",
									       	"#F9C800",
									       	"#FB8300",
									         "#ff0000"									          
									        ] */
									
									    });
									    </script>
								<!-- </div> -->
												
								</li> </ul>	';			
					} 
					}
					?>	
				</div>			
		</div>
	</div>

	   <?php 
			include ("graficos/inc/index/graflinhas_index_sel.inc.php");
		?>					
	
	<div class="row-fluid" style="margin-top: 75px;">	
		<div class="col-sm-6 col-md-6 knob-wrapper">
			<div id="pie1" style="height:320px;"> 			
				<?php
					include ("graficos/inc/index/grafpie_index.inc.php");
				?> 	 						            
			</div> 
		</div>

		<div class="col-sm-6 col-md-6 knob-wrapper" style="margin-bottom: 35px;">
			<div id="graf7" style="height:320px;"> 
				<?php
					include ("graficos/inc/index/grafcol_setedias.inc.php");
				?> 	 				              
			</div> 
  		</div>      
   </div>   
  	
	<div class="row-fluid" style="margin-top: 110px;">	
		<div class="col-sm-6 col-md-6 knob-wrapper">
			<div id="graf9" style="height:320px;"> 			
				<?php
					include ("graficos/inc/index/grafbar_age.inc.php");
				?> 	 						            
			</div> 
		</div>

		<div class="col-sm-6 col-md-6 knob-wrapper">
			<div id="graf8" style="height:320px;"> 
				<?php
					include ("graficos/inc/index/grafpie_time.inc.php");
				?> 	 				              
			</div> 
  		</div>      
   </div> 

<div class="row" style="margin-top: 40px;">
	
	<div id="last_tickets" class="col-sm-6 col-md-6" style="margin-top:50px;"> 
 	 				              
		      <div class="widget widget-table action-table striped">
            <div class="widget-header"> <i class="fa fa-list-alt" style="margin-left:7px;"></i>

              <h3><a href="../../../front/ticket.php" target="_blank" style="color: #525252;"><?php echo __('Last Tickets','dashboard'); ?></a></h3>
             
            </div>
            <!-- /widget-header -->
            <div class="widget-content" style="height:322px;">
            <?php

		// last tickets
			$status = "('5','6')"	;	         
                        
            $query_wid = "
            SELECT glpi_tickets.id AS id, glpi_tickets.name AS name
				FROM glpi_tickets
				WHERE glpi_tickets.is_deleted = 0
				AND glpi_tickets.status NOT IN $status
				".$entidade."
				ORDER BY id DESC
				LIMIT 10 ";
            
            $result_wid = $DB->query($query_wid);			            
            
            ?>    
              <table id="last_tickets" class="table table-hover table-bordered table-condensed" >
              <th style="text-align: center;"><?php echo __('Tickets','dashboard'); ?></th><th style="text-align: center;" ><?php echo __('Title','dashboard'); ?></th>
              
				<?php
					while($row = $DB->fetch_assoc($result_wid)) 
					{					
						echo "<tr><td style='text-align: center;'><a href=../../../front/ticket.form.php?id=".$row['id']." target=_blank style='color: #526273;'>".$row['id']."</a>
						</td><td>". substr($row['name'],0,60)."</td></tr>";											
					}				
				?>                                       
              </table>
              
            </div>
            <!-- /widget-content --> 
          </div>
	</div> 

<!--  open tickets by tech-->

	<div id="open_tickets" class="col-sm-6 col-md-6 " style="margin-top:50px;"> 
	
		<div class="widget widget-table action-table striped">
            <div class="widget-header"> <i class="fa fa-list-alt" style="margin-left:7px;"></i>

           		<h3><a href="../../../front/ticket.php" target="_blank" style="color: #525252;"><?php echo __('Open Tickets','dashboard'). " " .__('by Technician','dashboard') ?></a></h3>
           
            </div>
            <!-- /widget-header -->
            
            <div class="widget-content" style="height:322px;">
            <?php
                                
            $query_tec = "
            SELECT DISTINCT glpi_users.id AS id, glpi_users.`firstname` AS name, glpi_users.`realname` AS sname, count(glpi_tickets_users.tickets_id) AS tick
				FROM `glpi_users` , glpi_tickets_users, glpi_tickets
				WHERE glpi_tickets_users.users_id = glpi_users.id
				AND glpi_tickets_users.type = 2
				AND glpi_tickets.is_deleted = 0
				AND glpi_tickets.id = glpi_tickets_users.tickets_id
				AND glpi_tickets.status NOT IN ".$status."
				".$entidade."
				GROUP BY `glpi_users`.`firstname` ASC
				ORDER BY tick DESC
				LIMIT 10 ";
            
            $result_tec = $DB->query($query_tec);			            
            
            ?>    
              <table id="open_tickets" class="table table-hover table-bordered table-condensed" >
              <th style="text-align: center;"><?php echo __('Technician','dashboard'); ?></th><th style="text-align: center;">
              <?php echo __('Open Tickets','dashboard'); ?></th>
              
				<?php
					while($row = $DB->fetch_assoc($result_tec)) 
					{					
						echo "<tr><td><a href=./reports/rel_tecnico.php?con=1&tec=".$row['id']."&stat=open target=_blank style='color: #526273;'>
						".$row['name']." ".$row['sname']."</a></td><td style='text-align: center;' >".$row['tick']."</td></tr>";											
					}				
				?>                                       
              </table>
              
            </div>
            <!-- /widget-content --> 
          </div>
       </div>   
</div>

<div class="row ">

<div id="events" class="col-sm-6 col-md-6 " style="margin-top:35px;">  	 				              
		 <div class="widget widget-table action-table striped">
            <div class="widget-header"> <i class="fa fa-list-alt" style="margin-left:7px;"></i>

              <h3><a href="../../../front/event.php" target="_blank" style="color: #525252;"><?php echo __('Last Events','dashboard'); ?></a></h3>

            </div>
            <!-- /widget-header -->
            <div class="widget-content">
   
				<?php
				
				$query_evt = "
				SELECT *
				FROM `glpi_events`
				ORDER BY `glpi_events`.id DESC
				LIMIT 10 ";   
					
				$result_evt = $DB->query($query_evt);
				$number = $DB->numrows($result_evt);
				
				function tipo($type) {
				
				    switch ($type) {
				    case "system": $type 	  = __('System'); break;
				    case "ticket": $type 	  = __('Ticket'); break;
				    case "devices": $type 	  = _n('Component', 'Components', 2); break;
				    case "planning": $type 	  = __('Planning'); break;
				    case "reservation": $type = _n('Reservation', 'Reservations', 2); break;
				    case "dropdown": $type 	  = _n('Dropdown', 'Dropdowns', 2); break;
				    case "rules": $type 	  = _n('Rule', 'Rules', 2); break;
				   };
					return $type;
					}
				
				
				function servico($service) {
				
				    switch ($service) {
				    case "inventory": $service 	  = __('Assets'); break;
				    case "tracking": $service 	  = __('Ticket'); break;
				    case "maintain": $service 	  = __('Assistance'); break;
				    case "planning": $service  	  = __('Planning'); break;
				    case "tools": $service 	  	  = __('Tools'); break;
				    case "financial": $service 	  = __('Management'); break;
				    case "login": $service 	         = __('Connection'); break;
				    case "setup": $service 	  	  = __('Setup'); break;
				    case "security": $service 	  = __('Security'); break;
				    case "reservation": $service     = _n('Reservation', 'Reservations', 2); break;
				    case "cron": $service 	  	  = _n('Automatic action', 'Automatic actions', 2); break;
				    case "document": $service 	  = _n('Document', 'Documents', 2); break;
				    case "notification": $service    = _n('Notification', 'Notifications', 2); break;
				    case "plugin": $service 	  = __('Plugin'); break;
				   }
				
					return $service;
					}
					     ?>    
				          <table id="events" class="table table-hover table-bordered table-condensed" >
				            <th style="text-align: center;"><?php echo __('Type'); ?></th>
								<th style="text-align: center;"><?php echo __('Date'); ?></th>
								<!-- <th style="text-align: center;"><?php echo __('Service'); ?></th>  -->
								<th style="text-align: center;"><?php echo __('Message'); ?></th>                 
								<?php
								
									 switch ($_SESSION['glpidate_format']) {
								    case "0": $dataf = 'Y-m-d'; break;
								    case "1": $dataf = 'd-m-Y'; break;
								    case "2": $dataf = 'm-d-Y'; break;    
								    } 								
								
							   $i = 0;	
							   while ($i < $number) {
							   
								  $type     = $DB->result($result_evt, $i, "type");
			       			  $date     = date_create($DB->result($result_evt, $i, "date"));
						        // $service  = $DB->result($result_evt, $i, "service");         							        
						        $message  = $DB->result($result_evt, $i, "message");
								
								echo "<tr><td style='text-align: left;'>". tipo($type) ."</td>
										<td style='text-align: left;'>" . date_format($date, $dataf.' H:i:s') . "</td>					
										<td style='text-align: left;'>". substr($message,0,50) ."</td></tr>
								";
								++$i;													
								}												
						?>                                       
              </table>  
              
            </div>
            <!-- /widget-content --> 
       </div>
	</div>


	<div id="logged_users" class="col-sm-6 col-md-6 " style="margin-top:35px;"> 
 	 				              
		 <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="fa fa-group" style="margin-left:7px;"></i>
				<?php
				//logged users				
				//$path = "../../../files/_sessions/";
				$path = GLPI_SESSION_DIR . '/' ;
				$diretorio = opendir($path);        
				
				$arr_arq = array();
				$arquivos = array();    
				       
				while($arquivo = readdir($diretorio)){   
				      
				     $arr_arq[] = $path.$arquivo;           
				 }				 
								
				foreach ($arr_arq as $listar) {
				// retira "./" e "../" para que retorne apenas pastas e arquivos
								  
				   if ( is_file($listar) && $listar != '.' && $listar != '..'){ 
							$arquivos[]=$listar;
				   }
				}
				
				$conta = count($arquivos);
				
				if($conta > 0) {
				
				for($i=0; $i < $conta; $i++) {
				
					$file = $arquivos[$i];
					
					$string = file_get_contents( $file ); 
					// poderia ser um string ao invés de file_get_contents().
					
					$list = preg_match( '/glpiID\|s:[0-9]:"(.+)/', $string, $matches );
					
					$posicao = strpos($matches[0], 'glpiID|s:');
					$string2 = substr($matches[0], $posicao, 25);
					$string3 = explode("\"", $string2); 
					
					$arr_ids[] = $string3[1];
					
					}
				}
				
				$ids = array_values($arr_ids);
				$ids2 = implode("','",$ids);
				
				$query_name = 
				"SELECT firstname AS name, realname AS sname, id AS uid, name AS glpiname 
				FROM glpi_users				
				WHERE id IN ('".$ids2."')
				ORDER BY name"; 
				
				$result_name = $DB->query($query_name); 
				$num_users = $DB->numrows($result_name);          
				            
				?>    
           <h3><?php echo __('Logged Users','dashboard')."  :  " .$num_users; ?></h3>

            </div>
            <!-- /widget-header -->
            
				<?php
	          if($num_users <= 10) {
	          	echo '<div class="widget-content striped" style="min-height:318px;">'; }
	          else {
	          	echo '   <div class="widget-content striped ">'; }	          	
				?>        
              <table id="logged_users" class="table table-hover table-bordered table-condensed" >                         
				<?php
								
				while($row_name = $DB->fetch_assoc($result_name)) 
	  			   {
						echo "<tr>
									<td style='text-align: left;'><a href=../../../front/user.form.php?id=".$row_name['uid']." target=_blank style='color: #526273;'>
										".$row_name['name']." ".$row_name['sname']." (".$row_name['uid'].")</a>	
									</td>									
								</tr>";												
					}	

				?>                                       
              </table>
              
            </div>
            <!-- /widget-content --> 
          </div>
	</div>                    		
          <!-- content row 2 --> 
	<!-- </div> -->                    
   </div>       
	</div>  

	<div id="go-top" class="go-top" onclick="scrollWin()">
	   <i class="fa fa-chevron-up"></i>&nbsp; Top     							    
	</div>        
   </div>    
	</div>		
	<!-- end main-content 	
	</div>-->

</div>
<!-- /.box-holder -->
	<!-- transparent them footer -->
	<style type="text/css">
		@media screen and (min-width: 1201px) and (max-width: 2200px) {
	  	#footer-bar {
	    margin-top: 5px;
	    height: 20px;
	  	 }
		}
	</style>
	<?php
	if($theme == 'trans.css') {		 
		echo '<div id="footer-bar" class="footer-bar row-fluid" style="overflow: hidden; height:70px; width:100%; background-color: #000; opacity:0.7; float:left; bottom:0px; margin-top: -70px; position:relative; clear: both; margin-left: 220px; " ></div>';
	}  
	?>
	
</div>
<!-- /.site-holder -->
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/jquery-ui-1.10.2.custom.min.js"></script>
 
<script src="js/jquery.accordion.js"></script>            
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/jquery.easy-pie-chart.js"></script> 
<script src="js/jquery.address-1.6.min.js"></script>

<script src="js/bootstrap-switch.js"></script> 
<script src="js/highcharts.js" type="text/javascript" ></script>
<script src="js/highcharts-3d.js" type="text/javascript" ></script>
<script src="js/modules/exporting.js" type="text/javascript" ></script>
<script src="js/modules/no-data-to-display.js" type="text/javascript" ></script>

<!-- knob -->
<script src="js/jquery.knob.js"></script>

<!-- flot charts -->    
<script src="js/jquery.flot.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.resize.js"></script>
<script src="js/jquery.flot.pie.min.js"></script>
<script src="js/jquery.flot.valuelabels.js"></script>
<script src="js/theme.js"></script>         
<script src="js/jquery.jclock.js"></script>

<script>
function scrollWin()
{
	$('html, body').animate({ scrollTop: 0 }, 'slow');
}
</script> 

 <!-- Remove below two lines in production --> 
 
 <script src="js/theme-options.js"></script>       
 <script src="js/core.js"></script>
</body>
</html>
