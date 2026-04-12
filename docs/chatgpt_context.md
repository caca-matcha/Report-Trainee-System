# 🤖 Report Trainee System - Context for AI (ChatGPT / Claude / etc.)

This document is intended to be pasted to AI assistants to provide immediate context about the "Report Trainee System" (Dharma Learning Center Training Management System).

## 📌 Project Overview
- **Name**: Report Trainee System
- **Purpose**: A corporate training management system handling Training Master Data, Batch Execution, Attendance, and Performance Evaluation. 
- **Framework**: Laravel 11 (PHP 8.2+)
- **Frontend Stack**: Laravel Blade, Tailwind CSS (Custom Premium Glassmorphism Theme), Chart.js, Lucide Icons.
- **Database**: MySQL / MariaDB (Eloquent ORM).

## 🏗️ Core Architecture & Flow

### 1. Master Data Training (`MasterTraining`)
- Stores the blueprint of a training course.
- **Key Fields**: `event_no` (Auto-generated based on Category, e.g., MDT_01001), `category`, `training_course`, `provider`, `passing_grade`.
- **Flow**: Admin creates Master Training -> Admin triggers "Execute" to start a training batch.

### 2. Training Execution (`Training`)
- Represents a specific batch/session of a Master Training.
- Contains the actual dates, location, trainers array, pics array.
- **Key Statuses**: `Draft`, `Ongoing`, `Upcoming`, `Selesai` (Archive).

### 3. Training Participants (`TrainingParticipant`)
- Represents employees attending a specific Training.
- **Key Fields**: `training_id`, `npk`, `name`, `department`, `attendance_status`, `score` (pre_test, post_test), `signature_path`.
- **Flow**: Added manually or via CSV/Google Sheets sync -> Scans QR for attendance -> Submits signature -> Evaluated by Trainers/PICs.

### 4. Admin Dashboard
- Premium UI with "Welcome Home" greeting.
- Features real-time widget statistics (Active Sessions, Total Trainees).
- Built heavily utilizing Tailwind CSS `backdrop-blur`, custom gradients, and border-radius `rounded-[2.5rem]`.

## 📂 Key File Locations
- **Routes**: `routes/web.php`
- **Dashboard View**: `resources/views/admin/dashboard.blade.php`
- **Master Data Views**: `resources/views/admin/master/trainings/*`
- **Execution Controller**: `App\Http\Controllers\Admin\MasterTrainingController`
- **Models**: `App\Models\MasterTraining`, `App\Models\Training`, `App\Models\TrainingParticipant`

## 💡 Code Style & Conventions
1. **Design**: Modern UI with large border radiuses, soft drop shadows, mesh gradients, and indigo/emerald accents.
2. **Icons**: Exclusively use `lucide-icons` defined by `data-lucide="..."`.
3. **Database**: Use standard Laravel Migrations & standard Eloquent relationships.
4. **Naming**: Variables use camelCase or snake_case consistently, Controller methods use standard RESTful naming.

*Copy this text and paste it into a new ChatGPT session whenever you need assistance with this specific project!*
