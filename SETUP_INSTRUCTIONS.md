# Setup & Run Instructions

This file collects the steps you requested into a single, easy-to-follow checklist with copy-paste commands where applicable.

> NOTE: Replace placeholders (repo URL, paths, database names) with values for your environment.

---

## 1. Clone the repository

If you have a remote URL, run:

```bash
# clone into a folder named 'ospos' (or choose your folder)
git clone <REPO_URL> ospos
cd ospos
```

If you already have the repository locally, skip this step.

## 2. Install software from `downloads.rar`

The archive `downloads.rar` likely contains installers (e.g. PHP builds, database tools, node, npm, Composer, 7-Zip). On Windows:

1. Extract `downloads.rar` using 7-Zip or WinRAR to a temporary folder.
2. Run each installer from the extracted folder and follow their prompts.

Recommendations:
- Ensure PHP (8.1+ / 8.2 recommended), Composer, Node.js (16+ or as required), npm, MySQL or MariaDB, and XAMPP are installed and on your PATH.
- Install 7-Zip to be able to extract RAR archives if needed.

## 3. Copy project into `C:\xampp\htdocs\`

If you cloned elsewhere or extracted files, copy the project folder to XAMPP's webroot:

```powershell
# run in PowerShell as Administrator if required
Copy-Item -Recurse -Force .\ospos "C:\xampp\htdocs\ospos"
cd C:\xampp\htdocs\ospos
```

Or place your project files directly under `C:\xampp\htdocs\`.

## 4. Install PHP dependencies

From the project root (where `composer.json` lives):

```bash
composer install --no-interaction --prefer-dist
```

If Composer is not on PATH, use the full path to `composer.phar`.

## 5. Install Node dependencies and build assets

From the project root:

```bash
npm install
npm run build
```

If the project uses `gulp` or another runner, follow the repository README for the exact build command.

## 6. Edit `.env`

Open the project's `.env` file and set values appropriate for your local XAMPP environment. Common items:

- `CI_ENVIRONMENT = development`
- `app.baseURL = 'http://localhost/ospos/public/'`
- Database credentials (hostname, username, password, database name)
- `session.savePath` (use absolute path or ensure the `writable/session` directory exists)

Example (edit values):

```
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/ospos/public/'
database.default.hostname = localhost
database.default.database = opensourcepos
database.default.username = admin
database.default.password = pointofsale
session.driver = CodeIgniter\Session\Handlers\FileHandler
# Make sure this path is absolute or that writable/session exists
session.savePath = C:/xampp/htdocs/ospos/writable/session
```

Save the file after editing.

## 7. Start XAMPP and create the database

1. Start Apache and MySQL from the XAMPP Control Panel.
2. Create the database (using phpMyAdmin or the MySQL CLI). Example using CLI:

```powershell
# Open a shell and run:
"C:\xampp\mysql\bin\mysql.exe" -u root -p
# then inside MySQL prompt:
CREATE DATABASE opensourcepos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'pointofsale';
GRANT ALL PRIVILEGES ON opensourcepos.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

If you prefer phpMyAdmin, open http://localhost/phpmyadmin/ and create the DB and user there.

## 8. Run migrations

From the project root, run:

```bash
php spark migrate
```

If `php` is not on PATH, use the full path to your PHP executable (e.g. `C:\xampp\php\php.exe`), and if `spark` is not executable, run `php spark migrate`.

## 9. Final checks

- Ensure `writable/` directory is writable by the webserver and that `writable/session` exists if using file sessions.
- Visit `http://localhost/ospos/public/` in your browser.
- If you encounter redirects or session issues, check `writable/logs/` and the Apache/PHP error logs.

---

If you want, I can:
- Create this file in your repository (I created `SETUP_INSTRUCTIONS.md`).
- Run the commands for you (I can run `composer install`, `npm install`, `npm run build`, and `php spark migrate`) — tell me which steps to execute now.

