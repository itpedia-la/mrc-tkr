@include('layout.header')

@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
<div align="center">
<form id="frmSeat">
<!--  <input type="text" class="k-textbox"> <input type="text" class="k-textbox"> -->
ການສະແດງວັນທີ: <select id="showDate">
		<option value="2015-02-22" @if(Route::input('showDate')=="2015-02-22") selected="selected" @endif>22-02-2015</option>
		<option value="2015-02-23" @if(Route::input('showDate')=="2015-02-23") selected="selected" @endif>23-02-2015</option>
	</select>
<button class="k-button k-primary" type="button" id="btnSeatOk">ຕົກລົງ</button>  <button class="k-button" id="btnReset">ເລີ່ມໃຫມ່</button>
<p>ກະລຸນາເລືອກບ່ອນນັ່ງ</p>
</div>
<hr />
	<!-- Begine: VIP ZONE -->
	<div align="center">
	
		<br/>--------------------------------------------------- <span class="tag fb"><b>600,000</b></span> ---------------------------------------------------</br></br>
		@foreach( $VIP as $seat )
			
				{{ HTML::decode( $seat['seat']) }}
				<input type="checkbox" id="chk_{{ $seat['id'] }}" name="{{ $seat['number'] }}" style="display:none" value="{{ $seat['id'] }}" data-price="">
			
		@endforeach
	</div>
	<!-- End: VIP ZONE -->
</form>
<script type="text/javascript">

	$("#showDate").kendoDropDownList({
		change : function() {
			window.location = 'seat/'+this.value();
		}
	});

	$("#btnSeatOk").kendoButton({enable:false});
	$("#btnReset").kendoButton({enable:false});
	
	$(".seat_available").each(function(){

		$(this).click(function(){

			$("#btnSeatOk").data('kendoButton').enable(true);
			$("#btnReset").data('kendoButton').enable(true);

			if( $(this).hasClass('selected') ) {
				
				$(this).removeClass('selected');
				$("#chk_"+$(this).data('id')).prop('checked',false);

			} else {
				
				$(this).addClass('selected');
				$("#chk_"+$(this).data('id')).prop('checked',true);
				
			}
		})
		
	})
	
	$("#btnReset").click(function(e){
		
		e.preventDefault();

		$("#btnSeatOk").data('kendoButton').enable(false);
		$("#btnReset").data('kendoButton').enable(false);
		
		$(".seat_available.selected").removeClass('selected');
		$("input[id^='chk_']").prop('checked',false);
		
	});
	
	$("#btnSeatOk").click(function(){

		var seatData = $("#frmSeat").serializeArray();
			seatData = encodeURI(JSON.stringify(seatData));
		var showDate  = "{{ Route::input('showDate') }}";
		
		var confirmDialog = document.createElement('div');
		confirmDialog.id = 'confirmDialog';
		document.body.appendChild(confirmDialog);
		var confirmDialog = $("#confirmDialog").kendoWindow({
	        title: false,
	        visible: false,
	        animation: false,
	        modal: true,
	        width: 300,
	        height : 230,
	        resizable: false,
	        draggable: true,
	        close: function() { this.destroy(); $("#confirmDialog").remove() },
		}).data("kendoWindow");

		var content = '<div><form id="frmSubmit"><input type="hidden" value="'+seatData+'" name="seat"><input type="hidden" value="'+showDate+'" name="showDate">';
				content+= '<table>';
				content+= '<tr><td colspan="2" align="center"><span class="tag green" id="message">ກະລຸນາໃສ່ຂໍ້ມູນຕິດຕໍ່</span></td></tr>';
				content+= '<tr><td colspan="2" align="center"><hr/></tr>';
					content+= '<tr><td width="40%" align="right">ຊື່ ແລະ ນາມສະກຸນ: *</td><td><input type="text" class="k-textbox" id="fullname" name="fullname"></td></tr>';
					content+= '<tr><td width="40%" align="right">ເບີໂທລະສັບ: *</td><td><input type="text" class="k-textbox" id="telephone" name="telephone"></td></tr>';
					content+= '<tr><td width="40%" align="right">ທີ່ຢູ່: *</td><td><input type="text" class="k-textbox" id="address" name="address"></td></tr>';
					@if( $allowFreeTicket )
					content+= '<tr><td width="40%" align="right">&nbsp;</td><td><input type="checkbox" name="freeTicket" value="1"> ປີ້ຟຣີ</td></tr>';
					@endif
					content+= '<tr><td colspan="2" align="center"><hr/></tr>';
					content+= '<tr><td width="40%" align="right">&nbsp;</td><td><button type="submit" class="k-button k-primary">ຕົກລົງ</button> <button type="button" class="k-button" id="btnCancel">ຍົກເລີກ</button></td></tr>';
				content+= '</table>';
			content+= '</form></div>';

		confirmDialog.content(content);
		confirmDialog.center().open();

		$("#total").kendoNumericTextBox();
		
		$("#btnCancel").click(function(e){
			
			e.preventDefault();
			confirmDialog.close();
			$("#btnReset").click();
		});
		
		$("#frmSubmit").submit(function(e){
			e.preventDefault();
			
			$.ajax({
				url : '{{ URL::to("customer/submit") }}',
				type : 'POST',
				dataType : 'json',
				data : $(this).serializeArray(),
				success : function(returnData){

					window.location = 'done/'+returnData;
				},
				error: function(returnData) {
					
					var parsed = JSON.parse(returnData.responseText);
				
					var fullname = parsed['fullname'] == null ? '' : parsed['fullname'][0]+', ';
					var telephone = parsed['telephone'] == null ? '' : parsed['telephone'][0]+', ';
					var address = parsed['address'] == null ? '' : parsed['address'][0];
					
					var text = 'ກະລຸນາໃສ່ '+fullname+telephone+address;
					$("span#message").removeClass('green');
					$("span#message").addClass('red');
					$("span#message").text(text);
				}
			});
		});
	});
</script>

@include('layout.footer')