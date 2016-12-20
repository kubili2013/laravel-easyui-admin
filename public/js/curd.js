/**
 *
 * @param obj {url:'',sscFunc:function(){}}
 * @constructor
 */
function EasyCURDAjax(obj){
    if(!('url' in obj)){
        throw new Error("EasyCURDAjax缺少属性:url!");
    }
    if(!('sscFunc' in obj)){
        obj.sscFunc=function(data){};
    }
    $.ajax({
        url:obj.url,
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
                obj.sscFunc(data.data);
            } else {
                $.messager.show({
                    title: '失败消息',
                    msg: data.msg
                });
            }
        }
    });
}

function EasyCURDForm(form,EasyCURD){
    var selfForm = $(form);
    selfForm.form('submit',{
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
                var callback = selfForm.attr('callback');

                if(callback != null){
                    EasyCURD[callback]();
                }
            }else{
                selfForm.children('.messagebox').first().html(data.msg);
                setTimeout("$('.messagebox').html('');",3000);
            }
        },
        error:function () {
            $.messager.alert('警告','系统出错!请刷新界面重试!','warning');
            window.location.reload();
        }
    });
}
function EasyCURD(obj){
    // datagrid_url 数据列表获取数据的url
    if(!('datagrid_url' in obj)){
        throw new Error("缺少属性:datagrid_url!");
    }
    // datagrid_id 数据列表id <table id="XXX-datagrid" style="width:100%;"></table>
    if(!('datagrid_id' in obj)){
        throw new Error("缺少属性:datagrid_id!");
    }
    // 列属性
    if(!('columns' in obj)){
        throw new Error("缺少属性:columns!");
    }
    // 工具栏 id
    if(!('toolbar_id' in obj)){
        throw new Error("缺少属性:toolbar_id!");
    }
    // 查询表单id
    if(!('query_form_id' in obj)){
        throw new Error("缺少属性:query_form_id!");
    }
    var self= this;
    $("#" + obj.query_form_id).submit(function(){
        // 点击查询时
        $("#"+obj.datagrid_id).datagrid({queryParams:self.FormJson()});
        $("#"+obj.datagrid_id).datagrid('reload');
        console.log($("#" + obj.query_form_id ).serialize());
        return false;
    });
    // 获取查询表单的数据
    this.FormJson = function () {
        var o = {};
        var a = $("#" + obj.query_form_id).serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        // laravel csrf 否则post提交时报错
        o['_token'] = $('meta[name="csrf-token"]').attr('content');
        return o;
    };
    //创建datagrid
    $("#"+obj.datagrid_id).datagrid({
        url:obj.datagrid_url,
        // 网格宽度自适应
        fitColumns:true,
        // 调整列位置
        resizeHandle:'right',
        // 表格工具栏
        toolbar:'#' + obj.toolbar_id,
        // 数据表格条纹化
        striped:true,
        method:"post",
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
        queryParams:self.FormJson(),
        columns:obj.columns
    });
    // 增删改查
    var toolbars = $('#' + obj.toolbar_id).children(".curd-toolbar");
    $.each(toolbars, function (){
        var dialog = $(this).attr('dialog');
        var needid = $(this).attr('need-row');
        if(dialog != null && dialog != ""){
            $(this).click(function(){
                var row = $('#' + obj.datagrid_id).datagrid('getSelected');
                if(needid == 'yes' && row == null ){
                    return false;
                }
                $('#' + dialog).dialog('open').dialog('center');
                var func = $('#' + dialog).attr('befor-open');
                if(func != null){
                    self[func](row);
                }
            });
        }
        var confirm = $(this).attr('confirm');

        if(confirm != null && confirm != ""){
            var url = $(this).attr('url');
            if(url == null && url == ""){
                throw new Error('当confirm存在时,必须设置url!');
            }
            $(this).click(function(){
                var row = $('#' + obj.datagrid_id).datagrid('getSelected');
                debugger;
                if(needid == 'yes' && row == null ){
                    return false;
                }
                $.messager.confirm('警告','你确定要' + confirm + 'id=' + row.id + '的项?',function(r){
                    if(r){
                        EasyCURDAjax({
                            url:url.replace('{id}',row.id),
                            sscFunc:function(){
                                $("#"+obj.datagrid_id).datagrid('reload');
                            }
                        });
                    }
                });
            });
        }
    });
    return this;
}