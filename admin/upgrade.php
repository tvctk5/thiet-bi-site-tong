<?php

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cập nhật các trạm</title>
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
        <h3><a href='../index.php'>Trang chủ</a> <span class='link-to-home'> >> </span> Lịch sử cập nhật</h3>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="well clearfix">
            <form id='frm_createUpgradeVersion' name='frm_createUpgradeVersion' enctype="multipart/form-data">
                <input type="hidden" value="createUpgradeVersion" name="action" id="action">
            <!-- <form id='frm_createUpgradeVersion' action="upload.php" method="post" enctype="multipart/form-data"> -->
                <div class="form-group">
                    <label for="Version">Version</label>
                    <input type="text" class="form-control" name="Version" id="Version" aria-describedby="versionHelp" placeholder="Nhập Version">
                </div>
                <div class="form-group">
                    <label for="fileUpload">Tải lên tệp (*.zip)</label>
                    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="active" id="active" checked='checked'>
                    <label class="form-check-label" for="active">Kích hoạt cập nhật ngay</label>
                </div>
                <button type="button" class="btn btn-primary" name="createUpgradeVersion" id="createUpgradeVersion">Tạo phiên bản cập nhật</button>
            </form>
            <progress style="display: none;" class="file-upload"></progress>
		<table id="user_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
			<thead>
				<tr>
					<th data-column-id="id" data-type="numeric" data-identifier="true">#</th>
                    <th data-column-id="version">Version</th>
					<th data-column-id="uri_file">Đường dẫn tệp</th>
					<th data-column-id="active">Kích hoạt</th>
                    <th data-column-id="createdate">Ngày tạo</th>
                    <th data-column-id="count_host">Trạm sử dụng</th>
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

</body>
</html>
<script type="text/javascript">
$( document ).ready(function() {
    // $('progress').hide();
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
		
		url: "response_upgrade.php",
		formatters: {
            "commands": function(column, row)
            {
                if(row.active == 0){
                    return "<button title='Xóa' type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>" + 
                        "<button title='Kích hoạt' type=\"button\" class=\"btn btn-xs btn-default command-active\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-ok-sign\"></span></button>";
                }

                return "<button title='Xóa' type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>" + 
                "<button title='Hủy kích hoạt' type=\"button\" class=\"btn btn-xs btn-default command-inactive\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";

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
                $.post('response_upgrade.php', { id: $(this).data("row-id"), action:'delete'}
                    , function(){
                        // when ajax returns (callback), 
                        $("#user_grid").bootgrid('reload');
                }); 
                //$(this).parent('tr').remove();
                //$("#user_grid").bootgrid('remove', $(this).data("row-id"))
            }
        }).end().find(".command-active").on("click", function(e)
        {
        
            var conf = confirm('Kích hoạt #' + $(this).data("row-id") + '?');
            // alert(conf);
            if(conf){
                $.post('response_upgrade.php', { id: $(this).data("row-id"), action:'active'}
                    , function(){
                        // when ajax returns (callback), 
                        $("#user_grid").bootgrid('reload');
                }); 
                //$(this).parent('tr').remove();
                //$("#user_grid").bootgrid('remove', $(this).data("row-id"))
            }
        }).end().find(".command-inactive").on("click", function(e)
        {
        
            var conf = confirm('Hủy kích hoạt #' + $(this).data("row-id") + '?');
            // alert(conf);
            if(conf){
                $.post('response_upgrade.php', { id: $(this).data("row-id"), action:'inactive'}
                    , function(){
                        // when ajax returns (callback), 
                        $("#user_grid").bootgrid('reload');
                }); 
                //$(this).parent('tr').remove();
                //$("#user_grid").bootgrid('remove', $(this).data("row-id"))
            }
        });
});

function ajaxAction(action) {
    data = $("#frm_"+action).serializeArray();
    console.log(data);
    $.ajax({
        type: "POST",  
        url: "response_upgrade.php",  
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

    let d = new Date();

    let datestring = "V" + d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() + "_" +
    d.getHours() + "-" + d.getMinutes() + "-" + d.getSeconds() + "-" + d.getMilliseconds();
    $("#frm_createUpgradeVersion #Version").val(datestring);

    $( "#createUpgradeVersion" ).click(function() {
        let version = $("#frm_createUpgradeVersion #Version");
        if(version.val() == "" || version.val().trim() == ""){
            alert("Yêu cầu nhập version cho bản cập nhật.");
            version.focus();
            return;
        }

        let fileToUpload = $("#frm_createUpgradeVersion #fileToUpload");
        if(fileToUpload.val() == "" || fileToUpload.val().trim() == ""){
            alert("Yêu cầu nhập chọn tệp *.zip đính kèm.");
            fileToUpload.focus();
            return;
        }

        $('progress').show();
        // ajaxAction('createUpgradeVersion');
        $.ajax({
            // Your server script to process the upload
            url: 'uploadVersion.php',
            type: 'POST',

            // Form data
            data: new FormData($('#frm_createUpgradeVersion')[0]),

            // Tell jQuery not to process data or worry about content-type
            // You *must* include these options!
            cache: false,
            contentType: false,
            processData: false,

            // Custom XMLHttpRequest
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    // For handling the progress of the upload
                    myXhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            $('progress').attr({
                                value: e.loaded,
                                max: e.total,
                            });
                        }
                    } , false);
                }
                return myXhr;
            }
        }).done(function(data) {
            console.log("data: " + data);
            data = JSON.parse(data);
            if(data.status){
                alert( "Tạo version thành công");
            } else {
                alert( "Tạo version thất bại. Vui lòng thử lại");
            }
        })
        .fail(function(data) {
            console.log("data: " + data);
            data = JSON.parse(data);
            if(data.status){
                alert( "Tạo version thành công");
            } else {
                alert( "Tạo version thất bại. Vui lòng thử lại");
            }
        })
        .always(function(data) {
            // data = JSON.parse(data);
            // if(data.status){
            //     alert( "complete: " + data.status );
            // } else {
            //     alert( "complete: FAILED: " + data.status );
            // }
            $('progress').hide();
            $("#user_grid").bootgrid('reload');
            let d = new Date();
            let datestring = "V" + d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() + "_" +
                d.getHours() + "-" + d.getMinutes() + "-" + d.getSeconds() + "-" + d.getMilliseconds();
            $("#frm_createUpgradeVersion #Version").val(datestring);

            $("#frm_createUpgradeVersion #fileToUpload").val("");
        });
    });

    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
});
</script>
