<?php

namespace App\Http\Controllers;

use App\ApiService;

class UserDataDto
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

class KarirData
{
    public string $jabatan;

    public int $tahunMulai;

    public ?int $tahunSelesai;

    public function __construct(string $jabatan, int $tahunMulai, ?int $tahunSelesai)
    {
        $this->jabatan = $jabatan;
        $this->tahunMulai = $tahunMulai;
        $this->tahunSelesai = $tahunSelesai;
    }
}
class getDataController extends Controller
{
    private $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        $responseApi = $this->apiService->getDataFromApi();
        $presidenDataArray = [];
        foreach ($responseApi['calon_presiden'] as $dataCalon) {
            $karirDataArray = array_map(function ($karir) {
                $karirParts = explode('(', rtrim($karir, ')'));
                $jabatan = $karirParts[0] ?? '';
                $tahun = explode(' dan ', $karirParts[1] ?? '');
                $tahunMulai = intval(substr($tahun[0], 0, 4)) ?? '';
                $tahunSelesai = isset($karirParts[1]) ? intval(substr($karirParts[1], 5, 9)) : null;

                return new KarirData($jabatan, $tahunMulai, $tahunSelesai);
            }, $dataCalon['karir']);

            $dataPresiden = new UserDataDto(
                $dataCalon['nomor_urut'],
                $dataCalon['nama_lengkap'],
                $dataCalon['tempat_tanggal_lahir'],
                $karirDataArray
            );

            $presidenDataArray[] = $dataPresiden;
        }
        $wakilPresidenDataArray = [];
        foreach ($responseApi['calon_wakil_presiden'] as $dataWakilPresiden) {
            $karirDataWakil = array_map(function ($karir) {
                $karirPartsWakil = explode('(', rtrim($karir, ')'));
                $jabatanWakil = $karirPartsWakil[0] ?? '';
                $tahunWakil = explode(' dan ', $karirPartsWakil[1] ?? '');
                $tahunMulaiWakil = intval(substr($tahunWakil[0], 0, 4)) ?? '';
                $tahunSelesaiWakil = isset($karirPartsWakil[1]) ? intval(substr($karirPartsWakil[1], 5, 9)) : null;

                return new KarirData($jabatanWakil, $tahunMulaiWakil, $tahunSelesaiWakil);
            }, $dataWakilPresiden['karir']);

            $wakilPresidenData = new UserDataDto(
                $dataWakilPresiden['nomor_urut'],
                $dataWakilPresiden['nama_lengkap'],
                $dataWakilPresiden['tempat_tanggal_lahir'],
                $karirDataWakil
            );

            $wakilPresidenDataArray[] = $wakilPresidenData;
        }
        $dataCalon = collect([...$presidenDataArray, ...$wakilPresidenDataArray])->sortBy('nomorUrut')->values()->all();

        // dd($dataCalon);
        return view('home', ['data' => $dataCalon]);
    }
}
