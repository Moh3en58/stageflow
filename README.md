# StageFlow

StageFlow is a Laravel-based internship management platform developed for the Web Advanced / Programming Project course.

The application supports the complete internship workflow from proposal submission to final grading with different user roles.

---

## Features

### Authentication

- Secure login
- Role-based authorization
- Five user roles:
    - Student
    - Mentor
    - Teacher
    - Committee
    - Admin

---

### Stage Proposals

- Students submit internship proposals
- Committee reviews proposals
- Approval / rejection
- Feedback from committee

---

### Internship Management

- Companies management
- Internships management
- Competencies management
- Weekly logbooks

---

### Evaluations

- Student self-evaluation
- Mentor evaluation
- Teacher overview
- Competency-based assessment

---

### Final Grades

- Teachers register final grades
- Students can view their final grade
- Admin overview

---

### User Management (Admin)

- Create users
- Edit users
- Delete users
- Change user roles

---

## Technology

- Laravel 12
- PHP 8
- SQLite
- Blade
- Tailwind CSS

---

## Installation

Clone the repository

```bash
git clone https://github.com/Moh3en58/stageflow.git
```

Install dependencies

```bash
composer install
npm install
```

Generate application key

```bash
php artisan key:generate
```

Run migrations

```bash
php artisan migrate
```

Seed demo users

```bash
php artisan db:seed
```

Start the application

```bash
php artisan serve
```

---

## Demo Accounts

| Role      | Email              |
| --------- | ------------------ |
| Admin     | admin@test.com     |
| Committee | committee@test.com |
| Teacher   | teacher@test.com   |
| Mentor    | mentor@test.com    |
| Student   | student@test.com   |

Password for all demo accounts:

```
password
```

---

## GitHub

https://github.com/Moh3en58/stageflow

---

## Author

Mohsen Noorani
