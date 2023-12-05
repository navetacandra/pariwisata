@extends('admin.layout', ['title' => 'Add Destination'])

@section('style')
    <link rel="stylesheet" href="{{ asset('css/destination.css') }}">
@endsection

@section('content')
    @extends('admin.navigation')
    <div class="container">
        <div class="card">
            <h1 style="text-align: center; margin-bottom: 3rem;">EDIT GALLERY</h1>
            <form action="{{ url('/edit-gallery') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $gallery->id }}">
                <div class="input-group">
                    <label for="destination_id">Destination</label>
                    <div class="input">
                        <select name="destination_id" id="destination_id">
                            <option value="" @if($gallery->destination_id == null || old('destination_id') == null) selected @endif>NULL</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->id }}" @if (old('destination_id') == $destination->id || $gallery->destination_id == $destination->id) selected @endif>
                                    {{ $destination->location_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('destination_id')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label for="image">Description</label>
                    <div class="input">
                        <label for="des_image">Upload Image</label>
                        <input type="file" name="image" id="des_image" value="{{ old('image') }}">
                        <p id="filename"></p>
                        @error('image')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <button type="submit">ADD</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.querySelector('#des_image').addEventListener('change', (e) => {
            e.target.parentElement.querySelector('#filename').innerText = e.target.files[0].name;
        })
    </script>
@endsection
