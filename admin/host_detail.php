<?php
//include connection file 
include_once("../connection.php");
$db = new dbObj();
    $connString =  $db->getConnstring();

    // User
    $hostid = $_REQUEST["hostid"];
    if($hostid == ""){
        header('Location: index.php');
        return;
    }

    $sqlhost = "SELECT * FROM host where id=$hostid LIMIT 1";
    $qtot = mysqli_query($connString, $sqlhost) or die("error to fetch host data");

    while( $row = mysqli_fetch_assoc($qtot) ) { 
        $host = $row;
        break;
    }

/*
    $sqlUser = "SELECT u.name,u.username,uh.view,uh.control FROM user u join user_host uh on u.Id = uh.userId and uh.hostId=$hostid";
    $qtot = mysqli_query($connString, $sqlUser) or die("error to fetch user data");
    $user = null;

    while( $row = mysqli_fetch_assoc($qtot) ) { 
        $user = $row;
        break;
    }*/
    // Host
    $sqlhost = "SELECT * FROM host order by name";
    $qhost = mysqli_query($connString, $sqlhost) or die("error to fetch tot hosts data");
    //$dataHost[] = null;

    while( $row = mysqli_fetch_assoc($qhost) ) { 
        $dataHost[] = $row;
    }


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
        <h2>Danh sách tài khoản trên trạm</h2>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Trạm: <?php echo "#". $host["id"];
        echo " - ";
        echo $host["name"];
        echo " - ";
        echo $host["url"];
        //echo  "<a href='".."'>"$host["url"];
        ?>
		<div class="well clearfix">
			<div class="pull-right">
            <form method="post" id="frm_changehost">
				<input type="hidden" value="changehost" name="action" id="action">
                Chọn trạm: <select id="hostId"  name="hostId">
                <?php
                foreach ($dataHost as $key => $value) {
                    //if($key == 0){
                    //    echo "<option value='" . $value["id"] . "' selected>" . $value["name"] . "</option>";
                    //} else{
                        if($value["id"] == $hostid){
                            $selected = "selected='selected'";
                        } else{
                            $selected = "";
                        }

                        echo "<option value='" . $value["id"] . "' $selected >" . $value["name"] . "</option>";
                    //}
                }
                ?>
                </select>
                <?php
                echo "<input type='hidden' name='hostname' id='hostname' value='". $host["name"] ."' />";
                ?>
                </div></div>
            </form>
		<table id="grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
			<thead>
				<tr>
					<th data-column-id="userId" data-type="numeric" data-identifier="true">#</th>
                    <th data-column-id="name">Tên</th>
					<th data-column-id="username">Tài khoản</th>
                    <th data-column-id="view">Quyền xem</th>
                    <th data-column-id="control">Quyền điều khiển</th>
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
                <form method="post" id="frm_add_model">
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
				<input type="hidden" value="0" name="edit_hostid" id="edit_hostid">
				<input type="hidden" value="0" name="edit_userid" id="edit_userid">
                  <div class="form-group">
                    <label for="edit_name" class="control-label">Tên Tài khoản:</label>
                    <input type="text" class="form-control" id="edit_name" name="edit_name" readonly/>
                  </div>
                  <div class="form-group">
                    <label for="edit_username" class="control-label">Tài khoản:</label>
                    <input type="text" class="form-control" id="edit_username" name="edit_username" readonly/>
                  </div>
                  <div class="form-group">
                    <label for="edit_hostname" class="control-label">Trạm:</label>
                    <input type="text" class="form-control" id="edit_hostname" name="edit_hostname" readonly/>
                  </div>
				  <div class="form-group">
                    <label for="edit_view" class="control-label">Quyền xem:</label>
                    <input type="checkbox" class="" id="edit_view" name="edit_view"/>
                  </div>
				  <div class="form-group">
                    <label for="edit_control" class="control-label">Quyền điều khiển:</label>
                    <input type="checkbox" class="" id="edit_control" name="edit_control"/>
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
    $("#hostId").on("change", function(e){
        location.replace("?hostid=" + $(this).val());
        return;
    });

	var grid = $("#grid").bootgrid({
		ajax: true,
		rowSelect: true,
		post: function ()
		{
			/* To accumulate custom parameter with the request object */
			return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
                hostId: $("#hostId").val(),
			};
		},
		
		url: "response_host_detail.php",
		formatters: {
            "commands": function(column, row)
            {
                return "<button title='Sửa thông tin' type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-userId=\"" + row.userId + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
                    "<button title='Xóa' type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-userId=\"" + row.userId + "\" data-row-hostId=\"" + row.hostId + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
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
        if($(this).data("row-userid") >0) {
                
            // collect the data
            $('#edit_userid').val(ele.siblings(':first').html()); // in case we're changing the key
            $('#edit_name').val(ele.siblings(':nth-of-type(2)').html());
            $('#edit_username').val(ele.siblings(':nth-of-type(3)').html());
            $('#edit_hostname').val($("#hostname").val());
            $('#edit_hostid').val($("#hostId").val());

            var view = parseInt(ele.siblings(':nth-of-type(4)').html());
            var control = parseInt(ele.siblings(':nth-of-type(5)').html());

            if(view == 1){
                $('#edit_view').prop('checked', true);;                   
            } else{
                $('#edit_view').prop('checked', false);;     
            }

            if(control == 1){
                $('#edit_control').prop('checked', true);;                   
            } else{
                $('#edit_control').prop('checked', false);;     
            }

        } else {
            alert('Now row selected! First select row, then click edit button');
        }
    }).end().find(".command-delete").on("click", function(e)
    {
    
        var conf = confirm('Delete row #' + $(this).data("row-userid") + '?');
        // alert(conf);
        if(conf){
            $.post('response_host_detail.php', { hostid: $(this).data("row-hostid"), userid: $(this).data("row-userid"), action:'delete'}
                , function(){
                    // when ajax returns (callback), 
                    $("#grid").bootgrid('reload');
            }); 
            //$(this).parent('tr').remove();
            //$("#grid").bootgrid('remove', $(this).data("row-id"))
        }
    });
});


function ajaxAction(action) {
    data = $("#frm_"+action).serializeArray();
    console.log(data);
    $.ajax({
        type: "POST",  
        url: "response_host_detail.php",  
        data: data,
        dataType: "json",       
        success: function(response)  
        {
            $('#'+action+'_model').modal('hide');
            $("#grid").bootgrid('reload');
        }   
    })
    .done(function() {
        //alert( "success" );
    })
    .fail(function() {
        //alert( "error" );
    })
    .always(function() {
        //alert( "complete" );
    });
}
    
    $( "#command-add" ).click(function(e) {
        e.preventDefault();
        //$('#add_model').find("input[type='text']").val('');
        //$('#add_model').find("input#code").val(uuidv4());
        //$('#add_model').modal('show');
        var hostId = $("#frm_add #hostId").val();
        if(hostId == "" || hostId == null){
            alert("Yêu cầu chọn trạm");
            return;
        }

        ajaxAction('add');
    });
    $( "#btn_add" ).click(function() {
        ajaxAction('add');
    });
    $( "#btn_edit" ).click(function() {
        ajaxAction('edit');
    });

    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
});
</script>
