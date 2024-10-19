@extends('adminlte::page')

@section('plugins.Chartjs', true)
@section('plugins.FlagIcons', true)

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
        white-space: nowrap;
        width: 1%;
    }

    table#tableSimulations tr.financial-plan-row-header th {
        white-space: normal;
    }

    table#tableSimulations td span.input-group-text{
        background-color:transparent;
        border:transparent;
    }

    table#tableSimulations td.last {
        font-weight: bolder;
    }

    table#tableSimulations td.addnew {
        background-color: #70b2f9;
    }
    table#tableSimulations td.addnew:hover {
        background-color: #b8daff;
        cursor: pointer;
    }

    .height-graph {
        min-height: 40vh;
    }

    @media (max-width: 576px) {
        .height-sm-graph {
            height: 60vh;
        }
    }

</style>
@endpush

@section('content')
    <livewire:sim-manager />
@endsection

@section('footer')
    @include('footer')
@endsection
