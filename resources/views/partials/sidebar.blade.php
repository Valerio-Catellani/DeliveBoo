@php
    $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    $user = Auth::user();
    if ($restaurant) {
        $data = [
            'restaurant_slug' => $restaurant->slug,
            'user_slug' => $user->slug,
        ];
    }
@endphp

<nav id='sidebar' class=" navbar-dark position-relative sidebar-risize">
    <button id="hype-sidebar-collapse" class="default-button text-white position-absolute"><i
            class="fa-solid fa-caret-left fs-1 hype-text-collapse"></i><i
            class="fa-solid fa-caret-right fs-1 d-none hype-text-collapse"></i></button>
    <a href="http://localhost:5174" class="nav-link text-white d-flex p-3">
        <div class="logo-img-container d-flex align-items-center">
            <img class="img-fluid" src="/images/logo-trasparente.png" alt="logo">
        </div>
        <h2 class="p-3 hype-text-collapse">DeliveBoo</h2>
    </a>
    <ul class="nav flex-column">
        <li class="nav-item  {{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}">
            <a class="nav-link text-white " aria-current="page"
                href="{{ route('admin.dashboard', Auth::user()->slug) }}"><i
                    class="fa-solid fa-home fs-4 pe-3"></i><span class="hype-text-collapse">Dashboard</span></a>
        </li>

        @if ($restaurant)
            <li class="nav-item {{ Route::currentRouteName() === 'admin.restaurants.show' ? 'active' : '' }}">
                <a class="nav-link text-white " aria-current="page" href="{{ route('admin.restaurants.show', $data) }}"><i
                        class="fa-solid fa-utensils fs-4 pe-3"></i><span class="hype-text-collapse">Il mio
                        ristorante</span></a>
            </li>
            <li
                class="nav-item {{ Route::currentRouteName() === 'admin.dishes.index' || Route::currentRouteName() === 'admin.dishes.show' || Route::currentRouteName() === 'admin.dishes.edit' || Route::currentRouteName() === 'admin.dishes.create' ? 'active' : '' }}">
                <a class="nav-link text-white " aria-current="page" href="{{ route('admin.dishes.index', $data) }}">
                    <i class="fa-solid fa-pizza-slice fs-4 pe-3"></i><span class="hype-text-collapse">Il mio menù</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-white " aria-current="page" href="{{ route('admin.orders.showBills', $data) }}">
                    <i class="fa-solid fa-receipt fs-4 pe-3"></i><span class="hype-text-collapse">I miei ordini</span>
                </a>
            </li>
        @endif
        {{--
        <li
            class="nav-item {{ Route::currentRouteName() === 'admin.rooms.index' || Route::currentRouteName() === 'admin.rooms.show' || Route::currentRouteName() === 'admin.rooms.edit' || Route::currentRouteName() === 'admin.rooms.create' ? 'active' : '' }}">
            <a class="nav-link text-white " aria-current="page" href="{{ route('admin.rooms.index') }}"><i
                    class="fa-solid fa-tv fs-4 pe-3"></i><span class="hype-text-collapse">Sale</span></a>
        </li>
        {{--
        <li
            class="nav-item {{ Route::currentRouteName() === 'admin.movies.index' || Route::currentRouteName() === 'admin.movies.show' || Route::currentRouteName() === 'admin.movies.edit' || Route::currentRouteName() === 'admin.movies.create' ? 'active' : '' }}">
            <a class="nav-link text-white " aria-current="page" href="{{ route('admin.movies.index') }}"><i
                    class="fa-solid fa-film fs-4 pe-3"></i><span class="hype-text-collapse">Film</span></a>
        </li>
        <li
            class="nav-item {{ Route::currentRouteName() === 'admin.reviews.index' || Route::currentRouteName() === 'admin.reviews.show' || Route::currentRouteName() === 'admin.reviews.edit' || Route::currentRouteName() === 'admin.reviews.create' ? 'active' : '' }}">
            <a class="nav-link text-white " aria-current="page" href="{{ route('admin.reviews.index') }}"><i
                    class="fa-solid fa-comment fs-4 pe-3"></i><span class="hype-text-collapse">Recensioni</span></a>
        </li>
        <li
            class="nav-item {{ Route::currentRouteName() === 'admin.slots.index' || Route::currentRouteName() === 'admin.slots.show' || Route::currentRouteName() === 'admin.slots.edit' || Route::currentRouteName() === 'admin.slots.create' ? 'active' : '' }}">
            <a class="nav-link text-white " aria-current="page" href="{{ route('admin.slots.index') }}"><i
                    class="fa-solid fa-clock fs-4 pe-3"></i><span class="hype-text-collapse">Fascia Oraria</span></a>
        </li>
        <li
            class="nav-item {{ Route::currentRouteName() === 'admin.projections.index' || Route::currentRouteName() === 'admin.projections.show' || Route::currentRouteName() === 'admin.projections.edit' || Route::currentRouteName() === 'admin.projections.create' ? 'active' : '' }}">
            <a class="nav-link text-white " aria-current="page" href="{{ route('admin.projections.index') }}"><i
                    class="fa-solid fa-clapperboard fs-4 pe-3"></i><span
                    class="hype-text-collapse">Proiezioni</span></a>
        </li> --}}
    </ul>
</nav>