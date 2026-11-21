# Student Placement Management System

A PHP + MySQL college project with a modern responsive interface.

## Requirements
- XAMPP (Apache + MySQL)
- PHP 8.0+ recommended
- Browser

## Setup
1. Extract `student_placement_management_system.zip`.
2. Copy the `student_placement_management_system` folder into `C:\xampp\htdocs\`.
3. Start Apache and MySQL from XAMPP.
4. Open phpMyAdmin at `http://localhost/phpmyadmin`.
5. Import `database.sql`.
6. Open `config.php` and confirm database settings (defaults are for standard XAMPP).
7. Visit `http://localhost/student_placement_management_system/`.

## Demo admin account
- Email: `admin@college.test`
- Password: `password`

Change the demo password after first login. The password is stored using PHP `password_hash()`.

## Main features
- Student registration and login
- Student profile and CGPA details
- Browse placement opportunities
- Apply for jobs with eligibility checks
- Track application status
- Admin dashboard
- Manage companies and job openings
- Review applications and update status
- Basic placement statistics

## Notes
- This is an academic starter project. Before real deployment, configure HTTPS, email verification, stronger operational controls, backups, and production-grade file scanning/storage.
- Resume upload accepts PDF only and stores files in `uploads/`.
