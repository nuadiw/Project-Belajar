<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Kegiatan</title>

    <style>
        @page {
            size: A4;
            margin: 20px;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h3 {
            margin-bottom: 4px;
        }

        .meta {
            font-size: 10px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .doc-title {
            font-weight: bold;
            margin-bottom: 6px;
        }

        .docs {
            width: 100%;
        }

        .doc-item {
            width: 30%;
            display: inline-block;
            margin: 5px 1%;
            text-align: center;
            font-size: 9px;
        }

        .doc-item img {
            width: 100%;
            height: auto;
            border: 1px solid #000;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <h3>Riwayat Kegiatan</h3>
    <div class="meta">
        Dicetak oleh: {{ $user->name }} <br>
        Tanggal cetak: {{ now()->format('d-m-Y H:i') }} <br>
        Total kegiatan: {{ $kegiatans->count() }}
    </div>

    {{-- TABEL KEGIATAN --}}
    @include('kegiatan._table')

    {{-- DOKUMENTASI --}}
    @php
        $docs = $kegiatans->whereNotNull('dokumentasi');
    @endphp

    @if($docs->count())
        <div class="page-break"></div>

        <div class="doc-title">Dokumentasi Kegiatan</div>

        <div class="docs">
            @foreach($docs as $k)
                <div class="doc-item">
                    <img src="{{ public_path('storage/'.$k->dokumentasi) }}">
                    <div>{{ $k->judul_kegiatan }}</div>
                </div>
            @endforeach
        </div>
    @endif

</body>
</html>
