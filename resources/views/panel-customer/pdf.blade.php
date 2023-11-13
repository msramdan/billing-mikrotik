<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice Internet {{ getCompanyUser()->nama_perusahaan }}</title>
</head>
<style>
    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    a {
        color: #0087C3;
        text-decoration: none;
    }

    body {
        position: relative;
        /* width: 21cm;
  height: 29.7cm; */
        margin: 0 auto;
        color: #555555;
        background: #FFFFFF;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-family: SourceSansPro;
    }

    header {
        padding: 10px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #AAAAAA;
    }

    #logo {
        float: left;
        margin-top: 8px;
    }

    #logo img {
        height: 70px;
    }

    #company {
        float: right;
        text-align: right;
    }


    #details {
        margin-bottom: 50px;
    }

    #client {
        padding-left: 6px;
        border-left: 6px solid #0087C3;
        float: left;
    }

    #client .to {
        color: #777777;
    }

    h2.name {
        font-size: 1.4em;
        font-weight: normal;
        margin: 0;
    }

    #invoice {
        float: right;
        text-align: right;
    }

    #invoice h4 {
        color: #0087C3;
        font-size: 1.4em;
        line-height: 1em;
        font-weight: normal;
        margin: 0 0 10px 0;
    }

    #invoice .date {
        font-size: 1.1em;
        color: #777777;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
    }

    table th,
    table td {
        padding: 20px;
        background: #EEEEEE;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
    }

    table th {
        white-space: nowrap;
        font-weight: normal;
    }

    table td {
        text-align: right;
    }

    table td h3 {
        color: #57B223;
        font-size: 1.2em;
        font-weight: normal;
        margin: 0 0 0.2em 0;
    }

    table .no {
        color: #FFFFFF;
        font-size: 1.6em;
        background: #57B223;
    }

    table .desc {
        text-align: left;
    }

    table .unit {
        background: #DDDDDD;
    }

    table .qty {}

    table .total {
        background: #57B223;
        color: #FFFFFF;
    }

    table td.unit,
    table td.qty,
    table td.total {
        font-size: 1.2em;
    }

    table tbody tr:last-child td {
        border: none;
    }

    table tfoot td {
        padding: 10px 20px;
        background: #FFFFFF;
        border-bottom: none;
        font-size: 1.2em;
        white-space: nowrap;
        border-top: 1px solid #AAAAAA;
    }

    table tfoot tr:first-child td {
        border-top: none;
    }

    table tfoot tr:last-child td {
        color: #57B223;
        font-size: 1.4em;
        border-top: 1px solid #57B223;

    }

    table tfoot tr td:first-child {
        border: none;
    }

    #thanks {
        font-size: 2em;
        margin-bottom: 50px;
    }

    #notices {
        padding-left: 6px;
        border-left: 6px solid #0087C3;
    }

    #notices .notice {
        font-size: 1.2em;
    }

    footer {
        color: #777777;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #AAAAAA;
        padding: 8px 0;
        text-align: center;
    }
</style>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="../public/storage/uploads/logos/{{ getCompanyUser()->logo }}" style="width: 100%">
        </div>
        <div id="company">
            <h2 class="name">{{ getCompanyUser()->nama_perusahaan }}</h2>
            <div>{{ getCompanyUser()->alamat }}</div>
            <div>{{ getCompanyUser()->telepon_perusahaan }}</div>
            <div><a href="mailto:{{ getCompanyUser()->email }}">{{ getCompanyUser()->email }}</a></div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">INVOICE KEPADA :</div>
                <h2 class="name">{{ $data->nama }}</h2>
                <div class="address">{{ $data->alamat_customer }}</div>
                <div class="email"><a href="mailto:{{ $data->email_customer }}">{{ $data->email_customer }}</a></div>
            </div>
            <div id="invoice">
                <h4>INVOICE {{ $data->no_tagihan }}</h4>
                <div class="date">Tanggal Invoice : {{ date('Y-m-d', strtotime($data->tanggal_create_tagihan)) }}
                </div>
                @php
                    $tgl1 = date('Y-m-d', strtotime($data->tanggal_create_tagihan));
                    $tgl2 = date('Y-m-d', strtotime('+7 days', strtotime($tgl1)));
                @endphp
                <div class="date">Tenggat waktu : {{ $tgl2 }}</div>
            </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="desc">DESKRIPSI</th>
                    <th class="unit">HARGA</th>
                    <th class="qty">JUMLAH</th>
                    <th class="total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no">01</td>
                    <td class="desc">
                        <h3>Tagihan Internet {{ getCompanyUser()->nama_perusahaan }} </h3>No Layanan
                        {{ $data->no_layanan }} <br> {{ $data->nama_layanan }}
                    </td>
                    <td class="unit">{{ rupiah($data->nominal_bayar - $data->potongan_bayar) }}</td>
                    <td class="qty">1</td>
                    <td class="total">{{ rupiah($data->nominal_bayar - $data->potongan_bayar) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">SUBTOTAL</td>
                    <td>{{ rupiah($data->nominal_bayar - $data->potongan_bayar) }}</td>
                </tr>

                @if ($data->ppn == 'Yes')
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">TAX 11%</td>
                        <td>+ {{ rupiah($data->nominal_ppn) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">GRAND TOTAL</td>
                        <td>{{ rupiah($data->total_bayar) }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">GRAND TOTAL</td>
                        <td>{{ rupiah($data->total_bayar) }}</td>
                    </tr>
                @endif
            </tfoot>
        </table>
    </main>
    <footer>
        Invoice di generate automatis oleh komputer, dan sah tanpa tanda tangan dan stempel.
    </footer>
</body>

</html>
