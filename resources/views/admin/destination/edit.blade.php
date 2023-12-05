@extends('admin.layout', ['title' => 'Edit Destination'])

@section('style')
    <link rel="stylesheet" href="{{ asset('css/destination.css') }}">
@endsection

@section('content')
    @extends('admin.navigation')
    <div class="container">
        <div class="card">
            <h1 style="text-align: center; margin-bottom: 3rem;">ADD DESTINATION</h1>
            <form action="{{ url('/edit-destination') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $destination->id }}">
                <div class="input-group">
                    <label for="location_name">Location Name</label>
                    <div class="input">
                        <input type="text" name="location_name" placeholder="Location name" id="location_name"
                            value="{{ $destination->location_name ?? old('location_name') }}">
                        @error('location_name')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label for="slug">Slug</label>
                    <div class="input">
                        <input type="text" name="slug" placeholder="Slug" id="slug"
                            value="{{ $destination->slug ?? old('slug') }}">
                        @error('slug')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label for="address">Address</label>
                    <div class="input">
                        <input type="text" name="address" placeholder="Address" id="address"
                            value="{{ $destination->address ?? old('address') }}">
                        @error('address')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label for="category">Category</label>
                    <div class="input">
                        <select name="category" id="category">
                            <option value="" disabled>Wisata Category</option>
                            <option value="alam" @if (old('category') == 'alam' || $destination->category == 'alam') checked @endif>Wisata Alam</option>
                            <option value="buatan" @if (old('category') == 'buatan' || $destination->category == 'buatan') checked @endif>Wisata Buatan</option>
                            <option value="religi" @if (old('category') == 'religi' || $destination->category == 'religi') checked @endif>Wisata Religi</option>
                        </select>
                        @error('category')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label for="description">Description</label>
                    <div class="input">
                        <textarea name="description" placeholder="Description" id="description">{{ $destination->description ?? old('description') }}</textarea>
                        @error('description')
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
