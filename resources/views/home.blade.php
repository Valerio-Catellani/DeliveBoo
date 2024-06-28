@extends('layouts.app')
@section('content')
    <section class="container">
        <h1>Section title</h1>
        <div class="container">
            <div class="row">
                @foreach ($cat as $category)
                    <div class="col-2 mt-5" style="aspect-ratio: 1/1">
                        <h6>{{ $category->name }}</h6>
                        <div class="w-100 h-100">
                            <img class="img-fluid w-100 h-100" src="{{ $category->image }}" alt="no-img">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($res as $rest)
                    <div class="col-2 mt-5" style="aspect-ratio: 1/1">
                        <h6>{{ $res->name }}</h6>
                        <div class="w-100 h-100">
                            <img class="img-fluid w-100 h-100" src="{{ $res->image }}" alt="no-img">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            @foreach ($data as $value)
                <div class="col-2 mt-5" style="aspect-ratio: 1/1">
                    <h6>{{ $value->nome }}</h6>
                    <div class="w-100 h-100">
                        <img class="img-fluid w-100 h-100" src="{{ $value->immagine }}" alt="no-img">
                    </div>
                </div>
            @endforeach
        </div>
        <p>section content</p>
    </section>
@endsection
