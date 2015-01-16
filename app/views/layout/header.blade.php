<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="app_mode" content="rms">

<base href="http://localhost/mrc-pfms/">
<link href="public/css/style.css" rel="stylesheet" type="text/css" />
<link href="public/css/kendo.common.min.css" rel="stylesheet">
<link href="public/css/kendo.silver.min.css" rel="stylesheet">
<script src="public/js/jquery.min.js"></script>
<script src="public/js/kendo.all.min.js"></script>
<title>Miracle Lao | Online Ticketing Reservation and Management</title>
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
			<h2 style="padding:0px; margin:4px 0px 4px 0px; color:#005186">Miracle Lao</h2>
			<h3 style="color:#ccc; margin:0px; padding:0px">Online Ticketing Reservation and Management</h3>
		</div>
		<ul id="menu">

			<li><a href="transaction"><span class="sprite invoice-16">&nbsp;</span> ສະຖິຕິຫນ້າຫລັກ</a></li>
			<li><a href="product/"><span class="sprite product-16">&nbsp;</span> ສິນຄ້າ ແລະ ການບໍລິການ</a></li>
			<li><span class="sprite area-chart-16">&nbsp;</span> ລາຍງານ</li>	
			<li><span class="sprite gear-2-16">&nbsp;</span> ຕັ້ງຄ່າ
				<ul>
					<li id="liUserManage"> ຜູ້ໃຊ້ງານ</li>
					<li id="liExchangeRate"> ອັດຕາແລກປ່ຽນ</li>
					<li id="liApplicationSetting"> ຕັ້ງຄ່າລະບົບ</li>
				</ul></li>

			<li style="float: right" class="k-primary"><a href="{{ URL::to('user/logout') }}"><span class="sprite businessman-16-white">&nbsp;</span> ອອກຈາກລະບົບ</a></li>
		</ul>
		@else
		<div style="margin:50px"></div>
		@endif