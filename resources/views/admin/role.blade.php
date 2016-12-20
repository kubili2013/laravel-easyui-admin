{{--<div  data-options="region:'north'" title="设置查询条件" class="easyui-panel" style="height:80px;">--}}
    {{--<div style="margin: 10px 20px;">--}}
        {{--<input name="qname" id="qname" class="easyui-textbox" label="菜单名称:" labelAlign="right" style="width:300px;">--}}
        {{--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="query();" style="margin-left:10px;">查询</a>--}}
    {{--</div>--}}
{{--</div>--}}
<div data-options="region:'center'" style="width:100%;">
    <table id="role-dg" style="width:100%;">
    </table>
</div>
<div id="role-toolbar">
    @permission(('role-create'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRoleItem()">新增</a>
    @endpermission
    @permission(('role-edit'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRoleItem()">修改</a>
    @endpermission
    @permission(('role-delete'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteRoleItem()">刪除</a>
    @endpermission
</div>

<div id="role-dlg" class="easyui-dialog" style="width:480px;" modal="true"
     closed="true" buttons="#role-dlg-buttons">
    <form id="role-addForm" method="post" class="easyui-form" action="{{url('/role/create')}}" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">菜单信息</div>
        <div id="role-messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input name="name" label="角色代号:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,16]'">
        </div>
        <div style="margin-bottom:10px">
            <input name="display_name" label="角色名称:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,48]'" >
        </div>
        <div style="margin-bottom:10px">
            <input name="description" label="角色简介:" labelAlign="right" class="easyui-textbox" style="width:95%" data-options="required:true,validType:'length[1,64]'">
        </div>
        <div style="margin-bottom:10px">
           <input id="role-cc" name="permissions[]" label="赋予权限:" labelAlign="right" style="width:95%" class="easyui-combotree"
                    data-options="url:'/GetAllPermissionByTree',method:'get',required:true,multiple:true,values:''">
        </div>
    </form>
</div>
<div id="role-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRoleItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#role-dlg').dialog('close')" style="width:90px">取消</a>
</div>

<div id="role-edit-dlg" class="easyui-dialog" style="width:480px;" modal="true"
     closed="true" buttons="#role-edit-dlg-buttons">
    <form id="role-editForm" method="post" class="easyui-form" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">菜单信息</div>
        <div id="role-e-messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input id="role-e-name" name="name" label="角色代号:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,16]'">
        </div>
        <div style="margin-bottom:10px">
            <input id="role-e-display_name" name="display_name" label="角色名称:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,48]'" >
        </div>
        <div style="margin-bottom:10px">
            <input id="role-e-description" name="description" label="角色简介:" labelAlign="right" class="easyui-textbox" style="width:95%" data-options="required:true,validType:'length[1,64]'">
        </div>
        <div style="margin-bottom:10px">
            <input id="role-edit-cc" name="permissions[]" label="赋予权限:" labelAlign="right" style="width:95%" class="easyui-combotree"
                   data-options="url:'/GetAllPermissionByTree',method:'get',required:true,multiple:true">
        </div>
    </form>
</div>
<div id="role-edit-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="updateRoleItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#role-edit-dlg').dialog('close')" style="width:90px">取消</a>
</div>
<script type="text/javascript">
    var addRoleUrl = "";
    var editRoleUrl = "";
    var deleteRoleUrl = "";
    $("#role-dg").datagrid({
        url:"/GetAllRoles",
        // 网格宽度自适应
        fitColumns:true,
        // 调整列位置
        resizeHandle:'right',
        // 表格工具栏
        toolbar:"#role-toolbar",
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
            //qname:getValue
        },
        columns:[[
            {field:'id',title:'ID',width:40,sortable:true},
            {field:'name',title:'角色代号',width:120,sortable:true},
            {field:'display_name',title:'显示名称',width:120,sortable:true},
            {field:'description',title:'简介',width:120,sortable:true}]]

    });

    function queryRoles() {
        $("#role-dg").datagrid("load");
    }
    // 打开新增窗口
    function newRoleItem(){
        $('#role-dlg').dialog('open').dialog('center').dialog('setTitle','新增角色');
        $('#role-addForm').form('reset');
    }
    // 打开编辑窗口 并设置值
    function editRoleItem(){
        var row = $('#role-dg').datagrid('getSelected');
        if (row){
            //重置url 传role的id
            editRoleUrl = "/role/update/"+row.id;
            $("#role-e-name").textbox('setValue',row.name);
            $("#role-e-display_name").textbox('setValue',row.display_name);
            $("#role-e-description").textbox('setValue',row.description);
            // 请求角色的具有的权限,成功后显示在权限树中
            $.ajax({
                url:'/GetRolePermissions/'+row.id,
                data:{
                    // laravel 框架,post提交时,防止跨站请求伪造(CSRF)
                    "_token":$('meta[name="csrf-token"]').attr('content'),
                    // 返回错误的方式
                    'back_error':"json"
                },
                // 此处设置为接收json格式,success的方法中就不用eval进行转换json
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
                        var permissions = new Array();
                        for(var key in data.data){
                            permissions.push(data.data[key].id);
                        }
                        // 设置权限树的默认
                        $('#role-edit-cc').combotree('setValues',permissions);
                    } else {
                        $.messager.show({
                            title: '失败消息',
                            msg: data.msg
                        });
                    }
                }
            });
            $('#role-edit-dlg').dialog('open').dialog('center').dialog('setTitle','更新角色');
        }
    }
    // 提交更新
    function updateRoleItem(){
        $('#role-editForm').form('submit',{
            url:editRoleUrl,
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
                    $('#role-dlg').dialog('close');
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });
                    //新增成功 刷新grid
                    queryRoles();
                    $('#role-edit-dlg').dialog('close');
                    reloadAllTree();
                }else{
                    $('#role-e-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }
    // 提交新增项目
    function saveRoleItem(){
        $('#role-addForm').form('submit',{
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
                    $('#role-dlg').dialog('close');
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });
                    //新增成功 刷新grid
                    queryRoles();
                    $('#role-dlg').dialog('close');
                    reloadAllTree()
                }else{
                    $('#role-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }
    // 删除方法
    function deleteRoleItem() {
        var row = $('#role-dg').datagrid('getSelected');
        if (row){
            $.messager.confirm('警告','你确定要删除角色:' + row.display_name + '?',function(r){
                if (r){
                    $.ajax({
                        url:'/role/delete/'+row.id,
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
                                $('#role-dg').datagrid('reload');
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
