@extends('layout')

@section('content')
    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="article" class="form-label">Article:</label>
            <input type="text" name="article" id="article" class="form-control" value="{{ old('article') }}">
            @error('article')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name (не менее 10 символов):</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Поля для цвет, размер, etc (json data) -->
        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}">
        </div>
        <div class="mb-3">
            <label for="size" class="form-label">Size:</label>
            <input type="text" name="size" id="size" class="form-control" value="{{ old('size') }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Статус (available/unavailable):</label>
            <select name="status" id="status" class="form-control">
                <option value="available">available</option>
                <option value="unavailable">unavailable</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Создать</button>
    </form>
@endsection
