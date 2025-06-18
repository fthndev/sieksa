 @vite(['resources/css/app.css', 'resources/js/app.js'])
 <style>
    @media print{
    .no-print{
        display: none;
    }
}
 </style>
<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-center text-2xl font-bold mb-2">Laporan Kehadiran Ekstrakurikuler</h2>
    <p class="text-center text-gray-600 mb-6">
        Pertemuan ke-{{ $data_absensi->pertemuan }} <br>
        Tanggal: {{ \Carbon\Carbon::parse($data_absensi->tanggal)->translatedFormat('d F Y') }}
    </p>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 shadow-md text-sm">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">NIM</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Status Kehadiran</th>
                    <th class="border px-4 py-2">Musahil Pendamping</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
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
                    <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="border px-4 py-2 text-center">{{ $i + 1 }}</td>
                        <td class="border px-4 py-2 text-center">{{ $data->nim }}</td>
                        <td class="border px-4 py-2">{{ $data->nama }}</td>
                        <td class="border px-4 py-2 text-center">{{ ucfirst($status) }}</td>
                        <td class="border px-4 py-2">{{ $nama_musahil }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="text-right text-xs text-gray-500 mt-6">
        Dicetak pada: {{ now()->format('d M Y H:i') }}
    </p>
    <p class="text-right text-xs text-gray-500 mt-20">Penangung Jawab : {{$data_pj->nama}}</p>
    <div class="flex justify-end gap-3 mt-6">
        <button
            onclick="window.print()"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow-sm transition no-print">
            Cetak
        </button>
        <a 
            href="{{ url()->previous() }}" 
            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg shadow-sm transition no-print">
            Kembali
        </a>
    </div>
</div>