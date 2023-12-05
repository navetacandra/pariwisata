@extends('admin.layout', ['title' => 'Dashboard'])

@section('style')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
    @extends('admin.navigation')
    <div class="content">
        <form action="{{ url('/update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <label for="name">Site Name</label>
                <div class="input">
                    <input type="text" name="name" id="name" value="{{ old('name') ?? $data->name }}">
                </div>
            </div>
            <div class="input-group">
                <label for="about">About</label>
                <div class="input">
                    <textarea type="text" name="about" id="about">{{ old('about') ?? $data->about }}</textarea>
                </div>
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <div class="input">
                    <textarea type="text" name="address" id="address">{{ old('address') ?? $data->address }}</textarea>
                </div>
            </div>
            <div class="input-group">
                <label for="image">Site Icon</label>
                <div class="input">
                    <label for="image" class="image_label">Upload Image</label>
                    <input type="file" name="image" id="image">
                    <p class="filename"></p>
                </div>
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
    <script>
        document.querySelector('#image').addEventListener('change', el => {
            el.target.parentElement.querySelector('.filename').innerText = el.target.files[0].name;

        })
    </script>
@endsection
