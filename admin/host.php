<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quản lý các trạm</title>
<link rel="stylesheet" href="../css/common.css" type="text/css" media="all">
<link rel="stylesheet" href="../dist/bootstrap.min.css" type="text/css" media="all">
<link href="../dist/jquery.bootgrid.css" rel="stylesheet" />
<script src="../dist/jquery-1.11.1.min.js"></script>
<script src="../dist/bootstrap.min.js"></script>
<script src="../dist/jquery.bootgrid.min.js"></script>
</head>
<body>
	<div class="container">
      <div class="">
        <h3><a href='../index.php'>Trang chủ</a> <span class='link-to-home'> >> </span> Danh sách trạm</h3>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="well clearfix">
			<div class="pull-right"><button type="button" class="btn btn-xs btn-primary" id="command-add" data-row-id="0">
			<span class="glyphicon glyphicon-plus"></span> Thêm trạm</button></div></div>
		<table id="host_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
			<thead>
				<tr>
					<th data-column-id="id" data-type="numeric" data-identifier="true">#</th>
					<th data-column-id="name">Tên</th>
					<th data-column-id="phone">Số điện thoại</th>
					<th data-column-id="url">Đường dẫn</th>
					<th data-column-id="status">Trạng thái</th>
					<th data-column-id="allow_send_sms">Kích hoạt SMS</th>
					<th data-column-id="connection_status" title='Tình trạng kết nối'>Tình trạng kết nối</th>
					<th data-column-id="commands" data-formatter="commands" data-sortable="false">Sự kiện</th>
				</tr>
			</thead>
		</table>
    </div>
      </div>
    </div>
	
<div id="add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Thêm trạm</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add">
				<input type="hidden" value="add" name="action" id="action">
                  <div class="form-group">
                    <label for="name" class="control-label">Tên:</label>
                    <input type="text" class="form-control" id="name" name="name"/>
                  </div>
                  <div class="form-group">
                    <label for="phone" class="control-label">Số điện thoại:</label>
                    <input type="text" class="form-control" id="phone" name="phone"/>
                  </div>                  
				  <div class="form-group">
                    <label for="url" class="control-label">Đường dẫn:</label>
                    <input type="text" class="form-control" id="url" name="url"/>
                  </div>
				  <div class="form-group">
                    <label for="status" class="control-label">Trạng thái:</label>
                    <input type="checkbox" class="" id="status" name="status"/>
                  </div>
				  <div class="form-group">
                    <label for="allow_send_sms" class="control-label">Kích hoạt SMS:</label>
                    <input type="checkbox" class="" id="allow_send_sms" name="allow_send_sms"/>
                  </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" id="btn_add" class="btn btn-primary">Lưu</button>
            </div>
			</form>
        </div>
    </div>
</div>
<div id="edit_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Sửa trạm</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit">
                    <input type="hidden" value="edit" name="action" id="action">
                    <input type="hidden" value="0" name="edit_id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_name" class="control-label">Tên:</label>
                        <input type="text" class="form-control" id="edit_name" name="edit_name"/>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone" class="control-label">Số điện thoại:</label>
                        <input type="text" class="form-control" id="edit_phone" name="edit_phone"/>
                    </div>                  
                    <div class="form-group">
                        <label for="edit_url" class="control-label">Đường dẫn:</label>
                        <input type="text" class="form-control" id="edit_url" name="edit_url"/>
                    </div>
                    <!-- <input type="text" nam="abc" id="abc"/> -->
                    <div class="form-group">
                        <label for="edit_status" class="control-label">Trạng thái:</label>
                        <input type="checkbox" class="" id="edit_status" name="edit_status"/>
                    </div>
				  <div class="form-group">
                    <label for="edit_allow_send_sms" class="control-label">Kích hoạt SMS:</label>
                    <input type="checkbox" class="" id="edit_allow_send_sms" name="edit_allow_send_sms"/>
                  </div>
			    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" id="btn_edit" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>

<div id="edit_device_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Ẩn/ hiện thiết bị trên trạm</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit_device">
                    <input type="hidden" value="edit_device" name="action" id="action">
                    <div id="device_list">
                    </div>
			    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" id="btn_edit_device" name="btn_edit_device" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
$( document ).ready(function() {
	var grid = $("#host_grid").bootgrid({
		ajax: true,
		rowSelect: true,
		post: function ()
		{
			/* To accumulate custom parameter with the request object */
			return {
				id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
			};
		},
		
		url: "response_host.php",
		formatters: {
		        "commands": function(column, row)
		        {
		            return "<button title='Sửa thông tin' type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
                        "<button title='Ẩn hiện thiết bị' type=\"button\" class=\"btn btn-xs btn-default command-edit-device\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-th-large\"></span></button> " + 
		                "<button title='Xóa thông tin' type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>" + 
		                "<a title='Xem danh sách tài khoản' href='host_detail.php?hostid="+ row.id +"' class=\"btn btn-xs btn-default command-detail\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-zoom-in\"></span></a>";
		        }
		    }
   }).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {
        //alert("You pressed edit on row: " + $(this).data("row-id"));
			var ele =$(this).parent();
			var g_id = $(this).parent().siblings(':first').html();
            var g_name = $(this).parent().siblings(':nth-of-type(2)').html();
            console.log(g_id);
            console.log(g_name);

		//console.log(grid.data());//
		$('#edit_model').modal('show');
					if($(this).data("row-id") >0) {
                        // collect the data
                        $('#edit_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#edit_name').val(ele.siblings(':nth-of-type(2)').html());
                        $('#edit_phone').val(ele.siblings(':nth-of-type(3)').html());
                        $('#edit_url').val(ele.siblings(':nth-of-type(4)').html());
                        var status = parseInt(ele.siblings(':nth-of-type(5)').html());
                        var allow_send_sms = parseInt(ele.siblings(':nth-of-type(6)').html());

                        if(status == 1){
                            $('#edit_status').prop('checked', true);;                   
                        } else{
                            $('#edit_status').prop('checked', false);;     
                        }

                        if(allow_send_sms == 1){
                            $('#edit_allow_send_sms').prop('checked', true);;                   
                        } else{
                            $('#edit_allow_send_sms').prop('checked', false);;     
                        }
					} else {
					 alert('Now row selected! First select row, then click edit button');
					}
    }).end().find(".command-delete").on("click", function(e)
    {
	
		var conf = confirm('Delete ' + $(this).data("row-id") + '?');
					// alert(conf);
                    if(conf){
                                $.post('response_host.php', { id: $(this).data("row-id"), action:'delete'}
                                    , function(){
                                        // when ajax returns (callback), 
										$("#host_grid").bootgrid('reload');
                                }); 
								//$(this).parent('tr').remove();
								//$("#host_grid").bootgrid('remove', $(this).data("row-id"))
                    }
    }).end().find(".command-edit-device").on("click", function(e)
    {
        $('#edit_device_model').modal('show');
        let id=$(this).data("row-id");
        // $('#edit_id').val(id);
	    //alert("id="+id);

        // device_list
        $.post('response_host.php', { id: id, action:'get-list-device-by-hostid'}
            , function(data){
                // when ajax returns (callback), 
                // $("#host_grid").bootgrid('reload');
                // alert(data);
                data = JSON.parse(data);
                let lstId = '';
                let html ='<div class="form-group col-sm-12 host-device-title">Thiết bị vào</div>';
                for(let i = 0; i < data.length; i++){
                    let item = data[i];
                    if(item.type != 'obj-vao'){
                        continue;
                    }

                    // alert(item);
                    let checked='';
                    if(item.status == 1){
                        checked='checked';
                    }
                    if(lstId != ''){
                        lstId += ',';
                    }
                    // save list id to update
                    lstId += item.device_hostid + '';

                    html += '<div class="form-group col-sm-6"><input type="checkbox" class="" id="chk_' + item.device_hostid + '" name="chk_' + item.device_hostid + '" ' + checked + ' /> ' + item.name + '</div>'
                }

                html +='<div class="form-group col-sm-12 host-device-title">Thiết bị ra</div>';
                for(let i = 0; i < data.length; i++){
                    let item = data[i];
                    if(item.type == 'obj-vao'){
                        continue;
                    }

                    // alert(item);
                    let checked='';
                    if(item.status == 1){
                        checked='checked';
                    }

                    if(lstId != ''){
                        lstId += ',';
                    }
                    // save list id to update
                    lstId += item.device_hostid + '';

                    html += '<div class="form-group col-sm-6"><input type="checkbox" class="" id="chk_' + item.device_hostid + '" name="chk_' + item.device_hostid + '" ' + checked + ' /> ' + item.name + '</div>'
                }
                html += '<input type="hidden" name="lstId" id="lstId" value="' + lstId + '">';
                $("#device_list").html(html);
        });
    });
});

function ajaxAction(action) {
        data = $("#frm_"+action).serializeArray();
        console.log(data);
        $.ajax({
            type: "POST",
            url: "response_host.php",  
            data: data,
            dataType: "json",       
            success: function(response)  
            {
                // alert(action);
                $('#'+action+'_model').modal('hide');
                $("#host_grid").bootgrid('reload');
            }
        });
    }

    $( "#command-add" ).click(function() {
        $('#add_model').modal('show');
    });
    $( "#btn_add" ).click(function() {
        ajaxAction('add');
    });
    $( "#btn_edit" ).click(function() {
        ajaxAction('edit');
    });
    $("#btn_edit_device").click(function() {
        ajaxAction('edit_device');

        setTimeout(() => {
            $('#edit_device_model').modal('hide');
        }, 1000);
    });
});
</script>
