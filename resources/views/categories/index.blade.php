@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Categories</h1>
            <p class="text-muted mb-0">Manage product categories</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($categories->count())
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $category->name }}</td>
                                <td>{{ $category->created_at->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning">
                                        Edit
                                    </a>

                                    @if(auth()->user()->hasRole('Admin'))
                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h4 class="mb-2">No categories found</h4>
                <p class="text-muted mb-3">Start by creating your first category.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    Create Category
                </a>
            </div>
        </div>
    @endif
</div>
@endsection