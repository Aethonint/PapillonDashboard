@extends('admin.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Open+Sans&family=Lobster&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

<style>
    #editorWrap { display:flex; gap:20px; align-items:flex-start; }
    #canvasPanel { background:#f8f9fa; padding:10px; border-radius:6px; }
    #controls { width:320px; }
    .control-section { margin-bottom:12px; padding:10px; border:1px solid #eee; border-radius:6px; background:#fff; }
    #textToolbar select, #textToolbar input, #textToolbar button { margin: 0 6px 6px 0; }
    .small-btn { padding:4px 8px; font-size:13px; }
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
            {{-- Product Info --}}
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
            </div>
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
            <div class="mb-3">
                <label>Template Type</label>
                <select name="type" class="form-control" required>
                    <option value="text_only" {{ $product->type == 'text_only' ? 'selected' : '' }}>Text Only</option>
                    <option value="image_only" {{ $product->type == 'image_only' ? 'selected' : '' }}>Image Only</option>
                    <option value="text_image" {{ $product->type == 'text_image' ? 'selected' : '' }}>Text + Image</option>
                    <option value="fixed" {{ $product->type == 'fixed' ? 'selected' : '' }}>Fixed (No Change)</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">
                @if($product->thumbnail)
                    <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="Thumbnail" class="img-thumbnail mt-2" style="max-width:100px;">
                @endif
            </div>
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
                <h6>Canvas Tools</h6>
                <button type="button" id="addTextZone" class="btn btn-primary btn-sm">+ Text Zone</button>
                <button type="button" id="addImageZone" class="btn btn-warning btn-sm">+ Image Zone</button>
            </div>
            <div class="control-section" id="textToolbar" style="display:none;">
                <h6>Text Controls</h6>
                <select id="fontFamilySelect">
                    <option value="Roboto">Roboto</option>
                    <option value="Open Sans">Open Sans</option>
                    <option value="Lobster">Lobster</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Arial">Arial</option>
                </select>
                <input type="number" id="fontSizeInput" placeholder="Size" style="width:60px;">
                <input type="color" id="fontColorInput">
                <input type="color" id="bgColorInput">
                <button type="button" id="boldBtn" class="btn btn-secondary small-btn">B</button>
                <button type="button" id="italicBtn" class="btn btn-secondary small-btn">I</button>
                <button type="button" data-align="left" class="alignBtn btn btn-light small-btn">L</button>
                <button type="button" data-align="center" class="alignBtn btn btn-light small-btn">C</button>
                <button type="button" data-align="right" class="alignBtn btn btn-light small-btn">R</button>
                <input type="range" id="rotationRange" min="0" max="360" step="1">
            </div>
            <div class="control-section">
                <button type="button" id="bringForwardBtn" class="btn btn-info small-btn">Bring Forward</button>
                <button type="button" id="sendBackwardBtn" class="btn btn-info small-btn">Send Backward</button>
                <button type="button" id="deleteBtn" class="btn btn-danger small-btn">Delete Selected</button>
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
    <input type="hidden" name="background_image_uploaded" id="backgroundImageUploaded">

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
// FULL Fabric.js Logic (Load existing zones + Toolbar functionality)
document.addEventListener('DOMContentLoaded', function () {
    const canvas = new fabric.Canvas('templateCanvas', { preserveObjectStacking:true });
    canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));

    let selectedObject = null;

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
            angle: zone.rotation || 0
        });
        canvas.add(tb);
    });

    imageZonesData.forEach(zone => {
        const rect = new fabric.Rect({
            left: zone.x,
            top: zone.y,
            width: zone.width,
            height: zone.height,
            fill: 'rgba(0,0,0,0.04)',
            stroke: '#b22222',
            strokeWidth: 2
        });
        canvas.add(rect);
    });

    // Add new text zone
    document.getElementById('addTextZone').addEventListener('click', () => {
        const tb = new fabric.Textbox('Sample Text', { left:50, top:50, width:200, fontSize:24, fill:'#000' });
        canvas.add(tb).setActiveObject(tb);
    });

    // Add new image zone
    document.getElementById('addImageZone').addEventListener('click', () => {
        const rect = new fabric.Rect({ left:100, top:100, width:150, height:100, fill:'rgba(0,0,0,0.04)', stroke:'#b22222', strokeWidth:2 });
        canvas.add(rect).setActiveObject(rect);
    });

    // Object selection
    canvas.on('selection:created', updateToolbar);
    canvas.on('selection:updated', updateToolbar);
    canvas.on('selection:cleared', () => {
        selectedObject = null;
        document.getElementById('textToolbar').style.display = 'none';
    });

    function updateToolbar(e) {
        selectedObject = e.selected[0];
        if (selectedObject && selectedObject.type === 'textbox') {
            document.getElementById('textToolbar').style.display = 'block';
            document.getElementById('fontFamilySelect').value = selectedObject.fontFamily || 'Roboto';
            document.getElementById('fontSizeInput').value = selectedObject.fontSize || 24;
            document.getElementById('fontColorInput').value = selectedObject.fill || '#000000';
            document.getElementById('bgColorInput').value = selectedObject.backgroundColor || '#ffffff';
            document.getElementById('rotationRange').value = selectedObject.angle || 0;
        } else {
            document.getElementById('textToolbar').style.display = 'none';
        }
    }

    // Toolbar actions
    document.getElementById('fontFamilySelect').addEventListener('change', e => { if(selectedObject){ selectedObject.fontFamily=e.target.value; canvas.renderAll(); }});
    document.getElementById('fontSizeInput').addEventListener('input', e => { if(selectedObject){ selectedObject.fontSize=parseInt(e.target.value); canvas.renderAll(); }});
    document.getElementById('fontColorInput').addEventListener('input', e => { if(selectedObject){ selectedObject.fill=e.target.value; canvas.renderAll(); }});
    document.getElementById('bgColorInput').addEventListener('input', e => { if(selectedObject){ selectedObject.backgroundColor=e.target.value; canvas.renderAll(); }});
    document.getElementById('boldBtn').addEventListener('click', ()=>{ if(selectedObject){ selectedObject.fontWeight=(selectedObject.fontWeight==='bold'?'normal':'bold'); canvas.renderAll(); }});
    document.getElementById('italicBtn').addEventListener('click', ()=>{ if(selectedObject){ selectedObject.fontStyle=(selectedObject.fontStyle==='italic'?'normal':'italic'); canvas.renderAll(); }});
    document.querySelectorAll('.alignBtn').forEach(btn => {
        btn.addEventListener('click', ()=>{ if(selectedObject){ selectedObject.textAlign=btn.getAttribute('data-align'); canvas.renderAll(); }});
    });
    document.getElementById('rotationRange').addEventListener('input', e=>{ if(selectedObject){ selectedObject.angle=parseInt(e.target.value); canvas.renderAll(); }});

    // Layer & Delete
    document.getElementById('bringForwardBtn').addEventListener('click', ()=>{ if(selectedObject){ canvas.bringForward(selectedObject); }});
    document.getElementById('sendBackwardBtn').addEventListener('click', ()=>{ if(selectedObject){ canvas.sendBackwards(selectedObject); }});
    document.getElementById('deleteBtn').addEventListener('click', ()=>{ if(selectedObject){ canvas.remove(selectedObject); }});

    // On submit - save zones
    document.getElementById('productForm').addEventListener('submit', function() {
        const textZones = [];
        const imageZones = [];
        canvas.getObjects().forEach(obj => {
            if(obj.type === 'textbox'){
                textZones.push({
                    text: obj.text,
                    x: obj.left, y: obj.top, width: obj.width,
                    font_size: obj.fontSize, font_family: obj.fontFamily,
                    color: obj.fill, bold: obj.fontWeight==='bold',
                    italic: obj.fontStyle==='italic', alignment: obj.textAlign,
                    background_color: obj.backgroundColor || '', rotation: obj.angle
                });
            } else if(obj.type === 'rect'){
                imageZones.push({ x: obj.left, y: obj.top, width: obj.width, height: obj.height });
            }
        });
        document.getElementById('textZonesInput').value = JSON.stringify(textZones);
        document.getElementById('imageZonesInput').value = JSON.stringify(imageZones);
    });

    // Google Fonts Loader
    function loadGoogleFont(font) {
        const linkId = 'font-' + font.replace(/\s+/g, '-');
        if (!document.getElementById(linkId)) {
            const link = document.createElement('link');
            link.id = linkId;
            link.rel = 'stylesheet';
            link.href = `https://fonts.googleapis.com/css2?family=${font.replace(/\s+/g, '+')}&display=swap`;
            document.head.appendChild(link);
        }
    }
    ['Roboto','Open Sans','Lobster','Montserrat','Arial'].forEach(f => loadGoogleFont(f));
});
</script>
@endsection
