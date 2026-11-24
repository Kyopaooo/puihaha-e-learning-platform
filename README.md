# Puihaha E-Learning Platform

Puihaha is a Laravel-based e-learning and membership management platform. It combines course delivery, student learning progress, membership administration, transaction processing, and payment records in one application.

## Main Features

### Administrator
- Manage member profiles, categories, and membership levels.
- Link student login accounts to member profiles.
- Review and approve membership transactions.
- Record payments and view transaction/payment history.
- Manage courses and lessons.
- View dashboard statistics, current learning-center weather, and the learning-center map.

### Instructor
- Create and manage courses.
- Add, edit, publish, and unpublish lessons.
- Upload learning materials to lessons.
- View students enrolled in their courses and monitor learning progress.

### Student
- Register and verify an email address.
- Browse published courses and enroll.
- Access lesson content and available learning materials.
- Mark lessons as completed and view course progress.
- View membership information and transaction/payment history.

## Technologies

- PHP 8.2 or later
- Laravel 12
- MySQL / MariaDB
- Blade templates
- HTML, CSS, and JavaScript
- Leaflet and OpenStreetMap for interactive maps
- Open-Meteo for current weather information

The map and weather integrations in this version use Leaflet/OpenStreetMap and Open-Meteo. They do not require Google Maps API keys. OpenStreetMap attribution is displayed in the map interface. Open-Meteo data is attributed in the weather panel.

## Requirements

Install the following before setting up the project:

- PHP 8.2+
- Composer
- MySQL or MariaDB (XAMPP can be used on Windows)
- PHP extensions required by Laravel 12, including OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, and Fileinfo

Node.js and npm are only needed if you intend to rebuild frontend assets through Vite. The project includes its public stylesheet under `public/css`.

## Installation

### 1. Get the project

Clone the repository:

```bash
git clone https://github.com/Kyopaooo/puihaha-e-learning-platform.git
cd puihaha-e-learning-platform
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create the environment file

Copy `.env.example` to `.env`.

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Update the database settings in `.env` to match your local MySQL configuration:

```env
APP_NAME="Puihaha E-Learning Platform"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=puihaha_test
DB_USERNAME=root
DB_PASSWORD=
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

### 4. Set up the database

There are two ways to prepare the database. Choose **one** method.

#### Option A: Import the demonstration database

1. Start Apache and MySQL in XAMPP.
2. Open phpMyAdmin.
3. Create a database named `puihaha_test`.
4. Select that database and use the **Import** tab.
5. Import `database/puihaha_test_demo.sql`.
6. Confirm that `.env` uses the same database name and credentials.

The demonstration SQL export contains the saved database structure and sample data from the project. Use the included demo records for evaluation.

#### Option B: Build a fresh database with migrations and seeders

If you do not want to use the demonstration SQL export:

1. Create an empty MySQL database named `puihaha_test`.
2. Configure `.env` to connect to it.
3. Run:

```bash
php artisan migrate --seed
```

The seeder creates initial demonstration accounts and default membership/course categories and membership levels.

**Important:** Do not run `php artisan migrate:fresh` on a database containing data you want to keep. It drops existing tables.

### 5. Finish Laravel setup

Run:

```bash
php artisan optimize:clear
php artisan storage:link
```

If the `storage:link` command reports that the link already exists, the link may already be configured.

### 6. Configure email verification

Email verification requires a working mail transport. The `.env.example` uses the `log` mailer for local development, which writes messages to the Laravel log instead of sending them to an inbox.

To send verification messages through SMTP, configure your own mail settings in `.env`. Example structure:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email-username
MAIL_PASSWORD=your-email-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-verified-sender-address
MAIL_FROM_NAME="Puihaha E-Learning Platform"
```

Use your own SMTP provider's values. Never commit real email passwords or app passwords to GitHub.

### 7. Run the application

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## Demonstration Accounts

The database seeder defines these initial demonstration accounts:

| Role | Email | Initial password for newly seeded accounts |
|---|---|---|
| Administrator | `admin@puihaha.test` | `ChangeMe123!` |
| Instructor | `instructor@puihaha.test` | `ChangeMe123!` |
| Student | `student@puihaha.test` | `ChangeMe123!` |

The seeder uses `firstOrCreate`. If an account already exists in an imported database, running the seeder does not reset that account's password. The listed password is therefore only guaranteed for accounts created by the seeder on a fresh database.

Change demonstration passwords before any real deployment. These `.test` email addresses are for local demonstration and do not receive real email.

## Learning Center Location and Weather

The dashboard weather panel reads the active learning center's latitude and longitude from the `learning_centers` table. The demonstration location is FEU Institute of Technology, Manila:

- Latitude: `14.604167`
- Longitude: `120.988611`

If the imported database does not already contain these coordinates, update the learning-center record in phpMyAdmin or through a database administration tool. For example:

```sql
UPDATE learning_centers
SET latitude = 14.604167,
    longitude = 120.988611
WHERE name = 'Puihaha Main Learning Center';
```

The application retrieves current weather data from Open-Meteo and caches the response for 15 minutes. Weather display requires an internet connection from the PHP server.

The member form uses Leaflet with OpenStreetMap tiles to select and save member coordinates. The dashboard map displays the configured learning-center location. Public OpenStreetMap tile services have a usage policy; retain attribution and avoid bulk downloads or high-volume use.

## Database and Data Safety

- Keep `.env` private. It contains local database and mail credentials.
- Do not commit real API keys, SMTP passwords, or other secrets.
- The demonstration SQL file should contain only sample information suitable for sharing.
- Use fictional or dedicated demo email addresses and phone numbers in public demonstration data.
- Passwords are stored as hashes, not plain text. Use dedicated demonstration accounts and change their passwords before real deployment.
- Back up the database before importing or modifying it.

## Useful Commands

```bash
# Clear Laravel's cached configuration, routes, and views
php artisan optimize:clear

# List registered routes
php artisan route:list

# Run automated tests
php artisan test

# Start the local development server
php artisan serve
```

## Repository

GitHub: https://github.com/Kyopaooo/puihaha-e-learning-platform
