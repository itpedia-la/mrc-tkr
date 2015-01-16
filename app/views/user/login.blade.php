@include('layout.header')

<div align="center">
<img src="public/img/logo.png">
<h3>Online Ticketing Reservation</h3>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<span class="tag red"> {{ $error }}</span><br>     <br>    
	 @endforeach
 @endif

{{ Form::open(array('url' => 'user/login/submit')) }}
<table class="tableStyling" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="2">User Login</th>
	</tr>
	<tr>
		<td>Email:</td>
		<td><input type="textbox" class="k-textbox" name="email" id="email" value="{{ Input::get('email') }}"></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" class="k-textbox" name="password" id="password"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right"><button class="k-button k-primary" type="submit">Login</button></td>
	</tr>
</table>
</div>
{{ Form::close() }}
@include('layout.footer')