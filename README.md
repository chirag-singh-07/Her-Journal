# 🌸 Her Journal

> *A safe, beautiful space to capture your thoughts, track your moods, and reflect on your journey.*

![Her Journal Banner](https://via.placeholder.com/1200x400?text=Her+Journal+Dashboard)

**Her Journal** is a modern, privacy-focused digital journaling application built for those who appreciate aesthetics and simplicity. enhance your daily writing habit with a distraction-free editor, mood tracking, multimedia support, and insightful analytics—all wrapped in a stunning **Glassmorphism** and **Neo-Brutalist** design.

---

## 📖 Table of Contents

- [✨ Features](#-features)
- [🎨 Design Philosophy](#-design-philosophy)
- [🛠️ Tech Stack](#️-tech-stack)
- [🚀 Installation &amp; Setup](#-installation--setup)
- [📂 Project Structure](#-project-structure)
- [🗄️ Database Schema](#️-database-schema)
- [🔌 API Endpoints](#-api-endpoints)
- [🔮 Future Roadmap](#-future-roadmap)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)

---

## ✨ Features

### 📝 Smart Journaling

- **Rich Text Editor**: Write freely with a clean, spacious interface.
- **Daily Prompts**: Get a unique, thoughtful prompt every day to help overcome writer's block (e.g., *"What made you smile today?"*).
- **Search & Filter**: Instantly find past entries by keyword or filter them by mood tags.

### 📸 Multimedia Support

- **Photo Capture**: Take photos directly from your webcam to attach to your entries.
- **Video Recording**: Record short video clips to preserve moments in motion.
- **File Uploads**: Upload existing images or videos from your device.

### 😊 Mood Tracking

- **Emotional Logging**: Tag every entry with a mood (Happy, Calm, Sad, Anxious, Energetic).
- **Visual Cues**: Each mood is represented by a specific color and emoji, making it easy to scan your history.

### 📊 Analytics & Insights

- **Mood Trends**: Visualize your emotional journey over the last 7 or 30 days with interactive charts.
- **Consistency Streaks**: Track how many days in a row you've journaled.
- **Word Cloud**: See which themes occur most frequently in your happy entries.

### 📅 Interactive Calendar

- **Monthly View**: Browse your entries in a calendar grid.
- **Mood Indicators**: Quickly see how you felt on a specific day at a glance.
- **Memory Lane**: Click on a date to see a summary of that day's entry.

### ⚙️ Personalization

- **Theme Selection**: Choose between Light and Dark modes (UI ready).
- **Accent Colors**: Customize the application's primary color to match your vibe.
- **Profile Management**: Update your bio and avatar.

---

## 🎨 Design Philosophy

**Her Journal** moves away from the flat, corporate look of standard apps. We utilize:

* **Glassmorphism**: Translucent, frosted-glass cards (`backdrop-filter: blur`) that layer beautifully over colorful, gradient backgrounds.
* **Neo-Brutalism**: Bold typography ('Outfit' & 'Playfair Display'), high-contrast borders, and distinct shadows for a modern, edgy feel.
* **Responsive Layout**: A sidebar navigation that adapts seamlessly from desktop to mobile screens.

---

## 🛠️ Tech Stack

### Frontend

- **HTML5 & CSS3**: Custom properties (variables), Flexbox/Grid layouts, and CSS animations.
- **JavaScript (ES6+)**: Vanilla JS for DOM manipulation, `fetch` API for backend communication, and `MediaRecorder` API for video/audio capture.
- **Libraries**:
  - [FontAwesome 6](https://fontawesome.com/): For consistent, high-quality icons.
  - [Google Fonts](https://fonts.google.com/): Typography.
  - [Chart.js](https://www.chartjs.org/): For rendering beautiful analytics charts.

### Backend

- **PHP 7.4+**: Core server-side logic, session management, and file handling.
- **MySQL**: Relational database for storing users, entries, and metadata.

---

## 🚀 Installation & Setup

Follow these steps to get **Her Journal** running on your local machine.

### Prerequisites

- A local web server stack like **XAMPP**, **WAMP**, or **MAMP**.
- Git installed on your system.

### Step 1: Clone the Repository

```bash
git clone https://github.com/chirag-singh-07/Her-Journal.git
```

### Step 2: Move to Server Directory

Move the project folder into your server's root directory:

- **XAMPP**: `C:\xampp\htdocs\`
- **MAMP**: `/Applications/MAMP/htdocs/`

### Step 3: Database Setup

1. Start **Apache** and **MySQL** from your XAMPP/MAMP control panel.
2. Open **phpMyAdmin** in your browser (`http://localhost/phpmyadmin`).
3. Create a new database named `her_journal`.
4. **Import Schema**:
   - Click **Import**.
   - Choose the `db.sql` file from the project root.
   - Click **Go** to create the tables.
5. **Run Migration** (Critical for Media Support):
   - Import `db_migration_add_media.sql` to add the `attachment_path` columns.

### Step 4: Configure Connection

Open `php/config.php` (create it if it doesn't exist) and ensure your credentials match:

```php
<?php
$servername = "localhost";
$username = "root";       // Default XAMPP user
$password = "";           // Default XAMPP password is empty
$dbname = "her_journal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### Step 5: Launch!

Open your browser and navigate to:
`http://localhost/her-journal/pages/login.php`

---

## 📂 Project Structure

```text
her-journal/
├── css/                    # all styling files
│   ├── dashboard.css       # specific styles for dashboard components
│   └── shared.css          # global variables and utility classes
├── js/                     # frontend logic
│   └── common.js           # shared functions (e.g., logout, modal logic)
├── pages/                  # application views
│   ├── dashboard.php       # main overview page
│   ├── journal.php         # writing & entries page
│   ├── analytics.php       # analytics dashboard
│   ├── calendar.php        # calendar view
│   ├── settings.php        # user settings
│   └── login.php           # auth pages
├── php/                    # backend api endpoints
│   ├── config.php          # database connection
│   ├── save_entry.php      # create entry & handle uploads
│   ├── get_entries.php     # read entries
│   ├── update_entry.php    # edit entry
│   └── delete_entry.php    # delete entry
├── includes/               # reusable php components
│   ├── header.php          # top navigation bar
│   └── sidebar.php         # side navigation menu
├── uploads/                # storage for user photos/videos
└── db.sql                  # database schema definition
```

---

## 🗄️ Database Schema

### `users`

| Column       | Type     | Description           |
| :----------- | :------- | :-------------------- |
| `id`       | INT (PK) | Unique user ID        |
| `name`     | VARCHAR  | User's full name      |
| `email`    | VARCHAR  | User's email (Unique) |
| `password` | VARCHAR  | Hashed password       |

### `journal_entries`

| Column              | Type     | Description                      |
| :------------------ | :------- | :------------------------------- |
| `id`              | INT (PK) | Unique entry ID                  |
| `user_id`         | INT (FK) | Owner of the entry               |
| `text`            | TEXT     | The journal content              |
| `mood`            | VARCHAR  | Mood tag (Happy, Sad, etc.)      |
| `attachment_path` | VARCHAR  | Path to uploaded media file      |
| `attachment_type` | VARCHAR  | MIME type (image/png, video/mp4) |
| `entry_date`      | DATETIME | Timestamp of creation            |

---

## 🔌 API Endpoints

All endpoints return JSON responses or status codes.

- **`POST /php/save_entry.php`**: Expects `text`, `mood`, and optional `media` file.
- **`GET /php/get_entries.php`**: Returns an array of entries for the logged-in user.
- **`POST /php/delete_entry.php`**: Expects `id` of entry to delete.

---

## 🔮 Future Roadmap

- [ ] **AI Mood Insights**: Use sentiment analysis to provide deeper emotional insights.
- [ ] **Mobile App**: Native mobile application using React Native.
- [ ] **Export Options**: Download journal as PDF or Markdown.
- [ ] **Data Encryption**: End-to-end encryption for text entries.

---

## 🤝 Contributing

Contributions make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

<p align="center">
  Made with ❤️ by <a href="https://github.com/chirag-singh-07">Chirag Singh</a>
</p>
