@extends('layouts.app')
@section('content')
    <div id="main-panel" class="easyui-layout">
        <div data-options="region:'north'" style="height:55px;background:#E0ECFF;">
            <div style="margin:0 20px;display:inline;float:left;"><h2>{{ config('app.name', 'Laravel') }}</h2></div>
            <div style="margin:10px 20px;display:inline;float:right;font-size: 14px;">
                <a href="/logout">退出</a>&nbsp;&nbsp;
                <a href="/resetpsw">修改密码</a>&nbsp;&nbsp;
                <a href="#">{{ Auth::user()->name }} </a>
            </div>
        </div>
        <div data-options="region:'south',split:true" style="height:50px;"></div>
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
    <script>
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
    </script>
@endsection
