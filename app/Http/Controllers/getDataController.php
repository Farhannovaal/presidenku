<?php

namespace App\Http\Controllers;

use App\ApiService;
use App\Http\Controllers\KarirData;
use App\Http\Controllers\UserDataDto;


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

            $dataPresiden = new UserDto(
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

            $wakilPresidenData = new UserDto(
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
