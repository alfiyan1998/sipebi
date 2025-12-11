<!DOCTYPE html>
<html>
<head>
    <title>Surat Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>

<h2>Surat Peminjaman Barang</h2>

<p><strong>Nama Peminjam:</strong> {{ $peminjaman->user->name }}</p>
<p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_penggunaan }}</p>
<p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali }}</p>
<p><strong>Status:</strong> {{ ucfirst($peminjaman->status) }}</p>

<br>

<table>
    <thead>
        <tr>
            <th>Barang</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($peminjaman->items as $item)
        <tr>
            <td>{{ $item->bmn->nama_barang ?? '-' }}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>