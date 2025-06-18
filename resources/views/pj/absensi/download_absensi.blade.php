<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran</title>
</head>
<body>

    <h2>Laporan Kehadiran Ekstrakurikuler</h2>
    <p>
        Pertemuan ke-{{ $data_absensi->pertemuan }}<br>
        Tanggal: {{ \Carbon\Carbon::parse($data_absensi->tanggal)->translatedFormat('d F Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Status Kehadiran</th>
                <th>Musahil Pendamping</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ekstra as $i => $data)
                @php
                    $detail_absensi = DB::table('detail_absensi')
                        ->where('id_pengguna', $data->nim)
                        ->where('id_absensi', $data_absensi->id_absensi)
                        ->first();

                    $musahil = DB::table('musahil_pendamping')
                        ->where('id_warga', $data->nim)
                        ->first();

                    $nama_musahil = '-';

                    if ($musahil && $musahil->id_musahil_pendamping) {
                        $data_musahil = DB::table('pengguna')
                            ->where('nim', $musahil->id_musahil_pendamping)
                            ->first();
                        $nama_musahil = $data_musahil->nama ?? '-';
                    }

                    $status = $detail_absensi->status ?? 'Alpha';
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $data->nim }}</td>
                    <td style="text-align: left;">{{ $data->nama }}</td>
                    <td>{{ ucfirst($status) }}</td>
                    <td style="text-align: left;">{{ $nama_musahil }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
