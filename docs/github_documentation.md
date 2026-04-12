# 📚 Technical Documentation & GitHub Wiki

Welcome to the technical documentation for the **Report Trainee System**. This guide is intended for developers, maintainers, and open-source contributors working on this repository via GitHub.

## 🗄️ Database Architecture

The system utilizes a relational database mapped through Laravel's Eloquent ORM.

### Core Entities
1. **`users`**: System administrators, master accounts, and employee data synced from corporate DB.
2. **`master_trainings`**: Central repository of all training curriculums. Pre-defined blueprints for courses.
3. **`trainings`**: Active or archived executions of a master training. Contains schedule, location, trainers (JSON), and PICs (JSON).
4. **`training_participants`**: Many-to-one relationship with `trainings`. Stores participant NPK, attendance status (`present`, `absent`), evaluation scores, and digital signatures.
5. **`training_evaluations`** & **`training_atmospheres`**: Stores Customer Satisfaction Index (CSI) results and photographic atmosphere evidences during training.

## 🔐 Authentication & Middleware

The system uses standard Laravel Breeze/Jetstream authentication but restricts access via custom middleware:
- `auth`: Ensures the user is logged in.
- `npk_restrict`: Ensures the user has a valid corporate NPK registered in the local database.
- `role:admin`: Protects all routes prefixed with `admin/*` (dashboard, master data management, user sync). 

## 🌐 Route Structure (`routes/web.php`)

- **Public Routes**: Contains digitally signed URLs for participant QR code attendance scanning (`/trainings/{training}/presence`).
- **User / PIC Routes**: Handles scoring, import/export templates, and Google Sheets sync (`/trainings/*`).
- **Admin Routes**: Grouped under `/admin`, restricted by `role:admin`. Contains controllers inside `App\Http\Controllers\Admin\*`.

## 🎨 Design System & UI Guidelines

This project uses a custom "Glassmorphism" design approach via **Tailwind CSS**. If you are contributing UI changes, adhere to these rules:

1. **Border Radius**: 
   - Cards & Containers: `rounded-[2.5rem]` or `rounded-[3rem]`.
   - Small Elements (Inputs/Buttons): `rounded-2xl` or `rounded-3xl` (pill).
2. **Colors**: 
   - Primary accents are `indigo-500/600` and `emerald-500/600`. 
   - Avoid solid dark backgrounds; utilize `dark:bg-gray-800` coupled with `border border-white/5` for depth.
3. **Icons**: 
   - Use **Lucide Icons** implemented via HTML attributes (`<i data-lucide="icon-name"></i>`).
   - Call `lucide.createIcons()` upon dynamic rendering.
4. **Animations**: 
   - Modals and List Items should utilize the custom Tailwind `@keyframes` defined in Blade files (e.g., `.animate-fade-in`).

## 🔄 Integrations

### Google Sheets Sync
The system supports fetching Observation and CSI data directly from Google Sheets.
- **Workflow**: Ensure the Google Sheets are set to "Anyone with the link can read". The backend utilizes custom import logic (`syncFromGoogleSheets`) inside Controller actions to parse arrays.

### CSV Bulk Upload
For massive trainee databases, use the built-in Master Data import features. Ensure headers align exactly with the system's requirements (NPK, Nama, Dept).

## 🛠️ Dev Notes & Troubleshooting

- **Chart.js Not Loading**: Ensure the CDN script `<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>` is pushed to the `@stack('scripts')` before executing custom canvas initialization.
- **500 Server Error on Dashboard**: Commonly caused by missing named routes in UI navigation buttons. Always verify `route('admin.x')` commands match `php artisan route:list`.
- **Search Dropdown Clipping**: For cards containing live search results (`quick-search-pic`), ensure parent containers lack `overflow-hidden` classes so absolute positioned dropdowns appear correctly.

---

*This document is formatted for GitHub wikis and developer handovers.*
