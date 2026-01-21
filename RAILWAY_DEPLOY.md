# PAUD Damhil - Railway Deployment Guide

## Quick Deploy Steps

### 1. Push to GitHub

```bash
git add .
git commit -m "Add Railway deployment config"
git push origin main
```

### 2. Setup Railway

1. Buka [railway.app](https://railway.app) → Login dengan GitHub
2. Klik **"New Project"**
3. Pilih **"Deploy from GitHub repo"**
4. Pilih repository `paud-laravel`

### 3. Add MySQL Database

1. Di Railway project, klik **"+ New"**
2. Pilih **"Database"** → **"MySQL"**
3. Railway akan otomatis inject environment variables

### 4. Set Environment Variables

Di Railway dashboard → **Variables** tab, tambahkan:

| Variable | Value |
|----------|-------|
| `APP_KEY` | *(generate dengan `php artisan key:generate --show`)* |
| `APP_NAME` | `PAUD Damhil` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_TIMEZONE` | `Asia/Makassar` |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |
| `LOG_CHANNEL` | `stderr` |

> **Note**: `DB_*` variables akan otomatis terisi dari MySQL plugin

### 5. Generate Domain

1. Klik service Laravel Anda
2. Go to **Settings** → **Networking**
3. Klik **"Generate Domain"**
4. Anda akan mendapat URL seperti: `paud-laravel-production.up.railway.app`

### 6. Update APP_URL

Tambahkan variable:

```
APP_URL=https://your-app-name.up.railway.app
```

---

## Verification

Test API dengan curl:

```bash
# Test public endpoint
curl https://your-app.up.railway.app/api/settings

# Test login
curl -X POST https://your-app.up.railway.app/api/login \
  -H "Content-Type: application/json" \
  -d '{"nip":"198501012010011001","password":"123456"}'
```

---

## Troubleshooting

### Build Failed

- Check Railway build logs
- Pastikan `composer.json` dan `package.json` valid

### Database Error  

- Pastikan MySQL plugin sudah di-add
- Check apakah migrations sudah jalan: lihat deploy logs

### 500 Error

- Set `APP_DEBUG=true` sementara untuk lihat error
- Check `LOG_CHANNEL=stderr` lalu lihat runtime logs
