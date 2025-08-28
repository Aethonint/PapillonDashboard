@extends('admin.app')
@section('content')
    <main class="page-content">
        <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories Table</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('category.create') }}">
                    <i class="bi bi-plus-lg"></i> Add Category
                </a>
            </div>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
             
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                function displayCategories($categories, $level = 0) {
                                    $indentation = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                                    foreach ($categories as $category) {
                                        echo '<tr>';
                                        echo '<td>' . $indentation . htmlspecialchars($category->name) . '</td>';
                                        echo '<td>' . htmlspecialchars($category->slug) . '</td>';
                                        echo '<td>' . ($category->parent ? htmlspecialchars($category->parent->name) : 'Top Level') . '</td>';
                                        echo '<td class="text-center">';
                                        echo '<div class="d-flex justify-content-center">';
                                        echo '<a href="' . route('category.edit', $category->id) . '" class="btn btn-sm btn-info me-2">Edit</a>';
                                        echo '<form action="' . route('category.destroy', $category->id) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this category?\')">';
                                        echo csrf_field();
                                        echo method_field('DELETE');
                                        echo '<button type="submit" class="btn btn-sm btn-danger">Delete</button>';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</td>';
                                        echo '</tr>';

                                        if ($category->children->count()) {
                                            displayCategories($category->children, $level + 1);
                                        }
                                    }
                                }
                            @endphp
                            
                            @php
                                displayCategories($categories);
                            @endphp
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection