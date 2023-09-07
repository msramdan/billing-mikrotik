@extends('layouts.panelCustomer.panel-customer-master')

@push('css')
    <style>
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
                                <!-- The text field -->



                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Kode Bayar</th>
                                            <td>

                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control"
                                                        value="{{ $detail->pay_code }}" id="copyText" readonly>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="copyBtn"><i class="fa fa-copy"></i></span>
                                                        {{-- <button id="copyBtn"><i class="fa fa-copy"></i></button> --}}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nama</th>
                                            <td>{{ $detail->customer_name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Metode</th>
                                            <td>{{ $detail->payment_name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nominal</th>
                                            <td>{{ rupiah($detail->amount) }}</td>
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

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        const copyBtn = document.getElementById('copyBtn')
        const copyText = document.getElementById('copyText')
        copyBtn.onclick = () => {
            copyText.select(); // Selects the text inside the input
            document.execCommand('copy'); // Simply copies the selected text to clipboard
            Swal.fire({ //displays a pop up with sweetalert
                icon: 'success',
                title: 'Berhasil di copy',
                showConfirmButton: false,
                timer: 1000
            });
        }
    </script>
@endpush
