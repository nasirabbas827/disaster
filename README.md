# Disaster_final  

**Disaster_final** is a web‑based Disaster Information Management System built with PHP. It enables administrators and rehabilitation staff to record, edit, and view disaster and relief data, as well as manage user accounts. The application provides a clean, role‑based interface for both public users and staff members.

---

## Overview  

The system centralises disaster‑related information (e.g., incident details, relief measures, public messages) and presents it through a responsive UI. It supports:

* Secure login / registration for users and admins.  
* Role‑based dashboards (admin vs. rehabilitation staff).  
* CRUD operations for disaster and relief records.  
* User management (add, edit, deactivate).  
* Simple configuration via `config.php` files.

All data is stored in a MySQL database (`disaster_db.sql`).

---

## Features  

| Feature | Description |
|---------|-------------|
| **User Authentication** | Login, registration, password reset, and logout. |
| **Admin Dashboard** | View, add, edit, and delete disaster & relief information. |
| **Rehab Staff Interface** | Similar CRUD capabilities for staff members with a separate UI. |
| **User Management** | Admins can create, edit, and deactivate user accounts. |
| **Responsive Design** | CSS styles (`admin/css/style.css`, `rehab/css/style.css`, `css/style.css`) adapt to desktop and mobile. |
| **Modular Navigation** | Shared `navbar.php` components for consistent navigation across sections. |
| **Database Export** | `Database/disaster_db.sql` provides the schema and sample data. |
| **Documentation** | Project overview in `Online Disaster Information Management System.docx`. |

---

## Tech Stack  

| Layer | Technology |
|-------|------------|
| **Backend** | PHP 7.4+ |
| **Database** | MySQL / MariaDB |
| **Frontend** | HTML5, CSS3 (custom style sheets) |
| **Server** | Apache / Nginx (any web server supporting PHP) |
| **Version Control** | Git (GitHub) |

---

## Installation  

1. **Clone the repository**  

   ```bash
   git clone https://github.com/yourusername/Disaster_final.git
   cd Disaster_final
   ```

2. **Set up the database**  

   * Create a new MySQL database (e.g., `disaster_db`).  
   * Import the schema and sample data:  

   ```bash
   mysql -u YOUR_DB_USER -p disaster_db < Database/disaster_db.sql
   ```

3. **Configure PHP connection**  

   * Edit the root `config.php` (and the `admin/config.php` / `rehab/config.php` files if you prefer separate connections) and replace the placeholder values with your credentials:  

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'disaster_db');
   define('DB_USER', 'YOUR_DB_USER');
   define('DB_PASS', 'YOUR_DB_PASSWORD');
   ```

4. **Set up a web server**  

   * Place the project folder inside your web‑server’s document root (e.g., `/var/www/html/Disaster_final`).  
   * Ensure the server has permission to read the files and write session data.  

5. **Optional – Enable URL rewriting** (Apache)  

   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteBase /Disaster_final/
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^(.*)$ index.php [L]
   </IfModule>
   ```

6. **Install dependencies** (if any)  

   The project uses only core PHP, so no Composer packages are required.

---

## Usage  

###