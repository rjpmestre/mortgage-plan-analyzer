@extends('adminlte::page')

@section('plugins.Chartjs', true)

@push('css')
<style>
    div.input-group-append {
        height: 1.8rem;
    }
    table#tableSimulations td input {
        border: none;
    }
    .blank_row {
        line-height: 3px;
    }

    table#tableSimulations th, table#tableSimulations td {
        vertical-align: middle;
    }
    table#tableSimulations td {
        white-space: nowrap;
    }

    table#tableSimulations td span.input-group-text{
        background-color:transparent;
        border:transparent;
    }


    transparent


    table#tableSimulations td.last {
        font-weight: bolder;
    }

    table#tableSimulations td.addnew {
        background-color: #007bff;
    }
    table#tableSimulations td.addnew:hover {
        background-color: #b8daff;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
    @livewire('sim-manager')
@endsection

@section('footer')
    <div class="float-right d-none d-sm-inline">
        <b>v</b>{{env('APP_VERSION','???')}}
    </div>

    Copyright © 2023 <b>{{env('APP_NAME','???')}}</b>. All rights reserved.
@endsection
