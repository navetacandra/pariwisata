<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'login');
    }

    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users',
            'password' => 'required|min:8|max:24',
        ], [
            'username.required' => 'Username is required!',
            'username.exists' => 'User not found!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password minimum length is 8!',
            'password.max' => 'Password maximum length is 24!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->except('_token'))) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->withErrors(['username' => 'Wrong username or password!']);
        }
    }

    public function dashboard()
    {
        $data = DB::table('app')->first();
        return view('admin.dashboard', compact('data'));
    }

    public function update_app(Request $request)
    {
        $error = [];
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'about' => 'required|min:10',
            'address' => 'required',
        ], [
            'name.required' => "Name is required!",
            'about.required' => "About is required!",
            'about.min' => "About minimum length is 10!",
            'address.required' => "Address is required!",
        ]);
        $image = $request->file('image');

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($image) {
            if (explode('/', $image->getMimeType())[0] != 'image' && !in_array('image', $error)) {
                $error['image'] = 'Image must be an image!';
            }

            if (!in_array(explode('/', $image->getMimeType())[1], ['jpg', 'jpeg', 'png']) && !in_array('image', $error)) {
                $error['image'] = 'Image must be jpg, jpeg, or png!';
            }

            if ($image->getSize() / 1000 > 4096 && !in_array('image', $error)) {
                $error['image'] = 'Image maximum size is 4MB!';
            }
        }

        if (count($error) > 0) {
            return redirect()->back()->withErrors($error)->withInput();
        }

        $data = $request->except('_token', 'image', 'id');

        if ($image) {
            $saved_image = $image->storeAs('app', 'logo.' . $image->clientExtension(), ['disk' => 'public']);

            if (!$saved_image) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image!'])->withInput();
            }

            $data['image'] = $saved_image;
        }

        if (DB::table('app')->update($data)) {
            return redirect()->back()->with('success', 'App data has been updated!');
        } else {
            return redirect()->back()->with('success', 'App data failed to updated!');
        }
    }

    public function list_destination()
    {
        $destinations = Destination::all();
        return view('admin.destination.list', compact('destinations'));
    }

    public function add_destination()
    {
        return view('admin.destination.add');
    }

    public function delete_destination(Request $request)
    {
        $destination = Destination::find($request->id);
        if (!$destination->exists()) {
            echo '<script>alert("Destinasi not found!"); window.location.href = "' . route('admin.list-destination') . '"</script>';
            return;
        }
        Storage::disk('public')->delete($destination->get()->first()->image);
        $destination->delete();
        return redirect()->route('admin.list-destination');
    }

    public function store_destination(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location_name' => 'required',
            'address' => 'required',
            'slug' => 'required|unique:destinations',
            'category' => 'required|in:alam,buatan,religi',
            'description' => 'required|min:10',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ], [
            'location_name.required' => 'Location name is required!',
            'address.required' => 'Address is required!',
            'slug.required' => 'Slug is required!',
            'slug.unique' => 'Slug already used!',
            'category.required' => 'Category is required!',
            'category.in' => 'Invalid category!',
            'description.required' => 'Description is required!',
            'description.min' => 'Description minimum length is 10!',
            'image.required' => 'Image is required!',
            'image.image' => 'Image must be an image!',
            'image.mimes' => 'Image must be jpg, jpeg, or png!',
            'image.max' => 'Image maximum size is 4MB!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $image = $request->file('image');
        $saved_image = $image->storeAs('destination', time() . '.' . $image->clientExtension(), ['disk' => 'public']);

        if (!$saved_image) {
            return redirect()->back()->withErrors(['image' => 'Failed to upload image!'])->withInput();
        }

        $data = $request->except('_token', 'image');
        $data['image'] = $saved_image;

        if (Destination::create($data)) {
            return redirect()->route('admin.dashboard')->with('success', 'Destination added successfully!');
        } else {
            return redirect()->back()->withErrors(['name' => 'Failed to add destination!'])->withInput();
        }
    }

    public function edit_destination($slug)
    {
        $destination = Destination::where('slug', $slug);
        if (!$destination->exists()) {
            echo '<script>alert("Destinasi not found!"); window.location.href = "' . route('admin.list-destination') . '"</script>';
            return;
        }

        $destination = $destination->get()->first();
        return view('admin.destination.edit', compact('destination'));
    }

    public function update_destination(Request $request)
    {
        $error = [];
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:destinations',
            'location_name' => 'required',
            'address' => 'required',
            'slug' => 'required',
            'category' => 'required|in:alam,buatan,religi',
            'description' => 'required|min:10',
        ], [
            'location_name.required' => 'Location name is required!',
            'address.required' => 'Address is required!',
            'slug.required' => 'Slug is required!',
            'slug.unique' => 'Slug already used!',
            'category.required' => 'Category is required!',
            'category.in' => 'Invalid category!',
            'description.required' => 'Description is required!',
            'description.min' => 'Description minimum length is 10!',
        ]);
        $image = $request->file('image');
        $dest = Destination::find($request->id);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Destination::where('slug', $request->slug)->where('id', '!=', $request->id)->exists()) {
            $error['slug'] = 'Slug already used!';
        }

        if ($image) {
            if (explode('/', $image->getMimeType())[0] != 'image' && !in_array('image', $error)) {
                $error['image'] = 'Image must be an image!';
            }

            if (!in_array(explode('/', $image->getMimeType())[1], ['jpg', 'jpeg', 'png']) && !in_array('image', $error)) {
                $error['image'] = 'Image must be jpg, jpeg, or png!';
            }

            if ($image->getSize() / 1000 > 4096 && !in_array('image', $error)) {
                $error['image'] = 'Image maximum size is 4MB!';
            }
        }

        if (count($error) > 0) {
            return redirect()->back()->withErrors($error)->withInput();
        }

        $data = $request->except('_token', 'image', 'id');

        if ($image) {
            $saved_image = $image->storeAs('destination', time() . '.' . $image->clientExtension(), ['disk' => 'public']);

            if (!$saved_image) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image!'])->withInput();
            }

            Storage::disk('public')->delete($dest->get()->first()->image);
            $data['image'] = $saved_image;
        }

        if ($dest->update($data)) {
            return redirect()->route('admin.list-destination');
        } else {
            return redirect()->back()->withErrors(['location_name' => 'Failed to update destination!'])->withInput();
        }
    }

    public function list_gallery()
    {
        $galleries = Gallery::leftJoin('destinations', 'gallery.destination_id', '=', 'destinations.id')->select('gallery.*', 'destinations.location_name')->get();
        return view('admin.gallery.list', compact('galleries'));
    }

    public function delete_gallery(Request $request)
    {
        $gallery = Gallery::find($request->id);

        if (!$gallery->exists()) {
            echo '<script>alert("Gallery not found!"); window.location.href = "' . route('admin.list-gallery') . '"</script>';
            return;
        }

        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();
        return redirect()->route('admin.list-gallery');
    }

    public function add_gallery()
    {
        $destinations = Destination::select('id', 'location_name')->get();
        return view('admin.gallery.add', compact('destinations'));
    }

    public function store_gallery(Request $request)
    {
        $error = [];
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ], [
            'image.required' => 'Image is required!',
            'image.image' => 'Image must be an image!',
            'image.mimes' => 'Image must be jpg, jpeg, or png!',
            'image.max' => 'Image maximum size is 4MB!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->destination_id && !Destination::find($request->destination_id)->exists()) {
            $error['destination_id'] = 'Destination not found!';
        }

        $image = $request->file('image');
        $saved_image = $image->storeAs('gallery', time() . '.' . $image->clientExtension(), ['disk' => 'public']);

        if (!$saved_image) {
            return redirect()->back()->withErrors(['image' => 'Failed to upload image!'])->withInput();
        }

        $data = $request->except('_token', 'image');
        $data['image'] = $saved_image;

        if (Gallery::create($data)) {
            return redirect()->route('admin.list-gallery');
        } else {
            return redirect()->back()->withErrors(['location_name' => 'Failed to add destination!'])->withInput();
        }
    }

    public function edit_gallery($id)
    {
        $destinations = Destination::select('id', 'location_name')->get();
        $gallery = Gallery::find($id);
        if (!$gallery->exists()) {
            echo '<script>alert("Gallery not found!"); window.location.href = "' . route('admin.list-destination') . '"</script>';
            return;
        }

        $gallery = $gallery->get()->first();
        return view('admin.gallery.edit', compact('gallery', 'destinations'));
    }

    public function update_gallery(Request $request)
    {
        $error = [];
        $gallery = Gallery::find($request->id);
        $image = $request->file('image');
        $data = $request->except('_token', 'image', 'id');

        if (!$gallery->exists()) {
            echo '<script>alert("Gallery not found!"); window.location.href = "' . route('admin.list-destination') . '"</script>';
            return;
        }

        if(!$request->destination_id && $gallery->first()->destination_id != null) {
            $data['destination_id'] = null;
        }

        if ($request->destination_id && !Destination::find($request->destination_id)->exists()) {
            $error['destination_id'] = 'Destination not found!';
        }

        if ($image) {
            if (explode('/', $image->getMimeType())[0] != 'image' && !in_array('image', $error)) {
                $error['image'] = 'Image must be an image!';
            }

            if (!in_array(explode('/', $image->getMimeType())[1], ['jpg', 'jpeg', 'png']) && !in_array('image', $error)) {
                $error['image'] = 'Image must be jpg, jpeg, or png!';
            }

            if ($image->getSize() / 1000 > 4096 && !in_array('image', $error)) {
                $error['image'] = 'Image maximum size is 4MB!';
            }
        }

        if (count($error) > 0) {
            return redirect()->back()->withErrors($error)->withInput();
        }

        if ($image) {
            $saved_image = $image->storeAs('destination', time() . '.' . $image->clientExtension(), ['disk' => 'public']);

            if (!$saved_image) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image!'])->withInput();
            }

            Storage::disk('public')->delete($gallery->get()->first()->image);
            $data['image'] = $saved_image;
        }

        if ($gallery->update($data)) {
            return redirect()->route('admin.list-gallery');
        } else {
            return redirect()->back()->withErrors(['destination_id' => 'Failed to update destination!'])->withInput();
        }
    }
}
