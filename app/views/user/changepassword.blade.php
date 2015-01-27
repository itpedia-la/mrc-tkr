@include('layout.header')
{{ Form::open(array('url' => 'user/changepassword/submit')) }}
<input type="hidden" value="{{ Route::input('user_id') }}" name="user_id">

<div align="center">

<div class="k-block extended auto" style="width:40%">
<b>ແກ້ໄຂລະຫັດຜ່ານ</b>

<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td>ໃສ່ລະຫັດຜ່ານໃຫມ່: *</td>
			<td><input type="password" class="k-textbox" style="width:100%" name="password"></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			
			<td align="right">
			<button class="k-button" id="btnBack" type="button">ຍົກເລີກ</button> 
			{{Form::submit('ບັນທຶກ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){
		// Button Back
		$("#btnBack").click(function(e){
			window.location.href="{{ URL::to('user/list') }}";
		});
	});
</script>
@include('layout.footer')