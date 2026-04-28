<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>PIC</th>
            <th>Judul Kegiatan</th>
            <th>Kategori Kegiatan</th>
            <th>Deskripsi Kegiatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kegiatans as $i => $k)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($k->tanggal_kegiatan)->format('d-m-Y') }}</td>
            <td>{{ $k->pic }}</td>
            <td>{{ $k->judul_kegiatan }}</td>
            <td>{{ $k->kategori_kegiatan }}</td>
            <td>{{ $k->deskripsi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
