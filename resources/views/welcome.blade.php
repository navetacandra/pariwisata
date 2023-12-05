@extends('layout', ['title' => 'Home'])

@section('style')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('content')
    <div class="content">
        <div class="hero">
            <div class="overlay">
                <div class="prev-btn">&lt;</div>
                <div class="next-btn">&gt;</div>
            </div>
            <div class="slider">
                @foreach ($galleries as $gallery)
                    <div class="img-container"
                        style="background: url({{ asset('storage/' . $gallery->image) }}); background-repeat: no-repeat; background-size: cover; background-position: center;">
                    </div>
                @endforeach
            </div>
        </div>

        <section class="app-detail">
            <div>
                <img src="{{ asset('storage/' . \Illuminate\Support\Facades\DB::table('app')->first()->logo) }}"
                    alt="" class="app-logo">
            </div>
            <div>
                <p class="app-name">{{ \Illuminate\Support\Facades\DB::table('app')->first()->name }}</p>
                <p>{{ \Illuminate\Support\Facades\DB::table('app')->first()->about }}</p>
            </div>
        </section>

        <div class="wisata-list">
            @foreach ($destinations as $destination)
                <div class="wisata-card" data-destination="{{ $destination->slug }}">
                    <div class="wisata-image-overlay"></div>
                    <div class="wisata-image"
                        style="background: url({{ asset('storage/' . $destination->image) }}); background-repeat: no-repeat; background-size: cover; background-position: center;">
                    </div>
                    <div class="wisata-category">Wisata {{ Str::ucfirst($destination->category) }}</div>
                    <p class="wisata-name">{{ $destination->location_name }}</p>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        let showIndex = 0;
        const slider = document.querySelector('.slider');
        const imgs = document.querySelectorAll('.hero .img-container');

        document.querySelectorAll('.wisata-card')?.forEach(card => {
            const destination = card.getAttribute('data-destination');
            card.addEventListener('click', () => {
                if (!destination) return;
                window.open("{{ url('/destination/') }}/" + destination, "_self")
            })
        })

        document.querySelector('.hero .next-btn').addEventListener('click', el => {
            showIndex++;
            if (showIndex > imgs.length - 1) showIndex = 0;
            const nextPos = imgs[showIndex].getBoundingClientRect().width * showIndex;
            slider.scrollLeft = nextPos;
        });

        document.querySelector('.hero .prev-btn').addEventListener('click', el => {
            showIndex--;
            if (showIndex < 0) showIndex = imgs.length - 1;
            const nextPos = imgs[showIndex].getBoundingClientRect().width * showIndex;
            slider.scrollLeft = nextPos;
        });

        window.onresize = () => {
            const currPos = imgs[showIndex].getBoundingClientRect().width * showIndex;
            slider.scrollLeft = currPos;
        }

        window.onscroll = () => {
            const distance = window.scrollY;
            if (distance > 16) document.querySelector('nav').style['background-color'] = 'rgba(0, 0, 0, .3)';
            else document.querySelector('nav').style['background-color'] = 'rgba(0, 0, 0, .1)';

            document.querySelector('.hero').style.transform = `translateY(${distance}px)`
            document.querySelector('.overlay').style.transform = `translateY(${distance * -.5}px)`
            document.querySelector('.img-container').style.transform = `translateY(${distance * -.3}px)`
        }
    </script>
@endsection
