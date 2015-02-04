@include('layout.header')
<div align="center">
<div class="k-block extended auto">
<!--  <img src="img/logo.png">-->

 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<span class="tag red"> {{ $error }}</span><br>    
	 @endforeach
 @endif
{{ Form::open(array('url' => 'customer/ticket_issue/submit')) }}
<input type="hidden" name="customer_id" value="{{ Route::input('customer_id') }}">
<table class="tableStyling" cellpadding="0" cellspacing="0">
	<tr>
		<td>ຊື່ ຜູ້ຮັບປີ້:</td>
		<td><input type="textbox" class="k-textbox" name="ticketIssue" id="ticketIssue" value=""></td>
	</tr>

	<tr>
		<td>&nbsp;</td>
		<td align="right"><button class="k-button k-primary" type="submit">Confirm</button></td>
	</tr>
</table>
</div>
</div>
{{ Form::close() }}
@include('layout.footer')