@extends('layouts.app')

@section('content')
    <form id="login-form" role="form" method="POST" action="{{ url('/login') }}">
        <div class="easyui-panel" title="登录" style="margin:0 auto;width:100%;max-width:360px;padding:30px 60px;">
            {{ csrf_field() }}
            <div style="margin-bottom:10px">
                <label for="email" class="label-top">电子邮箱:</label>
                <input class="easyui-textbox " id="email" name="email" value="{{ old('email') }}"
                       data-options="iconCls:'icon-man',prompt:'邮箱'
                        ,required:true,validType:['email','length[0,32]']
                        " style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <label for="password" class="label-top">密码:</label>
                <input class="easyui-textbox " id="password" type="password" name="password"
                       data-options="iconCls:'icon-lock',prompt:'输入密码'
                        ,required:true,validType:['string','length[6,32]']
                        " style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <label>
                    <input type="checkbox" name="remember"> 记住我
                </label>
            </div>
            <div class="error-message hidden-2-sec">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email')}}</strong><br/>
                    </span>
                @endif
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong><br/>
                    </span>
                @endif
            </div>
            <div style="margin-bottom:10px">
                <label>
                    <a href="javascript:void(0);" class="easyui-linkbutton" id="submit-form">登录</a>
                </label>
            </div>
        </div>
    </form>
    <style scoped="scoped">
        .tb{
            width:100%;
            margin:0;
            padding:5px 4px;
            border:1px solid #ccc;
            box-sizing:border-box;
        }
        .error-message{
            margin: 4px 0 0 0;
            padding: 0;
            color: red;
        }
    </style>
    <script type="text/javascript">
        $(function(){
            // 两秒钟自动隐藏
            setTimeout("$('.hidden-2-sec').hide(500);",2000);
            $("#submit-form").click(function(){
                if($("#login-form").form('enableValidation').form('validate')){
                    $("#login-form").submit();
                }
            });
        });
    </script>
@endsection
