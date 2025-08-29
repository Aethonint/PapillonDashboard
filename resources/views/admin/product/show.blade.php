@extends('admin.app')
@section('content')
<main class="page-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Product Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('product.index') }}">Products</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $product->name }}</h5>
            <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm float-end">Back to List</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <!-- Thumbnail -->
                <div class="col-md-4 text-center">
                    <h6>Thumbnail</h6>
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/'.$product->thumbnail) }}" class="img-fluid rounded" style="max-height: 200px;">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="img-fluid rounded" style="max-height: 200px;">
                    @endif
                </div>
                <!-- Background Image -->
                <div class="col-md-8 text-center">
                    <h6>Background Image</h6>
                    <img src="{{ asset('storage/'.$product->background_image) }}" class="img-fluid rounded" style="max-height: 200px;">
                </div>
            </div>

            <hr>

            <!-- Details -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Main Category:</strong> {{ $product->category->name ?? 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>Sub Category:</strong> {{ $product->subcategory->name ?? 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $product->type)) }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                </div>
                <div class="col-md-4">
                    <strong>Status:</strong>
                    <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $product->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="col-md-4">
                    <strong>Created At:</strong> {{ $product->created_at->format('d M Y') }}
                </div>
            </div>

            <hr>

            <!-- Zones -->
            <div class="row">
                <div class="col-md-6">
                    <h6>Text Zones</h6>
                    @if($product->text_zones && count(json_decode($product->text_zones, true)) > 0)
                        <ul class="list-group">
                            @foreach(json_decode($product->text_zones, true) as $index => $zone)
                                <li class="list-group-item">
                                    <strong>Zone {{ $index + 1 }}:</strong>
                                    X: {{ $zone['x'] }}, Y: {{ $zone['y'] }},
                                    Width: {{ $zone['width'] }}, Height: {{ $zone['height'] }},
                                    Font Size: {{ $zone['font_size'] }},
                                    Color: <span style="background-color: {{ $zone['color'] }}; padding: 2px 6px; border:1px solid #ccc;"></span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No text zones defined.</p>
                    @endif
                </div>

                <div class="col-md-6">
                    <h6>Image Zones</h6>
                    @if($product->image_zones && count(json_decode($product->image_zones, true)) > 0)
                        <ul class="list-group">
                            @foreach(json_decode($product->image_zones, true) as $index => $zone)
                                <li class="list-group-item">
                                    <strong>Zone {{ $index + 1 }}:</strong>
                                    X: {{ $zone['x'] }}, Y: {{ $zone['y'] }},
                                    Width: {{ $zone['width'] }}, Height: {{ $zone['height'] }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No image zones defined.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
