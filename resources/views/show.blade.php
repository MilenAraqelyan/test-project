@extends('layout')

@section('content')
    <h2>Просмотр продукта #{{ $product->id }}</h2>

    <p><strong>Article:</strong> {{ $product->article }}</p>
    <p><strong>Name:</strong> {{ $product->name }}</p>
    <p><strong>Status:</strong> {{ $product->status }}</p>

    @if($product->data)
        <p><strong>Color:</strong> {{ $product->data['color'] ?? '' }}</p>
        <p><strong>Size:</strong> {{ $product->data['size'] ?? '' }}</p>
    @endif

    <img src="https://placehold.co/200x200" alt="Placeholder" class="my-3">

    <a href="{{ route('products.index') }}" class="btn btn-secondary">Назад</a>
@endsection
