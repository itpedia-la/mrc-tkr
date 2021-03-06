@include('layout.header')
<div align="center">

<div style="width:100%">

@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
<p><input type="text" id="ddUserList" value="{{ Route::input('user_id') }}">
<select id="ddStatus">
<option value="all" @if( Route::input('status') == "all") selected="selected" @endif>ທັງໝົດ</option>
<option value="0" @if( Route::input('status') == "0") selected="selected" @endif>ລໍຖ້າຈ່າຍເງິນ</option>
<option value="1" @if( Route::input('status') == "1") selected="selected" @endif>ຈ່າຍເງິນແລ້ວ</option>
<option value="2" @if( Route::input('status') == "2") selected="selected" @endif>ຮັບປີ້ແລ້ວ</option>
</select>
<button class="k-button k-primary" id="btnFilter">Filter</button></p>
<table class="tableStylingReport" cellpadding="3" cellspacing="0">
	<thead>
		<tr style="background:#11315A; color:white">
			<th>No</th>
			<td>ການສະແດງວັນທີ</td>
			<th>ຊື່ ແລະ ນາມສະກຸນ</th>
			<th>ເບິໂທລະສັບ</th>
			<th>ທີ່ຢູ່</th>
			<th>ລານການບ່ອນນັ່ງ</th>
			<th>ລວມເງິນ</th>
			<th>ຈອງໂດຍ</th>
			
			<th>ຈອງວັນທີ</th>
			<th>ໝົດກຳໜົດ</th>
			<th>ສະຖານະ</th>
		<th>ຜູ້ຮັບປີ້</th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	@foreach( $data as $value )
	<tr>
		<td>{{ $value['id'] }}</td>
		<td>{{ $value['showDate'] }}</td>
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
		<td>{{ @$value['ticket_issue'] }}</td>

		<td>

		@if( $value['status'] == 1 ) 
			<button class="k-button setIssued"id="{{ $value['id'] }}">ຮັບປີ້</button> 
			<button class="k-button k-primary remove" id="{{ $value['id'] }}">ຍົກເລີກ</button> 
		@elseif( $value['status'] == 2 ) 
		
		@elseif( $value['status'] == 3 ) 
		
		@else
			<button class="k-button ticketIssue"id="{{ $value['id'] }}">ແຈກປີ້</button> 
			<button class="k-button setPaid" id="{{ $value['id'] }}">ຈ່າຍເງິນແລ້ວ</button> 
			<button class="k-button k-primary remove" id="{{ $value['id'] }}">ຍົກເລີກ</button> 
		@endif
		</td>
	</tr>
	
	@endforeach
	@if( $sumary )
	<tr style="background:#11315A; color:white">
		<td colspan="6" align="right">ລວມທົງໝົດ:</td>
		<td>{{ @$sumary['totalPending'] }}</td>
		<td align="right">ຮັບເງິນ:</td>
		<td>{{ @$sumary['totalPaid'] }}</td>
		<td align="right">ຍັງເຫລືອ:</td>
		<td colspan="2">{{ $sumary['totalLeft'] }}</td>
		
	</tr>
	@endif
</table>
</div>
</div>
<script type="text/javascript">


$(".k-button.k-primary.remove").kendoButton({enable:true});
$(".k-button.setPaid").kendoButton({enable:true});
$(".k-button.setIssued").kendoButton({enable:true});

	$("#ddStatus").kendoDropDownList();
	
        // create DropDownList from input HTML element
       $("#ddUserList").kendoDropDownList({
		dataValueField: "user_id",
        dataTextField: "user",
        autoBind: true,
        change: function(e) {
            var id = this.value() > 0 ? this.value() : 0;

           // window.location = 'report/user/'+id;
        },
        optionLabel: {
        	user: '- ພະນັກງານທັງໝົດ -',
        	user_id: ""
        },
        dataSource: {
            transport: {
                read: {
                	url: "{{ URL::to('/sale_list') }}",
                    dataType: "json",
                }
            }
        }
	});

    $(".k-button.ticketIssue").click(function(e){
		e.preventDefault();
		window.location = 'customer/ticket_issue/'+$(this).attr('id');
    });

    
   	$("#btnFilter").click(function(){
   	   	if( $("#ddUserList").data('kendoDropDownList').value() == 0 ) {

   	   	window.location = 'report/user/'+$("#ddUserList").data('kendoDropDownList').value();
   	   	
   	   	} else {
   	   	   	
		window.location = 'report/custom/'+ $("#ddUserList").data('kendoDropDownList').value()+'/'+$( "#ddStatus option:selected").val();
   	   	}
	});
	
    $(".k-button.k-primary.remove").click(function(e){
    	 $(this).data('kendoButton').enable(false);
        var id = $(this).attr('id');
        e.preventDefault();
        var a = confirm('ທ່ານຕ້ອງການ "ຍົກເລີກ"ລາຍການນີ້ບໍ່?');

        if( a == true) {
        	$.ajax({
				url : 'customer/remove',
				type : 'POST',
				data : { 'id' : id },
				dataType : 'json',
				success : function(returnData) {
					 location.reload(); 
				},
				error: function(returnData) {

				}
			})
        } else {
        	 $(this).data('kendoButton').enable(true);
        }
    });

    $(".k-button.setPaid").click(function(e){
    	 $(this).data('kendoButton').enable(false);
        var id = $(this).attr('id');
        e.preventDefault();
        var a = confirm('ທ່ານຕ້ອງການຕັ້ງລາຍການນີ້ເປັນ "ຈ່າຍແລ້ວ" ຫລືບໍ່?');

        if( a == true) {
        	$.ajax({
				url : 'customer/setPaid',
				type : 'POST',
				data : { 'id' : id },
				dataType : 'json',
				success : function(returnData) {
					 location.reload(); 
				},
				error: function(returnData) {

				}
			})
        }else {
        	 $(this).data('kendoButton').enable(true);
        }

    });

    $(".k-button.setIssued").click(function(e){
    	 $(this).data('kendoButton').enable(false);
        var id = $(this).attr('id');
        e.preventDefault();
        var a = confirm('ທ່ານຕ້ອງການຕັ້ງລາຍການນີ້ເປັນ "ຮັບປີ້ແລ້ວ" ຫລືບໍ່?');

        if( a == true) {
        	$.ajax({
				url : 'customer/setIssued',
				type : 'POST',
				data : { 'id' : id },
				dataType : 'json',
				success : function(returnData) {
					 location.reload(); 
				},
				error: function(returnData) {

				}
			})
        }else {
        	 $(this).data('kendoButton').enable(true);
        }

    });
      	
</script>

@include('layout.footer')