# Puihaha E-Learning Platform — Laravel 12 application update

This is an **application overlay** for the existing Laravel 12.70.0 project, not a replacement Laravel installation. It preserves the original migrations and adds authentication, membership, transaction/payment, course, lesson, enrollment, progress, learning-center, and API configuration components.

## Before applying
1. Make a copy of your current `membership-management-system` folder.
2. Export/backup the `e-learning_platform` MySQL database in phpMyAdmin.
3. Do not replace your local `.env` file. This package intentionally does not include it.

## Apply the files
1. Extract this ZIP.
2. Copy the contents of its `membership-management-system` folder into your existing `C:\xampp\htdocs\membership-management-system` folder, choosing **merge/overwrite** when prompted for the included application files.
3. Keep your current `.env` and existing database.
4. Add these lines to the bottom of your local `.env` file:

```env
GOOGLE_MAPS_BROWSER_KEY=
GOOGLE_WEATHER_API_KEY=
```

5. In VS Code terminal, run:

```powershell
php artisan optimize:clear
php artisan migrate
php artisan db:seed
php artisan storage:link
```

6. Start the app:

```powershell
php artisan serve
```

7. Open `http://127.0.0.1:8000`.

## Demo accounts
The seeder creates the following accounts if they do not already exist:

| Role | Email | Temporary password |
|---|---|---|
| Administrator | admin@puihaha.test | ChangeMe123! |
| Instructor | instructor@puihaha.test | ChangeMe123! |
| Student | student@puihaha.test | ChangeMe123! |

Change these demo passwords before any real deployment. `firstOrCreate` does not reset passwords for accounts that already exist.

## Implemented in this first build
- Student registration and login/logout.
- Administrator, instructor, and student roles.
- Member CRUD, search, category and level assignment, deactivation, optional account linking, and map coordinate fields.
- Membership category and level management.
- Membership application and renewal transaction records.
- Payment recording with balance validation, payment references, and printable receipts.
- Approval rule: only fully paid transactions can be approved.
- Course catalog and course management.
- Lesson creation/viewing and student lesson completion tracking.
- Admin dashboard statistics and weather widget integration point.
- Google Maps address search and map pin selection when a browser key is configured.

## Google API configuration
Enable the Google Maps JavaScript API and Places API for the browser key. Restrict the browser key by HTTP referrer and API. Add the browser key to `GOOGLE_MAPS_BROWSER_KEY`.

Enable Google Weather API for the server-side key and add it to `GOOGLE_WEATHER_API_KEY`. Restrict the server-side key to the required API and server environment where possible. The dashboard weather panel also requires an active learning-center record with latitude and longitude. The seeded center does not include coordinates; add its coordinates in the database before testing weather.

The integrations require real Google Cloud credentials and billing/API enablement as applicable. An empty key leaves the rest of the application usable and displays a configuration note on the member form.

## Important limitations to address in the next build/test pass
- This is the first application build, not a claim of a fully acceptance-tested final submission. The PHP files passed syntax checks in the build environment, but the full Laravel app could not be executed against your local MySQL database here.
- The learning-material model/table is present; file upload and download screens still need to be completed.
- Course category administration, lesson edit/delete, and learning-center management screens still need to be completed.
- The seeded demo student is not automatically assigned a member record. An administrator can create a member and link the student account from the member form.
- Existing legacy member category/level strings are mapped to the new category/level IDs by the seeder when a matching default value exists.
- Run the provided commands locally and share any error output so it can be corrected before submission.

## Safety
Do not share `.env`, API keys, or database passwords. Do not run `php artisan migrate:fresh` on your working database.
