<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Identitas Desa Default
    |--------------------------------------------------------------------------
    | Nilai default pengaturan desa sebelum disimpan ke database pada tahap lanjut.
    */
    'identitas' => [
        'nama_desa' => env('SIGAP_NAMA_DESA', 'Desa Sigap'),
        'kecamatan' => env('SIGAP_KECAMATAN', ''),
        'kabupaten' => env('SIGAP_KABUPATEN', ''),
        'provinsi' => env('SIGAP_PROVINSI', ''),
        'kode_pos' => env('SIGAP_KODE_POS', ''),
        'email_desa' => env('SIGAP_EMAIL_DESA', ''),
        'telepon_desa' => env('SIGAP_TELEPON_DESA', ''),
        'alamat_kantor' => env('SIGAP_ALAMAT_KANTOR', ''),
    ],
];
