<style>
    #drop-zone-admin { 
        border: 2px dashed #ffc107; 
        border-radius: 50%; 
        width: 120px; 
        height: 120px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        overflow: hidden; 
        position: relative; 
        margin: 0 auto; 
        cursor: pointer; 
        background: #f8f9fa; 
        transition: 0.3s; 
    }
    @media (min-width: 768px) { #drop-zone-admin { width: 140px; height: 140px; } }
    #drop-zone-admin img { width: 100%; height: 100%; object-fit: cover; position: absolute; z-index: 1; }
    #drop-zone-admin .overlay { position: absolute; z-index: 2; background: rgba(0,0,0,0.5); color: white; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; transition: 0.3s; }
    #drop-zone-admin:hover .overlay { opacity: 1; }
    #drop-zone-admin.dragover { border-color: #28a745; background: #e9f7ef; }
</style>

<div class="text-center mb-4">
    <label id="drop-zone-admin" class="shadow-sm">
        <img id="previewAvatar" src="<?= !empty($user['avatar']) ? $user['avatar'] . '?v='.time() : 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>">
        <div class="overlay"><i class="fas fa-camera fs-3"></i></div>
        <input type="file" name="avatar" id="avatarInput" hidden accept="image/*">
    </label>
    <div class="mt-2 text-muted small fw-bold">Nhấn hoặc kéo thả ảnh vào đây</div>
</div>

<script>
    const dropZone = document.getElementById('drop-zone-admin');
    const fInput = document.getElementById('avatarInput');
    const pImg = document.getElementById('previewAvatar');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => dropZone.addEventListener(e, (ev) => { ev.preventDefault(); ev.stopPropagation(); }));
    ['dragenter', 'dragover'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.add('dragover')));
    ['dragleave', 'drop'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.remove('dragover')));

    dropZone.addEventListener('drop', (e) => {
        let files = e.dataTransfer.files;
        if (files.length) { fInput.files = files; updatePreview(files[0]); }
    });

    fInput.addEventListener('change', function() { if(this.files.length) updatePreview(this.files[0]); });

    function updatePreview(file) { 
        const reader = new FileReader(); 
        reader.onload = (e) => pImg.src = e.target.result; 
        reader.readAsDataURL(file); 
    }
</script>