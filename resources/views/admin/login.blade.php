@extends('admin.layout', ['title' => 'Login'])

@section('style')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h1 style="text-align: center; margin-bottom: 3rem;">LOGIN</h1>
            <form action="{{ url('/login') }}" method="post">
                @csrf
                <div class="input-group">
                    <label for="username">Username</label>
                    <div class="input">
                        <input type="text" name="username" placeholder="Username" id="username">
                        @error('username')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input">
                        <input type="password" name="password" placeholder="Password" id="password">
                        <small class="prefix-btn" id="show-pass">Show</small>
                        @error('password')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <button type="submit">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.querySelector('#show-pass').addEventListener('click', (e) => {
            const pass = e.target.parentElement.querySelector('#password');
            if (pass.getAttribute('type') == 'password') {
                e.target.innerText = 'Hide';
                pass.setAttribute('type', 'text');
            } else {
                e.target.innerText = 'Show';
                pass.setAttribute('type', 'password');
            }
        });
    </script>
@endsection
