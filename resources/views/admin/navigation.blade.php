<style>
    #sidemenu-show {
        display: none;
    }

    nav {
        z-index: 2;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 1.5rem;
        background-color: rgba(0, 0, 0, .3);
        color: #fff;
        box-shadow: none;
    }

    nav .brand a {
        text-decoration: none;
        color: #fff;
    }

    .nav-menu-toggler:hover,
    .nav-menu-toggler:focus {
        background-color: #dddddd99;
    }

    .nav-menu-toggler {
        cursor: pointer;
        padding: 1rem 2rem;
    }

    .nav-menu-toggler span {
        display: block;
        width: 1rem;
        height: .2rem;
        background-color: #fff;
        border-radius: 25%;
        margin: 2.8px auto;
        transition: all ease 1.25s;
    }

    .sidemenu {
        z-index: 3;
        position: fixed;
        top: 0;
        left: -100%;
        width: 40vw;
        height: 100vh;
        background-color: rgb(0, 85, 255);
        color: #fff;
        transition: all ease 1s;
    }

    .sidemenu .brand {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 2rem;
        font-size: 1.3rem;
    }

    .sidemenu .brand a {
        text-decoration: none;
        color: #fff;
    }

    .sidemenu .close {
        cursor: pointer;
        font-size: 1.75rem;
    }

    .sidemenu .menu {
        margin-top: 3rem;
    }

    .sidemenu .menu li a {
        display: block;
        text-decoration: none;
        padding: 1rem 1rem;
        background-color: inherit;
        color: #fff;
        transition: all ease .2s;
    }

    .sidemenu .menu li a:hover {
        font-size: 1.15rem;
        background-color: rgb(1, 70, 207);
    }

    .sidemenu .menu li a.active {
        background-color: rgb(1, 70, 207);
    }

    .dropdown-btn {
        position: relative;
    }

    .dropdown-btn::after {
        content: '';
        position: absolute;
        top: 50%;
        transform: translateY(-50%) rotate(-90deg);
        right: 1rem;
        width: 0;
        height: 0;
        border-right: .25rem solid transparent;
        border-left: .25rem solid transparent;
        border-top: .5rem solid #fff;
        transition: all ease .3s;
    }

    .dropdown-btn:hover::after,
    .dropdown-btn:focus::after {
        transform: rotate(0deg);
    }

    .dropdown-btn:hover~.dropdown-menu,
    .dropdown-btn:focus~.dropdown-menu,
    .dropdown-menu:hover,
    .dropdown-menu:focus,
    .dropdown-menu.active,
    .dropdown-menu.active {
        display: block;
    }

    .dropdown-menu {
        display: none;
        list-style: none;
    }

    .dropdown-menu li a {
        padding: 1rem 2rem !important;
    }

    .sidemenu-overlay {
        z-index: 1;
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, .4);
        overscroll-behavior: contain;
        animation: fade ease 1.5s;
    }

    @keyframes fade {
        from {
            opacity: .4;
        }

        to {
            opacity: 1;
        }
    }

    #sidemenu-show:checked~.sidemenu-overlay {
        display: block;
    }

    #sidemenu-show:checked~.sidemenu {
        left: 0;
    }

    #sidemenu-show:checked~nav .nav-menu-toggler span:nth-child(1) {
        transform: rotate(45deg) translateY(.25rem) translateX(.25rem);
    }

    #sidemenu-show:checked~nav .nav-menu-toggler span:nth-child(3) {
        transform: rotate(-45deg);
    }

    #sidemenu-show:checked~nav .nav-menu-toggler span:nth-child(2) {
        display: none;
    }

    @media screen and (max-width: 768px) {
        #sidemenu-show:checked~.sidemenu {
            width: 100%;
        }
    }
</style>

<input type="checkbox" name="sidemenu-show" id="sidemenu-show">
<nav>
    <div class="brand">
        <a href="{{ url('/dashboard') }}">{{ \Illuminate\Support\Facades\DB::table('app')->first()->name }}</a>
    </div>
    <label class="nav-menu-toggler" for="sidemenu-show">
        <span></span>
        <span></span>
        <span></span>
    </label>
</nav>
<aside class="sidemenu">
    <div class="brand">
        <a href="{{ url("/dashboard") }}">{{ \Illuminate\Support\Facades\DB::table('app')->first()->name }}</a>
        <label for="sidemenu-show" class="close">&times;</span>
    </div>
    <ul class="menu">
        <li>
            <a href="#" class="dropdown-btn">Destination</a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('admin.list-destination') }}">List</a>
                </li>
                <li>
                    <a href="{{ route('admin.add-destination') }}">Add</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" class="dropdown-btn">Gallery</a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('admin.list-gallery') }}">List</a>
                </li>
                <li>
                    <a href="{{ route('admin.add-gallery') }}">Add</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<div class="sidemenu-overlay"></div>

<script>
    document.querySelector('.sidemenu-overlay')?.addEventListener('click', () => {
        document.querySelector('#sidemenu-show').checked = false;
    })

    const sidemenuLinks = document.querySelectorAll('.sidemenu .menu li a');
    sidemenuLinks?.forEach(link => {
        if (window.location.href === link.getAttribute('href')) {
            link.parentElement.parentElement.classList.add('active')
            link.classList.add('active')
        }
    });
</script>
