<div  data-options="region:'north'" title="设置查询条件" class="easyui-panel" style="height:80px;">
    <div style="margin: 10px 20px;">
        <input name="qname" id="action-qname" class="easyui-textbox" label="Action名称:" labelAlign="right" style="width:300px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-2012092109942" onclick="queryActions();" style="margin-left:10px;">查询</a>
    </div>
</div>
<div data-options="region:'center'" style="width:100%;">
    <table id="action-dg" style="width:100%;">
    </table>
</div>
<div id="action-toolbar">
    @permission(('action-create'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newActionItem()">新增</a>
    @endpermission
    @permission(('action-edit'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editActionItem()">修改</a>
    @endpermission
    @permission(('action-delete'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteActionItem()">刪除</a>
    @endpermission
</div>

<div id="action-dlg" class="easyui-dialog" style="width:480px;"
     closed="true" buttons="#action-dlg-buttons">
    <form id="action-addForm" method="post" class="easyui-form" action="{{url('/action/create')}}" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">操作信息</div>
        <div id="action-messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input name="name" label="操作名称:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,16]'">
        </div>
        <div style="margin-bottom:10px">
            <input name="url" label="操作url:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,48]'" >
        </div>
        <div style="margin-bottom:10px">
            <input name="action_type" label="操作类型:" labelAlign="right" class="easyui-textbox" style="width:95%" data-options="required:true,validType:'length[1,64]'">
        </div>
        <div style="margin-bottom:10px">
            <input name="description" label="操作简介:" labelAlign="right" class="easyui-textbox" style="width:95%" data-options="required:true,validType:'length[1,64]'">
        </div>
        <div style="margin-bottom:10px">
            <input name="parent_id" label="父操作:" labelAlign="right" style="width:95%" class="easyui-combotree"
                   data-options="url:'/GetAllActionsByRootTree',method:'get',required:true,value:'0'">
        </div>
        <div style="margin-bottom:10px">
           <input id="action-cc" name="permission" label="关联权限:" labelAlign="right" style="width:95%" class="easyui-combotree"
                    data-options="url:'/GetAllPermissionByTree',method:'get',required:true,value:''">
        </div>
    </form>
</div>
<div id="action-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveActionItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#action-dlg').dialog('close')" style="width:90px">取消</a>
</div>

<div id="action-edit-dlg" class="easyui-dialog" style="width:480px;"
     closed="true" buttons="#action-edit-dlg-buttons">
    <form id="action-editForm" method="post" class="easyui-form" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">操作信息</div>
        <div id="action-e-messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input id="action-e-name" name="name" label="操作名称:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,16]'">
        </div>
        <div style="margin-bottom:10px">
            <input id="action-e-url" name="url" label="操作url:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,48]'" >
        </div>
        <div style="margin-bottom:10px">
            <input id="action-e-action_type" name="action_type" label="操作类型:" labelAlign="right" class="easyui-textbox" style="width:95%" data-options="required:true,validType:'length[1,64]'">
        </div>
        <div style="margin-bottom:10px">
            <input id="action-e-description" name="description" label="简介:" labelAlign="right" class="easyui-textbox" style="width:95%" data-options="required:true,validType:'length[1,64]'">
        </div>
        <div style="margin-bottom:10px">
            <input id="action-edit-cc-parent_id"  name="parent_id" label="父操作:" labelAlign="right" style="width:95%" class="easyui-combotree"
                   data-options="url:'/GetAllActionsByRootTree',method:'get',required:true,value:''">
        </div>
        <div style="margin-bottom:10px">
            <input id="action-edit-cc" name="permission" label="关联权限:" labelAlign="right" style="width:95%" class="easyui-combotree"
                   data-options="url:'/GetAllPermissionByTree',method:'get',required:true">
        </div>
    </form>
</div>
<div id="action-edit-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="updateActionItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#action-edit-dlg').dialog('close')" style="width:90px">取消</a>
</div>
<script type="text/javascript">
    var addActionUrl = "";
    var editActionUrl = "";
    var deleteActionUrl = "";
    $("#action-dg").datagrid({
        url:"/GetAllActions",
        // 网格宽度自适应
        fitColumns:true,
        // 调整列位置
        resizeHandle:'right',
        // 表格工具栏
        toolbar:"#action-toolbar",
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
            qname:getActionValue
        },
        columns:[[
            {field:'id',title:'ID',width:40,sortable:true},
            {field:'name',title:'操作名称',width:120,sortable:true},
            {field:'action_type',title:'操作类型',width:120,sortable:true},
            {field:'url',title:'操作url',width:120,sortable:true},
            {field:'description',title:'简介',width:120,sortable:true}]]

    });

    function queryActions() {
        $("#action-dg").datagrid("load");
    }
    function getActionValue(){
        return $('#action-qname').val();
    }
    // 打开新增窗口
    function newActionItem(){
        $('#action-dlg').dialog('open').dialog('center').dialog('setTitle','新增操作');
        // 清空显示的错误
        $('#action-messagebox').html("");
        $('#action-addForm').form('reset');
    }
    // 打开编辑窗口 并设置值
    function editActionItem(){
        $('#action-e-messagebox').html("");
        var row = $('#action-dg').datagrid('getSelected');
        if (row){
            //重置url 传action的id
            editActionUrl = "/action/update/"+row.id;
            $("#action-e-name").textbox('setValue',row.name);
            $("#action-e-url").textbox('setValue',row.url);
            $("#action-e-action_type").textbox('setValue',row.action_type);
            $("#action-edit-cc-parent_id").combotree('setValue',row.parent_id);
            $("#action-e-description").textbox('setValue',row.description);
            // 请求角色的具有的权限,成功后显示在权限树中
            $.ajax({
                url:'/GetActionPermissions/'+row.id,
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
                        var permission = data.data;
                        // 设置权限树的默认
                        $('#action-edit-cc').combotree('setValue',permission.id);
                    } else {
                        $.messager.show({
                            title: '失败消息',
                            msg: data.msg
                        });
                    }
                }
            });
            // 获取操作树

            $('#action-edit-dlg').dialog('open').dialog('center').dialog('setTitle','更新操作');
        }
    }
    // 提交更新
    function updateActionItem(){
        $('#action-editForm').form('submit',{
            url:editActionUrl,
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
                    $('#action-dlg').dialog('close');
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });
                    //新增成功 刷新grid
                    queryActions();
                    $('#action-edit-dlg').dialog('close');
                }else{
                    $('#action-e-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }
    // 提交新增项目
    function saveActionItem(){
        $('#action-addForm').form('submit',{
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
                    $('#action-dlg').dialog('close');
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });
                    // 新增成功 刷新grid
                    queryActions();
                    $('#action-dlg').dialog('close');
                    // 新增菜单之后之后,刷新菜单树menu-cc
                    $('#action-cc').combotree('reload');
                }else{
                    $('#action-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }
    // 删除方法
    function deleteActionItem() {
        var row = $('#action-dg').datagrid('getSelected');
        if (row){
            $.messager.confirm('警告','你确定要删除操作:' + row.name + '?',function(r){
                if (r){
                    $.ajax({
                        url:'/action/delete/'+row.id,
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
                                $('#action-dg').datagrid('reload');
                                $.messager.show({
                                    title: '成功消息',
                                    msg: data.msg
                                });
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