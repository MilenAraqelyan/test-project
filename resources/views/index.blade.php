@extends('layout')

@section('content')
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Создать продукт</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Article</th>
            <th>Name</th>
            <th>Status</th>
            <th>Placeholder Image</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $prod)
            <tr>
                <td>{{ $prod->id }}</td>
                <td>{{ $prod->article }}</td>
                <td>{{ $prod->name }}</td>
                <td>{{ $prod->status }}</td>
                <td>
                    <!-- Плейсхолдер из https://placehold.co/ -->
                    <img src="https://placehold.co/50x50" alt="Placeholder">
                </td>
                <td>
                    <a href="{{ route('products.show', $prod->id) }}" class="btn btn-sm btn-info">Просмотр</a>
                    <a href="{{ route('products.edit', $prod->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
                    <form action="{{ route('products.destroy', $prod->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Удалить продукт?')" class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
