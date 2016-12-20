<div  data-options="region:'north'" title="设置查询条件" class="easyui-panel" style="height:80px;">
    <div style="margin: 10px 20px;">
        <input name="qname" id="permission-qname" class="easyui-textbox" label="权限名称:" labelAlign="right" style="width:300px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-2012092109942" onclick="queryPermission();" style="margin-left:10px;">查询</a>
    </div>
</div>
<div data-options="region:'center'" style="width:100%;">
    <table id="permission-dg" style="width:100%;">
    </table>
</div>
<div id="permission-toolbar">
    @permission(('permission-create'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newPermissionItem()">新增</a>
    @endpermission
    @permission(('permission-edit'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPermissionItem()">编辑</a>
    @endpermission
    @permission(('permission-delete'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deletePermissionItem()">刪除</a>
    @endpermission
</div>

<div id="permission-dlg" class="easyui-dialog" style="width:480px;"
     closed="true" buttons="#permission-dlg-buttons">
    <form id="permission-addForm" method="post" class="easyui-form" action="{{url('/permission/create')}}" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">权限信息</div>
        <div id="permission-messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input name="name" label="权限代号:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,64]'">
        </div>
        <div style="margin-bottom:10px">
            <input name="display_name" label="权限名称:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,48]'" >
        </div>
        <div style="margin-bottom:10px">
            <input name="description" label="权限介绍:" labelAlign="right" class="easyui-textbox" style="width:95%" data-options="required:true,validType:'length[1,128]'">
        </div>
        <div style="margin-bottom:10px">
           <input id="permission-cc" name="parent_id" label="父权限:" labelAlign="right" style="width:95%" class="easyui-combotree"
                    data-options="url:'/GetAllPermissionByRootTree',method:'get',required:true,value:0">
        </div>
    </form>
</div>
<div id="permission-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="savePermissionItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#permission-dlg').dialog('close')" style="width:90px">取消</a>
</div>

<div id="permission-edit-dlg" class="easyui-dialog" style="width:480px;"
     closed="true" buttons="#permission-edit-dlg-buttons">
    <form id="permission-editForm" method="post" class="easyui-form" action="{{url('/permission/create')}}" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">权限信息</div>
        <div id="permission-edit-messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input id="permission-name" name="name" label="权限代号:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,64]'">
        </div>
        <div style="margin-bottom:10px">
            <input id="permission-display_name" name="display_name" label="权限名称:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,48]'" >
        </div>
        <div style="margin-bottom:10px">
            <input id="permission-description" name="description" label="权限介绍:" labelAlign="right" class="easyui-textbox" style="width:95%" data-options="required:true,validType:'length[1,128]'">
        </div>
        <div style="margin-bottom:10px">
            <input id="permission-edit-cc" name="parent_id" label="父权限:" labelAlign="right" style="width:95%" class="easyui-combotree"
                   data-options="url:'/GetAllPermissionByRootTree',method:'get',required:true">
        </div>
    </form>
</div>
<div id="permission-edit-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="updatePermissionItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#permission-edit-dlg').dialog('close')" style="width:90px">取消</a>
</div>

<script type="text/javascript">
    var addPermissionUrl = "";
    var editPermissionUrl = "";
    var deletePermissionUrl = "";
    $("#permission-dg").datagrid({
        url:"/GetAllPermissions",
        // 网格宽度自适应
        fitColumns:true,
        // 调整列位置
        resizeHandle:'right',
        // 表格工具栏
        toolbar:"#permission-toolbar",
        // 数据表格条纹化
        striped:true,
        method:"get",
        // 一行里显示
        nowrap:true,
        // 提示消息
        loadMsg:'正在努力加载...',
        pagination:true,
        rownumbers:true,
        // 只允许选中一行
        singleSelect:true,
        pageNumber:1,
        pageSize:20,
        // 属性
        queryParams:{
            qname:getPermissionValue
        },
        columns:[[
            {field:'id',title:'ID',width:40,sortable:true},
            {field:'name',title:'权限代码',width:120,sortable:true},
            {field:'display_name',title:'展示名称',width:120,sortable:true},
            {field:'description',title:'权限描述',width:120,sortable:true}]]

    });
    function editPermissionItem(){
        var row = $('#permission-dg').datagrid('getSelected');
        if (row){
            $('#permission-name').textbox('setValue',row.name);
            $('#permission-display_name').textbox('setValue',row.display_name);
            $('#permission-description').textbox('setValue',row.description);
            $('#permission-edit-cc').combotree("setValue",row.parent_id);
            $('#permission-edit-messagebox').html("");
            $('#permission-edit-dlg').dialog('open').dialog('center').dialog('setTitle','更新权限');
            editPermissionUrl = "/permission/update/"+ row.id;
        }
    }
    function updatePermissionItem(){
        $('#permission-editForm').form('submit',{
            url:editPermissionUrl,
            onSubmit:function(){
                return $(this).form('enableValidation').form('validate');
            },
            queryParams:{
                // laravel 框架,post提交时,防止跨站请求伪造(CSRF)
                "_token":$('meta[name="csrf-token"]').attr('content'),
                // 返回错误的方式
                'back_error':"json"
            },
            success:function (result){
                var data = eval('('+result+')');
                if(data.success){
                    $('#permission-edit-dlg').dialog('close');
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });
                    //新增成功 刷新grid
                    queryPermission();
                    //新增成功 重新获取权限树
                    reloadAllTree();
                }else{
                    $('#permission-edit-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }
    function getPermissionValue(){
        return $('#permission-qname').val();
    }
    function queryPermission() {
        $("#permission-dg").datagrid("load");
    }
    // 打开新增窗口
    function newPermissionItem(){
        $('#permission-dlg').dialog('open').dialog('center').dialog('setTitle','新建权限');
        $('#permission-messagebox').html("");
        $('#permission-addForm').form('reset');
    }
    // 提交新增项目
    function savePermissionItem(){
        $('#permission-addForm').form('submit',{
            onSubmit:function(){
                return $(this).form('enableValidation').form('validate');
            },
            queryParams:{
                // laravel 框架,post提交时,防止跨站请求伪造(CSRF)
                "_token":$('meta[name="csrf-token"]').attr('content'),
                // 返回错误的方式
                'back_error':"json"
            },
            success:function (result){
                var data = eval('('+result+')');
                if(data.success){
                    $('#permission-dlg').dialog('close');
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });

                    //新增成功 刷新grid
                    queryPermission();
                    //新增成功 重新获取权限树
                    reloadAllTree();
                }else{
                    $('#permission-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }
    // 删除方法
    function deletePermissionItem() {
        var row = $('#permission-dg').datagrid('getSelected');
        if (row){
            $.messager.confirm('警告','将删除所有子权限,你确定要删除权限' + row.display_name + '?',function(r){
                if (r){
                    $.ajax({
                        url:'/permission/delete/'+row.id,
                        data:{
                            // laravel 框架,post提交时,防止跨站请求伪造(CSRF)
                            "_token":$('meta[name="csrf-token"]').attr('content'),
                            // 返回错误的方式
                            'back_error':"json"
                        },
                        dataType: "json",
                        method:'post',
                        error:function(response){
                            var data = eval('('+response.responseText+')');
                            $.messager.show({
                                title: '失败消息',
                                msg: data.msg
                            });
                        },
                        success:function(data){
                            if (data.success){
                                $('#permission-dg').datagrid('reload');
                                $.messager.show({
                                    title: '成功消息',
                                    msg: data.msg
                                });
                                reloadAllTree();
                            } else {
                                $.messager.show({
                                    title: '失败消息',
                                    msg: data.msg
                                });
                            }
                        }
                    });
                }
            });
        }
    }
</script>