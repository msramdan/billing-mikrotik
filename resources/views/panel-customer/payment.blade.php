@extends('layouts.panelCustomer.panel-customer-master')

@push('css')
    <style>
        .frame {
            height: 65px;
            width: 160px;
            position: relative;
        }

        .img-aja {
            max-height: 100%;
            max-width: 100%;
            width: auto;
            height: auto;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            padding: 0.25rem;
            background-color: #fff;
            /* border: 1px solid #dee2e6; */
            border-radius: 0.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .075);
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($metodeBayar as $row)
                                    <div class="col-md-3 col-md-3">
                                        <div class="small-box bg-light">
                                            <center>
                                                <div class="frame">
                                                    <img src="{{ $row->icon_url }}" class="img-aja" style="height: 80%" />
                                                </div>
                                            </center>
                                            <a href="{{ route('doPayment', [
                                                'tagihan_id' => $tagihan_id,
                                                'metode' => $row->code,
                                            ]) }}"
                                                class="small-box-footer">Pilih Metode <i
                                                    class="fas fa-arrow-circle-right"></i></a>
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
@endsection
