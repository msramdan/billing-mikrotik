@extends('layouts.panelCustomer.panel-customer-master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('No Tagihan') }}</td>
                                        <td>{{ $tagihan->no_tagihan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Pelanggan') }}</td>
                                        <td>{{ $tagihan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Periode') }}</td>
                                        <td>{{ tanggal_indonesia($tagihan->periode)  }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Metode Bayar') }}</td>
                                        <td>{{ $tagihan->metode_bayar }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status Bayar') }}</td>
                                        <td>{{ $tagihan->status_bayar }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Nominal Bayar') }}</td>
                                        <td>{{ rupiah($tagihan->nominal_bayar) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Potongan Bayar') }}</td>
                                        <td>{{ rupiah($tagihan->potongan_bayar) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('PPN') }}</td>
                                        <td>{{ $tagihan->ppn }} - {{ rupiah($tagihan->nominal_ppn) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Total Bayar') }}</td>
                                        <td>
                                            (Nominal Bayar - Potongan Bayar) + PPN <br>
                                            ({{ rupiah($tagihan->nominal_bayar) }} - {{ rupiah($tagihan->potongan_bayar) }}) + {{ rupiah($tagihan->nominal_ppn) }} <br>
                                            <b>{{ rupiah($tagihan->total_bayar) }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Bayar') }}</td>
                                        <td>{{ isset($tagihan->tanggal_bayar) ? $tagihan->tanggal_bayar : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Create Tagihan') }}</td>
                                        <td>{{ isset($tagihan->tanggal_create_tagihan) ? $tagihan->tanggal_create_tagihan : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Kirim Notif Wa') }}</td>
                                        <td>{{ isset($tagihan->tanggal_kirim_notif_wa) ? $tagihan->tanggal_kirim_notif_wa : '' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
