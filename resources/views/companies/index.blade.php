@extends('layouts.app')

@section('title', __('Companies'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Companies') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all companies.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Companies') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

                @can('company create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('companies.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new company') }}
                    </a>
                </div>
                @endcan

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Nama Perusahaan') }}</th>
											<th>{{ __('Nama Pemilik') }}</th>
											<th>{{ __('Telepon Perusahaan') }}</th>
											<th>{{ __('Email') }}</th>
											<th>{{ __('No Wa') }}</th>
											<th>{{ __('Alamat') }}</th>
											<th>{{ __('Deskripsi Perusahaan') }}</th>
											<th>{{ __('Logo') }}</th>
											<th>{{ __('Favicon') }}</th>
											<th>{{ __('Url Wa Gateway') }}</th>
											<th>{{ __('Api Key Wa Gateway') }}</th>
											<th>{{ __('Is Active') }}</th>
											<th>{{ __('Footer Pesan Wa Tagihan') }}</th>
											<th>{{ __('Footer Pesan Wa Pembayaran') }}</th>
											<th>{{ __('Url Tripay') }}</th>
											<th>{{ __('Api Key Tripay') }}</th>
											<th>{{ __('Kode Merchant') }}</th>
											<th>{{ __('Private Key') }}</th>
											<th>{{ __('Paket') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('companies.index') }}",
            columns: [
                {
                    data: 'nama_perusahaan',
                    name: 'nama_perusahaan',
                },
				{
                    data: 'nama_pemilik',
                    name: 'nama_pemilik',
                },
				{
                    data: 'telepon_perusahaan',
                    name: 'telepon_perusahaan',
                },
				{
                    data: 'email',
                    name: 'email',
                },
				{
                    data: 'no_wa',
                    name: 'no_wa',
                },
				{
                    data: 'alamat',
                    name: 'alamat',
                },
				{
                    data: 'deskripsi_perusahaan',
                    name: 'deskripsi_perusahaan',
                },
				{
                    data: 'logo',
                    name: 'logo',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class="avatar">
                            <img src="${data}" alt="Logo" >
                        </div>`;
                        }
                    },
				{
                    data: 'favicon',
                    name: 'favicon',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class="avatar">
                            <img src="${data}" alt="Favicon" >
                        </div>`;
                        }
                    },
				{
                    data: 'url_wa_gateway',
                    name: 'url_wa_gateway',
                },
				{
                    data: 'api_key_wa_gateway',
                    name: 'api_key_wa_gateway',
                },
				{
                    data: 'is_active',
                    name: 'is_active',
                },
				{
                    data: 'footer_pesan_wa_tagihan',
                    name: 'footer_pesan_wa_tagihan',
                },
				{
                    data: 'footer_pesan_wa_pembayaran',
                    name: 'footer_pesan_wa_pembayaran',
                },
				{
                    data: 'url_tripay',
                    name: 'url_tripay',
                },
				{
                    data: 'api_key_tripay',
                    name: 'api_key_tripay',
                },
				{
                    data: 'kode_merchant',
                    name: 'kode_merchant',
                },
				{
                    data: 'private_key',
                    name: 'private_key',
                },
				{
                    data: 'paket',
                    name: 'paket.nama_paket'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
