<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDto
{
    public $nomorUrut;

    public $namaLengkap;

    public $tempatTanggalLahir;

    public $karirData;

    public $umur;

    public function __construct(
        int $nomorUrut,
        string $namaLengkap,
        string $tempatTanggalLahir,
        array $karirData
    ) {
        $this->nomorUrut = $nomorUrut;
        $this->namaLengkap = $namaLengkap;
        $this->tempatTanggalLahir = $tempatTanggalLahir;
        $this->karirData = $karirData;
        $this->umur = self::hitungUmur($tempatTanggalLahir);
    }

    private static function hitungUmur($tanggalLahir)
    {
        $tahunLahir = date('Y', strtotime($tanggalLahir));
        $tahunSekarang = date('Y');
        $umur = $tahunSekarang - $tahunLahir;

        // Check apakah sudah ulang tahun atau belum pada tahun ini
        $bulanLahir = date('m', strtotime($tanggalLahir));
        $bulanSekarang = date('m');

        if ($bulanSekarang < $bulanLahir || ($bulanSekarang == $bulanLahir && date('d') < date('d', strtotime($tanggalLahir)))) {
            $umur--;
        }

        return $umur;
    }
}