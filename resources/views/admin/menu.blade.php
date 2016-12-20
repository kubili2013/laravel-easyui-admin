<div  data-options="region:'north'" title="设置查询条件" class="easyui-panel" style="height:80px;">
    <div style="margin: 10px 20px;">
        <input name="qname" id="menu-qname" class="easyui-textbox" label="菜单名称:" labelAlign="right" style="width:300px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-2012092109942" onclick="query();" style="margin-left:10px;">查询</a>
    </div>
</div>
<div data-options="region:'center'" style="width:100%;">
    <table id="menu-dg" style="width:100%;">
    </table>
</div>
<div id="menu-toolbar">
    @permission(('menu-create'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMenuItem()">新增</a>
    @endpermission
    @permission(('menu-delete'))
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteMenuItem()">刪除</a>
    @endpermission
</div>

<div id="menu-dlg" class="easyui-dialog" style="width:480px;" modal="true"
     closed="true" buttons="#menu-dlg-buttons">
    <form id="menu-addForm" method="post" class="easyui-form" action="{{url('/menu/create')}}" style="margin:0;padding:20px 50px">
        <div style="margin-bottom:20px;font-size:14px;border-bottom:1px solid #ccc">菜单信息</div>
        <div id="messagebox" style="margin-bottom:10px;color:red">
        </div>
        <div style="margin-bottom:10px">
            <input name="name" label="菜单名称:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,16]'">
        </div>
        <div style="margin-bottom:10px">
            <input name="icon" label="图标类:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,48]'" >
        </div>
        <div style="margin-bottom:10px">
            <input name="description" label="简介:" labelAlign="right" class="easyui-textbox" required="true" style="width:95%" data-options="required:true,validType:'length[1,100]'" >
        </div>
        <div style="margin-bottom:10px">
            <input id="menu-action-cc" name="action" label="关联操作:" labelAlign="right" style="width:95%" class="easyui-combotree"
                   data-options="url:'/GetAllActionsByTree',method:'get',required:true">
        </div>
        <div style="margin-bottom:10px">
           <input id="menu-cc" name="parent_id" label="父菜单:" labelAlign="right" style="width:95%" class="easyui-combotree"
                    data-options="url:'/GetAllMenusByTree',method:'get',required:true,value:0">
        </div>
    </form>
</div>
<div id="menu-dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenuItem()" style="width:90px">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#menu-dlg').dialog('close')" style="width:90px">取消</a>
</div>
<script type="text/javascript">
    var addMenuUrl = "";
    var editMenuUrl = "";
    var deleteMenuUrl = "";
    $("#menu-dg").datagrid({
        url:"/GetAllMenus",
        // 网格宽度自适应
        fitColumns:true,
        // 调整列位置
        resizeHandle:'right',
        // 表格工具栏
        toolbar:"#menu-toolbar",
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
            qname:getMenuValue
        },
        columns:[[
            {field:'id',title:'ID',width:40,sortable:true},
            {field:'name',title:'菜单名称',width:120,sortable:true},
            {field:'icon',title:'图标',width:120,sortable:true},
            {field:'menu_type',title:'菜单类型',width:120,sortable:true},
            {field:'description',title:'简介',width:120,sortable:true}]]

    });
    function getMenuValue(){
        return $('#menu-qname').val();
    }
    function queryMenu() {
        $("#menu-dg").datagrid("load");
    }
    // 打开新增窗口
    function newMenuItem(){
        $('#menu-dlg').dialog('open').dialog('center').dialog('setTitle','新建菜单');
        $('#menu-addForm').form('reset');
    }
    // 提交新增项目
    function saveMenuItem(){
        $('#menu-addForm').form('submit',{
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
                    $.messager.show({    // show error message
                        title: '成功消息',
                        msg: data.msg
                    });

                    //新增成功 刷新grid
                    queryMenu();
                    $('#menu-dlg').dialog('close');
                    // 菜单之后,刷新菜单树menu-cc
                    reloadAllTree();
                }else{
                    $('#menu-messagebox').html(data.msg);
                }
            },
            error:function () {
                $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                window.location.reload();
            }
        });
    }

    // 删除方法
    function deleteMenuItem() {
        var row = $('#menu-dg').datagrid('getSelected');
        if (row){
            $.messager.confirm('警告','你确定要删除菜单' + row.name,function(r){
                if (r){
                    $.ajax({
                        url:'/menu/delete/'+row.id,
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
                                $('#menu-dg').datagrid('reload');
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
