<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToDo App</title>
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>

<div class="container">
    @yield('content')
</div>
<div class="footer">
<p>For any query please contact</p>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript" src="/js/app.js"></script>

</body>
</html>
