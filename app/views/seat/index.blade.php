@include('layout.header')

<h3>ລາຍການແຜນຜັງ</h3>

<div>
<div class="floatLeft">
	
</div>
<div class="floatRight">
	<button class="k-button k-primary" id="btnAddUser">ເພີ່ມ ຜູ້ໃຊ້ງານ</button> <button class="k-button" id="btnChangePassword">ແກ້ໄຂລະຫັດຜ່ານ</button>  <button class="k-button" id="btnRemove">ລົບລ້າງ</button>
</div>
<div class="ClearFix"></div>
<hr class="hrHeader"/>
<style type="text/css">
	.seat { 
	
		border:1px solid #000; 
		font-size:9px; 
		padding:1px;
		 -moz-border-radius:2px 2px 2px 2px; 
		border-radius:2px 2px 2px 2px; 
		cursor: pointer;
		
	}
	.saperate { padding:10px }
	.newRow { margin:20px 0px 20px 20px }
	
</style>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif

	<!-- Begine: VIP ZONE -->
	<div align="center">
		@foreach( $VIP as $seat )
			
				{{ HTML::decode( $seat['seat']) }}
			
		@endforeach
	</div>
	<!-- End: VIP ZONE -->

</div>
<script type="text/javascript">

</script>

@include('layout.footer')