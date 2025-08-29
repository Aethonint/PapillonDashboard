@extends('admin.app')

@section('content')
<!-- Preload some Google fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Open+Sans&family=Lobster&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

<style>
    /* small toolbar styling */
    #textToolbar select, #textToolbar input, #textToolbar button {
        margin: 0 6px 6px 0;
        vertical-align: middle;
    }
    #editorWrap { display:flex; gap:20px; align-items:flex-start; }
    #canvasPanel { background:#f8f9fa; padding:10px; border-radius:6px; }
    #controls { width:320px; }
    .control-section { margin-bottom:12px; padding:10px; border:1px solid #eee; border-radius:6px; background:#fff; }
    .small-btn { padding:4px 8px; font-size:13px; }
</style>

<main class="page-content">
    <div class="col-12">
        <div class="card shadow rounded-card">
            <div class="card-body bg-white p-4 rounded-card">
                <h2 class="card-title mb-3">Create Product Template</h2>
<form id="productForm" method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-8">
            {{-- Product Name --}}
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" 
                       placeholder="Enter product name" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

           <!-- Template Type (make sure values match validation) -->
<div class="mb-3">
    <label>Template Type</label>
    <select name="type" class="form-control" required>
        <option value="text_only" {{ old('type') == 'text_only' ? 'selected' : '' }}>Text Only</option>
        <option value="image_only" {{ old('type') == 'image_only' ? 'selected' : '' }}>Image Only</option>
        <option value="text_image" {{ old('type') == 'text_image' ? 'selected' : '' }}>Text + Image</option>
        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed (No Change)</option>
    </select>
    @error('type') <small class="text-danger">{{ $message }}</small> @enderror
</div>

            {{-- Thumbnail --}}
            <div class="mb-3">
                <label>Thumbnail (optional)</label>
                <input type="file" name="thumbnail" class="form-control">
                @error('thumbnail')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Background Image (IMPORTANT: add name="background_image") -->
<div class="mb-3">
    <label>Upload Background Image (template)</label>
    <input type="file" id="background-image-input" name="background_image" accept="image/*" class="form-control">
    <small class="text-muted">Recommended size: match canvas (600x800) or similar ratio.</small>
    @error('background_image') <small class="text-danger">{{ $message }}</small> @enderror
</div>
        </div>

        {{-- Sidebar Controls --}}
        <div class="col-md-4" id="controls">
            <div class="control-section">
                <h6>Editor Actions</h6>
                <button type="button" id="addTextZone" class="btn btn-primary small-btn">Add Text Zone</button>
                <button type="button" id="addImageZone" class="btn btn-secondary small-btn">Add Image Zone</button>
                <button type="button" id="addImageFromFile" class="btn btn-info small-btn">Place Image File</button>
                <button type="button" id="clearSelection" class="btn btn-light small-btn">Deselect</button>
            </div>

            <div id="textToolbar" class="control-section" style="display:none;">
                <h6>Text Properties</h6>

                <label>Font</label>
                <select id="fontFamilyInput" class="form-control" style="width:100%;">
                    <option value="Arial">Arial</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Open Sans">Open Sans</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Lobster">Lobster</option>
                </select>

                <div class="mt-2">
                    <label>Size</label>
                    <input type="number" id="fontSizeInput" class="form-control" value="20" min="8" style="width:100px; display:inline-block;">
                    <label class="ms-2">Color</label>
                    <input type="color" id="fontColorInput" value="#000000">
                </div>

                <div class="mt-2">
                    <button type="button" id="boldBtn" class="btn btn-sm btn-outline-dark small-btn"><b>B</b></button>
                    <button type="button" id="italicBtn" class="btn btn-sm btn-outline-dark small-btn"><i>I</i></button>
                    <button type="button" id="alignLeftBtn" class="btn btn-sm btn-outline-secondary small-btn">L</button>
                    <button type="button" id="alignCenterBtn" class="btn btn-sm btn-outline-secondary small-btn">C</button>
                    <button type="button" id="alignRightBtn" class="btn btn-sm btn-outline-secondary small-btn">R</button>
                </div>

                <div class="mt-2">
                    <label>Text Background</label>
                    <input type="color" id="textBgColorInput" value="#ffffff">
                </div>

                <div class="mt-2">
                    <label>Rotate</label>
                    <input type="range" id="rotateInput" min="0" max="360" value="0" style="width:100%;">
                </div>

                <div class="mt-2">
                    <button type="button" id="bringForward" class="btn btn-sm btn-outline-info small-btn">Bring Forward</button>
                    <button type="button" id="sendBack" class="btn btn-sm btn-outline-info small-btn">Send Back</button>
                    <button type="button" id="removeObject" class="btn btn-sm btn-outline-danger small-btn">Delete</button>
                </div>
            </div>

            <div class="control-section">
                <h6>Preview Controls</h6>
                <label>Canvas Size</label>
                <div class="d-flex gap-2">
                    <input type="number" id="canvasWidth" class="form-control" value="600" style="width:100px;">
                    <input type="number" id="canvasHeight" class="form-control" value="800" style="width:100px;">
                    <button type="button" id="resizeCanvas" class="btn btn-sm btn-outline-primary small-btn">Resize</button>
                </div>
            </div>

            <div class="control-section">
                <h6>Notes</h6>
                <small class="text-muted">Drag, resize, rotate objects. When done, press Save Product. Zones are saved as JSON.</small>
            </div>
        </div>
    </div>

    {{-- Editor & Canvas --}}
    <div id="editorWrap" class="mt-3">
        <div id="canvasPanel">
            <canvas id="templateCanvas" width="600" height="800" style="border:1px solid #ddd;"></canvas>
        </div>
    </div>

    {{-- Hidden inputs to receive JSON --}}
    <input type="hidden" name="text_zones" id="textZonesInput">
    <input type="hidden" name="image_zones" id="imageZonesInput">
    <input type="hidden" name="background_image_uploaded" id="backgroundImageUploaded">

    <div class="mt-4">
        <button type="submit" id="submitBtn" class="btn btn-success">Save Product</button>
        <a href="{{ route('product.index') }}" class="btn btn-outline-danger">Cancel</a>
    </div>
</form>

            </div>
        </div>
    </div>
</main>

<!-- Fabric.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // initialize
    const canvas = new fabric.Canvas('templateCanvas', { preserveObjectStacking: true, selection: true });
    canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));

    // helpers
    function bringToFront(obj){ if(obj) obj.bringToFront(); canvas.renderAll(); }
    function sendToBack(obj){ if(obj) obj.sendToBack(); canvas.renderAll(); }

    // load fonts preloaded via link tag in head. Use document.fonts to ensure loaded.
    function loadGoogleFont(fontName) {
        const font = fontName.replace(/ /g, '+');
        // append link only if not present
        if (!document.querySelector(`link[data-font="${fontName}"]`)) {
            const link = document.createElement('link');
            link.href = `https://fonts.googleapis.com/css2?family=${font}&display=swap`;
            link.rel = 'stylesheet';
            link.setAttribute('data-font', fontName);
            document.head.appendChild(link);
        }
        // return a promise resolved when font loaded
        return document.fonts.load(`16px "${fontName}"`);
    }

    // DOM elements
    const addTextBtn = document.getElementById('addTextZone');
    const addImageBtn = document.getElementById('addImageZone');
    const addImageFromFileBtn = document.getElementById('addImageFromFile');
    const backgroundInput = document.getElementById('background-image-input');
    const textToolbar = document.getElementById('textToolbar');
    const fontFamilyInput = document.getElementById('fontFamilyInput');
    const fontSizeInput = document.getElementById('fontSizeInput');
    const fontColorInput = document.getElementById('fontColorInput');
    const rotateInput = document.getElementById('rotateInput');
    const boldBtn = document.getElementById('boldBtn');
    const italicBtn = document.getElementById('italicBtn');
    const alignLeftBtn = document.getElementById('alignLeftBtn');
    const alignCenterBtn = document.getElementById('alignCenterBtn');
    const alignRightBtn = document.getElementById('alignRightBtn');
    const textBgColorInput = document.getElementById('textBgColorInput');
    const bringForward = document.getElementById('bringForward');
    const sendBack = document.getElementById('sendBack');
    const removeObject = document.getElementById('removeObject');
    const clearSelection = document.getElementById('clearSelection');
    const canvasWidthInput = document.getElementById('canvasWidth');
    const canvasHeightInput = document.getElementById('canvasHeight');
    const resizeCanvasBtn = document.getElementById('resizeCanvas');

    let selectedObject = null;

    // Utility: create editable textbox
    function createTextBox() {
        const tb = new fabric.Textbox('Edit text', {
            left: 80,
            top: 80,
            width: 260,
            fontSize: 20,
            fontFamily: 'Arial',
            fill: '#000000',
            backgroundColor: 'transparent',
            textAlign: 'center',
            editable: true,
            objectCaching: false,
            lockUniScaling: false
        });
        canvas.add(tb);
        canvas.setActiveObject(tb);
        canvas.renderAll();
    }

    // Utility: create image placeholder rect
    function createImageRect() {
        const rect = new fabric.Rect({
            left: 120,
            top: 120,
            width: 160,
            height: 160,
            fill: 'rgba(0,0,0,0.04)',
            stroke: '#b22222',
            strokeWidth: 2,
            hasBorders: true,
            hasControls: true,
            lockUniScaling: false,
            selectable: true
        });
        canvas.add(rect);
        canvas.setActiveObject(rect);
        canvas.renderAll();
    }

    // Add text zone button
    addTextBtn.addEventListener('click', function () {
        createTextBox();
    });

    // Add rect image zone
    addImageBtn.addEventListener('click', function () {
        createImageRect();
    });

    // Place an actual image from file directly onto canvas (admin can use this to test)
    addImageFromFileBtn.addEventListener('click', function () {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (ev) {
                fabric.Image.fromURL(ev.target.result, function (img) {
                    img.set({ left: 120, top: 120, scaleX: 0.4, scaleY: 0.4, hasBorders: true, hasControls: true });
                    canvas.add(img);
                    canvas.setActiveObject(img);
                    canvas.renderAll();
                }, { crossOrigin: 'anonymous' });
            };
            reader.readAsDataURL(file);
        };
        input.click();
    });

    // Background image upload (scale to fit)
    backgroundInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (ev) {
            fabric.Image.fromURL(ev.target.result, function (img) {
                // scale to fit canvas while preserving aspect ratio
                const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
                img.set({
                    selectable: false,
                    evented: false,
                    originX: 'left',
                    originY: 'top',
                    left: 0,
                    top: 0,
                    scaleX: scale,
                    scaleY: scale
                });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
                document.getElementById('backgroundImageUploaded').value = '1';
            }, { crossOrigin: 'anonymous' });
        };
        reader.readAsDataURL(file);
    });

    // Selection change -> show toolbar when textbox selected
    canvas.on('selection:created', function (e) { onSelectionChange(e.target || e.selected && e.selected[0]); });
    canvas.on('selection:updated', function (e) { onSelectionChange(e.target || e.selected && e.selected[0]); });
    canvas.on('selection:cleared', function () { selectedObject = null; textToolbar.style.display = 'none'; });

    function onSelectionChange(obj) {
        selectedObject = obj;
        if (!obj) { textToolbar.style.display = 'none'; return; }
        // show toolbar only for textbox or editable text-like objects
        if (obj.type === 'textbox' || obj.type === 'i-text' || obj.type === 'text') {
            textToolbar.style.display = 'block';
            // set fields
            fontFamilyInput.value = obj.fontFamily || 'Arial';
            fontSizeInput.value = Math.round(obj.fontSize) || 20;
            fontColorInput.value = obj.fill || '#000000';
            rotateInput.value = obj.angle || 0;
            textBgColorInput.value = obj.backgroundColor ? obj.backgroundColor : '#ffffff';
        } else {
            // for non-text objects, still show bring/send/delete controls by showing toolbar (we keep it visible)
            textToolbar.style.display = 'block';
        }
    }

    // Text property handlers (wrap changing in font load when necessary)
    fontFamilyInput.addEventListener('change', function () {
        if (!selectedObject) return;
        const newFont = this.value;
        loadGoogleFont(newFont).then(() => {
            selectedObject.set('fontFamily', newFont);
            canvas.requestRenderAll();
        });
    });

    fontSizeInput.addEventListener('input', function () {
        if (!selectedObject) return;
        selectedObject.set('fontSize', parseInt(this.value));
        canvas.requestRenderAll();
    });

    fontColorInput.addEventListener('input', function () {
        if (!selectedObject) return;
        selectedObject.set('fill', this.value);
        canvas.requestRenderAll();
    });

    rotateInput.addEventListener('input', function () {
        if (!selectedObject) return;
        selectedObject.rotate(parseInt(this.value));
        canvas.requestRenderAll();
    });

    boldBtn.addEventListener('click', function () {
        if (!selectedObject) return;
        const current = selectedObject.fontWeight === 'bold' ? 'normal' : 'bold';
        selectedObject.set('fontWeight', current);
        canvas.requestRenderAll();
    });

    italicBtn.addEventListener('click', function () {
        if (!selectedObject) return;
        const current = selectedObject.fontStyle === 'italic' ? 'normal' : 'italic';
        selectedObject.set('fontStyle', current);
        canvas.requestRenderAll();
    });

    alignLeftBtn.addEventListener('click', function () { if(selectedObject) { selectedObject.set('textAlign','left'); canvas.renderAll(); }});
    alignCenterBtn.addEventListener('click', function () { if(selectedObject) { selectedObject.set('textAlign','center'); canvas.renderAll(); }});
    alignRightBtn.addEventListener('click', function () { if(selectedObject) { selectedObject.set('textAlign','right'); canvas.renderAll(); }});

    textBgColorInput.addEventListener('input', function () {
        if (!selectedObject) return;
        selectedObject.set('backgroundColor', this.value);
        canvas.requestRenderAll();
    });

    bringForward.addEventListener('click', function () { if(selectedObject) { bringToFront(selectedObject); }});
    sendBack.addEventListener('click', function () { if(selectedObject) { sendToBack(selectedObject); }});
    removeObject.addEventListener('click', function () { if(selectedObject) { canvas.remove(selectedObject); selectedObject = null; textToolbar.style.display='none'; }});
    clearSelection.addEventListener('click', function () { canvas.discardActiveObject().renderAll(); selectedObject = null; textToolbar.style.display='none'; });

    // Canvas resizing
    resizeCanvasBtn.addEventListener('click', function () {
        const w = parseInt(canvasWidthInput.value) || 600;
        const h = parseInt(canvasHeightInput.value) || 800;
        // scale existing background image (if any) proportionally
        const bg = canvas.backgroundImage;
        const prevW = canvas.width, prevH = canvas.height;
        canvas.setWidth(w);
        canvas.setHeight(h);
        if (bg) {
            // re-scale bg to fit new size
            fabric.Image.fromURL(bg.getSrc ? bg.getSrc() : bg.src || bg.getElement().src, function (img) {
                const scale = Math.min(w / img.width, h / img.height);
                img.set({ left: 0, top: 0, originX: 'left', originY: 'top', scaleX: scale, scaleY: scale, selectable: false, evented: false });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
            }, { crossOrigin: 'anonymous' });
        }
        canvas.renderAll();
    });

    // make Enter key finalize editing (textarea) but not submit the form accidentally
    canvas.on('text:editing:entered', function() { /* reserved */ });

    // Save: extract objects to JSON and put into hidden fields
    function exportZonesToJSON() {
        const objects = canvas.getObjects().filter(o => o !== canvas.backgroundImage);
        const textZones = [], imageZones = [];
        objects.forEach(obj => {
            if (obj.type === 'textbox' || obj.type === 'i-text' || obj.type === 'text') {
                textZones.push({
                    x: Math.round(obj.left),
                    y: Math.round(obj.top),
                    width: Math.round((obj.width || obj.getScaledWidth()) * (obj.scaleX || 1)),
                    height: Math.round((obj.height || obj.getScaledHeight()) * (obj.scaleY || 1)),
                    font_size: Math.round(obj.fontSize || 0),
                    font_family: obj.fontFamily || '',
                    color: obj.fill || '',
                    bold: (obj.fontWeight === 'bold'),
                    italic: (obj.fontStyle === 'italic'),
                    alignment: obj.textAlign || obj.textAlign || 'left',
                    background_color: obj.backgroundColor || null,
                    rotation: Math.round(obj.angle || 0),
                    text: obj.text || ''
                });
            } else {
                // treat any non-text object as image zone placeholder (rect) or image
                if (obj.type === 'rect' || obj.type === 'image' || obj.type === 'path' || obj.type === 'group' || obj.type === 'image') {
                    let w = Math.round((obj.width || obj.getScaledWidth()) * (obj.scaleX || 1));
                    let h = Math.round((obj.height || obj.getScaledHeight()) * (obj.scaleY || 1));
                    imageZones.push({
                        x: Math.round(obj.left),
                        y: Math.round(obj.top),
                        width: w,
                        height: h,
                        rotation: Math.round(obj.angle || 0),
                        type: obj.type
                    });
                }
            }
        });
        document.getElementById('textZonesInput').value = JSON.stringify(textZones);
        document.getElementById('imageZonesInput').value = JSON.stringify(imageZones);
    }

    // intercept form submit to generate JSON
    const productForm = document.getElementById('productForm');
    productForm.addEventListener('submit', function (e) {
        exportZonesToJSON();
        // allow submit to continue; Laravel will handle validation
    });

    // Font loading helper for initial default fonts
    ['Roboto','Open Sans','Lobster','Montserrat','Arial'].forEach(f => loadGoogleFont(f));

    // Resize canvas when window resizes (optional)
    //window.addEventListener('resize', () => canvas.requestRenderAll());

});
</script>
@endsection
