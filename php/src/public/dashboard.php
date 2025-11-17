<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        #previewModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        #previewModal .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>
</head>
<body>
    <h1>Welcome to your Dashboard</h1>
    <p>Your user ID is: <?php echo $_SESSION['user_id']; ?></p>
    <a href="/api/logout.php">Logout</a>

    <h2>Upload File</h2>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
    <div id="uploadMessage"></div>

    <h2>Your Files</h2>
    <table id="filesTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Size</th>
                <th>Type</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div id="previewModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="viewer"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FBXLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/OBJLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/api/upload.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('uploadMessage').innerText = data.message;
                loadFiles();
            });
        });

        function loadFiles() {
            fetch('/api/get_files.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('filesTable').getElementsByTagName('tbody')[0];
                    tableBody.innerHTML = '';
                    data.forEach(file => {
                        const row = tableBody.insertRow();
                        let actions = `
                            <a href="/api/download.php?file_id=${file.id}">Download</a>
                            <button onclick="deleteFile(${file.id})">Delete</button>
                        `;
                        if (['model/gltf-binary', 'model/gltf+json', 'application/octet-stream'].includes(file.type) || file.name.endsWith('.fbx') || file.name.endsWith('.obj')) {
                            actions += `<button onclick="previewFile(${file.id}, '${file.name}')">Preview</button>`;
                        }
                        row.innerHTML = `
                            <td>${file.name}</td>
                            <td>${file.size}</td>
                            <td>${file.type}</td>
                            <td>${file.created_at}</td>
                            <td>${actions}</td>
                        `;
                    });
                });
        }

        function deleteFile(fileId) {
            if (confirm('Are you sure you want to delete this file?')) {
                fetch(`/api/delete.php?file_id=${fileId}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    loadFiles();
                });
            }
        }

        function previewFile(fileId, fileName) {
            const modal = document.getElementById('previewModal');
            modal.style.display = 'block';

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer();
            renderer.setSize(window.innerWidth * 0.7, window.innerHeight * 0.7);
            document.getElementById('viewer').innerHTML = '';
            document.getElementById('viewer').appendChild(renderer.domElement);

            const controls = new THREE.OrbitControls(camera, renderer.domElement);

            const light = new THREE.HemisphereLight(0xffffff, 0x000000, 1);
            scene.add(light);

            camera.position.z = 5;

            const fileUrl = `/uploads/<?php echo $_SESSION['user_id']; ?>/${fileName}`;
            const fileExtension = fileName.split('.').pop().toLowerCase();

            let loader;
            if (fileExtension === 'gltf' || fileExtension === 'glb') {
                loader = new THREE.GLTFLoader();
            } else if (fileExtension === 'fbx') {
                loader = new THREE.FBXLoader();
            } else if (fileExtension === 'obj') {
                loader = new THREE.OBJLoader();
            }

            if (loader) {
                loader.load(fileUrl, function (object) {
                    scene.add(object.scene || object);
                    animate();
                }, undefined, function (error) {
                    console.error(error);
                });
            }

            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }
        }

        function closeModal() {
            document.getElementById('previewModal').style.display = 'none';
        }

        window.onload = loadFiles;
    </script>
</body>
</html>