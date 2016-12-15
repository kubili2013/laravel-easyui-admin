<div  data-options="region:'north'" title="设置查询条件" class="easyui-panel" style="height:80px;">
    <div style="margin: 10px 20px;">
        <input name="qname" id="user-qname" class="easyui-textbox" label="用户姓名:" labelAlign="right" style="width:300px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="queryUser();" style="margin-left:10px;">查询</a>
    </div>
</div>
<div data-options="region:'center'" style="width:100%;">
    <table id="user-dg" style="width:100%;">
    </table>
</div>
<div id="user-toolbar">
    @permission(('admin-create'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUserItem()">新增</a>
    @endpermission
    @permission(('admin-edit'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUserItem()">编辑</a>
    @endpermission
    @permission(('admin-delete'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteUserItem()">刪除</a>
    @endpermission
</div>

<div id="user-dlg" class="easyui-dialog" style="width:480px;"
     closed="true" buttons="#user-dlg-buttons">
    <form id="user-addForm" method="post" class="easyui-form" action="{{url('/user/create')}}" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">用户信息</div>
        <div id="user-messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input name="name" label="姓名:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,12]'">
        </div>
        <div style="margin-bottom:10px">
            <input name="email" label="电子邮箱:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:['email','length[0,32]']" >
        </div>
        <div style="margin-bottom:10px">
            <select id="user-roles-add-cg" name="roles[]" class="easyui-combogrid" style="width:95%" data-options="
                        panelWidth: 250,
                        multiple: true,
                        idField: 'id',
                        textField: 'display_name',
                        url: '/GetAllRoles?rows=50',
                        method: 'get',
                        columns: [[
                            {field:'id',title:'ID',hidden:true,sortable:true},
                            {field:'name',title:'角色代号',hidden:true,sortable:true},
                            {field:'display_name',title:'显示名称',width:120,sortable:true},
                            {field:'description',title:'简介',width:120,sortable:true}
                        ]],
                        fitColumns: true,
                        label: '所有角色:',
                        labelPosition: 'left',
                        labelAlign:'right'
                    ">
            </select>
        </div>
    </form>
</div>
<div id="user-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUserItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#user-dlg').dialog('close')" style="width:90px">取消</a>
</div>

<div id="user-edit-dlg" class="easyui-dialog" style="width:480px;"
     closed="true" buttons="#user-edit-dlg-buttons">
    <form id="user-editForm" method="post" class="easyui-form" action="{{url('/user/update')}}" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">用户信息</div>
        <div id="user-edit-messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input id="user-name" name="name" label="姓名:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,12]'">
        </div>
        <div style="margin-bottom:10px">
            <input id="user-email" name="email" label="电子邮箱:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:['email','length[0,32]']" >
        </div>
        <select id="user-roles-cg" name="roles[]" class="easyui-combogrid" style="width:95%" data-options="
                        panelWidth: 250,
                        multiple: true,
                        idField: 'id',
                        textField: 'display_name',
                        url: '/GetAllRoles?rows=50',
                        method: 'get',
                        columns: [[
                            {field:'id',title:'ID',hidden:true,sortable:true},
                            /*{field:'name',title:'角色代号',hidden:true,sortable:true},*/
                            {field:'display_name',title:'显示名称',width:120,sortable:true},
                            {field:'description',title:'简介',width:120,sortable:true}
                        ]],
                        fitColumns: true,
                        label: '所有角色:',
                        labelPosition: 'left',
                        labelAlign:'right'
                    ">
        </select>
    </form>
</div>
<div id="user-edit-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="updateUserItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#user-edit-dlg').dialog('close')" style="width:90px">取消</a>
</div>

<script type="text/javascript">
    var addUserUrl = "";
    var editUserUrl = "";
    var deleteUserUrl = "";
    $("#user-dg").datagrid({
        url:"/GetAllUsers",
        // 网格宽度自适应
        fitColumns:true,
        // 调整列位置
        resizeHandle:'right',
        // 表格工具栏
        toolbar:"#user-toolbar",
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
            qname:getUserValue
        },
        columns:[[
            {field:'id',title:'ID',width:40,sortable:true},
            {field:'name',title:'用户姓名',width:120,sortable:true},
            {field:'email',title:'电子邮件',width:120,sortable:true},
            {field:'created_at',title:'创建日期',width:120,sortable:true}]]

    });
    function editUserItem(){
        var row = $('#user-dg').datagrid('getSelected');
        if (row){
            $('#user-name').textbox('setValue',row.name);
            $('#user-email').textbox('setValue',row.email);
            $('#user-edit-messagebox').html('');
            // 获取角色
            $.ajax({
                url:'/User/'+row.id + '/Roles',
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
                        var roles = new Array();
                        for(var key in data.data){
                            roles.push(data.data[key].id);
                        }
                        // 设置用户之前具备的角色
                        $('#user-roles-cg').combogrid('setValue',roles);
                    } else {
                        $.messager.show({
                            title: '失败消息',
                            msg: data.msg
                        });
                    }
                }
            });
            $('#user-edit-dlg').dialog('open').dialog('center').dialog('setTitle','更新权限');
            editUserUrl = "/user/update/"+ row.id;
        }
    }
    function updateUserItem(){
        $('#user-editForm').form('submit',{
            url:editUserUrl,
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
                    $('#user-edit-dlg').dialog('close');
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });
                    //新增成功 刷新grid
                    queryUser();
                    reloadAllTree();
                }else{
                    $('#user-edit-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }
    function getUserValue(){
        return $('#user-qname').val();
    }
    function queryUser() {
        $("#user-dg").datagrid("load");
    }
    // 打开新增窗口
    function newUserItem(){
        $('#user-dlg').dialog('open').dialog('center').dialog('setTitle','新建权限');
        $('#user-messagebox').html('');
        $('#user-addForm').form('reset');
    }
    // 提交新增项目
    function saveUserItem(){
        $('#user-addForm').form('submit',{
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
                    $('#user-dlg').dialog('close');
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });

                    //新增成功 刷新grid
                    queryUser();
                    reloadAllTree();
                }else{
                    $('#user-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }
    // 删除方法
    function deleteUserItem() {
        var row = $('#user-dg').datagrid('getSelected');
        if (row){
            $.messager.confirm('警告','你确定要删除用户' + row.name + '?',function(r){
                if (r){
                    $.ajax({
                        url:'/user/delete/'+row.id,
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
                                $('#user-dg').datagrid('reload');
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