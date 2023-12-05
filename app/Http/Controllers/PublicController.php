<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gallery;
use App\Models\Destination;
use App\Models\Comment;

class PublicController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        $galleries = Gallery::all();
        return view('welcome', compact('destinations', 'galleries'));
    }

    public function category($category)
    {
        $destinations = Destination::where('category', $category)->get();
        $galleries = Gallery::all();
        return view('welcome', compact('destinations', 'galleries'));
    }

    public function destination_detail($slug)
    {
        $destination = Destination::where('slug', $slug);

        if (!$destination->exists()) {
            echo '
            <script>alert("Destinasi tidak di-temukan!"); window.location.href = "' . route('home') . '";</script>
            ';
        }

        $destination = Destination::with('comments')->where('slug', $slug)->orderBy('created_at')->get()->first();
        $q_replies = Comment::where('destination_id', $destination->id)->whereNotNull('comment_id')->orderBy('created_at')->get();

        $data = [];

        foreach ($destination->comments as $key => $comment) {
            $replies = [];
            foreach ($q_replies->toArray() as $i => $reply) {
                if($reply['comment_id'] == $comment->id) {
                    array_push($replies, $reply);
                }
            }
            $destination->comments[$key]->replies = $replies;
        }

        return view('details', compact('destination'));
    }

    public function post_comment(Request $request)
    {
        $error = [];
        $validator = Validator::make($request->all(), [
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required',
            'content' => 'required|min:10',
        ], [
            'destination_id.required' => 'Destination is required!',
            'destination_id.exists' => 'Destination is doesn\'t exists!',
            'name.required' => 'Name is required!',
            'content.required' => 'Comment is required!',
            'content.min' => 'Comment minimum length is 10!',
        ]);

        if ($request->comment_id) {
            if (!Comment::where('id', $request->comment_id)->exists()) {
                $error['comment_id'] = 'Comment doesn\'t exists!';
            }
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else if (count($error) > 1) {
            return redirect()->back()->withErrors($error)->withInput();
        }

        if (Comment::create($request->all())) {
            return redirect()->back()->with('success', 'Comment has been posted!');
        } else {
            return redirect()->back()->with('error', 'Failed post comment!');
        }
    }
}
