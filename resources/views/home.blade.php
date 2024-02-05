<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Calon Presidenku</title>
</head>
<body>
    <h2 class="text-center">Halo Selamat Datang Calon Presiden & Wakil Presiden Ku</h2>
    <div class="row text-center">
        @foreach ($data as $userData)
            <div class="col-12 col-sm-6">
                <h2 class="text-danger"><strong>Nomor Urut:</strong> {{ $userData->nomorUrut }}</h2>
                <p>
                    <strong>Nama Lengkap:</strong> {{ $userData->namaLengkap }}<br>
                    <strong>Tempat Tanggal Lahir:</strong> {{ $userData->tempatTanggalLahir }}<br>
                    <strong>Umur:</strong> {{ $userData->umur }}<br>

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
        </div>
        @endforeach
  
</div>
</body>
</html>
