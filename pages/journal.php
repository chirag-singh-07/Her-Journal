<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$page_title = 'My Journal';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Journal - Her Journal</title>
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap"
        rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/shared.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        /* Journal Page Specific Styles - Enhanced */
        .journal-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 40px;
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .journal-container {
                grid-template-columns: 1fr;
            }
        }

        /* Editor Section */
        .editor-section {
            background: white;
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            position: sticky;
            top: 100px;
        }

        .editor-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            margin-bottom: 20px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .daily-prompt-box {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px dashed #4ade80;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #15803d;
        }

        .daily-prompt-box p {
            font-style: italic;
            font-weight: 500;
            margin: 0;
            font-size: 0.95rem;
        }

        .refresh-prompt-btn {
            background: rgba(255, 255, 255, 0.6);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #166534;
            transition: all 0.2s;
        }

        .refresh-prompt-btn:hover {
            background: white;
            transform: rotate(180deg);
        }

        .media-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .media-btn {
            padding: 10px 16px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .media-btn:hover {
            background: white;
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .media-btn.recording {
            background: #fee2e2;
            color: #ef4444;
            border-color: #ef4444;
            animation: pulse 1.5s infinite;
        }

        /* Entry List Section */
        .entries-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .section-header h3 {
            font-size: 1.5rem;
            font-family: 'Playfair Display', serif;
        }

        .search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .search-container input {
            width: 100%;
            padding: 14px 20px;
            padding-left: 48px;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            background: white;
            font-family: inherit;
            outline: none;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .search-container input:focus {
            box-shadow: 0 8px 16px rgba(124, 58, 237, 0.08);
            border-color: rgba(124, 58, 237, 0.2);
        }

        .search-container i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .filter-tags {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-tag {
            padding: 6px 14px;
            border-radius: 50px;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.85rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-tag:hover,
        .filter-tag.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Re-style Entry Cards specifically for this page */
        .journal-entry-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            /* Prevent overflow */
        }

        .journal-entry-card:hover {
            background: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        /* Fixed Media Container */
        .entry-media {
            margin-top: 15px;
            margin-bottom: 15px;
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 300px;
            /* Limit height */
        }

        .entry-media video,
        .entry-media img {
            width: 100%;
            height: auto;
            max-height: 300px;
            /* Ensure max height matches container */
            object-fit: contain;
            /* Show full content without cropping */
            display: block;
        }

        .journal-date-badge {
            display: inline-block;
            background: rgba(124, 58, 237, 0.08);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 12px;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main-content">
            <?php include '../includes/header.php'; ?>

            <div class="journal-container">
                <!-- Editor Column (Left) -->
                <div class="editor-section">
                    <div class="editor-header">
                        <h3><i class="fa-solid fa-feather-pointed" style="color: var(--primary);"></i> Pen Your Thoughts
                        </h3>
                    </div>

                    <!-- Daily Prompt Feature -->
                    <div class="daily-prompt-box">
                        <p id="dailyPrompt">"What made you smile today?"</p>
                        <button class="refresh-prompt-btn" onclick="newPrompt()" title="New Prompt"><i
                                class="fa-solid fa-rotate"></i></button>
                    </div>

                    <!-- Media Controls -->
                    <div class="media-controls">
                        <button class="media-btn" onclick="capturePhoto()"><i class="fa-solid fa-camera"></i>
                            Photo</button>
                        <button class="media-btn" id="videoBtn" onclick="toggleVideoRecording()"><i
                                class="fa-solid fa-video"></i> Video</button>
                        <button class="media-btn" onclick="document.getElementById('fileInput').click()"><i
                                class="fa-solid fa-upload"></i> Upload</button>
                        <input type="file" id="fileInput" accept="image/*,video/*" style="display: none;"
                            onchange="handleFileSelect(event)">
                    </div>

                    <!-- Preview Area -->
                    <div class="media-preview" id="mediaPreview">
                        <button class="remove-media" onclick="clearMedia()"><i class="fa-solid fa-times"></i></button>
                        <video id="previewVideo" controls
                            style="display: none; width: 100%; border-radius: 12px; margin-bottom: 15px;"></video>
                        <img id="previewImage"
                            style="display: none; width: 100%; border-radius: 12px; margin-bottom: 15px;">
                    </div>

                    <div class="editor-wrapper">
                        <textarea id="thoughts" placeholder="Dear Diary, today I felt..."
                            style="background: #f8fafc; border: none;"></textarea>
                        <div class="editor-tools">
                            <div class="mood-selector">
                                <span class="label">Mood:</span>
                                <select id="mood" class="mood-dropdown">
                                    <option value="Happy">😊 Happy</option>
                                    <option value="Calm">😌 Calm</option>
                                    <option value="Sad">😢 Sad</option>
                                    <option value="Anxious">😰 Anxious</option>
                                    <option value="Energetic">⚡ Energetic</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" onclick="saveEntry()">Save Entry</button>
                        </div>
                    </div>
                </div>

                <!-- Entries List Column (Right) -->
                <div class="entries-section">
                    <div class="section-header">
                        <h3>Your Journey</h3>
                        <div class="filter-tags">
                            <span class="filter-tag active" onclick="filterEntries('all')">All</span>
                            <span class="filter-tag" onclick="filterEntries('Happy')">Happy</span>
                            <span class="filter-tag" onclick="filterEntries('Calm')">Calm</span>
                            <span class="filter-tag" onclick="filterEntries('Sad')">Sad</span>
                        </div>
                    </div>

                    <div class="search-container">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" placeholder="Search your memories..."
                            onkeyup="searchEntries()">
                    </div>

                    <div id="entries-list" class="entries-scroll">
                        <div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i> Loading...</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modals -->
    <div class="modal" id="editModal">
        <div class="modal-content glass-card">
            <h3>Edit Entry</h3>
            <textarea id="editText" class="journal-input"
                style="width: 100%; min-height: 150px; padding: 15px; border-radius: 12px; border: 1px solid #ddd; margin: 15px 0;"></textarea>
            <div class="modal-actions" style="display: flex; gap: 10px; justify-content: flex-end;">
                <button class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button class="btn btn-primary" onclick="updateEntry()">Update</button>
            </div>
        </div>
    </div>

    <script src="../js/common.js"></script>
    <script>
        let entries = [];
        let filteredEntries = [];
        let editIndex = null;
        let currentMediaFile = null;
        let mediaRecorder = null;
        let recordedChunks = [];
        let stream = null;

        // Prompts Logic
        const prompts = [
            "What made you smile today?",
            "What is a challenge you overcame?",
            "Describe a moment of peace.",
            "What are you grateful for right now?",
            "Who are you appreciating today?",
            "Write a note to your future self."
        ];

        function newPrompt() {
            document.getElementById("dailyPrompt").innerText = `"${prompts[Math.floor(Math.random() * prompts.length)]}"`;
        }

        // --- EXISTING LOGIC PRESERVED BELOW ---

        // Media Capture Functions
        async function capturePhoto() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                const video = document.createElement('video');
                video.srcObject = stream;
                video.play();
                const modal = document.createElement('div');
                modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px;';
                video.style.cssText = 'max-width: 90%; max-height: 70vh; border-radius: 12px;';
                const captureBtn = document.createElement('button');
                captureBtn.className = 'btn btn-primary';
                captureBtn.innerHTML = '<i class="fa-solid fa-camera"></i> Capture';
                const cancelBtn = document.createElement('button');
                cancelBtn.className = 'btn btn-secondary';
                cancelBtn.textContent = 'Cancel';
                modal.appendChild(video);
                const div = document.createElement('div'); div.style.display = 'flex'; div.style.gap = '15px';
                div.appendChild(captureBtn); div.appendChild(cancelBtn); modal.appendChild(div);
                document.body.appendChild(modal);

                captureBtn.onclick = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth; canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0);
                    canvas.toBlob(blob => {
                        currentMediaFile = new File([blob], 'photo.png', { type: 'image/png' });
                        showMediaPreview(URL.createObjectURL(blob), 'image');
                        stream.getTracks().forEach(track => track.stop());
                        document.body.removeChild(modal);
                    }, 'image/png');
                };
                cancelBtn.onclick = () => { stream.getTracks().forEach(track => track.stop()); document.body.removeChild(modal); };
            } catch (err) { alert('Camera error: ' + err.message); }
        }

        async function toggleVideoRecording() {
            const btn = document.getElementById('videoBtn');
            if (!mediaRecorder || mediaRecorder.state === 'inactive') {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                    mediaRecorder = new MediaRecorder(stream);
                    recordedChunks = [];
                    mediaRecorder.ondataavailable = (e) => { if (e.data.size > 0) recordedChunks.push(e.data); };
                    mediaRecorder.onstop = () => {
                        const blob = new Blob(recordedChunks, { type: 'video/webm' });
                        currentMediaFile = new File([blob], 'video.webm', { type: 'video/webm' });
                        showMediaPreview(URL.createObjectURL(blob), 'video');
                        stream.getTracks().forEach(track => track.stop());
                        btn.classList.remove('recording');
                        btn.innerHTML = '<i class="fa-solid fa-video"></i> Video';
                    };
                    mediaRecorder.start();
                    btn.classList.add('recording');
                    btn.innerHTML = '<i class="fa-solid fa-stop"></i> Stop';
                } catch (err) { alert('Mic/Cam error: ' + err.message); }
            } else { mediaRecorder.stop(); }
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                currentMediaFile = file;
                const url = URL.createObjectURL(file);
                const type = file.type.startsWith('image/') ? 'image' : 'video';
                showMediaPreview(url, type);
            }
        }

        function showMediaPreview(url, type) {
            const preview = document.getElementById('mediaPreview');
            const video = document.getElementById('previewVideo');
            const img = document.getElementById('previewImage');
            if (type === 'video') { video.src = url; video.style.display = 'block'; img.style.display = 'none'; }
            else { img.src = url; img.style.display = 'block'; video.style.display = 'none'; }
            preview.classList.add('active');
        }

        function clearMedia() {
            currentMediaFile = null;
            document.getElementById('mediaPreview').classList.remove('active');
            document.getElementById('previewVideo').src = '';
            document.getElementById('previewImage').src = '';
            document.getElementById('fileInput').value = '';
        }

        async function loadEntries() {
            try {
                const res = await fetch("../php/get_entries.php");
                if (res.status === 403) return window.location.href = "login.php";
                const data = await res.json();
                entries = data;
                filteredEntries = data; // Init filtered
                renderEntries();
            } catch (e) { console.error(e); }
        }

        function filterEntries(mood) {
            // Update UI
            document.querySelectorAll('.filter-tag').forEach(tag => {
                if (tag.innerText === mood || (mood === 'all' && tag.innerText === 'All')) tag.classList.add('active');
                else tag.classList.remove('active');
            });

            if (mood === 'all') filteredEntries = entries;
            else filteredEntries = entries.filter(e => e.mood === mood);
            renderEntries(filteredEntries);
        }

        function searchEntries() {
            const term = document.getElementById('searchInput').value.toLowerCase();
            filteredEntries = entries.filter(e => e.text.toLowerCase().includes(term));
            renderEntries(filteredEntries);
        }

        function renderEntries(data = entries) {
            const list = document.getElementById("entries-list");
            list.innerHTML = "";
            if (data.length === 0) {
                list.innerHTML = `<div class="empty-state"><i class="fa-regular fa-paper-plane" style="font-size: 2rem; color: var(--text-muted); margin-bottom: 10px;"></i><p>No entries found.</p></div>`;
                return;
            }

            data.forEach((entry, i) => {
                const realIndex = entries.indexOf(entry); // Ensure correct index for edit/delete
                const date = new Date(entry.entry_date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                const item = document.createElement("div");
                item.className = "journal-entry-card"; // New class

                let mediaHTML = '';
                if (entry.attachment_path) {
                    const isVideo = entry.attachment_type && entry.attachment_type.startsWith('video/');
                    if (isVideo) mediaHTML = `<div class="entry-media"><video src="../${entry.attachment_path}" controls></video></div>`;
                    else mediaHTML = `<div class="entry-media"><img src="../${entry.attachment_path}" alt="Entry media"></div>`;
                }

                item.innerHTML = `
                <div class="journal-date-badge">${date}</div>
                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span class="entry-mood" style="font-weight:600; color:var(--text-main);">${getMoodIcon(entry.mood)} ${entry.mood}</span>
                    <div class="entry-actions">
                        <button onclick="openEdit(${realIndex})" style="background:none; border:none; cursor:pointer; color:var(--text-muted);"><i class="fa-solid fa-pen"></i></button>
                        <button onclick="deleteEntry(${realIndex})" style="background:none; border:none; cursor:pointer; color:var(--text-muted);"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                ${mediaHTML}
                <p class="entry-preview" style="margin-top:10px; color:var(--text-main); line-height:1.6;">${entry.text}</p>
            `;
                list.appendChild(item);
            });
        }

        function getMoodIcon(mood) {
            const icons = { 'Happy': '😊', 'Calm': '😌', 'Sad': '😢', 'Anxious': '😰', 'Energetic': '⚡' };
            return icons[mood] || '😐';
        }

        async function saveEntry() {
            const text = document.getElementById("thoughts").value;
            const mood = document.getElementById("mood").value;
            if (!text && !currentMediaFile) return alert("Please write something or add media!");
            const fd = new FormData();
            fd.append("text", text || "(Media only)");
            fd.append("mood", mood);
            if (currentMediaFile) fd.append("media", currentMediaFile);
            await fetch("../php/save_entry.php", { method: "POST", body: fd });
            document.getElementById("thoughts").value = "";
            clearMedia();
            loadEntries();
            newPrompt(); // Refresh prompt
        }

        async function deleteEntry(i) {
            if (!confirm("Delete this entry?")) return;
            const fd = new FormData();
            fd.append("id", entries[i].id);
            await fetch("../php/delete_entry.php", { method: "POST", body: fd });
            loadEntries();
        }

        function openEdit(i) {
            editIndex = i;
            document.getElementById("editText").value = entries[i].text;
            document.getElementById("editModal").classList.add("active");
        }

        function closeModal(id) { document.getElementById(id).classList.remove("active"); }

        async function updateEntry() {
            const fd = new FormData();
            fd.append("id", entries[editIndex].id);
            fd.append("text", document.getElementById("editText").value);
            await fetch("../php/update_entry.php", { method: "POST", body: fd });
            closeModal("editModal");
            loadEntries();
        }

        window.onload = function () {
            loadEntries();
            newPrompt();
        };
    </script>
</body>

</html>