@extends('layouts.app')

@section('title', __('Detail of Tagihans'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Tagihans') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of tagihan.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('tagihans.index') }}">{{ __('Tagihans') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
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
                                        <td>{{ $tagihan->periode }}</td>
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
                                        <td class="fw-bold">{{ __('Total Bayar') }}</td>
                                        <td>{{ rupiah($tagihan->total_bayar) }}</td>
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
                                    {{-- <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $tagihan->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $tagihan->updated_at }}</td>
                                    </tr> --}}
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
