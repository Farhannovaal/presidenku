<?php

namespace App\Http\Controllers;

use App\ApiService;

class UserDataDto
{
    public $nomorUrut;
    public $namaLengkap;
    public $tempatTanggalLahir;
    public $karirData;

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
        $responseApi = $this->apiService->getDataFromApi()->json();
        $userDataArray = [];
        foreach ($responseApi['calon_presiden'] as $dataCalon) {
            $karirDataArray = array_map(function ($karir) {
                $karirParts = explode('(', rtrim($karir, ')'));
                $jabatan = $karirParts[0] ?? '';
                $tahun = explode(' dan ', $karirParts[1] ?? '');
                $tahunMulai = intval(substr($tahun[0], 0, 4)) ?? '';
                $tahunSelesai = isset($karirParts[1]) ? intval(substr($karirParts[1], 5, 9)) : null;
                return new KarirData($jabatan, $tahunMulai, $tahunSelesai);
            }, $dataCalon['karir']);
            
            $userData = new UserDataDto(
                $dataCalon['nomor_urut'],
                $dataCalon['nama_lengkap'],
                $dataCalon['tempat_tanggal_lahir'],
                $karirDataArray
            );
            $userDataArray[] = $userData;
        }        
        $userDataArray = collect($userDataArray)->sortBy('nomorUrut')->values()->all();
        return view('home', ['data' => $userDataArray]);
    }
}
