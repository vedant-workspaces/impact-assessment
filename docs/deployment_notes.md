# 🚀 NGO Platform – Deployment Notes

## 🧠 Overview
This project backend is built using:
- Laravel (PHP)
- PostgreSQL (Supabase)
- Docker (for containerization)
- Render (for hosting)

---

## 🌐 Live URLs

- **Backend URL:**
  https://your-app.onrender.com

- **Health Check Endpoint:**
  /api/health

---

## 🗄️ Database (Supabase)

- **Provider:** Supabase
- **Connection Type:** Pooler (recommended for deployment)
- **SSL:** Enabled

### DB Configuration
DB_CONNECTION=pgsql
DB_HOST=your-pooler-host
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
DB_SSLMODE=require

---

## ⚙️ Render Deployment

- **Service Type:** Web Service (Docker)
- **Branch:** setup-laravel-base
- **Region:** (closest available)

### Environment Variables
APP_NAME=NGOPlatform
APP_ENV=production
APP_KEY=base64:YOUR_KEY
APP_DEBUG=false
APP_URL=https://your-app.onrender.com

DB_CONNECTION=pgsql
DB_HOST=your-pooler-host
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
DB_SSLMODE=require

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

---

## 🐳 Docker Configuration

- **PHP Version:** 8.3
- Required extensions installed:
  - pdo
  - pdo_pgsql
  - mbstring
  - zip
  - bcmath
  - opcache

### Startup Command
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000


---

## 🔐 Security Notes

- `.env` is NOT committed to GitHub
- Environment variables are managed via Render
- Supabase SSL is enforced
- RLS (Row Level Security) is currently NOT used (handled via backend)

---

## ⚠️ Known Behaviors

- Render free tier may:
  - Sleep after inactivity
  - First request may take ~30–60 seconds

---

## 🧱 Architecture
Client (future frontend)
↓
Laravel API (Render)
↓
PostgreSQL (Supabase)

---

## 📌 Future Improvements

- Add JWT Authentication
- Implement role-based access (Admin, NGO, Donor, Worker)
- Add database indexes for performance
- Add logging and monitoring
- Enable caching strategies (Redis / DB cache)
- Add CI/CD pipeline

---

## 🧠 Notes

- Always test DB connection locally before deploying
- Keep migration order correct (users → ngos → others)
- Use pooler connection for better compatibility

---

## 👨‍💻 Maintainer

Vedant Salvi  
Backend Developer – Opn Book