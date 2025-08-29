@extends('admin.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Open+Sans&family=Lobster&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

<style>
    #editorWrap { display:flex; gap:20px; align-items:flex-start; }
    #canvasPanel { background:#f8f9fa; padding:10px; border-radius:6px; }
    #controls { width:320px; }
</style>

<main class="page-content">
    <div class="col-12">
        <div class="card shadow rounded-card">
            <div class="card-body bg-white p-4 rounded-card">
                <h2 class="card-title mb-3">Edit Product Template</h2>

<form id="productForm" method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">
            {{-- Product Name --}}
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            {{-- Price --}}
            <div class="mb-3">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
            </div>

            {{-- Main Category --}}
            <div class="mb-3">
                <label>Main Category</label>
                <select name="category_id" id="parentCategory" class="form-control" required>
                    <option value="">-- Select Main Category --</option>
                    @foreach($categories->where('parent_id', null) as $parent)
                        <option value="{{ $parent->id }}" {{ $product->category_id == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sub Category --}}
            <div class="mb-3">
                <label>Sub Category</label>
                <select name="subcategory_id" id="subCategory" class="form-control">
                    <option value="">-- Select Sub Category --</option>
                    @foreach($categories->where('parent_id', $product->category_id) as $child)
                        <option value="{{ $child->id }}" {{ $product->subcategory_id == $child->id ? 'selected' : '' }}>
                            {{ $child->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Template Type --}}
            <div class="mb-3">
                <label>Template Type</label>
                <select name="type" class="form-control" required>
                    <option value="text_only" {{ $product->type == 'text_only' ? 'selected' : '' }}>Text Only</option>
                    <option value="image_only" {{ $product->type == 'image_only' ? 'selected' : '' }}>Image Only</option>
                    <option value="text_image" {{ $product->type == 'text_image' ? 'selected' : '' }}>Text + Image</option>
                    <option value="fixed" {{ $product->type == 'fixed' ? 'selected' : '' }}>Fixed (No Change)</option>
                </select>
            </div>

            {{-- Thumbnail --}}
            <div class="mb-3">
                <label>Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">
                @if($product->thumbnail)
                    <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="Thumbnail" class="img-thumbnail mt-2" style="max-width:100px;">
                @endif
            </div>

            {{-- Background Image --}}
            <div class="mb-3">
                <label>Upload Background Image</label>
                <input type="file" id="background-image-input" name="background_image" accept="image/*" class="form-control">
                @if($product->background_image)
                    <img src="{{ asset('storage/'.$product->background_image) }}" alt="Background" class="img-thumbnail mt-2" style="max-width:100px;">
                @endif
            </div>
        </div>
    </div>

    {{-- Canvas --}}
    <div id="editorWrap" class="mt-3">
        <div id="canvasPanel">
            <canvas id="templateCanvas" width="600" height="800" style="border:1px solid #ddd;"></canvas>
        </div>
    </div>

    {{-- Hidden fields --}}
    <input type="hidden" name="text_zones" id="textZonesInput" value="{{ old('text_zones', $product->text_zones) }}">
    <input type="hidden" name="image_zones" id="imageZonesInput" value="{{ old('image_zones', $product->image_zones) }}">

    <div class="mt-4">
        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="{{ route('product.index') }}" class="btn btn-outline-danger">Cancel</a>
    </div>
</form>

            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = new fabric.Canvas('templateCanvas', { preserveObjectStacking:true });
    canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));

    // Load background image from DB
    const bgImageUrl = "{{ $product->background_image ? asset('storage/'.$product->background_image) : '' }}";
    if (bgImageUrl) {
        fabric.Image.fromURL(bgImageUrl, function (img) {
            const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
            img.set({ originX:'left', originY:'top', left:0, top:0, scaleX:scale, scaleY:scale, selectable:false, evented:false });
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        }, { crossOrigin:'anonymous' });
    }

    // Load zones from DB
    const textZonesData = {!! $product->text_zones ? $product->text_zones : '[]' !!};
    const imageZonesData = {!! $product->image_zones ? $product->image_zones : '[]' !!};

    // Create text zones (fixed position, editable text only)
    textZonesData.forEach(zone => {
        const tb = new fabric.Textbox(zone.text || 'Edit text', {
            left: zone.x,
            top: zone.y,
            width: zone.width,
            fontSize: zone.font_size,
            fontFamily: zone.font_family,
            fill: zone.color,
            fontWeight: zone.bold ? 'bold' : 'normal',
            fontStyle: zone.italic ? 'italic' : 'normal',
            textAlign: zone.alignment || 'left',
            backgroundColor: zone.background_color || 'transparent',
            angle: zone.rotation || 0,
            lockMovementX: true,
            lockMovementY: true,
            lockScalingX: true,
            lockScalingY: true,
            lockRotation: true
        });
        canvas.add(tb);
    });

    // Create image zones (fixed size and position, allow replace on click)
    imageZonesData.forEach(zone => {
        const rect = new fabric.Rect({
            left: zone.x,
            top: zone.y,
            width: zone.width,
            height: zone.height,
            fill: 'rgba(0,0,0,0.04)',
            stroke: '#b22222',
            strokeWidth: 2,
            selectable: true,
            lockMovementX: true,
            lockMovementY: true,
            lockScalingX: true,
            lockScalingY: true,
            lockRotation: true
        });
        rect.set('type', 'imagePlaceholder'); // Custom type for identification
        canvas.add(rect);
    });

    // Replace image on click
    canvas.on('mouse:down', function (opt) {
        const obj = opt.target;
        if (obj && obj.type === 'imagePlaceholder') {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*';
            fileInput.onchange = function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (f) {
                        fabric.Image.fromURL(f.target.result, function (img) {
                            img.set({
                                left: obj.left,
                                top: obj.top,
                                scaleX: obj.width / img.width,
                                scaleY: obj.height / img.height,
                                selectable: false,
                                evented: false
                            });
                            canvas.remove(obj);
                            canvas.add(img);
                            canvas.renderAll();
                        });
                    };
                    reader.readAsDataURL(file);
                }
            };
            fileInput.click();
        }
    });
});
</script>
@endsection
