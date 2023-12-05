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
                <th>Location Name</th>
                <th>Slug</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            @foreach ($destinations as $idx => $destination)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $destination->location_name }}</td>
                    <td>{{ $destination->slug }}</td>
                    <td>{{ $destination->address }}</td>
                    <td>
                        <div class="actions">
                            <form action="{{ url('/delete-destination') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $destination->id }}">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                            <a href="{{ route('admin.edit-destination', ['slug' => $destination->slug]) }}"
                                class="edit-btn">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
