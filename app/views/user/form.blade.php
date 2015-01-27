@include('layout.header')
{{ Form::open(array('url' => 'user/form/submit')) }}

<div align="center">

<div class="k-block extended auto" style="width:40%">
<b>ເພີ່ມຜູ້ໃຊ້ງານ</b>

<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
<!-- <div class="message green">Successfull</div> -->
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="40%">ກຸ່ມຜູ້ໃຊ້ງານ:</td>
			<td><input type="text" id="ddUserGroup" style="width:100%" name="user_group_id" value=""></td>
		</tr>
		<tr>
			<td>ລະຫັດ ຫລື ອີເມວ: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="login" value=""></td>
		</tr>
		<tr>
			<td>ລະຫັດຜ່ານ: *</td>
			<td><input type="password" class="k-textbox" style="width:100%" name="password"></td>
		</tr>
<tr>
			<td>ຊື້: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="firstname" value=""></td>
		</tr>
		<tr>
			<td>ນາມສະກຸນ:</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="lastname" value=""></td>
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
		
		// User Group Dropdown
		$("#ddUserGroup").kendoDropDownList({
			dataValueField: "id",
	        dataTextField: "name",
	        autoBind: true,
	        change: function(e) {
	            var id = this.value();
	        },
	        optionLabel: {
	        	name: '- ລາຍການທັງໝົດ -',
	            id: ""
	        },
	        dataSource: {
	            transport: {
	                read: {
	                	url: "{{ URL::to('user/json/group') }}",
	                    dataType: "json",
	                }
	            }
	        }
		});

		// Button Back
		$("#btnBack").click(function(e){
			window.location.href="{{ URL::to('user/list') }}";
		});
	});
</script>
@include('layout.footer')