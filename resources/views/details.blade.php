@extends('layout', ['title' => $destination->location_name])

@section('style')
    <link rel="stylesheet" href="{{ asset('css/details.css') }}">
@endsection

@section('content')
    <div class="content">
        <div class="main-details">
            <div class="img-thumbnail"
                style="background: url( {{ asset('storage/' . $destination->image) }} ); background-repeat: no-repeat; background-size: cover;">
            </div>
            <div class="detail">
                <p class="wisata-category">Wisata {{ Str::ucfirst($destination->category) }}</p>
                <p class="location-name">{{ $destination->location_name }}</p>
                <p>{{ $destination->address }}</p>
            </div>
        </div>
        <div class="description">
            <p>{{ $destination->description }}</p>
        </div>
    </div>

    <div class="comment-section">
        <form action="{{ url('/post-comment') }}" method="POST">
            @csrf
            <input type="hidden" name="destination_id" value="{{ $destination->id }}">
            <div class="input-group">
                <label for="name">Name</label>
                <div class="input">
                    <input type="text" name="name" id="name" placeholder="Name"
                        value="{{ !old('comment_id') ? old('name') : '' }}">
                    @if (!old('comment_id'))
                        @error('name')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    @endif
                </div>
            </div>
            <div class="input-group">
                <label for="content">Comment</label>
                <div class="input">
                    <textarea name="content" id="content" placeholder="Your Comment">{{ !old('comment_id') ? old('content') : '' }}</textarea>
                    @if (!old('comment_id'))
                        @error('content')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    @endif
                </div>
            </div>
            <div class="input-group">
                <button type="submit">Send</button>
            </div>
        </form>
        <ul class="comments">
            @foreach ($destination->comments as $comment)
                <li class="comment">
                    <p class="name">{{ $comment->name }}</p>
                    <p>{{ $comment->content }}</p>
                    <div class="actions">
                        @if (count($comment->replies) > 0)
                            <small class="show-reply">Show Replies</small>
                        @endif
                        <small class="reply">Reply</small>
                    </div>
                    <ul class="replies {{ old('comment_id') && old('comment_id') == $comment->id ? '' : 'hidden' }}">
                        <li class="reply-form hidden">
                            <form action="{{ url('/post-comment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                <div class="input-group">
                                    <label for="name">Name</label>
                                    <div class="input">
                                        <input type="text" name="name" id="name" placeholder="Name"
                                            value="{{ old('comment_id') && request()->comment_id == $comment->id ? old('name') : '' }}">
                                        @if (old('comment_id') && old('comment_id') == $comment->id)
                                            @error('name')
                                                <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="content">Comment</label>
                                    <div class="input">
                                        <textarea name="content" id="content" placeholder="Your Comment">{{ old('comment_id') && request()->comment_id == $comment->id ? old('content') : '' }}</textarea>
                                        @if (old('comment_id') && old('comment_id') == $comment->id)
                                            @error('content')
                                                <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group">
                                    <button type="submit">Send</button>
                                </div>
                            </form>
                        </li>
                        @foreach ($comment->replies as $reply)
                            <li class="reply hidden">
                                <p class="name">{{ $reply['name'] }}</p>
                                <p>{{ $reply['content'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        document.querySelectorAll('.comment')?.forEach(comment => {
            comment.querySelector('.reply')?.addEventListener('click', (el) => {
                const isRepliesShowed = !comment.querySelector('.replies').className.includes('hidden');
                const isShowed = !comment.querySelector('.replies .reply-form').className.includes(
                    'hidden');
                if (comment.querySelector('.show-reply')) comment.querySelector('.show-reply').innerText =
                    'Show Replies';

                if (isRepliesShowed && !isShowed) {
                    comment.querySelectorAll('.replies .reply')?.forEach(rep => {
                        rep.classList.add('hidden');
                    })
                } else {
                    comment.querySelector('.replies').classList.toggle('hidden');
                }

                comment.querySelector('.replies .reply-form')?.classList.toggle('hidden');
            });

            comment.querySelector('.show-reply')?.addEventListener('click', (el) => {
                const isRepliesShowed = !comment.querySelector('.replies').className.includes('hidden');
                const isShowed = !comment.querySelector('.replies .reply').className.includes('hidden');

                if (isRepliesShowed && !isShowed) {
                    comment.querySelector('.replies .reply-form')?.classList.add('hidden');
                } else {
                    comment.querySelector('.replies').classList.toggle('hidden');
                }

                el.target.innerText = isShowed ? 'Show Replies' : 'Hide Replies';

                comment.querySelectorAll('.replies .reply')?.forEach(rep => {
                    rep.classList.toggle('hidden');
                })
            });
        });

        window.onscroll = () => {
            if (window.scrollY > 16) document.querySelector('nav').style['background-color'] = 'rgba(0, 0, 0, .3)';
            else document.querySelector('nav').style['background-color'] = 'rgba(0, 0, 0, .1)';
        }
    </script>
@endsection
