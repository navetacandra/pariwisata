<!DOCTYPE html>
<html>

<head>
    <title>{{ \Illuminate\Support\Facades\DB::table('app')->first()->name }} - {{ $title }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <style>
        nav .brand a {
            text-decoration: none;
            color: #fff;
        }

        footer {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            position: relative;
            padding: 5rem 2rem 1rem 2rem;
            bottom: 0;
            left: 0;
            width: 100vw;
            min-height: 10rem;
            background: #fafafa;
            box-shadow: 2px 0 0 4px rgba(0, 0, 0, .1);
        }

        footer div {
            display: flex;
            flex-direction: column;
            justify-content: start;
            padding: 1rem 2rem;
            width: 45%;
        }

        .site-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
    </style>
    @yield('style')
</head>

<body>
    <nav>
        <input type="checkbox" name="nav-menu-show" id="nav-menu-show">
        <div class="brand">
            <a href="{{ route('home') }}">{{ \Illuminate\Support\Facades\DB::table('app')->first()->name }}</a>
        </div>
        <ul class="menu">
            <li><a href="{{ route('category', ['category' => 'alam']) }}">Wisata Alam</a></li>
            <li><a href="{{ route('category', ['category' => 'buatan']) }}">Wisata Buatan</a></li>
            <li><a href="{{ route('category', ['category' => 'religi']) }}">Wisata Religi</a></li>
        </ul>
        <label class="nav-menu-toggler" for="nav-menu-show">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </nav>
    @yield('content')
    <footer>
        <div>
            <p class="site-name">{{ \Illuminate\Support\Facades\DB::table('app')->first()->name }}</p>
            <p>{{ \Illuminate\Support\Facades\DB::table('app')->first()->address }}</p>
        </div>
        <div>
            <p>{{ \Illuminate\Support\Facades\DB::table('app')->first()->about }}</p>
        </div>
    </footer>
</body>

</html>
