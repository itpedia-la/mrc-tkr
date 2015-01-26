<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="app_mode" content="rms">

<base href="http://localhost/mrc-tkr/">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/kendo.common.min.css" rel="stylesheet">
<link href="css/kendo.default.min.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/kendo.all.min.js"></script>
<title>Bob Freeman Talk Show - Ticket Reservation</title>
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
	<div id="">
		<div align="center" style="padding:30px 0px 0px 0px">
		@if( Auth::id() ) 

			<a class="k-button" href="{{ URL::to('seat') }}">ແຜນຜັງບ່ອນນັ່ງ</a>
			<a class="k-button" href="{{ URL::to('user/logout') }}">ລາຍງານ</a>
			<a class="k-button" href="{{ URL::to('user/list') }}">ຜູ້ໃຊ້ງານ</a>
			<a class="k-button" href="{{ URL::to('user/logout') }}">ອອກຈາກລະບົບ</a>
		
		@else
		<div style="margin:00px"></div>
		@endif
		
		</div>
				<div align="center">
				<img src="img/logo.png">
	<h3>Ticket Reservation</h3>
</div>
<hr class="hrHeader"/>
