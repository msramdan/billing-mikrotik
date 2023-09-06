@extends('layouts.panelCustomer.panel-customer-master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-secondary" role="alert" style="">
                                <h4>Anda dapat melakukan pembayaran tagihan dengan cara : <br>
                                    <ul>
                                        <li>Lewat Virtual Account (Verifikasi Pembayaran Automatis)</li>
                                        {{-- <img class="img-thumbnail" style="padding: 10px"
                                            src="{{ asset('mazer/carabayar.jpg') }}" alt=""> --}}
                                        <li>Transfer lewat Norek {{ getCompany()->nama_perusahaan }} dengan menyerahkan
                                            bukti transfer lewat WA / datang ke kantor</li>
                                        <li>Bayar Cash dengan datang ke kantor</li>
                                    </ul>
                                    <hr>
                                    Contact Person {{ getCompany()->nama_perusahaan }} : <br>
                                    <ul>
                                        <li> No Wa : {{ getCompany()->no_wa }}</li>
                                        <li>Telpon : {{ getCompany()->telepon_perusahaan }} </li>
                                        <li>Email : {{ getCompany()->email }}</li>
                                        <li>Alamat : {{ getCompany()->alamat }}</li>
                                    </ul>
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <center>
                                <div class="alert alert-primary" role="alert">
                                    <h4>Daftar nomor rekening Pembayaran {{ getCompany()->nama_perusahaan }} </h4>
                                </div>
                                <div class="row">
                                    @foreach ($bankAccounts as $row)
                                        <div class="col-md-6">
                                            <div class="card">
                                                <center>
                                                    <img style="border: 1px solid #ddd;border-radius: 10px;padding: 5px;width: 150px;margin-top:5px"
                                                        src="{{ asset('storage/uploads/logo_banks/' . $row->logo_bank) }}"
                                                        alt="Card image cap">
                                                </center>
                                                <div class="card-body">
                                                    <h5>A.n {{ $row->pemilik_rekening }}</h5>
                                                    <h5>Norek {{ $row->nomor_rekening }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
