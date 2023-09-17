@extends('layouts.frontend.frontend-master')

@push('css')
    <style>
        .swal2-html-container,
        .swal2-title {
            color: black !important;
        }
    </style>
@endpush

@section('content')
    <br>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>
        <div class="content ">
            <div class="col-md-6 offset-md-3" style="padding: 10px">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Kode Bayar</th>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" style="color: black"
                                                        value="{{ $detail->pay_code }}" id="copyText" readonly>
                                                    <span class="input-group-text" id="copyBtn" style="width: 50px"><i
                                                            class="fa fa-copy"></i></span>
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



                                <div class="accordion" id="accordionExample">

                                    @foreach ($detail->instructions as $key => $row)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ $key }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}"
                                                    aria-expanded="false" aria-controls="collapse{{ $key }}">
                                                    {{ $row->title }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading{{ $key }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
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
