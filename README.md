<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&height=220&color=0:00F7FF,50:7C3AED,100:FF2E63&text=Online%20Course%20Material%20Management%20System&fontColor=ffffff&fontSize=34&fontAlignY=38&desc=Laravel%20%7C%20PHP%20%7C%20MySQL%20%7C%20Role-Based%20E-Learning%20Platform&descAlignY=58&descSize=16" />

<img src="https://readme-typing-svg.demolab.com?font=JetBrains+Mono&weight=700&size=22&duration=2800&pause=1000&color=00F7FF&center=true&vCenter=true&width=900&lines=Manage+course+materials+online;Role-based+access+for+users+and+admins;Authentication+%7C+Search+%7C+Filtering+%7C+Material+Management;Built+with+Laravel%2C+PHP%2C+and+MySQL" />

<br><br>

<a href="https://github.com/bapikarmandal/Online-Course-Material-Management-System">
  <img src="https://img.shields.io/badge/GitHub-Repository-181717?style=for-the-badge&logo=github&logoColor=white" />
</a>
<img src="https://img.shields.io/badge/Laravel-Framework-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
<img src="https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php&logoColor=white" />
<img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />

</div>

---

## Project Overview

**Online Course Material Management System** is a web-based e-learning platform built to help students and admins manage course materials in a clean and organized way.

The project includes authentication, role-based access, study material management, and advanced search/filtering features. It is designed for educational use cases where study resources need to be uploaded, managed, searched, and accessed easily.

---

## Key Features

<table>
  <tr>
    <td><b>User Authentication</b></td>
    <td>Secure login and registration system for users.</td>
  </tr>
  <tr>
    <td><b>Role-Based Access</b></td>
    <td>Different access levels for admin and users/students.</td>
  </tr>
  <tr>
    <td><b>Study Material Management</b></td>
    <td>Add, update, view, and manage course-related study materials.</td>
  </tr>
  <tr>
    <td><b>Advanced Search</b></td>
    <td>Find course materials quickly using search functionality.</td>
  </tr>
  <tr>
    <td><b>Filtering System</b></td>
    <td>Filter materials based on course, subject, category, or related details.</td>
  </tr>
  <tr>
    <td><b>Database Integration</b></td>
    <td>Stores and manages application data using MySQL.</td>
  </tr>
</table>

---

## Tech Stack

<div align="center">

### Backend

<img src="https://skillicons.dev/icons?i=laravel,php&perline=8" />

### Frontend

<img src="https://skillicons.dev/icons?i=html,css,js,bootstrap&perline=8" />

### Database

<img src="https://skillicons.dev/icons?i=mysql&perline=8" />

### Tools

<img src="https://skillicons.dev/icons?i=git,github,vscode,postman&perline=8" />

<br>

![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)

</div>

---

## Modules

### Admin Module

- Admin login and dashboard
- Manage users/students
- Manage courses and subjects
- Upload and manage study materials
- Search and filter uploaded materials
- Update or remove old records

### User/Student Module

- User registration and login
- View available course materials
- Search study materials
- Filter materials by available categories
- Access learning resources from one place

---

## Installation and Setup

Follow these steps to run the project locally.

### 1. Clone the repository

```bash
git clone https://github.com/bapikarmandal/Online-Course-Material-Management-System.git
```

### 2. Go to the project folder

```bash
cd Online-Course-Material-Management-System
```

### 3. Install PHP dependencies

```bash
composer install
```

### 4. Create environment file

```bash
cp .env.example .env
```

On Windows PowerShell, use:

```powershell
copy .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Configure database

Open the `.env` file and update your MySQL database details:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=course_material_db
DB_USERNAME=root
DB_PASSWORD=
```

Create a database with the same name in phpMyAdmin or MySQL.

### 7. Run database migration

```bash
php artisan migrate
```

If the project has seeders, run:

```bash
php artisan db:seed
```

### 8. Start the development server

```bash
php artisan serve
```

Now open:

```text
http://127.0.0.1:8000
```

---

## Project Workflow

```text
User/Admin
   |
   v
Login / Register
   |
   v
Dashboard
   |
   v
Course Material Management
   |
   v
Search / Filter / View Materials
   |
   v
MySQL Database
```

---

## Folder Structure

```text
Online-Course-Material-Management-System/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
└── README.md
```

---

## Future Enhancements

- Add material download tracking
- Add student dashboard analytics
- Add email notification system
- Add course-wise reports
- Add PDF preview before download
- Improve admin dashboard UI

---

## Author

<div align="center">

<h3>Bapikar Mandal</h3>

<p>
Computer Science and Technology Diploma Student<br>
Full-Stack Web Developer | Software Developer Aspirant
</p>

<a href="mailto:bapikarmandal76@gmail.com">
  <img src="https://img.shields.io/badge/Gmail-EA4335?style=for-the-badge&logo=gmail&logoColor=white" />
</a>
<a href="https://linkedin.com/in/bapikar-mandal">
  <img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white" />
</a>
<a href="https://github.com/bapikarmandal">
  <img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white" />
</a>
<a href="https://bapikarmandal.vercel.app">
  <img src="https://img.shields.io/badge/Portfolio-000000?style=for-the-badge&logo=vercel&logoColor=white" />
</a>

</div>

---

## Support

If you like this project, please consider giving it a star on GitHub.

<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&height=120&section=footer&color=0:00F7FF,50:7C3AED,100:FF2E63" />

</div>
