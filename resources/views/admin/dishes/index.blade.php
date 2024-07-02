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

@section('title', 'Dettagli Ristorante: ')
@extends('layouts.admin')

@section('content')
<section class="container py-5">
@if(session()->has('message'))
    <div class="alert alert-success mt-3">{{session()->get('message')}}</div>
    @endif

    <h2 class="text-center">Piatti del: {{ $restaurant->name }}</h2>
    @if ($dishes)
    <div class="row">
        @foreach ($dishes as $dish)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card h-100">
                @if (isset($dish->image) && strpos($dish->image, 'http') === 0)
                <img src="{{ $dish->image }}" class="card-img-top" alt="...">
                @else
                <img src="{{ asset('storage/' . $dish->image) }}" class="card-img-top" alt="...">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><span class="fw-bold">Nome: </span>{{ $dish->name }}</h5>
                    <p class="card-text"><span class="fw-bold">Descrizione: </span>{{ $dish->description }}</p>
                    <p class="card-text mt-auto"><span class="fw-bold">Prezzo: </span> {{ $dish->price }}€</p>
                </div>
                @php
                if ($restaurant) {
                    $data_dish_slug = [
                        'restaurant_slug' => $restaurant->slug,
                        'user_slug' => $user->slug,
                        'dish_slug' => $dish->slug,
                    ];
                }
                @endphp
                <div class="card-footer d-flex justify-content-between" style="background: inherit; border-color: inherit;">
                    <button class="button-show me-2" onclick="location.href='{{ route('admin.dishes.show', $data_dish_slug) }}'">
                        <i class="fa-solid fa-eye" style="color: #4000ff;"></i>
                        <span class="lable">Mostra</span>
                    </button>
                    <form id="delete-form" action="{{ route('admin.dishes.destroy', $data_dish_slug) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="button-del-main element-delete" type="submit" data-element-id="{{ $dish->id }}" data-element-title="{{ $dish->name }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 14" class="svgIcon bin-top">
                                <g clip-path="url(#clip0_35_24)">
                                    <path fill="black" d="M20.8232 2.62734L19.9948 4.21304C19.8224 4.54309 19.4808 4.75 19.1085 4.75H4.92857C2.20246 4.75 0 6.87266 0 9.5C0 12.1273 2.20246 14.25 4.92857 14.25H64.0714C66.7975 14.25 69 12.1273 69 9.5C69 6.87266 66.7975 4.75 64.0714 4.75H49.8915C49.5192 4.75 49.1776 4.54309 49.0052 4.21305L48.1768 2.62734C47.3451 1.00938 45.6355 0 43.7719 0H25.2281C23.3645 0 21.6549 1.00938 20.8232 2.62734ZM64.0023 20.0648C64.0397 19.4882 63.5822 19 63.0044 19H5.99556C5.4178 19 4.96025 19.4882 4.99766 20.0648L8.19375 69.3203C8.44018 73.0758 11.6746 76 15.5712 76H53.4288C57.3254 76 60.5598 73.0758 60.8062 69.3203L64.0023 20.0648Z"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_35_24">
                                        <rect fill="white" height="14" width="69"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 69 57" class="svgIcon bin-bottom">
                                <g clip-path="url(#clip0_35_22)">
                                    <path fill="black" d="M20.8232 -16.3727L19.9948 -14.787C19.8224 -14.4569 19.4808 -14.25 19.1085 -14.25H4.92857C2.20246 -14.25 0 -12.1273 0 -9.5C0 -6.8727 2.20246 -4.75 4.92857 -4.75H64.0714C66.7975 -4.75 69 -6.8727 69 -9.5C69 -12.1273 66.7975 -14.25 64.0714 -14.25H49.8915C49.5192 -14.25 49.1776 -14.4569 49.0052 -14.787L48.1768 -16.3727C47.3451 -17.9906 45.6355 -19 43.7719 -19H25.2281C23.3645 -19 21.6549 -17.9906 20.8232 -16.3727ZM64.0023 1.0648C64.0397 0.4882 63.5822 0 63.0044 0H5.99556C5.4178 0 4.96025 0.4882 4.99766 1.0648L8.19375 50.3203C8.44018 54.0758 11.6746 57 15.5712 57H53.4288C57.3254 57 60.5598 54.0758 60.8062 50.3203L64.0023 1.0648Z"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_35_22)">
                                        <rect fill="white" height="57" width="69"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>Non ci sono piatti nel ristorante</p>
    @endif
    <button class="Btn btn-add-index mt-4" onclick="location.href='{{ route('admin.dishes.create', $data) }}'">
        <div class="sign">+</div>
        <div class="text">Piatto</div>
    </button>
</section>
@endsection