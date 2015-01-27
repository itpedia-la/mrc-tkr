@include('layout.header')
<div align="center">

<div style="width:100%">

@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
<table class="tableStylingReport" cellpadding="3" cellspacing="0">
	<thead>
		<tr style="background:#11315A; color:white">
			<th>No</th>
			<th>ຊື່ ແລະ ນາມສະກຸນ</th>
			<th>ເບິໂທລະສັບ</th>
			<th>ທີ່ຢູ່</th>
			<th>ລານການບ່ອນນັ່ງ</th>
			<th>ລວມເງິນ</th>
			<th>ຈອງໂດຍ</th>
			
			<th>ຈອງວັນທີ</th>
			<th>ໝົດກຳໜົດ</th>
			<th>ສະຖານະ</th>
	
		</tr>
	</thead>
	@foreach( $data as $value )
	<tr>
		<td>{{ $value['id'] }}</td>
		<td>{{ $value['customer_name'] }}</td>
		<td>{{ $value['telephone'] }}</td>
		<td>{{ $value['address'] }}</td>
		<td>
			@foreach($value['seat'] as $i)
				{{ $i['name'] }}
			@endforeach
		</td>
		<td>{{ $value['total'] }}</td>
		<td>{{ $value['user'] }}</td>
		<td>{{ $value['created_at'] }}</td>
		<td>{{ @$value['expired_at'] }}</td>
		<td>{{ @$value['statusHtml'] }}</td>
		
	</tr>
	
	@endforeach
	<tr style="background:#11315A; color:white">
		<td colspan="5" align="right">ລວມທົງໝົດ:</td>
		<td align="right">{{ $sumary['totalPending'] }}</td>
		<td align="right">ຮັບເງິນ:</td>
		<td>{{ $sumary['totalPaid'] }}</td>
		<td align="right">ຍັງເຫລືອ:</td>
		<td>{{ $sumary['totalLeft'] }}</td>
		
	</tr>
</table>
</div>
</div>
<script type="text/javascript">

</script>

@include('layout.footer')