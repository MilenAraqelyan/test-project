@extends('layout')

@section('content')
    <h2>Редактирование продукта #{{ $product->id }}</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        @php
            $isAdmin = (config('products.role') === 'admin');
        @endphp

        @if($isAdmin)
            <div class="mb-3">
                <label for="article" class="form-label">Article:</label>
                <input type="text" name="article" id="article" class="form-control" value="{{ old('article', $product->article) }}">
                @error('article')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        @else
            <!-- Если не админ, запрещено редактировать article -->
            <input type="hidden" name="article" value="{{ $product->article }}">
            <div class="mb-3">
                <label for="article" class="form-label">Article (read-only):</label>
                <input type="text" id="article" class="form-control" value="{{ $product->article }}" readonly>
            </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Name (не менее 10 символов):</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Поля для color, size и т.п. -->
        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <input type="text" name="color" id="color" class="form-control"
                   value="{{ old('color', $product->data['color'] ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="size" class="form-label">Size:</label>
            <input type="text" name="size" id="size" class="form-control"
                   value="{{ old('size', $product->data['size'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Статус (available/unavailable):</label>
            <select name="status" id="status" class="form-control">
                <option value="available" {{ $product->status === 'available' ? 'selected' : '' }}>available</option>
                <option value="unavailable" {{ $product->status === 'unavailable' ? 'selected' : '' }}>unavailable</option>
            </select>
            @error('status')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
@endsection
