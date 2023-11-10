@extends('layouts.app')

@section('title', __('No Router'))

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="error-page container">
                            <div class="col-md-8 col-12 offset-md-2">
                                <div class="text-center">
                                    <img style="width: 60%;"
                                        class="img-error"src="{{ asset('mazer/images/samples/error-404.svg') }}"
                                        alt="Not Found"> <br>
                                    <p  class='fs-5 ' style="color: red"> <b>Router belum dipilih atau Router tidak aktif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
