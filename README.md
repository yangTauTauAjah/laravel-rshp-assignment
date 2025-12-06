# Dokumentasi Sistem Manajemen Klinik Hewan RSHP

## 📋 Daftar Isi

1. [Pengenalan Sistem](#pengenalan-sistem)
2. [Peran Pengguna dan Hak Akses](#peran-pengguna-dan-hak-akses)
3. [Panduan Masuk Sistem](#panduan-masuk-sistem)
4. [Manajemen Data](#manajemen-data)
5. [Alur Kerja Klinik](#alur-kerja-klinik)
6. [Panduan Per Peran](#panduan-per-peran)

---

## 📖 Pengenalan Sistem

Sistem Manajemen Klinik Hewan RSHP adalah aplikasi web yang dirancang untuk mengelola operasional klinik hewan secara digital. Sistem ini mengganti proses manual dengan sistem terintegrasi yang memungkinkan:

- ✅ Manajemen data hewan peliharaan dan pemilik
- ✅ Penjadwalan dan pengelolaan reservasi dokter  
- ✅ Pencatatan rekam medis digital
- ✅ Manajemen pengguna dan peran akses
- ✅ Kategori tindakan medis dan terapi

---

## 👥 Peran Pengguna dan Hak Akses

### 🔑 **1. Administrator**
**Akses Penuh ke Seluruh Sistem**

| Fitur | Hak Akses |
|-------|-----------|
| **Manajemen Pengguna** | ✅ Create, Read, Update, Delete |
| **Manajemen Peran** | ✅ Assign, Remove, Toggle Status |
| **Data Hewan** | ✅ View All, Edit All, Delete All |
| **Data Pemilik** | ✅ View All, Create, Edit, Delete |
| **Temu Dokter** | ✅ View All, Create, Edit, Delete, Update Status |
| **Rekam Medis** | ✅ View All, Edit Data & Detail, Delete |
| **Master Data** | ✅ Jenis Hewan, Ras, Kategori Tindakan |
| **Manajemen Dokter/Perawat** | ✅ Create, Edit, Delete Profiles |

### 👩‍⚕️ **2. Resepsionis**  
**Manajemen Front Office dan Administrasi**

| Fitur | Hak Akses |
|-------|-----------|
| **Data Hewan** | ✅ View All, Create, Edit, Delete |
| **Data Pemilik** | ✅ View All, Create, Edit, Delete |
| **Temu Dokter** | ✅ View All, Create, Edit, Update Status |
| **Rekam Medis** | ✅ View All (Read Only) |
| **Master Data** | ✅ Jenis Hewan, Ras (Create, Edit, Delete) |
| **Dashboard** | ✅ Statistics Overview |

### 👩‍⚕️ **3. Perawat**
**Manajemen Data Medis dan Assistance**

| Fitur | Hak Akses |
|-------|-----------|
| **Data Hewan** | ✅ View All (Read Only) |
| **Temu Dokter** | ✅ View All |
| **Rekam Medis** | ✅ View All, Edit Data Utama (Anamnesa, Diagnosa, dll) |
| **Dashboard** | ✅ Medical Overview |

**❌ Tidak Dapat:** Edit detail tindakan/terapi (khusus dokter)

### 👨‍⚕️ **4. Dokter**
**Manajemen Medis dan Diagnosa**

| Fitur | Hak Akses |
|-------|-----------|
| **Temu Dokter** | ✅ View Jadwal Sendiri |
| **Rekam Medis** | ✅ View Pasien Sendiri, Edit Detail Tindakan/Terapi |
| **Dashboard** | ✅ Personal Practice Overview |

**❌ Tidak Dapat:** Edit data utama rekam medis (anamnesa, diagnosa - khusus perawat)

### 👤 **5. Pemilik**
**Akses Data Hewan Pribadi**

| Fitur | Hak Akses |
|-------|-----------|
| **Data Hewan** | ✅ View Hewan Sendiri |
| **Temu Dokter** | ✅ View Reservasi Hewan Sendiri |
| **Rekam Medis** | ✅ View Rekam Medis Hewan Sendiri |
| **Profile** | ✅ Edit Profile Sendiri |

---

## 🚪 Panduan Masuk Sistem

### **1. Akses Login**
1. Buka browser dan kunjungi URL sistem klinik
2. Masukkan **Email** dan **Password** yang telah diberikan
3. Klik tombol **"Masuk"**
4. Sistem akan mengarahkan ke dashboard sesuai peran

### **2. Dashboard Overview**
Setelah login berhasil, pengguna akan melihat:
- **Header Navigation** - Menu sesuai hak akses peran
- **Main Dashboard** - Statistik dan ringkasan data
- **Quick Actions** - Tombol aksi cepat untuk fitur utama
- **Recent Activities** - Aktivitas terbaru sistem

### **3. Profile Management**
- Klik nama pengguna di pojok kanan atas
- Pilih **"Profile"** untuk mengedit data personal
- Opsi **"Logout"** untuk keluar sistem

---

## 📊 Manajemen Data

### 🐕 **1. Manajemen Data Hewan**

#### **Input Data Hewan Baru** *(Administrator/Resepsionis)*
1. **Navigasi:** Data → Kelola Hewan Peliharaan
2. **Aksi:** Klik tombol **"+ Tambah Hewan Peliharaan"**
3. **Form Input:**
   - **Nama Hewan*** *(wajib)*
   - **Jenis Kelamin*** *(Jantan/Betina)*
   - **Ras Hewan*** *(pilih dari dropdown)*
   - **Pemilik*** *(pilih dari dropdown)*
   - **Tanggal Lahir** *(opsional)*
   - **Warna/Tanda Khusus** *(opsional)*
4. **Simpan:** Klik **"Simpan"**

#### **Edit Data Hewan** *(Administrator/Resepsionis)*
1. Di halaman daftar hewan, klik ikon **Edit (✏️)** 
2. Ubah data yang diperlukan
3. Klik **"Simpan Perubahan"**

#### **Soft Delete Hewan** *(Administrator/Resepsionis)*
1. Klik ikon **Delete (🗑️)** pada data hewan
2. Konfirmasi penghapusan
3. **Catatan:** Data tidak dihapus permanen, hanya disembunyikan

### 👤 **2. Manajemen Data Pemilik**

#### **Registrasi Pemilik Baru** *(Administrator/Resepsionis)*
1. **Navigasi:** Data → Kelola Pemilik
2. **Aksi:** Klik **"+ Tambah Pemilik"**
3. **Form Input:**
   - **Nama Lengkap*** 
   - **Email*** *(unique)*
   - **Password*** *(auto-generated atau manual)*
   - **Alamat**
   - **No. Telepon**
4. **Sistem otomatis:**
   - Membuat akun User
   - Assign role "Pemilik" 
   - Generate password (jika auto)

### 🏥 **3. Master Data Klinik**

#### **Jenis Hewan & Ras** *(Administrator/Resepsionis)*
1. **Navigasi:** Data → Jenis & Ras Hewan
2. **Tambah Jenis:** 
   - Klik **"+ Tambah Jenis Hewan"**
   - Input nama jenis (contoh: "Anjing", "Kucing")
3. **Tambah Ras:**
   - Pilih jenis hewan terlebih dahulu
   - Klik **"+ Tambah Ras"**
   - Input nama ras (contoh: "Golden Retriever", "Persian")

#### **Kategori Tindakan** *(Administrator)*
1. **Navigasi:** Data → Tindakan Terapi
2. **Setup Hierarki:**
   - **Kategori** (contoh: "Pemeriksaan", "Operasi")
   - **Kategori Klinis** (contoh: "Diagnosa", "Terapi")
   - **Kode Tindakan** (detail tindakan medis)

---

## ⚕️ Alur Kerja Klinik

### 📅 **1. Proses Reservasi Dokter**

#### **Membuat Reservasi** *(Administrator/Resepsionis)*
1. **Navigasi:** Data → Temu Dokter
2. **Aksi:** Klik **"+ Buat Reservasi"**
3. **Form Reservasi:**
   - **Pilih Dokter*** *(dari dropdown dokter aktif)*
   - **Tanggal & Waktu***
   - **Catatan** *(opsional)*
4. **Sistem otomatis:**
   - Generate nomor antrian
   - Set status "Menunggu"
   - Kirim notifikasi

#### **Update Status Reservasi** *(Administrator/Resepsionis)*
- **Menunggu** → **Selesai** *(setelah pemeriksaan)*
- **Menunggu** → **Batal** *(jika dibatalkan)*
- **Batal** → **Menunggu** *(reaktivasi)*

### 📋 **2. Proses Rekam Medis**

#### **Tahap 1: Input Data Utama** *(Perawat)*
1. **Akses:** Data → Rekam Medis → Edit Data 
2. **Form Data Utama:**
   - **Hewan Pasien*** *(pilih dari dropdown)*
   - **Dokter Pemeriksa*** 
   - **Anamnesa*** *(keluhan pemilik)*
   - **Temuan Klinis*** *(hasil pemeriksaan fisik)*
   - **Diagnosa*** *(kesimpulan diagnosa)*

#### **Tahap 2: Input Detail Tindakan** *(Dokter)*
1. **Akses:** Data → Rekam Medis → Edit Detail
2. **Tambah Tindakan:**
   - Klik **"+ Tambah Tindakan"**
   - **Pilih Kode Tindakan*** *(dari master data)*
   - **Detail Spesifik** *(catatan tambahan)*
3. **Multiple Tindakan:** Bisa menambah beberapa tindakan sekaligus
4. **Hapus Tindakan:** Klik ikon delete pada tindakan yang tidak diperlukan

### 🔄 **3. Workflow Integration**

```
Pemilik Datang → Resepsionis Buat Reservasi → Dokter Periksa 
     ↓
Perawat Input Data Medis → Dokter Input Detail Tindakan → Selesai
```

---

## 📖 Panduan Per Peran

### 👑 **Administrator - Panduan Lengkap**

#### **Setup Awal Sistem:**
1. **Manajemen User:**
   - Create akun untuk Dokter, Perawat, Resepsionis
   - Assign role yang sesuai
   - Monitor aktivitas user
   
2. **Setup Master Data:**
   - Input jenis dan ras hewan populer
   - Setup kategori tindakan medis
   - Konfigurasi kode tindakan terapi

3. **Operational Management:**
   - Monitor semua aktivitas sistem
   - Backup dan maintenance data
   - Generate reports dan statistik

#### **Tugas Harian:**
- Review dan approve registrasi baru
- Monitor performa sistem  
- Handle escalated issues
- Manage user access dan permissions

### 👩‍⚕️ **Resepsionis - Front Office Management**

#### **Tugas Utama:**
1. **Customer Service:**
   - Registrasi pemilik dan hewan baru
   - Buat reservasi dokter
   - Update status appointment
   - Handle pembatalan dan reschedule

2. **Data Management:**
   - Maintain data hewan dan pemilik
   - Update contact information
   - Manage appointment calendar

#### **Daily Workflow:**
```
Pagi: Review appointment hari ini
 ↓
Registrasi walk-in customers
 ↓  
Coordinate dengan dokter untuk scheduling
 ↓
Update status appointment real-time
 ↓
End of day: Reconcile data dan prepare next day
```

### 👩‍⚕️ **Perawat - Medical Data Assistant**

#### **Tanggung Jawab:**
1. **Pre-Examination:**
   - Prepare rekam medis template
   - Input vital signs dan basic assessment
   - Coordinate patient flow dengan dokter

2. **Post-Examination:**
   - Input/update data medis dari hasil pemeriksaan
   - Pastikan diagnosa dan anamnesa tercatat lengkap
   - Coordinate dengan pemilik untuk follow-up

#### **Workflow dengan Dokter:**
```
Persiapan Pasien → Input Data Awal → Dokter Examine 
     ↓
Input Diagnosa → Dokter Review → Input Detail Treatment
```

### 👨‍⚕️ **Dokter - Medical Professional**

#### **Fokus Utama:**
1. **Patient Examination:**
   - Review appointment schedule  
   - Examine patients sesuai jadwal
   - Coordinate dengan perawat untuk data support

2. **Medical Documentation:**
   - Input detail tindakan dan terapi
   - Specify treatment procedures
   - Add medical notes dan recommendations

#### **Best Practices:**
- Selalu review data yang sudah diinput perawat
- Input detail treatment sesegera mungkin
- Coordinate dengan tim untuk patient care

### 👤 **Pemilik - Pet Owner Access**

#### **Akses Yang Tersedia:**
1. **Monitor Pet Health:**
   - Lihat semua data hewan peliharaan
   - Review riwayat medical appointments
   - Track medical history dan progress

2. **Appointment Tracking:**
   - Monitor upcoming appointments
   - View appointment history
   - Access medical reports

#### **Tips Penggunaan:**
- Regularly check untuk appointment updates
- Keep contact information updated
- Review medical history untuk better pet care

---