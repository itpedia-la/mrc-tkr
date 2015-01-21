<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="app_mode" content="rms">

<base href="http://localhost/mrc-tkr/">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/kendo.common.min.css" rel="stylesheet">
<link href="css/kendo.silver.min.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/kendo.all.min.js"></script>
<title>Miraclelao| Online Ticketing Reservation</title>
</head>

<!-- <style>
.k-window
    {
        box-shadow: none !important;
    }
.k-overlay { opacity:0.1 !important }
@media print
{
   body { display: none; }
}
</style> -->

<body>
	<div id="wrapper">
		@if( Auth::id() ) 
		<div id="header">
			<img src="img/logo.png" width="80" class="floatLeft">
			<h3 style="color:#444; margin:23x 0px 0px 0px; padding:0px">Online Ticketing<br/>Reservation</h3>
			<div class="ClearFix"></div>
		</div>
		<ul id="menu">

			<li><a href="transaction"><span class="sprite invoice-16">&nbsp;</span> ຫນ້າຫລັກ</a></li>
			<li><a href="product/"><span class="sprite product-16">&nbsp;</span> ແຜນຜັງບ່ອນນັ່ງ</a></li>
			<li><span class="sprite area-chart-16">&nbsp;</span> ລາຍງານ</li>	
			<li><span class="sprite gear-2-16">&nbsp;</span> ຕັ້ງຄ່າ
				<ul>
					<li id="liUserManage"><a href="{{ URL::to('user/list') }}">ຜູ້ໃຊ້ງານ</a></li>
				</ul></li>

			<li style="float: right" class="k-primary"><a href="{{ URL::to('user/logout') }}"><span class="sprite businessman-16-white">&nbsp;</span> ອອກຈາກລະບົບ</a></li>
		</ul>
		@else
		<div style="margin:200px"></div>
		@endif