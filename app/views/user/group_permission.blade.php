@include('layout.header')
{{ Form::open(array('url' => 'user/group/permission/submit')) }}
<input type="hidden" value="{{ Route::input('group_id') }}" name="user_group_id">
<div align="center">

<div class="k-block extended auto" style="width:60%">
<b>ກຳໜົດສິດກຸ່ມຜູ້ໃຊ້ງານ ( {{ $group }} )</b>

<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
<!-- <div class="message green">Successfull</div> -->
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		@foreach ( $GroupPermission as $key => $value )
		
		<tr>
			<th colspan="3"><u>{{ $key }}</u></th>
		</tr>
			@foreach( $value as $row )
				<tr>
					<td><input type="checkbox" name="permission[{{ $row['id'] }}]" {{ @$row['checked'] }} id="permission_{{ $row['id'] }}" value="{{ $row['permissionTitle'] }}"></td>
					<td>{{ $row['permissionTitle'] }} ({{$row['id']}})</td>
					<td><i>{{ $row['permissionDescription'] }}</i></td>
				</tr>
			@endforeach
		@endforeach


		<tr>
			
			
			<td align="right" colspan="3">
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