@extends('layouts.panelCustomer.panel-customer-master')

@push('css')
    <style>
        /*
                    *
                    * ==========================================
                    * CUSTOM UTIL CLASSES
                    * ==========================================
                    *
                    */
        /* Horizontal line */
        .collapsible-link::before {
            content: '';
            width: 14px;
            height: 2px;
            background: #333;
            position: absolute;
            top: calc(50% - 1px);
            right: 1rem;
            display: block;
            transition: all 0.3s;
        }

        /* Vertical line */
        .collapsible-link::after {
            content: '';
            width: 2px;
            height: 14px;
            background: #333;
            position: absolute;
            top: calc(50% - 7px);
            right: calc(1rem + 6px);
            display: block;
            transition: all 0.3s;
        }

        .collapsible-link[aria-expanded='true']::after {
            transform: rotate(90deg) translateX(-1px);
        }

        .collapsible-link[aria-expanded='true']::before {
            transform: rotate(180deg);
        }
        body {
            background: #dd5e89;
            background: -webkit-linear-gradient(to left, #dd5e89, #f7bb97);
            background: linear-gradient(to left, #dd5e89, #f7bb97);
            min-height: 100vh;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>
        <div class="content">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Kode Pembayaran</th>
                                            <td> <b>{{ $detail->pay_code }}</b> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nama Customer</th>
                                            <td>{{ $detail->customer_name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Metode</th>
                                            <td>{{ $detail->payment_name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nominal</th>
                                            <td>{{ $detail->amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="alert alert-secondary" role="alert">
                                    Instruksi Pembayaran
                                  </div>

                                <div id="accordionExample" class="accordion shadow">
                                    @foreach ($detail->instructions as $key => $row)
                                        <div class="card">
                                            <div id="headingOne{{ $key }}"
                                                class="card-header bg-white shadow-sm border-0">
                                                <h6 class="mb-0 font-weight-bold"><a href="#" data-toggle="collapse"
                                                        data-target="#collapseOne{{ $key }}" aria-expanded="false"
                                                        aria-controls="collapseOne{{ $key }}"
                                                        class="d-block position-relative text-dark text-uppercase collapsible-link py-2">{{ $row->title }}</a>
                                                </h6>
                                            </div>
                                            <div id="collapseOne{{ $key }}"
                                                aria-labelledby="headingOne{{ $key }}"
                                                data-parent="#accordionExample" class="collapse">
                                                <div class="card-body p-5">
                                                    <ul>
                                                        @foreach ($row->steps as $value)
                                                            <li>{!! $value !!}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
