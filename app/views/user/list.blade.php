@include('layout.header')
<div align="center">

<div class="k-block extended" style="width:50%">
<div class="floatLeft">
	ກູ່ມຜູ້ໃຊ້ງານ: <input type="text" id="ddUserGroup" style="width:250px"> <button class="k-button" id="btnGroupPermission">ກຳໜົດສິດກຸ່ມຜູ້ໃຊ້ງານ</button>
</div>
<div class="floatRight">
	<button class="k-button k-primary" id="btnAddUser">ເພີ່ມ ຜູ້ໃຊ້ງານ</button> <button class="k-button" id="btnChangePassword">ແກ້ໄຂລະຫັດຜ່ານ</button>  <button class="k-button" id="btnRemove">ລົບລ້າງ</button>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
<div id="gridUserList"></div>
</div>
</div>
<script type="text/javascript">

	// Page element initial stage
	$("#btnRemove").kendoButton({enable:false});
	$("#btnChangePassword").kendoButton({enable:false});

	$("#btnGroupPermission").kendoButton({enable:false});
	
	// form Action element reset
	function btnReset() {

		$("#btnChangePassword").removeData('user_id');
		$("#btnRemove").removeData('user_id');
		
		$("#btnChangePassword").data('kendoButton').enable(false);
		$("#btnRemove").data('kendoButton').enable(false);
		
	}

	// form Action element Set
	function btnSet(user_id) {

		$("#btnChangePassword").data('user_id', user_id);
		$("#btnRemove").data('user_id', user_id);

		$("#btnChangePassword").data('kendoButton').enable(true);
		$("#btnRemove").data('kendoButton').enable(true);
		
	}
	
	// User Group Dropdown
	$("#ddUserGroup").kendoDropDownList({
		dataValueField: "id",
        dataTextField: "name",
        autoBind: true,
        change: function(e) {
            var id = this.value() > 0 ? this.value() : 0;
            
            btnReset();

            var grid = $("#gridUserList").data("kendoGrid");
            grid.dataSource.transport.options.read.url = "user/json/list/group/"+id;
            grid.dataSource.read(); 

            if( id > 0 ) {
            	$("#btnGroupPermission").data('kendoButton').enable(true);
            	$("#btnGroupPermission").data('id',id);
            } else {
            	$("#btnGroupPermission").data('kendoButton').enable(false);
            	$("#btnGroupPermission").removeData('id');
            }
			
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
	
    // User Grid Datasource
	var sourceUserList = new kendo.data.DataSource({
		transport: {
	    	read:  {
	           		url: "{{ URL::to('user/json/list') }}",
	                dataType: "json"
	           },
	        },
		pageSize: 10,
	});

	// User Grid
	$("#gridUserList").kendoGrid({
		dataSource: sourceUserList,
		pageable: false,
		selectable: true,
		sortable: true,
		height: 400,
		change: function(e) {
			  grid = e.sender;
			  var selectedValue = grid.dataItem(this.select());
			  btnSet(selectedValue.id);
		}, 
		filter: true,
	    	columns: [
	    	    { field:"id", title: "ລະຫັດ", width: '5%',},
	    	    { field:"user_group", title: "ກຸ່ມຜູ້ໃຊ້", width: '10%', encoded:false },
				{ field:"login", title: "ລະຫັດ / ອີເມວ", width: '15%', encoded:false },
				{ field:"firstname", title: "ຊື່", width: '10%', encoded:false },
				{ field:"lastname", title: "ນາມສະກຸນ", width: '10%', encoded:false },
				{ field:"created_at", title: "ສ້າງວັນທີ", width: '10%', encoded:false },
				{ field:"updated_at", title: "ແກ້ໄຂວັນທີ", width: '10%', encoded:false },
	        ],
	});

	// User Add
	$("#btnAddUser").click(function(e){
		window.location.href="{{ URL::to('user/form') }}";
	});

	// User Edit
	$("#btnChangePassword").click(function(e){
		window.location.href= 'user/changepassword/'+$(this).data('user_id');
	});

	// User remove
	$("#btnRemove").click(function(e){
		
		window.location.href= 'user/remove/'+$(this).data('user_id');
	});

	// Group Set Permission
	$("#btnGroupPermission").click(function(e){

		window.location.href= 'user/group/permission/'+$(this).data('id');
	});

</script>

@include('layout.footer')