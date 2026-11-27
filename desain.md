# SIGAP — UI/UX Design System & Web Design Specification

| Atribut Dokumen | Detail |
|---|---|
| **Nama Aplikasi** | **SIGAP** (*Sistem Informasi Geografis dan Aspirasi Publik*) |
| **Tagline Utama** | *Desa Terhubung, Masyarakat Terlayani.* |
| **Kategori** | Sistem Informasi Geografis dan Pelayanan Publik Desa |
| **Versi Dokumen** | `1.0` |
| **Tema Visual** | **Civic Green** — *Minimalist Modern* |

---

## 1. Design Overview

### 1.1 Tentang SIGAP
**SIGAP** adalah platform digital terpadu bagi pemerintah desa dan masyarakat untuk mengenali kondisi wilayah secara spasial, menyampaikan aspirasi publik, mengelola data kependudukan, serta memproses pelayanan surat administrasi desa secara daring dan transparan.

SIGAP mengintegrasikan tiga modul operasional inti:

1. **Pelaporan Masalah Berbasis GIS**
   - Masyarakat melaporkan permasalahan infrastruktur maupun lingkungan desa disertai titik lokasi pada peta.
   - Lokasi laporan divisualisasikan pada peta interaktif berbasis koordinat dan poligon wilayah RT.
   - Ketua RT melakukan verifikasi lapangan dan penanganan awal.
   - Laporan dapat diselesaikan di tingkat RT atau diteruskan (*eskalasi*) kepada Kepala Desa untuk instruksi tindak lanjut.
   - Masyarakat dapat memantau progres penyelesaian secara transparan dan teranonimisasi.

2. **Manajemen Masyarakat**
   - Pengelolaan terpusat data penduduk dan kartu keluarga (KK) dengan perlindungan enkripsi NIK/KK.
   - Pengelompokan wilayah terstruktur berbasis Desa → Dusun → RW → RT.
   - Pencatatan riwayat kependudukan (kelahiran, kematian, mutasi) serta visualisasi statistik demografi desa.

3. **Pelayanan Surat Digital**
   - Pengajuan surat pengantar dan keterangan desa secara daring oleh warga.
   - Pengisian data otomatis dari profil warga terverifikasi.
   - Persetujuan berjenjang (Pengantar RT → Persetujuan & Penerbitan Kepala Desa).
   - Penerbitan dokumen PDF otomatis beserta arsip surat digital.

### 1.2 Tujuan Desain
- **Modern dan Minimalis**: Mengutamakan keterbacaan, ruang bernapas (*whitespace*), serta hierarki visual yang jelas.
- **Ramah Masyarakat Umum**: Alur navigasi intuitif bagi seluruh lapisan warga maupun perangkat desa.
- **Identitas Visual Konsisten**: Seluruh antarmuka publik, autentikasi, warga, RT, Kepala Desa, hingga Admin Sistem menggunakan satu bahasa desain yang sama.
- **Anti-Legacy Government Look**: Bebas dari tampilan aplikasi administrasi kaku/usang; terinspirasi oleh *Modern SaaS Dashboard*, *Civic Tech*, dan *GIS Platform*.
- **Map-First untuk Fitur GIS**: Area peta mendapatkan porsi ruang visual yang optimal tanpa terhalang panel dekoratif.
- **Responsif Penuh**: Nyaman diakses pada layar desktop, tablet, dan smartphone.

### 1.3 Design Direction & Anti-Patterns
- **Karakter Visual**: *Clean, Professional, Trustworthy, Human-centered*.
- **Inspirasi Utama**: *Modern SaaS Dashboard*, *Civic Technology Platform*, *Geographic Information System*, *Modern Government Digital Service*.
- **Hal yang Wajib Dihindari**:
  - Penggunaan gradien mencolok atau dekorasi berlebihan (*over-styled gradients*).
  - Penerapan *glassmorphism* di seluruh permukaan komponen.
  - Terlalu banyak variasi warna di luar sistem token resmi.
  - Bayangan (*shadow*) tebal atau efek 3D artifisial.
  - Card penuh hiasan yang mengaburkan informasi inti.
  - Animasi kosmetik yang tidak memiliki fungsi UX.
  - Tata letak dashboard yang terlalu padat tanpa jarak antarelemen.

---

## 2. Brand Identity

### 2.1 Konsep Logo — *The Connected S*
Logo SIGAP mengusung konsep **The Connected S**, yakni monogram huruf **S** geometris yang menyatukan tiga elemen bermakna:
1. **Huruf S**: Identitas utama **SIGAP**.
2. **Pin Lokasi**: Representasi pemetaan geografis (GIS) dan pelaporan lokasi masalah.
3. **Garis Lanskap**: Representasi teritorial wilayah, batas RT/RW, dan potensi desa.
4. **Bentuk Geometris Sederhana**: Melambangkan integrasi teknologi yang modern, akurat, dan ringan.

#### Variasi Logo Resmi
| Variasi | Deskripsi & Penggunaan |
|---|---|
| **Primary Logo** | Simbol SVG *The Connected S* + logotype **SIGAP** (*Header*, halaman *Login/Register*, *Footer*). |
| **Icon Logo** | Simbol SVG *The Connected S* tanpa teks (*Collapsed sidebar*, *app badge*, `public/sigap.ico`). |
| **Monochrome Logo** | Variasi satu warna gelap/putih (*Kop surat PDF DomPDF*, watermark dokumen, dan media cetak). |

> Gunakan **inline SVG** untuk logo antarmuka agar tetap tajam pada layar Retina/HiDPI serta aset raster teroptimasi (`public/images/logo/sigap.png` dan `public/sigap.ico`) untuk favicon browser dan dokumentasi.

### 2.2 Brand Tagline
- **Tagline Utama**: *Desa Terhubung, Masyarakat Terlayani.*
- **Alternatif Kontekstual**:
  - *Bersama Membangun Desa Lebih Baik.*
  - *Satu Platform untuk Desa yang Lebih Responsif.*

### 2.3 Brand Personality
`Responsif` · `Terpercaya` · `Transparan` · `Modern` · `Kolaboratif` · `Dekat dengan Masyarakat`

---

## 3. Color System (Civic Green)

### 3.1 Primary & Accent Colors
| Token | Hex | Tailwind Token | Penggunaan |
|---|---|---|---|
| **Primary** | `#1B5E3B` | `sigap-primary` | Tombol aksi utama, indikator aktif sidebar, branding |
| **Primary Dark** | `#15452D` | `sigap-primary-dark` | State `:hover` dan `:active` pada elemen primary |
| **Primary Light** | `#E7F1E9` | `sigap-primary-light` | Latar item navigasi aktif, badge ringan, highlight |
| **Secondary** | `#A7C957` | `sigap-secondary` | Aksen grafis, garis fokus dekoratif fungsional, ilustrasi |
| **Secondary Light** | `#EDF5D8` | `sigap-secondary-light` | Latar kartu aksen atau banner informasi halus |

### 3.2 Neutral Colors
| Token | Hex | Tailwind Token | Penggunaan |
|---|---|---|---|
| **Background** | `#F5F8F1` | `sigap-bg` | Latar belakang utama halaman |
| **Surface** | `#FFFFFF` | `sigap-surface` | Permukaan card, tabel, modal, dan topbar |
| **Surface Muted** | `#F8FAF7` | `sigap-surface-muted` | Header tabel, area input readonly, blok sekunder |
| **Text Primary** | `#1F2937` | `sigap-ink` | Heading, isi utama, nilai statistik |
| **Text Secondary** | `#6B7280` | `sigap-muted` | Deskripsi, subjudul, label metadata |
| **Text Muted** | `#9CA3AF` | `sigap-subtle` | Timestamp, placeholder input, teks tersier |
| **Border** | `#E5E7EB` | `sigap-border` | Garis pemisah card, tabel, sidebar, dan topbar |
| **Border Strong** | `#D1D5DB` | `sigap-border-strong` | Border input formulir dan elemen interaktif |

### 3.3 Semantic Colors
| Status | Warna | Hex | Penggunaan Khusus |
|---|---|---|---|
| **Success** | Hijau | `#16A34A` | Status selesai, terverifikasi, disetujui, pesan berhasil |
| **Warning** | Kuning/Amber | `#D97706` | Menunggu verifikasi, perlu revisi, sedang diproses |
| **Danger** | Merah | `#DC2626` | Ditolak, prioritas tinggi, error validasi, aksi hapus |
| **Info** | Biru | `#2563EB` | Diajukan ke Kepala Desa, informasi sistem, instruksi |
| **Neutral** | Abu-abu | `#6B7280` | Draf, diarsipkan, nonaktif |

### 3.4 Aturan Penggunaan Warna
1. **Primary** hanya dipakai untuk aksi utama dan penanda navigasi aktif agar fokus pengguna terjaga.
2. **Background** selalu memakai `#F5F8F1`, sementara **Card/Panel** selalu memakai `#FFFFFF` dengan garis tepi `#E5E7EB`.
3. **Semantic colors** dilarang keras dipakai sebagai hiasan visual yang tidak merepresentasikan status data.
4. Seluruh teks di atas latar wajib memenuhi rasio kontras WCAG AA (`>= 4.5:1`).

---

## 4. Typography

### 4.1 Font Family
- **Heading & Navigasi**: [`Plus Jakarta Sans`](https://fonts.google.com/specimen/Plus+Jakarta+Sans) — judul halaman, judul card, item navigasi, angka statistik.
- **Body & Teknis**: [`Inter`](https://fonts.google.com/specimen/Inter) — paragraf, isi tabel, label & input formulir, deskripsi, metadata teknis.

### 4.2 Typography Scale
| Elemen | Ukuran Desktop | Weight | Line Height | Font Family |
|---|---|---|---|---|
| **Display** | `48px` (`3rem`) | `700` | `1.15` | Plus Jakarta Sans |
| **H1** | `32px` (`2rem`) | `700` | `1.25` | Plus Jakarta Sans |
| **H2** | `24px` (`1.5rem`) | `700` | `1.3` | Plus Jakarta Sans |
| **H3** | `20px` (`1.25rem`) | `600` | `1.35` | Plus Jakarta Sans |
| **H4** | `16px` (`1rem`) | `600` | `1.4` | Plus Jakarta Sans |
| **Body Large** | `16px` (`1rem`) | `400` | `1.5` | Inter |
| **Body** | `14px` (`0.875rem`) | `400` | `1.5` | Inter |
| **Caption** | `12px` (`0.75rem`) | `400` | `1.4` | Inter |

### 4.3 Aturan Tipografi
- Gunakan heading yang singkat dan tegas.
- Hindari penggunaan `font-bold` pada seluruh paragraf atau blok teks panjang.
- Gunakan `Text Secondary` (`#6B7280`) untuk deskripsi pendukung di bawah heading.
- Batasi penggunaan huruf kapital semua (*uppercase*) hanya pada label mikro/kategori bila benar-benar diperlukan.

---

## 5. Layout System & Spacing

### 5.1 Properti Tata Letak
| Properti | Nilai | Keterangan |
|---|---|---|
| **Max Content Width** | `1440px` | Batas lebar kontainer utama pada layar lebar |
| **Desktop Page Padding** | `32px` | Ruang tepi halaman pada breakpoint `>= 1024px` |
| **Tablet Page Padding** | `24px` | Ruang tepi halaman pada breakpoint `640px – 1023px` |
| **Mobile Page Padding** | `16px` | Ruang tepi halaman pada breakpoint `< 640px` |
| **Sidebar Width** | `260px` | Lebar penuh panel navigasi Admin |
| **Collapsed Sidebar** | `76px` | Lebar sidebar saat diciutkan pada desktop |
| **Topbar Height** | `68px` | Tinggi bar atas di halaman publik maupun admin |
| **Card Radius** | `12px` (`rounded-xl`) | Sudut membulat standar untuk seluruh card |
| **Input Radius** | `8px` (`rounded-lg`) | Sudut membulat elemen formulir |
| **Button Radius** | `8px` (`rounded-lg`) | Sudut membulat seluruh varian tombol |

### 5.2 Skala Spasi (Kelipatan `4px`)
| Token | Nilai | Penggunaan Umum |
|---|---|---|
| `space-1` | `4px` | Jarak ikon kecil atau label mikro |
| `space-2` | `8px` | Gap antar tombol/ikon atau padding vertikal kecil |
| `space-3` | `12px` | Gap item menu sidebar, jarak label ke input |
| `space-4` | `16px` | Padding mobile, gap grid standar |
| `space-5` | `20px` | Padding minimal dalam card |
| `space-6` | `24px` | Padding standar card, jarak antar blok form |
| `space-8` | `32px` | Padding desktop, jarak antar section dashboard |
| `space-10` | `40px` | Pemisah antar section halaman publik |
| `space-12` | `48px` | Jarak hero section & blok konten utama |

### 5.3 Border & Shadow
- Pemisahan komponen mengandalkan **border tipis `1px solid #E5E7EB`** di atas kontras `#F5F8F1` dan `#FFFFFF`.
- **Card tidak wajib memakai shadow**.
- **Shadow ringan** (`0 4px 12px rgba(15, 23, 42, 0.06)`) hanya digunakan pada komponen mengambang (*dropdown*, *popover*, *modal*, *floating map controls*).

---

## 6. Icon System

Seluruh aplikasi menggunakan satu keluarga ikon konsisten: **[Lucide Icons](https://lucide.dev)** berukuran standar `18px–20px` (`w-[18px] h-[18px]` atau `w-5 h-5`) dengan ketebalan garis default (`stroke-width: 1.75` atau `2`).

| Konteks | Nama Ikon Lucide |
|---|---|
| Beranda / Dashboard | `layout-dashboard` |
| Peta Desa / GIS | `map` |
| Daftar Laporan | `clipboard-list` |
| Titik Lokasi / Wilayah | `map-pin` |
| Data Masyarakat / Users | `users` |
| Keluarga / Rumah | `house` |
| Surat Digital / Berita | `file-text` |
| Notifikasi | `bell` |
| Pengaturan | `settings` |
| Profil Pengguna | `user-round` |
| Statistik | `chart-no-axes-combined` |
| Verifikasi / Role | `shield-check` |
| Riwayat / Aktivitas | `history` |

**Aturan**: Dilarang mencampur pustaka ikon lain (misal FontAwesome + Heroicons + Lucide sekaligus). Setiap item navigasi wajib memadukan ikon dan label teks saat sidebar terbuka.

---

## 7. Component System

### 7.1 Buttons
- **Varian**: `primary` (`#1B5E3B`), `secondary` (`#E7F1E9` teks `#1B5E3B`), `outline` (border `#D1D5DB`), `ghost` (transparan hover `#F8FAF7`), `danger` (`#DC2626`).
- **Ukuran**: `sm` (`h-8`, `32px`), `md` (`h-10`, `40px`), `lg` (`h-12`, `48px`).
- **Aturan**: Gunakan kata kerja aktif (*Buat Laporan*, *Simpan Perubahan*, *Ajukan Surat*, *Verifikasi Laporan*, *Setujui Pengajuan*, *Unduh Dokumen*). Berikan status loading (`wire:loading` / spinner) dan disabled yang jelas.

### 7.2 Cards
Enam pola kartu standar: `Statistic Card`, `Information Card`, `Report Card`, `Service Card`, `Activity Card`, `Map Card`. Semua menggunakan latar putih `#FFFFFF`, border `#E5E7EB`, radius `12px`, dan padding `20px–24px`.

### 7.3 Badges
- **Status Laporan**: *Baru Masuk / Menunggu Verifikasi*, *Diverifikasi RT*, *Ditolak*, *Diajukan ke Kepala Desa*, *Diinstruksikan*, *Dalam Proses*, *Selesai oleh RT*, *Divalidasi Kepala Desa / Selesai*, *Ditinjau Ulang*, *Diarsipkan*.
- **Status Surat**: *Draf*, *Diajukan / Menunggu Pemeriksaan*, *Diverifikasi RT*, *Ditolak RT*, *Menunggu Persetujuan*, *Disetujui Kepala Desa*, *Ditolak Kepala Desa*, *Diterbitkan / Selesai*, *Dibatalkan*.

### 7.4 Form Elements, Modal CRUD & Alert System
- **Form**: Text input, textarea, select, date picker, file upload (preview sebelum kirim), search input, radio group, checkbox, dan map location picker (Leaflet). Setiap input wajib berlabel jelas, menandai field wajib (`*`), menampilkan pesan validasi tepat di bawah input (`@error`), dan menjaga nilai `old()` / `wire:model`.
- **Modal CRUD (Panel Admin)**: Seluruh aksi **Tambah**, **Edit**, dan **Konfirmasi Hapus / Nonaktifkan** di modul master data Admin dijalankan di dalam **Modal Dialog** (`<x-modal>`) berbasis Livewire agar proses administrasi lebih ringkas, fokus, dan bebas perpindahan halaman yang tidak perlu.
- **Alert & Toast Feedback (`success`, `error`, `warning`, `info`)**: Setiap aksi pengguna (Login, Logout, Register, Google OAuth, Tambah/Ubah/Hapus/Toggle data, maupun kegagalan validasi/konfigurasi) wajib memberikan umpan balik visual yang jelas melalui komponen `<x-toast />` menggunakan warna semantik resmi SIGAP (`#16A34A`, `#DC2626`, `#D97706`, `#2563EB`) — baik via Laravel `session()` maupun event Livewire `sigap-toast`.
- **Table**: Mendukung pencarian (*search*), filter, pengurutan (*sorting*), pagination, aksi per baris, *empty state* informatif, *loading state*, serta tampilan adaptif **daftar card pada layar mobile**.

---

## 8. Frontend Stack, Livewire SPA Admin & GSAP UI Sync Architecture

Agar pengembangan cepat, ringan, dan bebas kendala sinkronisasi aset di berbagai lingkungan tim kecil, frontend SIGAP menerapkan arsitektur berbasis CDN modern yang terintegrasi penuh dengan **Livewire v4**:

### 8.1 Pustaka CDN Terstandarisasi
| Teknologi | Peran | Sumber |
|---|---|---|
| **Tailwind CSS v4 / v3 Play CDN** | Utilitas styling instan dengan konfigurasi token warna Civic Green & font SIGAP | `https://cdn.tailwindcss.com` (konfigurasi terpusat di `<head>` layout) |
| **Google Fonts** | Font `Plus Jakarta Sans` & `Inter` | `https://fonts.googleapis.com` |
| **Lucide Icons CDN** | Rendering ikon vektor konsisten | `https://unpkg.com/lucide@latest` |
| **GSAP + ScrollTrigger CDN** | Animasi masuk (*stagger/reveal*) yang halus, cepat, dan fungsional | `https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js` & `ScrollTrigger.min.js` |
| **Leaflet.js CDN** | Peta interaktif OpenStreetMap & visualisasi batas GeoJSON RT/Desa | `https://unpkg.com/leaflet@1.9.4/` |

### 8.2 Navigasi Panel Admin Tanpa Reload (Livewire `wire:navigate`)
Seluruh navigasi pada **Panel Admin** (`/admin/*`) menggunakan **Livewire SPA Navigation (`wire:navigate`)**:
1. **Perpindahan Halaman Instan**: Setiap tautan menu sidebar, tombol *Tambah*, *Edit*, *Kembali*, dan link paginasi di panel Admin menyertakan atribut `wire:navigate` (dan `wire:navigate.hover` bila diperlukan untuk pre-fetching).
2. **Layout Persisten (`@persist`)**: Sidebar navigasi dan header topbar dibungkus `@persist('admin-sidebar')` atau disinkronkan secara bersih sehingga tidak terjadi kedipan (*flicker*) saat berpindah halaman.
3. **Indikator Progres Civic Green**: Progress bar bawaan Livewire dikustomisasi menggunakan warna primer `#1B5E3B` via konfigurasi `livewire.navigate.progressBarColor` atau CSS variable.
4. **Live Search & Filter Interaktif**: Komponen pencarian, filter tabel, dan aksi cepat tanpa refresh halaman penuh menggunakan komponen Livewire reaktif (`wire:model.live.debounce.300ms`, `wire:loading`).

### 8.3 Siklus Hidup **GSAP Sync UI** dengan Livewire & Lucide
Karena navigasi Livewire SPA mengganti konten DOM tanpa memuat ulang `window.onload`, seluruh inisialisasi UI disinkronkan melalui satu orkestrator event terpusat pada layout (`layouts/admin.blade.php` & `layouts/app.blade.php`):

```javascript
window.SigapUI = {
    init() {
        // 1. Render ulang seluruh ikon Lucide setelah DOM berubah/dimorph
        if (window.lucide) {
            window.lucide.createIcons();
        }

        // 2. Sinkronisasi animasi GSAP fungsional (menghormati prefers-reduced-motion)
        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (window.gsap && !prefersReduced) {
            const targets = document.querySelectorAll('[data-gsap="fade-up"]');
            if (targets.length > 0) {
                window.gsap.fromTo(
                    targets,
                    { y: 12, opacity: 0 },
                    { y: 0, opacity: 1, duration: 0.32, stagger: 0.04, ease: 'power2.out', clearProps: 'transform' }
                );
            }
        }
    }
};

document.addEventListener('DOMContentLoaded', () => window.SigapUI.init());
document.addEventListener('livewire:navigated', () => window.SigapUI.init());
```

**Prinsip GSAP Sync UI**:
- Durasi singkat (`0.25s – 0.35s`) dan *easing* natural (`power2.out`) agar terasa responsif, bukan lambat.
- Menggunakan `clearProps: 'transform'` setelah animasi selesai agar elemen tetap rapi dan tidak mengganggu posisi *sticky/fixed/dropdown*.
- Menghormati preferensi aksesibilitas `prefers-reduced-motion`.
- Untuk peta **Leaflet.js**, instansiasi peta dibersihkan terlebih dahulu sebelum navigasi ulang (`map.remove()`) dan diinisialisasi ulang pada event `livewire:navigated` agar tidak terjadi kebocoran memori atau error kontainer sudah terinisialisasi.
