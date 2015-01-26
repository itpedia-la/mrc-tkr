@include('layout.header')


<style type="text/css">

	.seat_reserved_public {
		border:1px solid #bbb; 
		font-size:10px; 
		color:#ccc;
		padding:2px 3px 2px 3px;
		 -moz-border-radius:2px 2px 2px 2px; 
		border-radius:2px 2px 2px 2px; 
		
		background:#fff;
		text-shadow: 1px 1px #fff
	}
	.seat_pending {
		border:1px solid #bbb; 
		font-size:10px; 
		color:#fff;
		padding:2px 3px 2px 3px;
		 -moz-border-radius:2px 2px 2px 2px; 
		border-radius:2px 2px 2px 2px; 
		
		background:red;
		text-shadow: 0px 0px #fff
	}
	.seat_paid {
		border:1px solid #bbb; 
		font-size:10px; 
		color:#fff;
		padding:2px 3px 2px 3px;
		 -moz-border-radius:2px 2px 2px 2px; 
		border-radius:2px 2px 2px 2px; 
		
		background:green;
		text-shadow: 0px 0px #fff
	}
	.seat_available { 
	
		border:1px solid #ccc; 
		font-size:10px; 
		padding:2px 3px 2px 3px;
		 -moz-border-radius:2px 2px 2px 2px; 
		border-radius:2px 2px 2px 2px; 
		cursor: pointer;
		background:#dedede;
		text-shadow: 1px 1px #fff
	}

	.seat_available:hover { background:#FFFF66 }
	.seat_available.selected { background:#FF6600; color:#fff; text-shadow:0px 0px #fff }
	.saperate { padding:10px }
	.newRow { margin:20px 0px 20px 20px }
	
</style>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
<div align="center">
<form id="frmSeat">
<!--  <input type="text" class="k-textbox"> <input type="text" class="k-textbox"> -->
<button class="k-button k-primary" type="submit">ຕົກລົງ</button>  <button class="k-button" id="btnReset">ເລີ່ມໃຫມ່</button>
<br/><br/>
</div>
<hr class="hrHeader"/>
	<!-- Begine: VIP ZONE -->
	<div align="center">
	
		---------------------------------------------------  <span class="tag fb"><b>600,000</b></span> ---------------------------------------------------<br/><br/>
		@foreach( $VIP as $seat )
			
				{{ HTML::decode( $seat['seat']) }}
				<input type="checkbox" id="chk_{{ $seat['id'] }}" name="seat[]" style="display:none" value="{{ $seat['id'] }}" data-price="">
			
		@endforeach
	</div>
	<!-- End: VIP ZONE -->
</form>
<script type="text/javascript">

	$(".seat_available").each(function(){
		
		$(this).click(function(){

			if( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$("#chk_"+$(this).data('id')).prop('checked',false);
			} else {
				$(this).addClass('selected');
				$("#chk_"+$(this).data('id')).prop('checked',true);
			}
		})
		
	})
	
	$("#frmSeat").submit(function(e){
		e.preventDefault();
		$.ajax({
			url : '',
			dataType : 'json',
			type : 'POST',
			data : $(this).serialize(),
			success : function(returnData) {
				
			}
		});
	});
	
	$("#btnReset").click(function(e){
		
		e.preventDefault();
		
		$(".seat_available.selected").removeClass('selected');
		$("input[id^='chk_']").prop('checked',false);
		
	});
	
	$("#frmConfirm").click(function(){

		var confirmDialog = document.createElement('div');
		confirmDialog.id = 'confirmDialog';
		document.body.appendChild(confirmDialog);
		var confirmDialog = $("#confirmDialog").kendoWindow({
	        title: false,
	        visible: false,
	        animation: false,
	        modal: true,
	        width: 300,
	        height : 250,
	        resizable: false,
	        draggable: true,
	        close: function() { this.destroy(); $("#confirmDialog").remove() },
		}).data("kendoWindow");

		var content = '<div><form id="frmSubmit">';
				content+= '<table>';
				content+= '<tr><td colspan="2" align="center"><span class="tag green">ກະລຸນາໃສ່ຂໍ້ມູນຕິດຕໍ່</span></td></tr>';
				content+= '<tr><td colspan="2" align="center"><hr/></tr>';
					content+= '<tr><td width="40%" align="right">ຊື່ ແລະ ນາມສະກຸນ: *</td><td><input type="text" class="k-textbox" id="fullname" name="fullname"></td></tr>';
					content+= '<tr><td width="40%" align="right">ເບີໂທລະສັບ: *</td><td><input type="text" class="k-textbox" id="telephone" name="telephone"></td></tr>';
					content+= '<tr><td width="40%" align="right">ທີ່ຢູ່: *</td><td><input type="text" class="k-textbox" id="address" name="address"></td></tr>';
					content+= '<tr><td width="40%" align="right">ລວມ (ກີບ): </td><td><input type="text" id="total" name="total" readonly="readonly" value="100000"> </td></tr>';
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
			
		});
		
		$("#frmSubmit").submit(function(e){
			e.preventDefault();
			alert('submit');
		});
	});
</script>

@include('layout.footer')