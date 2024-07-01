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
            <img class="img-fluid" src="/images/cinema_paradiso_logo.png" alt="logo">
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
            <li class="nav-item ">
                <a class="nav-link text-white " aria-current="page"
                    href="{{ route('admin.restaurants.show', $data) }}"><i class="fa-solid fa-tv fs-4 pe-3"></i><span
                        class="hype-text-collapse">I miei
                        Ristoranti</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-white " aria-current="page" href="{{ route('admin.dishes.index', $data) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 128 128"><path fill="#ffe082" d="M69.08 10.59c-12.87-2.27-20.67 5.35-21.77 17.72c-.24 2.68-2.38 5.04-4.01 7.15c-5.47 7.11-11.08 14.55-16.82 21.49c-4.98 6.01-9.25 12.53-13.63 18.97C3.74 89.38.14 99.8 5.22 115.79c1.11 3.52 3.65 9.27 8.22 9.05c4.57-.21 5.29-6.02 6.12-9.33c.42-1.7.92-3.72 2.32-4.94c.75-.65 1.38-.44 2.22-.67c.85-.23.92-.4 1.59-.89c1.87-1.37 2.38-.71 3.82.7c2.07 2.03 5.5 1.87 8.12 1.35c1.53-.3 2.03-.63 2.94-1.77c.98-1.24 2.48-2.05 3.35-3.37c.9-1.36.93-1.84 2.59-2.39c3.54-1.17 4.51 1.29 7.04 3.02c2.48 1.7 5.85 2.36 8.78 1.68c1.42-.33 1.83-.72 2.53-1.88c.83-1.39 1.91-2.33 2.91-3.59c1.1-1.4 1.98-2.25 3.49-3.2c1.37-.86 2.6-1.24 4.15-1.73c2.84-.9 5.58-2.15 8.4-3.09c3.67-1.23 7.34-2.46 11.01-3.7c7.22-2.46 14.42-4.97 21.56-7.62c4.08-1.51 8.65-2.71 9.71-7.47c.36-1.61.63-3.24.8-4.88c1.87-17.84-8.7-33.67-22.34-44.31c-6.9-5.38-14.68-9.7-22.9-12.74c-3.15-1.15-7.73-2.57-12.57-3.43"/><path fill="#757f3f" d="M52.39 81.54c-.42 0-.82-.02-1.23-.05c-3.94-.38-7-3.88-7.13-8.16c-.07-2.51 1.08-4.84 3.16-6.38c.52-.39 1.38-.96 2.34-1.32c-.19-.45-.36-.96-.5-1.52c-.38-1.54-.26-3.04.36-4.35c1.03-2.19 3.25-3.68 6.25-4.24c.63-.11 1.32-.17 2.03-.17c1.32 0 4.61.24 6.6 2.45c.68.75 1.12 1.64 1.31 2.63c3.27-.77 6.91.72 8.63 3.59c2.07 3.46 1.76 8.68-2.01 10.95c-1.68 1.01-3.5 1.47-5.75 1.47c-.37 0-.62.02-.89.04c-1.02.04-2.02.04-2.81-.14a3.86 3.86 0 0 1-.83-.3c-.02.04-.04.07-.06.11c-.91 1.45-2.09 3.06-4.44 3.97c-.2.08-.39.19-.57.3c-.45.25-.91.5-1.41.66c-.91.31-1.93.46-3.05.46m-1.18-11.63c-.04.03-.64.32-1.25.77c-.86.63-1.31 1.53-1.29 2.53c.04 1.68 1.16 3.49 2.93 3.67c.84.07 1.73.03 2.36-.18c.22-.07.41-.2.61-.31c.38-.22.76-.42 1.17-.58c.86-.33 1.38-.83 2.2-2.14c.03-.06.06-.14.1-.23c.22-.5.59-1.35 1.47-1.93c.6-.4 1.24-.61 1.92-.61c1.05 0 1.82.51 2.27.8c.08.05.16.12.25.15c.03 0 .24.02.5.02c.28 0 .58-.02.87-.04c.35-.02.7-.04 1.02-.04c1.51 0 2.52-.24 3.47-.81c1.29-.78 1.29-3.14.43-4.58c-.8-1.34-2.68-1.92-4.14-1.29l-.08.08c-.57.4-1.56 1.05-2.73.9a2.75 2.75 0 0 1-1.85-1.1c-.77-1.05-.56-2.25-.44-2.97l.03-.25c.06-.58-.12-.79-.21-.88c-.49-.54-1.76-.91-3.16-.91c-.43 0-.84.04-1.19.1c-1.45.26-2.53.88-2.89 1.65c-.2.42-.14.92-.05 1.27c.18.75.35.98.36.99c.4.24 1.15.74 1.56 1.78c.58 1.45.23 2.46-.17 3.05c-.32.47-1.07 1.25-2.56 1.25c-.37 0-.81-.05-1.21-.12c-.11-.01-.21-.03-.3-.04"/><path fill="#ed6c30" d="M16.75 69.45c.25-2.4 1.77-4.86 5.14-7.03c2.43-1.56 4.94-2.12 7.81-1.72c6.54.9 12.61 4.41 10.73 12.13c-.78 3.21-4.89 5.73-7.78 6.76c-3.52 1.26-7.44 1.11-10.81-.52c-1.52-.73-3.52-2.11-4.41-3.57c-.93-1.53-.87-4.31-.68-6.05"/><path fill="#fff" d="m34.8 66.86l-1.45 2.31l3.48.29l1.16-2.6l-1.74-1.74zm-10.27 2.89l-2.73.16l1.78 3l2.8-.57l.41-2.42zm5.25 5.04L27 74.78l2.02 3.33l2.83-.42l.25-2.57zm7.75-4.19l-.43 1.52l1.81.07l.07-1.45zm-6.64-.06s-1.3 1.23-1.09 1.3c.22.07 2.03.29 2.03.29l.72-1.16zm-9.11 3.32s-1.66 1.74-1.23 1.74c.43 0 1.67-.22 1.67-.22l.72-1.16zm7.92-11.03s-3.02 3.15-2.23 3.15s3.02-.39 3.02-.39l1.31-2.1z"/><path fill="#ed6c30" d="M41.05 41.3c-.15-2.42.95-5.09 3.92-7.79c2.14-1.94 4.53-2.9 7.42-2.98c6.59-.18 13.16 2.28 12.58 10.21c-.23 3.3-3.88 6.46-6.56 7.95c-3.26 1.81-7.15 2.32-10.75 1.27c-1.62-.48-3.82-1.5-4.93-2.8c-1.17-1.36-1.56-4.12-1.68-5.86"/><path fill="#fff" d="m53.56 36.35l-1.45 2.32l3.48.29l1.16-2.61l-1.74-1.74zm-4.77 4.4l-2.73.17l1.78 2.99l2.79-.56l.42-2.43zm9.23 1.82l-2.79-.01l2.03 3.34l2.82-.42l.26-2.57zm-9.76 4.92l1.45-.94l.94.87l-.51.79l-1.09.22zm11.44-7.97l-.43 1.52l1.81.07l.07-1.44zm.94-5.36s-1.3 1.23-1.09 1.3c.22.07 2.03.29 2.03.29l.72-1.16zm-11.01.29s-1.67 1.74-1.23 1.74c.43 0 1.67-.22 1.67-.22l.72-1.16zm-6.73 8.62l-.65 1.16l1.01 1.09s.65-.8.65-1.09c0-.29-.29-1.16-.29-1.16z"/><path fill="#ed6c30" d="M75.86 58.63c.25-2.4 1.77-4.86 5.14-7.03c2.43-1.56 4.94-2.12 7.8-1.72c6.54.9 12.61 4.41 10.74 12.13c-.78 3.21-4.89 5.73-7.78 6.75c-3.52 1.26-7.44 1.11-10.81-.52c-1.52-.73-3.52-2.11-4.41-3.57c-.93-1.52-.87-4.3-.68-6.04"/><path fill="#fff" d="m84.65 54.69l.42 2.7l2.82-2.06l-.82-2.73l-2.46-.18zm-.73 6.45l-1.96 1.9l3.31 1.11l1.75-2.26l-1.28-2.1zm8.17-4.66l-2.11 1.82l3.71 1.2l1.86-2.17l-1.48-2.11zm-.25 7.31l1.45-.95l.94.88l-.5.79l-1.09.22zm-7.32 1.83s-1.3 1.23-1.09 1.3c.22.07 2.03.29 2.03.29l.72-1.16zm-4.86-9.1l-.65 1.16l1.01 1.09s.65-.8.65-1.09c0-.29-.29-1.16-.29-1.16z"/><path fill="#dda450" d="M54.1 25.35c2.9-1.12 5.4.26 8.27 1.3c2.05.75 4.03 1.68 6 2.6c6.07 2.85 12.14 5.69 18.2 8.54c2.96 1.39 5.93 2.79 8.55 4.75c3.09 2.31 5.77 4.96 8.21 7.95c1.96 2.39 3.92 6.64 3.4 9.7c-.29 1.02-1.09.42-1.26.06a35.44 35.44 0 0 0-10.98-12.9c-5.76-4.13-12.61-6.43-19.4-8.49c-1.69-.52-3.42-1.03-4.91-1.98c-1.67-1.06-2.96-2.6-4.46-3.89c-3.54-3.06-8.28-4.7-12.96-4.48c-.99.09-.45-2.39 1.34-3.16"/><path fill="#dda450" d="M125.83 59.5c-1.74-2.88-4.73-4.36-8.01-3.61c-3.08.71-6.79 4.14-8.24 6.96c-1.45 2.81-2.26 7.71-4.97 9.34c-3.13 1.9-7.22 1.32-10.54 2.86c-2.18 1.02-4.7 2.45-6.78 3.67c-3.04 1.79-5.86 2.51-9.34 3.11c-3.48.6-7.91 1.74-10.04 4.56c-.77 1.03-1.29 2.23-2.09 3.24c-3.12 3.98-6.82 1.57-11.81.73c-1.59-.27-3.61-.44-5.16 0c-1.64.46-4.83 2.84-6.34 3.64c-3.78 2.02-8.08.16-12.01 1.87c-5.19 2.26-7.88 8.07-12.57 11.25c-2.67 1.81-6.05 2.69-9.19 1.96c-2.37-.55-4.54-2.1-5.75-4.19c.25 3.38.96 6.97 2.21 10.9c1.11 3.52 3.65 9.27 8.22 9.05c4.57-.21 5.29-6.02 6.12-9.33c.42-1.7.92-3.72 2.32-4.94c.75-.65 1.38-.44 2.22-.67c.85-.23.92-.4 1.59-.89c1.87-1.37 2.38-.71 3.82.7c2.07 2.03 5.5 1.87 8.12 1.35c1.53-.3 2.03-.63 2.94-1.77c.98-1.24 2.48-2.05 3.35-3.37c.9-1.36.93-1.84 2.59-2.39c3.54-1.17 4.51 1.29 7.04 3.02c2.48 1.7 5.85 2.36 8.78 1.68c1.42-.33 1.83-.72 2.53-1.88c.83-1.39 1.91-2.33 2.91-3.59c1.1-1.4 1.98-2.25 3.49-3.2c1.37-.86 2.6-1.24 4.15-1.73c2.84-.9 5.58-2.15 8.4-3.09c3.67-1.23 7.34-2.46 11.01-3.7c7.22-2.46 14.42-4.97 21.56-7.62c4.08-1.51 8.65-2.71 9.71-7.47c.36-1.61.63-3.24.8-4.88c.12-1.15.19-2.3.21-3.43c.01-2.45.08-5.95-1.25-8.14"/></svg><span class="hype-text-collapse">Il mio menù</span>
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
