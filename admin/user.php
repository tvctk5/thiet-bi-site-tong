<?php

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quản lý tài khoản</title>
<link rel="stylesheet" href="../dist/bootstrap.min.css" type="text/css" media="all">
<link href="../dist/jquery.bootgrid.css" rel="stylesheet" />
<script src="../dist/jquery-1.11.1.min.js"></script>
<script src="../dist/bootstrap.min.js"></script>
<script src="../dist/jquery.bootgrid.min.js"></script>
</head>
<body>
	<div class="container">
      <div class="">
        <h2>Danh sách tài khoản</h2>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="well clearfix">
			<div class="pull-right"><button type="button" class="btn btn-xs btn-primary" id="command-add" data-row-id="0">
			<span class="glyphicon glyphicon-plus"></span> Thêm tài khoản</button></div></div>
		<table id="user_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
			<thead>
				<tr>
					<th data-column-id="Id" data-type="numeric" data-identifier="true">#</th>
                    <th data-column-id="name">Tên</th>
					<th data-column-id="username">Tài khoản</th>
					<th data-column-id="phone">Số điện thoại</th>
					<th data-column-id="status">Trạng thái</th>
                    <th data-column-id="createdate">Ngày tạo</th>
                    <th data-column-id="updatedate">Ngày cập nhật</th>
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
                    <label for="username" class="control-label">Tài khoản:</label>
                    <input type="text" class="form-control" id="username" name="username"/>
                  </div>
                  <div class="form-group">
                    <label for="password" class="control-label">Mật khẩu:</label>
                    <input type="password" class="form-control" id="password" name="password"/>
                  </div>
                  <div class="form-group">
                    <label for="phone" class="control-label">Số điện thoại:</label>
                    <input type="text" class="form-control" id="phone" name="phone"/>
                  </div>
				  <div class="form-group">
                    <label for="status" class="control-label">Trạng thái:</label>
                    <input type="checkbox" class="" id="status" name="status"/>
                  </div>
                    <input type="hidden" name="code" id="code">

                
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
                <h4 class="modal-title">Sửa tài khoản</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit">
				<input type="hidden" value="edit" name="action" id="action">
				<input type="hidden" value="0" name="edit_id" id="edit_id">
                  <div class="form-group">
                    <label for="edit_username" class="control-label">Tài khoản:</label>
                    <input type="text" class="form-control" id="edit_username" name="edit_username" readonly/>
                  </div>
                  <div class="form-group">
                    <label for="edit_name" class="control-label">Tên:</label>
                    <input type="text" class="form-control" id="edit_name" name="edit_name"/>
                  </div>
                  <div class="form-group">
                    <label for="edit_phone" class="control-label">Số điện thoại:</label>
                    <input type="text" class="form-control" id="edit_phone" name="edit_phone"/>
                  </div>
				  <div class="form-group">
                    <label for="edit_status" class="control-label">Trạng thái:</label>
                    <input type="checkbox" class="" id="edit_status" name="edit_status"/>
                  </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" id="btn_edit" class="btn btn-primary">Lưu</button>
            </div>
			</form>
        </div>
    </div>
</div>

<div id="editpass_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Đổi mật khẩu</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_editpass">
				<input type="hidden" value="editpass" name="action" id="action">
				<input type="hidden" value="0" name="editpass_id" id="editpass_id">
                  <div class="form-group">
                    <label for="editpass_name" class="control-label">Tên:</label>
                    <input type="text" class="form-control" id="editpass_name" name="editpass_name" readonly/>
                  </div>
                  <div class="form-group">
                    <label for="editpass_username" class="control-label">Tài khoản:</label>
                    <input type="text" class="form-control" id="editpass_username" name="editpass_username" readonly/>
                  </div>

                  <div class="form-group">
                    <label for="editpass_password" class="control-label">Mật khẩu mới:</label>
                    <input type="password" class="form-control" id="editpass_password" name="editpass_password"/>
                  </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" id="btn_editpass" class="btn btn-primary">Lưu</button>
            </div>
			</form>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
$( document ).ready(function() {
	var grid = $("#user_grid").bootgrid({
		ajax: true,
		rowSelect: true,
		post: function ()
		{
			/* To accumulate custom parameter with the request object */
			return {
				id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
			};
		},
		
		url: "response_user.php",
		formatters: {
            "commands": function(column, row)
            {
                return "<button title='Sửa thông tin' type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.Id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
                    "<button title='Xóa' type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.Id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>"+ 
                    "<button title='Đổi mật khẩu' type=\"button\" class=\"btn btn-xs btn-default command-editpass\" data-row-id=\"" + row.Id + "\"><span class=\"glyphicon glyphicon-pencil\"></span></button>" +
                    "<button title='Phân quyền' type=\"button\" class=\"btn btn-xs btn-default command-permission\" data-row-code=\"" + row.code + "\"><span class=\"glyphicon glyphicon-cog\"></span></button>";
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
                $('#edit_username').val(ele.siblings(':nth-of-type(3)').html());
                $('#edit_phone').val(ele.siblings(':nth-of-type(4)').html());
                var status = parseInt(ele.siblings(':nth-of-type(5)').html());

                if(status == 1){
                    $('#edit_status').prop('checked', true);;                   
                } else{
                    $('#edit_status').prop('checked', false);;     
                }

            } else {
                alert('Now row selected! First select row, then click edit button');
            }
        }).end().find(".command-delete").on("click", function(e)
        {
        
            var conf = confirm('Delete ' + $(this).data("row-id") + '?');
            // alert(conf);
            if(conf){
                $.post('response_user.php', { id: $(this).data("row-id"), action:'delete'}
                    , function(){
                        // when ajax returns (callback), 
                        $("#user_grid").bootgrid('reload');
                }); 
                //$(this).parent('tr').remove();
                //$("#user_grid").bootgrid('remove', $(this).data("row-id"))
            }
        }).end().find(".command-editpass").on("click", function(e)
        {
        //alert("You pressed edit on row: " + $(this).data("row-id"));
        var ele =$(this).parent();
        var g_id = $(this).parent().siblings(':first').html();
        var g_name = $(this).parent().siblings(':nth-of-type(2)').html();
        console.log(g_id);
        console.log(g_name);

		//console.log(grid.data());//
		$('#editpass_model').modal('show');
            if($(this).data("row-id") >0) {
                    
                // collect the data
                $('#editpass_id').val(ele.siblings(':first').html()); // in case we're changing the key
                $('#editpass_name').val(ele.siblings(':nth-of-type(2)').html());
                $('#editpass_username').val(ele.siblings(':nth-of-type(3)').html());
            } else {
                alert('Now row selected! First select row, then click edit button');
            }
        }).end().find(".command-permission").on("click", function(e)
        {
            var win = window.open('user_permission.php?code=' + $(this).data("row-code"), '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        });
});

function ajaxAction(action) {
    data = $("#frm_"+action).serializeArray();
    // console.log(data);
    $.ajax({
        type: "POST",  
        url: "response_user.php",  
        data: data,
        dataType: "json",       
        success: function(response)  
        {
        $('#'+action+'_model').modal('hide');
        $("#user_grid").bootgrid('reload');
        }   
    });
    }
    
    $( "#command-add" ).click(function() {
        $('#add_model').find("input[type='text']").val('');
        $('#add_model').find("input#code").val(uuidv4());
        $('#add_model').modal('show');
    });
    $( "#btn_add" ).click(function() {
        ajaxAction('add');
    });
    $( "#btn_edit" ).click(function() {
        ajaxAction('edit');
    });
    $( "#btn_editpass" ).click(function() {
        ajaxAction('editpass');
    });

    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
});
</script>
