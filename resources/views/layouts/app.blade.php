<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="/themes/bootstrap/easyui.css">
    <link rel="stylesheet" type="text/css" href="/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/themes/IconExtension.css">
    <link rel="stylesheet" type="text/css" href="/css/home.css">
    <!-- 加载 easyui -->
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/locale/easyui-lang-zh_CN.js"></script>
    <script type="text/javascript" src="/js/home.js"></script>
    <script type="text/javascript" src="/js/curd.js"></script>
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?>
    </script>
    <style type="text/css">
        body{
            padding:2px;
            margin: 0px;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
