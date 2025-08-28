@extends('admin.app')

@section('content')
<main class="page-content">
    <div class="justify-content-center">
        <div class="col-12">
            <div class="card shadow rounded-card">
                <div class="card-body bg-white p-4 rounded-card">
                    <h2 class="card-title mb-3">Edit Category: {{ $category->name }}</h2>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                

                    <form method="POST" action="{{ route('category.update', $category->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name">Category Name</label>
                                <input type="text" name="name" id="name" class="form-control" 
                                    placeholder="Enter category name" value="{{ old('name', $category->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="parent_id">Parent Category</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">-- No Parent (Top Level) --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" 
                                            @if ($cat->id == old('parent_id', $category->parent_id)) selected @endif
                                            {{-- Optionally, disable the current category and its children to prevent self-referencing issues --}}
                                            {{ ($cat->id == $category->id || $category->children->contains($cat->id)) ? 'disabled' : '' }}
                                            >
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-start align-items-center gap-5">
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                            <a href="{{ route('category.index') }}" class="btn btn-outline-danger mt-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection