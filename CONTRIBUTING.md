# Panduan Kontribusi SIGAP

Terima kasih atas minat Anda untuk berkontribusi pada proyek **SIGAP (Sistem Informasi Geografis dan Aspirasi Publik)**! Dokumen ini memuat panduan alur kerja git, konvensi kode, dan tata cara pengajuan perubahan (Pull Request).

---

## 🌿 Alur Percabangan (Branching Model)

Proyek ini menggunakan strategi percabangan berbasis cabang singkat (*trunk-based development*):

| Cabang (Branch) | Kegunaan & Karakteristik |
|---|---|
| `main` | Cabang produksi yang selalu stabil dan siap dideploy. |
| `develop` | Cabang integrasi fitur sebelum masuk rilis stabil. |
| `feat/<nama-fitur>` | Pengembangan fitur baru (contoh: `feat/gis-polygon-rt`). |
| `fix/<nama-bug>` | Perbaikan cacat/bug (contoh: `fix/nomor-surat-duplikat`). |
| `docs/<topik>` | Pembaruan atau penambahan dokumentasi proyek. |
| `refactor/<topik>` | Perapian dan restrukturisasi kode tanpa mengubah fungsionalitas. |

---

## ✍️ Konvensi Pesan Commit (Conventional Commits)

Format penulisan pesan commit:
```text
<type>(<scope>): <deskripsi ringkas dalam kalimat aktif>

[penjelasan opsional mengenai latar belakang perubahan]
[referensi issue opsional, misal: Closes #12]
```

### Tipe Commit yang Didukung:
- `feat`: Penambahan fitur baru bagi pengguna.
- `fix`: Perbaikan bug atau kesalahan logika.
- `docs`: Perubahan atau penambahan dokumentasi.
- `style`: Penyesuaian format/tata letak kode yang tidak memengaruhi logika bisnis.
- `refactor`: Refaktor kode sumber (bukan bug fix atau fitur baru).
- `perf`: Optimasi performa dan efisiensi eksekusi.
- `test`: Penambahan atau perbaikan unit/feature tests.
- `chore`: Pembaruan build scripts, konfigurasi dependensi, atau dependensi paket.

### Contoh Pesan Commit:
```text
feat(gis): implementasi validasi titik koordinat dalam poligon RT
fix(surat): cegah race condition penomoran surat pada submit simultan
docs(readme): perbarui panduan konfigurasi Google OAuth
```

---

## 🧪 Standar Mutu & Pengujian

Sebelum membuat commit atau membuka Pull Request, seluruh pengujian dan formatting harus dijalankan secara lokal:

```bash
# Jalankan test suite PHPUnit
php artisan test

# Format kode otomatis menggunakan Laravel Pint
./vendor/bin/pint

# Pastikan tidak ada pelanggaran standar kode
./vendor/bin/pint --test
```

### Alur Kritis yang Wajib Memiliki Test:
1. **Alur Pelaporan Masalah (GIS)**: Pembuatan aduan oleh warga → Notifikasi ke RT → Verifikasi RT → Instruksi tindak lanjut Kades → Penyelesaian lapangan → Validasi akhir.
2. **Alur Pelayanan Surat**: Pengajuan surat oleh warga → Verifikasi pengantar RT → Penerbitan resmi Kades → Pengunduhan berkas PDF.
3. **Autentikasi & Autorisasi**: Login Google OAuth berhasil memetakan akun dan role pengguna dengan tepat.
4. **Kebijakan Akses (Policy)**: Ketua RT dilarang mengakses data atau laporan di luar wilayah teritorial RT-nya.

---

## 🎨 Konvensi Kode Sumber

### Backend (PHP / Laravel)
- Ikuti standar **PSR-12** dan konvensi resmi Laravel.
- Wajib menyertakan *type hinting* pada parameter fungsi dan *return types*.
- Gunakan **PHP 8.1+ Enums** untuk representasi status (`StatusLaporan`, `StatusSurat`, dll).
- Letakkan logika bisnis kompleks di lapisan **Services**, bukan di Controller.
- Gunakan **Form Request** untuk validasi data masukan pengguna.

### Frontend (Blade & Tailwind CSS)
- Gunakan komponen Blade reusable di direktori `resources/views/components/`.
- Manfaatkan utilitas resmi Tailwind CSS v4 tanpa gaya sebaris (*inline styles*).
- Pisahkan script peta spasial ke file modular (misalnya `resources/js/map.js`).

---

## 🔀 Prosedur Pengajuan Pull Request (PR)

1. Buat branch fitur dari `develop`:
   ```bash
   git checkout develop
   git pull origin develop
   git checkout -b feat/nama-fitur
   ```
2. Kerjakan perubahan kode dan buat commit sesuai konvensi.
3. Pastikan test dan lint lulus (`php artisan test && ./vendor/bin/pint --test`).
4. Push branch Anda ke remote repository:
   ```bash
   git push origin feat/nama-fitur
   ```
5. Buka Pull Request ke branch `develop` di GitHub dengan mengisi template PR secara lengkap.
6. Tunggu proses peninjauan (*code review*) dan persetujuan dari setidaknya satu anggota tim sebelum digabungkan (*merged*).
