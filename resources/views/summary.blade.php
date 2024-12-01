@extends('layouts.shop')

@section('title', 'E-sklep Podsumowanie')

@section('content')

    <div class="containerOrder">
        <h2>Dziękujemy za złożenie zamówienia:</h2>
        @if (Cookie::get('shopping_uuid'))
            {!! $summaryOrder !!}
            {!! $summary !!}
        @endif
    </div>

@endsection
