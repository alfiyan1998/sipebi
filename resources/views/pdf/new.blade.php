<!DOCTYPE html>
<html>

<head>
    <title>Surat Izin Penggunaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="image/logo.png" />
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            /* Use a classic serif font */
            line-height: 1.6;

            /* A light grey background to simulate a page */
        }



        .document-header {
            border-bottom: 2px solid black;
            /* The thick black line under the header */
            /* padding-bottom: 5px; */
            /* margin-bottom: 30px; */
        }

        .header-content {
            display: flex;
            /* Use flexbox for logo and text alignment */
            align-items: center;
            gap: 10px;
        }

        .header-logo {
            width: 80px;
            /* Adjust the logo size as needed */
            height: auto;
        }

        .header-text {
            text-align: center;
            flex-grow: 1;
            /* Allows the text to take up remaining space */
        }

        .header-text h1,
        .header-text h2 {
            margin: 0;
            line-height: 1.2;
        }

        .header-text h1 {
            font-size: 1.2em;
        }

        .header-text h2 {
            font-size: 1.1em;
        }

        .header-text p {
            margin: 0;
            font-size: 0.8em;
        }

        .document-main {
            text-align: center;
        }

        .document-main h3 {
            margin: 0;
            text-decoration: underline;
            /* Add the underline to the heading */
        }

        .document-main p {
            text-align: justify;
            /* Aligns the paragraph text to both sides */
            /* margin-top: 20px; */
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            /* Merges table borders */
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .my-custom-table,
        .my-custom-table th,
        .my-custom-table td {
            border: none;
        }

        .paraf {
            margin-top: 5px;
        }

        .tabel-paraf {
            width: 100%;
            border: none;
        }

        .tabel-paraf td {
            width: 50%;
            border: none;
        }

        .tabel-paraf .kanan {
            text-align: right;
        }

        .tabel-paraf .isi-paraf {
            height: 55px;
        }

        .signatures-right {
            display: flex;
            justify-content: flex-end;
            /* Menempatkan konten di ujung kanan */
            margin-top: 50px;
        }

        .right-signature {
            text-align: center;
            /* Teks di dalam div di tengah */
            width: 45%;
        }

        .notes,
        .notes ul,
        .notes li {
            text-align: left;
            font-size: 0.9em;
            /* Menyesuaikan ukuran font untuk catatan */
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="document-container">
        <header class="document-header">
            <div class="header-content">
                <table class="table my-custom-table">
                    <tr>
                        <td>
                            <img src="image/logo.png" alt="Logo Kemenag RI" class="header-logo">
                        </td>
                        <td>
                            <div class="header-text">
                                <h1>KEMENTERIAN AGAMA RI</h1>
                                <h2>LAJNAH PENTASHIHAN MUSHAF AL-QUR'AN</h2>
                                <p>Gedung Bayt Al-Qur'an & Museum Istiqlal Jl. Raya TMII Pintu 1 Jakarta Timur 13560</p>
                                <p>Telp. (021) 8416466 8416647 Fax. (021) 8416468</p>
                                <p>Website: http://lajnah.kemenag.go.id Email: lajnah@kemenag.go.id</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </header>

        <main class="document-main">
            <h3>SURAT IZIN PENGGUNAAN BMN</h3>
            <h3>LAJNAH PENTASHIHAN MUSHAF AL-QUR'AN</h3>
            <p>Pembawa surat ini diberi izin untuk menggunakan Barang Milik Negara Lajnah Pentashihan Mushaf Al-Qur'an,
                Kementerian Agama RI sebagai berikut:</p>

            <p><strong>Barang yang akan digunakan:</strong></p>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No.Kode Barang</th>
                        <th>Nama Barang</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($peminjaman->items as $item )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->bmn->kode_barang ?? '-' }}</td>
                        <td>{{ $item->bmn->nama_barang ?? '-' }}</td>                                               
                    </tr>
                    @endforeach
                    

                </tbody>
            </table>

            <p class="signature-line">
                Barang-barang tersebut akan digunakan oleh {{ $peminjaman->user->name }} dengan waktu penggunaan dari {{ $peminjaman->tanggal_penggunaan}} sampai {{ $peminjaman->tanggal_kembali}} di lingkungan Lajnah
                Pentashihan Mushaf Al-Qur'an Kementerian
                Agama RI "Telah Disetujui" untuk keperluan kantor.
            </p>
            <p class="closing">
                Terima kasih atas kerja samanya
            </p>
            <div class="paraf">
                <table class="tabel-paraf">
                    <tr>
                        <td class="keterangan-paraf"></td>
                        <td class="keterangan-paraf kanan">Kepala Sub Bag Tata Usaha</td>
                    </tr>
                    <tr>
                        <td class="isi-paraf"></td>
                        <td class="isi-paraf kanan"></td>
                    </tr>
                    <tr>
                        <td class="nama-paraf"></td>
                        <td class="nama-paraf kanan">H. Muhammad Musadad, M.Ag</td>
                    </tr>
                </table>
            </div>
            <div class="notes">
                <p><strong><em>Catatan :</em></strong></p>

                <ul>
                    <li>Form ini hanya berlaku satu kali penggunaan dan diisi dengan lengkap</li>
                    <li>Hanya ditanda tangani oleh orang yang berwenang</li>
                    <li>Setelah digunakan, barang harus dikembalikan ke bagian BMN</li>
                    <li>Barang yang dipinjam menjadi tanggung jawab peminjam selama digunakan</li>
                    <li>Segera laporkan kepada petugas BMN apabila terjadi kerusakan, kehilangan atau hal-hal yang tidak
                        diinginkan lainnya</li>
                </ul>
            </div>
        </main>
    </div>
</body>

</html>