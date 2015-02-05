@include('layout.header')
<div align="center">

<div style="width:100%">

@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif

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
		<td>

		@if( $value['status'] == 1 ) 
			<button class="k-button setIssued"id="{{ $value['id'] }}">ຮັບປີ້</button> 
		@elseif( $value['status'] == 2 ) 
		
		@elseif( $value['status'] == 3 ) 
		
		@else
			<button class="k-button setPaid" id="{{ $value['id'] }}">ຈ່າຍເງິນແລ້ວ</button> 

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

   	$("#btnFilter").click(function(){
   	   	if( $("#ddUserList").data('kendoDropDownList').value() == 0 ) {

   	   	window.location = 'report/user/'+$("#ddUserList").data('kendoDropDownList').value();
   	   	
   	   	} else {
   	   	   	
		window.location = 'report/custom/'+ $("#ddUserList").data('kendoDropDownList').value()+'/'+$( "#ddStatus option:selected").val();
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
        }

    });
      	
</script>

@include('layout.footer')