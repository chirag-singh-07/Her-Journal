// let entries = [];
//       let editIndex = null;
//       let lockIndex = null;
//       const quotes = [
//         "Every day is a second chance.",
//         "Believe in yourself!",
//         "Your story matters.",
//         "Small steps every day.",
//         "Stay positive, work hard, make it happen.",
//       ];

//       function nextQuote() {
//         const q = quotes[Math.floor(Math.random() * quotes.length)];
//         document.getElementById("quote").innerText = q;
//       }

//       function saveEntry() {
//         const text = document.getElementById("thoughts").value.trim();
//         const mood = document.getElementById("mood").value;
//         if (!text) {
//           alert("Please write something!");
//           return;
//         }
//         const entry = {
//           text,
//           mood,
//           date: new Date().toLocaleString(),
//           lock: null,
//         };
//         entries.push(entry);
//         document.getElementById("thoughts").value = "";
//         renderEntries();
//       }

//       function renderEntries() {
//         const container = document.getElementById("entries");
//         container.innerHTML = "";
//         entries.forEach((entry, index) => {
//           const div = document.createElement("div");
//           div.className = "entry" + (entry.lock ? " locked" : "");
//           div.innerHTML = `
//         <strong>${entry.date}</strong> | Mood: ${entry.mood}
//         <p>${entry.text}</p>
//         <div class="entry-buttons">
//           <button onclick="openEdit(${index})">Edit</button>
//           <button onclick="deleteEntry(${index})">Delete</button>
//           <button onclick="openLock(${index})">${
//             entry.lock ? "Unlock" : "Set Lock"
//           }</button>
//         </div>
//       `;
//           container.appendChild(div);
//         });
//       }

//       function deleteEntry(i) {
//         entries.splice(i, 1);
//         renderEntries();
//       }

//       function openEdit(i) {
//         editIndex = i;
//         document.getElementById("editText").value = entries[i].text;
//         document.getElementById("editModal").style.display = "flex";
//       }

//       function updateEntry() {
//         entries[editIndex].text = document.getElementById("editText").value;
//         closeModal("editModal");
//         renderEntries();
//       }

//       function openLock(i) {
//         lockIndex = i;
//         document.getElementById("lockPassword").value = "";
//         document.getElementById("lockModal").style.display = "flex";
//       }

//       function applyLock() {
//         const pass = document.getElementById("lockPassword").value;
//         if (!pass) return;
//         let entry = entries[lockIndex];
//         if (!entry.lock) {
//           entry.lock = pass; // set lock
//         } else {
//           if (entry.lock === pass) {
//             entry.lock = null; // unlock
//           } else {
//             alert("Wrong password!");
//           }
//         }
//         closeModal("lockModal");
//         renderEntries();
//       }

//       function closeModal(id) {
//         document.getElementById(id).style.display = "none";
//       }

let entries = [];
let editIndex = null;
let lockIndex = null;

async function loadEntries() {
  const res = await fetch("../php/get_entries.php");
  if (!res.ok) return;
  entries = await res.json();
  renderEntries();
}

async function saveEntry() {
  const text = document.getElementById("thoughts").value.trim();
  const mood = document.getElementById("mood").value;
  if (!text) {
    alert("Please write something!");
    return;
  }

  const formData = new FormData();
  formData.append("text", text);
  formData.append("mood", mood);

  await fetch("../php/save_entry.php", { method: "POST", body: formData });
  document.getElementById("thoughts").value = "";
  loadEntries(); // reload list
}

async function deleteEntry(i) {
  const id = entries[i].id;
  const formData = new FormData();
  formData.append("id", id);

  await fetch("../php/delete_entry.php", { method: "POST", body: formData });
  loadEntries();
}

function openEdit(i) {
  editIndex = i;
  document.getElementById("editText").value = entries[i].text;
  document.getElementById("editModal").style.display = "flex";
}

async function updateEntry() {
  const id = entries[editIndex].id;
  const text = document.getElementById("editText").value;

  const formData = new FormData();
  formData.append("id", id);
  formData.append("text", text);

  await fetch("../php/update_entry.php", { method: "POST", body: formData });
  closeModal("editModal");
  loadEntries();
}

function renderEntries() {
  const container = document.getElementById("entries");
  container.innerHTML = "";
  entries.forEach((entry, index) => {
    const div = document.createElement("div");
    div.className = "entry" + (entry.lock_password ? " locked" : "");
    div.innerHTML = `
      <strong>${entry.entry_date}</strong> | Mood: ${entry.mood}
      <p>${entry.text}</p>
      <div class="entry-buttons">
        <button onclick="openEdit(${index})">Edit</button>
        <button onclick="deleteEntry(${index})">Delete</button>
      </div>
    `;
    container.appendChild(div);
  });
}

window.onload = loadEntries;
