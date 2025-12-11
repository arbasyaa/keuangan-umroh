# Panduan Deploy ke Railway.app (GRATIS)

## 🎯 Persiapan

### 1. Buat Akun Railway
- Kunjungi: https://railway.app
- Sign up dengan GitHub (WAJIB pakai GitHub)
- Gratis 500 jam/bulan (cukup untuk personal use)

### 2. Persiapkan Repository GitHub

#### Cara A: Upload Manual ke GitHub (Untuk Pemula)
```bash
# 1. Buat repo baru di GitHub: https://github.com/new
#    Nama: keuangan-umroh
#    Private/Public: Terserah
#    Jangan centang README

# 2. Di terminal laptop, jalankan:
cd "/home/arbasya/Projek Umroh"

# Initialize git (kalau belum)
git init

# Add semua file
git add .

# Commit
git commit -m "Initial commit - Aplikasi Keuangan Umroh"

# Connect ke GitHub (ganti USERNAME dengan username GitHub Anda)
git remote add origin https://github.com/USERNAME/keuangan-umroh.git

# Push ke GitHub
git branch -M main
git push -u origin main
```

#### Cara B: Pakai GitHub Desktop (Lebih Mudah)
1. Download GitHub Desktop: https://desktop.github.com
2. Login dengan akun GitHub
3. Klik "Add" → "Add Existing Repository"
4. Pilih folder: `/home/arbasya/Projek Umroh`
5. Klik "Publish repository"
6. Selesai!

---

## 🚀 Deploy ke Railway

### Step 1: Buat Project Baru
1. Login ke Railway: https://railway.app
2. Klik "New Project"
3. Pilih "Deploy from GitHub repo"
4. Pilih repository: `keuangan-umroh`
5. Klik "Deploy Now"

### Step 2: Setup Database MySQL
1. Di Railway dashboard, klik "New" → "Database" → "Add MySQL"
2. Database otomatis dibuat
3. Railway akan auto-connect ke aplikasi Laravel

### Step 3: Setup Environment Variables
1. Klik tab "Variables"
2. Tambahkan variable berikut:

```env
APP_NAME="Pencatatan Keuangan Umroh"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stderr
```

**PENTING:** Railway akan auto-populate `${{MYSQL_*}}` dari database yang dibuat!

### Step 4: Generate APP_KEY
1. Di Railway, klik tab "Deployments"
2. Klik deployment terbaru
3. Scroll ke bawah, cari "Logs"
4. Copy APP_KEY yang di-generate otomatis
5. Paste ke Variables (atau biarkan auto-generate)

### Step 5: Deploy!
1. Railway akan otomatis build dan deploy
2. Tunggu 3-5 menit
3. Klik "View Deployment"
4. Aplikasi online! 🎉

---

## 📱 Akses Aplikasi

Setelah deploy sukses, Anda akan dapat URL:
```
https://keuangan-umroh-production.up.railway.app
```

**Aplikasi bisa diakses dari mana saja:**
- ✅ HP (via browser)
- ✅ Laptop
- ✅ Tablet
- ✅ Dari rumah, kantor, mall, dimana saja!

---

## 🔧 Troubleshooting

### Jika deployment gagal:

#### Error: "APP_KEY not set"
**Solusi:**
1. Buka Railway → Variables
2. Klik "Raw Editor"
3. Generate key manual:
```bash
# Di laptop, jalankan:
php artisan key:generate --show

# Copy hasilnya, misalnya:
# base64:xyz123abc456...

# Tambahkan ke Variables:
APP_KEY=base64:xyz123abc456...
```

#### Error: "Database connection failed"
**Solusi:**
1. Pastikan MySQL service sudah running
2. Cek Variables: `DB_HOST`, `DB_PORT`, dll sudah ter-set otomatis
3. Re-deploy dengan klik "Redeploy"

#### Error: "Storage not writable"
**Solusi:**
Railway sudah handle ini di `deploy.sh`, tapi kalau tetap error:
1. Tambah di Variables:
```
FILESYSTEM_DISK=public
```

#### Error: "Class not found"
**Solusi:**
1. Pastikan `composer.json` sudah di-push ke GitHub
2. Re-deploy

---

## 🎨 Custom Domain (Opsional)

### Cara Pakai Domain Sendiri:
1. Beli domain (Rp 100rb/tahun di Niagahoster/IDCloudHost)
2. Di Railway → Settings → Domains
3. Klik "Custom Domain"
4. Masukkan domain: `keuangan-umroh.com`
5. Update DNS di registrar domain:
   - Type: CNAME
   - Name: www
   - Value: your-app.railway.app
6. Tunggu 5-10 menit
7. Selesai!

---

## 💰 Biaya

**Railway Free Tier:**
- ✅ 500 jam/bulan GRATIS
- ✅ $5 credit/bulan
- ✅ Auto sleep setelah 1 jam idle (bisa di-disable)
- ✅ SSL certificate gratis
- ✅ Unlimited bandwidth

**Untuk 1 user pribadi:** Selamanya GRATIS!
**Untuk banyak user:** Upgrade ke Pro ($5/bulan)

---

## 🔄 Update Aplikasi

Setiap kali Anda update code:
```bash
# Edit file di laptop
# Commit changes:
git add .
git commit -m "Update fitur XYZ"
git push

# Railway auto-deploy dalam 2-3 menit!
```

---

## 📞 Support

Jika ada masalah:
1. Cek Railway Logs (sangat detail!)
2. Tanya di Railway Discord: https://discord.gg/railway
3. Atau contact saya lagi 😊

---

## ✅ Checklist Deployment

- [ ] Akun Railway dibuat
- [ ] Code di-push ke GitHub
- [ ] Project Railway dibuat
- [ ] MySQL database ditambahkan
- [ ] Environment variables di-set
- [ ] Deployment sukses
- [ ] Bisa akses via URL
- [ ] Test tambah transaksi
- [ ] Test upload foto
- [ ] Test download PDF
- [ ] Share URL ke pengguna

---

**🎉 SELAMAT! Aplikasi Anda sudah online dan bisa diakses dari mana saja!**
