<?php
include("../config/config.php");
$admin_id = $_SESSION['adminrecord']['id'];
admin_login_check();

$p = (isset($_GET['p']))?$_GET['p'].'.php':"home.php";

function redirect_admin($page){
	echo '<script>window.location="'.$page.'";</script>';
}

if(!isset($_SESSION['page_url']) or $_SESSION['page_url']!=$p){
	unset($_SESSION['pagination']);
	$_SESSION['page_url'] = $p;
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php echo $cons_sitetitle;?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	
    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    
    <link href="<?php echo $web_site.'css/mystyle.css';?>" rel="stylesheet">
    <style>
	.err, .err_msg { color:#f00; }
	.card { padding:20px; }
	.card .header { padding-left:0px; padding-bottom:20px; }
	.fa { color:#999; font-size:20px; }
	.fa:hover { color:#555 !important; }
	.fa-trash { color:#ccc; font-size:20px; }
	.fa-trash:hover { color:#f00 !important; }
	.add_new { text-align:right; }
	.table > thead > tr > th { color:#fff !important; font-weight:bold; }
	.mytable { margin-top:20px; border:1px solid #ddd; }
	thead { background-color:#666; color:#fff; }
	.chart_iframe { border:0px; height:390px; }
	.img_box { background-color: #ddd; border:1px solid #ccc; }
	.img_thumb { width: 100%; height: 150px; padding: 10px; overflow: hidden; }
	.img_thumb img { width: 100%; }
	.news_thumb { width: 50%; height: 80px; padding: 10px; overflow: hidden; }
	.news_thumb img { width: 50%; }
	.export_to_excel {float: right;margin-top: 20px;margin-right: 15px}
	</style>
    
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="" style="opacity: .9;">
    <!--
    Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
    Tip 2: you can also add an image using data-image tag
    -->
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="<?php echo $web_site.'admin';?>" class="simple-text">
                    vieva
                </a>
            </div>

            <?php include("menu_left.php");?>
    	</div>
    </div>

    <div class="main-panel">
        <?php
		include("menu_top.php");
		
		echo '<div class="content"><div class="container-fluid">';
		include($p); /// Add content page
		echo '</div></div>';
		
		include("menu_footer.php");
		?>
    </div>
</div>


</body>

<div id="delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal_tlt">Delete</h4>
      </div>
      <div class="modal-body">
        <p class="text-danger" id="modal_msg">Are you sure you want to perform delete operation?</p>
      </div>
      
      <div class="modal-footer">
      <a class="btn btn-danger" id="delete_client_button" href="" >Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<script>
function delete_record(url,modal_msg="",modal_tlt=""){
	if(modal_msg!=""){
		$( "#modal_msg" ).html(modal_msg);
	}
	if(modal_tlt!=""){
		$( "#modal_tlt" ).html(modal_tlt);
	}
	$( "#delete_client_button" ).attr( "href", url );
}
</script>


<!--   Core JS Files   -->
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->

<script src="assets/js/demo.php"></script>
<script type="text/javascript">
    $(document).ready(function(){
        demo.initChartist();
	});
</script>
<script>
$(document).ready(function(){
	$(".product_status").on("change",function(e){
		$checkbox = $(this);
		var id= $checkbox.data('id');
		var status = 0;
		if ($checkbox.is(':checked')) {
			status = 1;
		}
		jQuery.ajax({
			type: "POST",
			url: "ajax.php?p=product_status",
			dataType: 'json',
			data: {id: id,status:status},
			success: function(res) {
				if (res){
					console.log(res);
				}
			}
		});
	});
	
});
</script>
<script>
/**
	function add_new_record()
	{
		var html = $( "#record_div" ).html();
		html = '<div class="row">'+html+'</div>';
		$( "#record_div" ).after(html);
	}
	/**/
</script>
</html>
<?php
$not_unset_sysData = array('addedituser.php','addeditcategory.php','addeditproduct.php','addeditorder.php');
if( !in_array($p,$not_unset_sysData) ){
	unset($_SESSION['sysData']);
}

unset($_SESSION['sysErr']);
?>
