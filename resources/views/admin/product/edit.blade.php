@extends('admin.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Open+Sans&family=Lobster&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

<style>
    #textToolbar select, #textToolbar input, #textToolbar button { margin: 0 6px 6px 0; vertical-align: middle; }
    #editorWrap { display:flex; gap:20px; align-items:flex-start; flex-wrap: wrap; }
    #canvasPanel { background:#f8f9fa; padding:10px; border-radius:6px; }
    #controls { width:340px; }
    .control-section { margin-bottom:12px; padding:10px; border:1px solid #eee; border-radius:6px; background:#fff; }
    .small-btn { padding:4px 8px; font-size:13px; }
    .canvas-container { border:1px solid #ddd; display:block; }
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

        {{-- Sidebar Controls --}}
        <div class="col-md-4" id="controls">
            <div class="control-section">
                <h6>Canvas Size</h6>
                <input type="number" id="canvasWidth" value="600" class="form-control mb-2" placeholder="Width">
                <input type="number" id="canvasHeight" value="800" class="form-control mb-2" placeholder="Height">
                <button type="button" class="btn btn-primary w-100" id="resizeCanvas">Resize Canvas</button>
            </div>

            <div class="control-section" id="textToolbar">
                <h6>Text Tools</h6>
                <button type="button" class="btn btn-sm btn-secondary small-btn" id="addTextZone">Add Text</button>
                <select id="fontFamily" class="form-control mt-2">
                    <option value="Roboto">Roboto</option>
                    <option value="Open Sans">Open Sans</option>
                    <option value="Lobster">Lobster</option>
                    <option value="Montserrat">Montserrat</option>
                </select>
                <input type="number" id="fontSize" value="20" class="form-control mt-2" placeholder="Font Size">
                <input type="color" id="fontColor" class="form-control mt-2">
                <button type="button" id="boldBtn" class="btn btn-outline-dark btn-sm mt-2">Bold</button>
                <button type="button" id="italicBtn" class="btn btn-outline-dark btn-sm mt-2">Italic</button>
                <select id="textAlign" class="form-control mt-2">
                    <option value="left">Left</option>
                    <option value="center">Center</option>
                    <option value="right">Right</option>
                </select>
            </div>

            <div class="control-section">
                <h6>Image Zones</h6>
                <button type="button" class="btn btn-sm btn-info" id="addImageZone">Add Image Zone</button>
            </div>

            <div class="control-section">
                <button type="button" id="deleteObject" class="btn btn-danger w-100">Delete Selected</button>
            </div>
        </div>
    </div>

    {{-- Canvas --}}
    <div id="editorWrap" class="mt-3">
        <div id="canvasPanel">
            <canvas id="templateCanvas" width="600" height="800"></canvas>
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

    // Load background image
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

    textZonesData.forEach(zone => {
        const tb = new fabric.Textbox(zone.text || 'Edit text', {
            left: zone.x, top: zone.y, width: zone.width, fontSize: zone.font_size,
            fontFamily: zone.font_family, fill: zone.color,
            fontWeight: zone.bold ? 'bold' : 'normal',
            fontStyle: zone.italic ? 'italic' : 'normal',
            textAlign: zone.alignment || 'left', angle: zone.rotation || 0
        });
        canvas.add(tb);
    });

    imageZonesData.forEach(zone => {
        const rect = new fabric.Rect({
            left: zone.x, top: zone.y, width: zone.width, height: zone.height,
            fill: 'rgba(0,0,0,0.04)', stroke: '#b22222', strokeWidth: 2
        });
        canvas.add(rect);
    });

    // Toolbar Elements
    const fontFamilyInput = document.getElementById('fontFamily');
    const fontSizeInput = document.getElementById('fontSize');
    const fontColorInput = document.getElementById('fontColor');
    const textAlignInput = document.getElementById('textAlign');
    const boldBtn = document.getElementById('boldBtn');
    const italicBtn = document.getElementById('italicBtn');

    // Update toolbar when object selected
    canvas.on('selection:created', updateToolbar);
    canvas.on('selection:updated', updateToolbar);

    function updateToolbar() {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'textbox') {
            fontFamilyInput.value = obj.fontFamily || 'Roboto';
            fontSizeInput.value = obj.fontSize || 20;
            fontColorInput.value = obj.fill || '#000000';
            textAlignInput.value = obj.textAlign || 'left';
            boldBtn.classList.toggle('active', obj.fontWeight === 'bold');
            italicBtn.classList.toggle('active', obj.fontStyle === 'italic');
        }
    }

    // Apply font family
    fontFamilyInput.addEventListener('change', function () {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'textbox') {
            obj.fontFamily = this.value;
            canvas.renderAll();
        }
    });

    // Apply font size
    fontSizeInput.addEventListener('input', function () {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'textbox') {
            obj.fontSize = parseInt(this.value);
            canvas.renderAll();
        }
    });

    // Apply color
    fontColorInput.addEventListener('input', function () {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'textbox') {
            obj.set('fill', this.value);
            canvas.renderAll();
        }
    });

    // Apply alignment
    textAlignInput.addEventListener('change', function () {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'textbox') {
            obj.textAlign = this.value;
            canvas.renderAll();
        }
    });

    // Toggle bold
    boldBtn.addEventListener('click', function () {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'textbox') {
            obj.fontWeight = obj.fontWeight === 'bold' ? 'normal' : 'bold';
            canvas.renderAll();
        }
    });

    // Toggle italic
    italicBtn.addEventListener('click', function () {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'textbox') {
            obj.fontStyle = obj.fontStyle === 'italic' ? 'normal' : 'italic';
            canvas.renderAll();
        }
    });

    // Resize canvas
    document.getElementById('resizeCanvas').addEventListener('click', function () {
        const newWidth = parseInt(document.getElementById('canvasWidth').value);
        const newHeight = parseInt(document.getElementById('canvasHeight').value);
        canvas.setWidth(newWidth);
        canvas.setHeight(newHeight);
        canvas.renderAll();
    });

    // Add text zone
    document.getElementById('addTextZone').addEventListener('click', function () {
        const tb = new fabric.Textbox('New Text', {
            left: 50, top: 50, width: 200, fontSize: 20, fontFamily: 'Roboto', fill: '#000'
        });
        canvas.add(tb).setActiveObject(tb);
        updateToolbar();
    });

    // Add image zone
    document.getElementById('addImageZone').addEventListener('click', function () {
        const rect = new fabric.Rect({
            left: 100, top: 100, width: 150, height: 150,
            fill: 'rgba(0,0,0,0.04)', stroke: '#b22222', strokeWidth: 2
        });
        canvas.add(rect).setActiveObject(rect);
    });

    // Delete object
    document.getElementById('deleteObject').addEventListener('click', function () {
        const active = canvas.getActiveObject();
        if (active) canvas.remove(active);
    });

    // Save zones before submit
    document.getElementById('productForm').addEventListener('submit', function () {
        const textZones = [];
        const imageZones = [];
        canvas.getObjects().forEach(obj => {
            if (obj.type === 'textbox') {
                textZones.push({
                    x: obj.left, y: obj.top, width: obj.width, height: obj.height,
                    font_size: obj.fontSize, font_family: obj.fontFamily, color: obj.fill,
                    bold: obj.fontWeight === 'bold', italic: obj.fontStyle === 'italic',
                    alignment: obj.textAlign, rotation: obj.angle, text: obj.text
                });
            } else if (obj.type === 'rect') {
                imageZones.push({
                    x: obj.left, y: obj.top, width: obj.width, height: obj.height
                });
            }
        });
        document.getElementById('textZonesInput').value = JSON.stringify(textZones);
        document.getElementById('imageZonesInput').value = JSON.stringify(imageZones);
    });
});
</script>

@endsection
