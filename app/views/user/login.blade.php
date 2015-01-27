@include('layout.header')
<div align="center">
<div class="k-block extended auto">
<!--  <img src="img/logo.png">-->

 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<span class="tag red"> {{ $error }}</span><br>    
	 @endforeach
 @endif
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
{{ Form::open(array('url' => 'user/login/submit')) }}
<table class="tableStyling" cellpadding="0" cellspacing="0">
	<tr>
		<td>ລະຫັດ / ອີເມວ:</td>
		<td><input type="textbox" class="k-textbox" name="email" id="email" value="{{ Input::get('email') }}"></td>
	</tr>
	<tr>
		<td>ລະຫັດຜ່ານ:</td>
		<td><input type="password" class="k-textbox" name="password" id="password"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right"><button class="k-button k-primary" type="submit">ເຂົ້າສູ່ລະບົບ</button></td>
	</tr>
</table>
</div>
</div>
{{ Form::close() }}
@include('layout.footer')