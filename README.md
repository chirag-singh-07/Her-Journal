# Her Journal 🌸

**Her Journal** is a modern, beautifully designed digital journaling application that helps you capture your daily thoughts, track your moods, and reflect on your personal journey. Built with a focus on aesthetics (Glassmorphism & Neo-Brutalism) and user experience.

## ✨ Key Features

- **📝 Daily Journaling**: Write unlimited entries with a rich, distraction-free editor.
- **📸 Media Attachments**: Capture photos and record videos directly within your journal entries to preserve memories vividly.
- **😊 Mood Tracking**: Log how you feel each day (Happy, Calm, Sad, Anxious, Energetic) and visualize your emotional trends.
- **💡 Daily Prompts**: Need inspiration? Get a new thoughtful prompt every day to kickstart your writing.
- **📊 Analytics Dashboard**: Visualize your writing consistency, mood distribution, and keyword themes (currently with placeholder data).
- **📅 Interactive Calendar**: View your journey day-by-day with mood indicators (currently visual-only).
- **🎨 Custom Themes**: Toggle between Light/Dark modes and accent colors (Settings page UI implemented).
- **🔒 Secure & Private**: User authentication ensures your journal remains private.

## 🛠️ Tech Stack

- **Frontend**: HTML5, CSS3 (Glassmorphism), JavaScript (Vanilla)
- **Backend**: PHP (Core)
- **Database**: MySQL
- **Icons**: FontAwesome 6
- **Fonts**: 'Outfit' & 'Playfair Display' (Google Fonts)

## 🚀 Getting Started

### Prerequisites

- A local server environment like **XAMPP**, **WAMP**, or **MAMP** (Apache & MySQL).
- PHP 7.4 or higher.

### Installation

1.  **Clone the repository**:
    ```bash
    git clone https://github.com/chirag-singh-07/Her-Journal.git
    ```

2.  **Move project to your server directory** (e.g., `htdocs` in XAMPP):
    ```bash
    mv Her-Journal C:/xampp/htdocs/her-journal
    ```

3.  **Database Setup**:
    - Open `phpMyAdmin` (usually at `http://localhost/phpmyadmin`).
    - Create a new database named `her_journal`.
    - Import `db.sql` to create the initial tables.
    - Run the SQL commands in `db_migration_add_media.sql` to add support for media attachments.

4.  **Configuration**:
    - Navigate to `php/config.php` (if not present, create one based on your DB credentials).
    - Ensure your database connection details (host, user, password, db_name) are correct.

5.  **Run the Application**:
    - Open your browser and go to: `http://localhost/her-journal/pages/login.php` (or wherever you placed the folder).

## 📂 Project Structure

```
her-journal/
├── css/                # Stylesheets (Dashboard, Shared, Glassmorphism)
├── js/                 # Client-side scripts (Common functions)
├── pages/              # Main application views
│   ├── dashboard.php   # Overview & Quick Actions
│   ├── journal.php     # Main Writing & Entry Management
│   ├── analytics.php   # Visual Reports
│   ├── calendar.php    # Calendar View
│   ├── settings.php    # User Preferences
│   └── login.php       # Authentication
├── php/                # Backend Logic (API endpoints)
│   ├── save_entry.php  # Handles text & file uploads
│   ├── get_entries.php # Retrieves JSON data
│   └── ...
├── includes/           # Reusable components (Header, Sidebar)
├── uploads/            # Stores user-uploaded media
└── db.sql              # Database schema
```

## 🤝 Contributing

Contributions are welcome! If you have ideas for new features (like AI-powered mood analysis or export options), feel free to fork the repository and submit a pull request.

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

---

*Made with ❤️ by Chirag Singh*
