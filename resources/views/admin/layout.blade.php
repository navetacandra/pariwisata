<!DOCTYPE html>
<html>

<head>
    <title>{{ \Illuminate\Support\Facades\DB::table('app')->first()->name }} - {{ $title }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    @yield('style')
</head>

<body>
    @yield('content')
</body>

</html>
