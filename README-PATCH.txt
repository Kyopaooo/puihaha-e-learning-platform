PUHAHA FINAL FIXES - INSTALLATION NOTES

This patch adds:
- Lesson editing and deletion for administrators and the instructor who owns the course.
- Draft lesson previews for authorized administrators and the course-owning instructor.
- Student access remains limited to enrolled students and published lessons.
- Laravel email verification for newly registered student accounts.
- Existing local demo accounts are marked verified by the database seeder so they remain usable for demonstrations.
- Verification routes and a resend-verification page.

INSTALL
1. Back up C:\xampp\htdocs\puihaha-test.
2. Extract this ZIP.
3. Copy the folders into C:\xampp\htdocs\puihaha-test, preserving the folder structure.
4. Do NOT replace or upload your .env file.
5. In the project terminal run:
   php artisan optimize:clear
   php artisan db:seed
6. Check routes:
   php artisan route:list --name=lessons
   php artisan route:list --name=verification
7. Restart the local server if needed:
   php artisan serve

EMAIL VERIFICATION CONFIGURATION
The uploaded project's current .env uses MAIL_MAILER=log. With that setting, Laravel writes verification messages to storage/logs/laravel.log instead of delivering them to an inbox.

To send real verification emails, configure SMTP in your LOCAL .env. Example for Gmail SMTP:

MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-sending-gmail-address
MAIL_PASSWORD=your-16-character-google-app-password
MAIL_FROM_ADDRESS=your-sending-gmail-address
MAIL_FROM_NAME="${APP_NAME}"

For Gmail, enable 2-Step Verification and create an App Password. Use the App Password, not your normal Google account password. Keep all credentials private and never upload .env.

After editing .env, run:
   php artisan optimize:clear

For a no-delivery local test, keep MAIL_MAILER=log, register a NEW account, and open storage/logs/laravel.log to find the verification URL. This confirms the verification notification is generated, but it does not prove delivery to an email inbox.

DEMO ACCOUNTS
The three seeded local demo accounts are marked as already verified:
admin@puihaha.test
instructor@puihaha.test
student@puihaha.test

Their existing demo password remains ChangeMe123! unless you have changed it.

IMPORTANT
- Do not run php artisan migrate:fresh.
- This patch does not include .env, vendor, node_modules, or your database.
- A 419 on logout can occur if the browser's session/CSRF token has expired. Refresh the page and retry. The current layout already uses a POST logout form with @csrf; do not change logout to a GET link.
- Test with a newly registered email address after SMTP is configured. The three demo accounts are intentionally pre-verified and will not receive verification emails.
