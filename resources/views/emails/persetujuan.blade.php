<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 25px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .header {
            background: linear-gradient(135deg, #10b981, #059669);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .body {
            padding: 30px;
            color: #4b5563;
            font-size: 15px;
            line-height: 1.6;
        }

        .body strong {
            color: #111827;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
            color: white;
            margin-bottom: 20px;
        }

        .badge-primary { background-color: #2563eb; }
        .badge-success { background-color: #059669; }
        .badge-warning { background-color: #d97706; }
        .badge-danger  { background-color: #dc2626; }

        .table-container {
            margin-top: 20px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: #f3f4f6;
        }

        thead th {
            padding: 12px;
            font-size: 14px;
            color: #374151;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody td {
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #f1f1f1;
        }

        .cta-button {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 24px;
            background-color: #10b981;
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .cta-button:hover {
            background-color: #059669;
        }

        .footer {
            padding: 18px;
            font-size: 13px;
            text-align: center;
            color: #6b7280;
            background: #f9fafb;
        }

    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>{{ $title }}</h1>
    </div>

    <div class="body">

        <p>Halo <strong>{{ $user }}</strong>,</p>

        {!! $content !!}

        <!-- Status Badge -->
        @if(isset($status))
            <div class="status-badge badge-{{ strtolower($statusColor ?? 'primary') }}">
                Status: {{ $status }}
            </div>
        @endif

        <!-- Tabel Barang -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['kode'] }}</td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- CTA Button -->
        <a href="{{ $url }}" class="cta-button">Lihat Detail</a>

    </div>

    <div class="footer">
        Sistem Informasi Barang & Aset<br>
        <strong>Si-Barkend</strong>
    </div>

</div>

</body>
</html>
