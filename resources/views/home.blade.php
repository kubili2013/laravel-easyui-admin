@extends('layouts.app')
@section('content')
    <div id="main-panel" class="easyui-layout">
        <div data-options="region:'north'" style="height:55px;background:#EEEEEE;">
            <div style="margin:0 20px;display:inline;float:left;"><h2>{{ config('app.name', 'Laravel') }}</h2></div>
            <div style="margin:10px 20px;display:inline;float:right;font-size: 14px;">
                <a href="/logout">退出</a>&nbsp;&nbsp;
                <a href="javascript:$('#reset-psw-dlg').dialog('open');">修改密码</a>&nbsp;&nbsp;
                <a href="#">{{ Auth::user()->name }} </a>
            </div>
        </div>
        <div data-options="region:'south',split:true" style="height:50px;background:#EEEEEE;"></div>
        <div data-options="region:'east',split:true" title="任务" style="width:200px;"></div>
        <div data-options="region:'west',split:true" title="欢迎" style="width:200px;padding: 0px;">
            <div class="easyui-accordion menu" fit="true" border="false" multiple="true">
            </div>
        </div>
        <div data-options="region:'center',split:true">
            <div id="work-panel" class="easyui-tabs" fit="true" border="false" >
                <div title="welcome" style="padding:20px;overflow:hidden;" id="welcome">
                    <h1>Welcome to jQuery UI!</h1>
                </div>
            </div>
        </div>
    </div>
    <div id="reset-psw-dlg"
         class="easyui-dialog"
         style="width:480px;"
         title="重设密码"
         closed="true"
         buttons="#reset-psw-dlg-buttons">
        <form method="post"
              class="easyui-form"
              id="reset-psw-form"
              action="/reset/psw"
              style="margin:0;padding:20px 50px">
            <div class="messagebox" style="margin-bottom:10px;color:red">
            </div>
            <div style="margin-bottom:10px">
                <input label="旧密码:" labelAlign="right" class="easyui-passwordbox" type="password" name="old_password"
                       data-options="iconCls:'icon-lock'
                        ,required:true,validType:['string','length[6,32]']
                        " style="width:95%">
            </div>
            <div style="margin-bottom:10px">
                <input label="密码:" labelAlign="right" class="easyui-passwordbox" type="password" name="password"
                       data-options="iconCls:'icon-lock'
                        ,required:true,validType:['string','length[6,32]']
                        " style="width:95%">
            </div>
            <div style="margin-bottom:10px">
                <input label="重复密码:" labelAlign="right" class="easyui-passwordbox" type="password" name="re_password"
                       data-options="iconCls:'icon-lock'
                        ,required:true,validType:['string','length[6,32]']
                        " style="width:95%">
            </div>
        </form>
    </div>
    <div id="reset-psw-dlg-buttons">
        <a href="javascript:void(0)"
           class="easyui-linkbutton"
           iconCls="icon-ok"
           onclick="resetPsw();"
           style="width:90px">更新密码</a>
        <a href="javascript:void(0)"
           class="easyui-linkbutton"
           iconCls="icon-cancel"
           onclick="javascript:$('#reset-psw-dlg').dialog('close');"
           style="width:90px">取消</a>
    </div>
    <script>
        function resetPsw(){
            $("#reset-psw-form").form('submit',{
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
                        $('#reset-psw-dlg').dialog('close');
                    }else{
                        $(this).children('.messagebox').first().html(data.msg);
                        setTimeout("$('.messagebox').html('');",3000);
                    }
                },
                error:function () {
                    $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
                    window.location.reload();
                }
            });
        }
        $(document).ready(function(){
            var height1 = $(window).height()-4;
            if(height1 > 512){
                $("#main-panel").attr("style","width:100%;height:"+height1+"px");
                $("#main-panel").layout("resize",{
                    width:"100%",
                    height:height1+"px"
                });
            }else{
                $("#main-panel").attr("style","width:100%;height:"+height1+"px");
                $("#main-panel").layout("resize",{
                    width:"100%",
                    height:"512px"
                });
            }
            //异步获取菜单
            $.ajax({
                url:"/GetMyMenus",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async:false,
                type:'post'
            }).success(function(data){
                var menus = data;
                // 初始化菜单
                initMenu(menus);
            });
        });
        // 窗口改变 布局的宽高跟着变化
        $(window).resize(function(){
            var height1 = $(window).height()-4;
            if(height1 > 512){
                $("#main-panel").attr("style","width:100%;height:"+height1+"px");
                $("#main-panel").layout("resize",{
                    width:"100%",
                    height:height1+"px"
                });
            }else{
                $("#main-panel").attr("style","width:100%;height:"+height1+"px");
                $("#main-panel").layout("resize",{
                    width:"100%",
                    height:"512px"
                });
            }
        });
        function reloadAllTree(){
            $('#user-roles-cg').combogrid("reload");
            $('#user-roles-add-cg').combogrid("reload");
            $('#role-edit-cc').combotree("reload");
            $('#role-cc').combotree("reload");
            $('#permission-edit-cc').combotree("reload");
            $('#permission-cc').combotree("reload");
            $('#menu-cc').combotree("reload");
            $('#action-edit-cc').combotree("reload");
            $('#action-edit-cc-parent_id').combotree("reload");
            $('#action-cc').combotree("reload");
            $('#action-cc-parent_id').combotree("reload");
        }
    </script>
@endsection
