<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice Internet {{ getCompany()->nama_perusahaan }}</title>
    <link rel="stylesheet" href="{{ asset('mazer/asset_pdf') }}/style.css" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="../public/storage/uploads/logos/{{  getCompany()->logo }}" style="width: 100%">
        </div>
        <div id="company">
            <h2 class="name">{{ getCompany()->nama_perusahaan }}</h2>
            <div>{{ getCompany()->alamat }}</div>
            <div>{{ getCompany()->telepon_perusahaan }}</div>
            <div><a href="mailto:{{ getCompany()->email }}">{{ getCompany()->email }}</a></div>
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
                <div class="date">Tanggal Invoice : {{  date("Y-m-d", strtotime($data->tanggal_create_tagihan))}}</div>
                @php
                    $tgl1 =  date("Y-m-d", strtotime($data->tanggal_create_tagihan));
                    $tgl2    = date('Y-m-d', strtotime('+7 days', strtotime($tgl1)))
                @endphp
                <div class="date">Tenggat waktu : {{  $tgl2 }}</div>
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
                        <h3>Tagihan Internet {{ getCompany()->nama_perusahaan }} </h3>No Layanan
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
