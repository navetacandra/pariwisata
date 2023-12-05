@extends('admin.layout', ['title' => 'Destinations List'])

@section('style')
    <link rel="stylesheet" href="{{ asset('css/destination.css') }}">
@endsection

@section('content')
    @extends('admin.navigation')
    <div class="container">
        <table>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Destination</th>
                <th>Actions</th>
            </tr>
            @foreach ($galleries as $idx => $gallery)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $gallery->image) }}" target="_blank">{{ $gallery->image }}</a>
                    </td>
                    <td>{{ $gallery->location_name ?? "NULL" }}</td>
                    <td>
                        <div class="actions">
                            <form action="{{ url('/delete-gallery') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $gallery->id }}">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                            <a href="{{ route('admin.edit-gallery', ['id' => $gallery->id]) }}"
                                class="edit-btn">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
