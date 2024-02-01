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

    <h3>Calon Presiden:</h3>
    @foreach ($data['calon_presiden'] as $calonPresiden)
        <p>
            <strong>Nomor Urut:</strong> {{ $calonPresiden['nomor_urut'] }}<br>
            <strong>Nama Lengkap:</strong> {{ $calonPresiden['nama_lengkap'] }}<br>
            <strong>Tempat Tanggal Lahir:</strong> {{ $calonPresiden['tempat_tanggal_lahir'] }}<br>
            <strong>Karir:</strong> {{ implode(", ", $calonPresiden['karir']) }}
        </p>
        <hr>
    @endforeach

    <h3>Calon Wakil Presiden:</h3>
    @foreach ($data['calon_wakil_presiden'] as $calonWakil)
        <p>
            <strong>Nomor Urut:</strong> {{ $calonWakil['nomor_urut'] }}<br>
            <strong>Nama Lengkap:</strong> {{ $calonWakil['nama_lengkap'] }}<br>
            <strong>Tempat Tanggal Lahir:</strong> {{ $calonWakil['tempat_tanggal_lahir'] }}<br>
            <strong>Karir:</strong> {{ implode(", ", $calonWakil['karir']) }}
        </p>
        <hr>
    @endforeach
</body>
</html>