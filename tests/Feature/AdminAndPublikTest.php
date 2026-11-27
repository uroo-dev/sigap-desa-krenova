<?php

namespace Tests\Feature;

use App\Enums\LaporanStatus;
use App\Enums\RoleName;
use App\Livewire\Admin\UserTable;
use App\Models\Berita;
use App\Models\JenisSurat;
use App\Models\KategoriLaporan;
use App\Models\Keluarga;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Warga;
use App\Models\Wilayah;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAndPublikTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        $this->admin = User::where('email', 'admin@sigap.test')->firstOrFail();
    }

    public function test_guest_and_non_admin_cannot_access_admin_routes(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));

        $warga = User::factory()->create();
        $warga->assignRole(RoleName::MASYARAKAT->value);

        $this->actingAs($warga)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_manage_users_wilayah_kategori_jenis_surat_berita_and_pengaturan(): void
    {
        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertOk();

        // Wilayah + GeoJSON array casting
        $geojson = json_encode([
            'type' => 'Polygon',
            'coordinates' => [[[110.1, -7.1], [110.2, -7.1], [110.2, -7.2], [110.1, -7.1]]],
        ]);

        $this->actingAs($this->admin)->post(route('admin.wilayah.store'), [
            'tipe' => 'rt',
            'nama' => 'RT 01',
            'kode' => 'RT-01',
            'geojson' => $geojson,
        ])->assertRedirect(route('admin.wilayah.index'));

        $rt = Wilayah::where('kode', 'RT-01')->firstOrFail();
        $this->assertIsArray($rt->geojson);
        $this->assertSame('Polygon', $rt->geojson['type']);

        // User create + soft deactivate
        $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name' => 'Ketua RT 01',
            'email' => 'rt01@sigap.test',
            'password' => 'password123',
            'role' => RoleName::KETUA_RT->value,
            'rt_id' => $rt->id,
        ])->assertRedirect(route('admin.users.index'));

        $rtUser = User::where('email', 'rt01@sigap.test')->firstOrFail();
        $this->assertTrue($rtUser->hasRole(RoleName::KETUA_RT->value));

        $this->actingAs($this->admin)->delete(route('admin.users.destroy', $rtUser))->assertRedirect();
        $this->assertFalse($rtUser->fresh()->is_active);

        // Kategori laporan
        $this->actingAs($this->admin)->post(route('admin.kategori-laporan.store'), [
            'nama' => 'Jalan Rusak',
            'deskripsi' => 'Laporan kerusakan jalan desa',
        ])->assertRedirect(route('admin.kategori-laporan.index'));

        $kategori = KategoriLaporan::where('slug', 'jalan-rusak')->firstOrFail();
        $this->assertTrue($kategori->aktif);

        // Jenis surat
        $this->actingAs($this->admin)->post(route('admin.jenis-surat.store'), [
            'nama' => 'Surat Keterangan Domisili',
            'persyaratan' => ['Fotokopi KTP', 'Fotokopi KK'],
        ])->assertRedirect(route('admin.jenis-surat.index'));

        $jenisSurat = JenisSurat::where('slug', 'surat-keterangan-domisili')->firstOrFail();
        $this->assertSame(['Fotokopi KTP', 'Fotokopi KK'], $jenisSurat->persyaratan);

        // Berita + custom parameter binding {berita}
        $this->actingAs($this->admin)->post(route('admin.berita.store'), [
            'judul' => 'Kerja Bakti Desa',
            'isi' => 'Pelaksanaan kerja bakti bersama.',
            'tipe' => 'agenda',
            'published_at' => now()->subMinute()->toDateTimeString(),
        ])->assertRedirect(route('admin.berita.index'));

        $berita = Berita::firstOrFail();
        $this->actingAs($this->admin)->get(route('admin.berita.edit', $berita))->assertOk();
        $this->actingAs($this->admin)->put(route('admin.berita.update', $berita), [
            'judul' => 'Kerja Bakti Desa Diperbarui',
            'isi' => 'Konten diperbarui.',
            'tipe' => 'agenda',
        ])->assertRedirect(route('admin.berita.index'));
        $this->assertSame('Kerja Bakti Desa Diperbarui', $berita->fresh()->judul);

        // Pengaturan desa
        $this->actingAs($this->admin)->get(route('admin.pengaturan.edit'))->assertOk();
        $this->actingAs($this->admin)->put(route('admin.pengaturan.update'), [
            'nama_desa' => 'Desa Krenova',
        ])->assertRedirect();
    }

    public function test_publik_routes_work_and_hide_private_reports_and_reporter_identity(): void
    {
        $rt = Wilayah::create(['tipe' => 'rt', 'nama' => 'RT 02', 'kode' => 'RT-02']);
        $kategori = KategoriLaporan::create(['nama' => 'Drainase', 'slug' => 'drainase']);
        $pelapor = User::factory()->create(['name' => 'Rahasia Pelapor']);

        $berita = Berita::create([
            'judul' => 'Pengumuman Musrenbang',
            'slug' => 'pengumuman-musrenbang',
            'isi' => 'Undangan musyawarah desa.',
            'tipe' => 'berita',
            'published_at' => now()->subHour(),
            'user_id' => $this->admin->id,
        ]);

        $laporanBaru = Laporan::create([
            'nomor_laporan' => 'LAP-001',
            'user_id' => $pelapor->id,
            'kategori_id' => $kategori->id,
            'rt_id' => $rt->id,
            'judul' => 'Laporan Belum Diverifikasi',
            'deskripsi' => 'Masih baru.',
            'latitude' => -7.123456,
            'longitude' => 110.123456,
            'status' => LaporanStatus::BARU->value,
        ]);

        $laporanPublik = Laporan::create([
            'nomor_laporan' => 'LAP-002',
            'user_id' => $pelapor->id,
            'kategori_id' => $kategori->id,
            'rt_id' => $rt->id,
            'judul' => 'Saluran Air Tersumbat',
            'deskripsi' => 'Perlu pembersihan.',
            'latitude' => -7.123456,
            'longitude' => 110.123456,
            'status' => LaporanStatus::DIVERIFIKASI_RT->value,
        ]);

        $this->get(route('home'))->assertOk();
        $this->get(route('publik.peta'))->assertOk();
        $this->get(route('publik.potensi'))->assertOk();
        $this->get(route('publik.informasi'))->assertOk();
        $this->get(route('publik.informasi.detail', $berita->slug))->assertOk();

        $this->get(route('publik.laporan'))
            ->assertOk()
            ->assertViewHas('laporan', fn ($items) => $items->total() === 1);

        // Laporan berstatus BARU tidak boleh tampil ke publik
        $this->get(route('publik.laporan.detail', $laporanBaru))->assertNotFound();

        $detailResponse = $this->get(route('publik.laporan.detail', $laporanPublik));
        $detailResponse->assertOk();
        $detailResponse->assertViewHas('laporan', fn (Laporan $model) => ! $model->relationLoaded('user'));
    }

    public function test_warga_and_keluarga_encrypt_and_hash_sensitive_identifiers(): void
    {
        $rt = Wilayah::create(['tipe' => 'rt', 'nama' => 'RT 03', 'kode' => 'RT-03']);

        $keluarga = Keluarga::create([
            'no_kk' => '3301010101010001',
            'rt_id' => $rt->id,
            'alamat' => 'Jl. Merdeka No. 1',
        ]);

        $warga = Warga::create([
            'keluarga_id' => $keluarga->id,
            'rt_id' => $rt->id,
            'nik' => '3301010101010002',
            'nama_lengkap' => 'Ahmad Yani',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Merdeka No. 1',
        ]);

        $this->assertSame(hash('sha256', '3301010101010001'), $keluarga->no_kk_hash);
        $this->assertSame('3301010101010001', $keluarga->fresh()->no_kk);
        $this->assertArrayNotHasKey('no_kk', $keluarga->toArray());

        $this->assertSame(hash('sha256', '3301010101010002'), $warga->nik_hash);
        $this->assertSame('3301010101010002', $warga->fresh()->nik);
        $this->assertArrayNotHasKey('nik', $warga->toArray());
    }

    public function test_admin_pages_use_livewire_navigate_and_all_views_render_cleanly(): void
    {
        $rt = Wilayah::create(['tipe' => 'rt', 'nama' => 'RT 04', 'kode' => 'RT-04']);
        $kategori = KategoriLaporan::create(['nama' => 'Penerangan', 'slug' => 'penerangan']);
        $jenis = JenisSurat::create(['nama' => 'Surat Keterangan Usaha', 'slug' => 'sku']);
        $berita = Berita::create([
            'judul' => 'Jadwal Posyandu',
            'slug' => 'jadwal-posyandu',
            'isi' => 'Posyandu dilaksanakan pukul 08.00.',
            'tipe' => 'agenda',
            'user_id' => $this->admin->id,
        ]);

        // Halaman Auth
        $this->get(route('login'))->assertOk()->assertSee('Masuk dengan Google');
        $this->get(route('register'))->assertOk()->assertSee('Daftar Cepat dengan Google');

        // Halaman Admin mendukung wire:navigate (SPA tanpa reload) & tema Civic Green
        $this->actingAs($this->admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('wire:navigate', false)
            ->assertSee('#1B5E3B', false)
            ->assertSee('SigapUI', false);

        $this->actingAs($this->admin)->get(route('admin.users.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.users.create'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.users.edit', $this->admin))->assertOk();

        $this->actingAs($this->admin)->get(route('admin.wilayah.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.wilayah.create'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.wilayah.edit', $rt))->assertOk();

        $this->actingAs($this->admin)->get(route('admin.kategori-laporan.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.kategori-laporan.create'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.kategori-laporan.edit', $kategori))->assertOk();

        $this->actingAs($this->admin)->get(route('admin.jenis-surat.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.jenis-surat.create'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.jenis-surat.edit', $jenis))->assertOk();

        $this->actingAs($this->admin)->get(route('admin.berita.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.berita.create'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.berita.edit', $berita))->assertOk();
    }

    public function test_livewire_user_table_supports_live_search_filter_and_toggle_active(): void
    {
        $warga = User::factory()->create([
            'name' => 'Warga Contoh',
            'email' => 'wargacontoh@sigap.test',
            'is_active' => true,
        ]);
        $warga->assignRole(RoleName::MASYARAKAT->value);

        Livewire::actingAs($this->admin)
            ->test(UserTable::class)
            ->assertSee('Warga Contoh')
            ->set('search', 'Warga Contoh')
            ->assertSee('wargacontoh@sigap.test')
            ->assertDontSee('admin@sigap.test')
            ->set('search', '')
            ->set('roleFilter', RoleName::MASYARAKAT->value)
            ->assertSee('Warga Contoh')
            ->call('toggleActive', $warga->id)
            ->call('toggleActive', $this->admin->id);

        $this->assertFalse($warga->fresh()->is_active);
        // Admin tidak boleh menonaktifkan dirinya sendiri
        $this->assertTrue($this->admin->fresh()->is_active);
    }
}
