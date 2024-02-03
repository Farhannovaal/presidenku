<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calon Presidenku</title>
</head>
<body>
    <h2>Halo Selamat Datang Calon Presiden Ku</h2>

    @foreach ($data as $userData)
        <h3>Calon Presiden:</h3>
        <p>
            <strong>Nomor Urut:</strong> {{ $userData->nomorUrut }}<br>
            <strong>Nama Lengkap:</strong> {{ $userData->namaLengkap }}<br>
            <strong>Tempat Tanggal Lahir:</strong> {{ $userData->tempatTanggalLahir }}<br>

            @if (property_exists($userData, 'karirData'))
                <strong>Karir:</strong>
                @foreach ($userData->karirData as $karir)
                    <p>
                        <strong>Jabatan:</strong> {{ $karir->jabatan }}<br>
                        <strong>Tahun Mulai:</strong> {{ $karir->tahunMulai }}<br>
                        <strong>Tahun Selesai:</strong> {{ $karir->tahunSelesai ?? 'Sekarang' }}<br>
                    </p>
                @endforeach
            @endif
        </p>
        <hr>
    @endforeach
</body>
</html>
