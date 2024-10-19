@extends('adminlte::page')
@section('plugins.FlagIcons', true)

@section('content')

<div class="row">
    <div class="col-12 col-md-8">

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">{{ __('mpa.about')}}</h4>
            </div>
            <div class="card-body">
                @if (App::getLocale() === 'en')
                    <div class="post">
                        <span class="user-block">
                            <img class="img-circle img-bordered-sm" src="{{ asset('vendor/components/flag-icon-css/flags/1x1/gb.svg')}}">
                        </span>
                        <p>Developed as part of <b><a href="https://hackweek.opensuse.org/24/projects/mortgage-plan-analyzer">SUSE Hack Week 23 and 24</a></b>, the <b>Mortgage Plan Analyzer</b> is a collaborative project aimed at simplifying the analysis of housing loan proposals, with a current focus on the most common configurations in Portugal. <br/>
                            These proposals often have two phases: an initial fixed-rate phase, followed by a variable phase composed of a contracted spread and variable Euribor, commonly used as a reference in determining interest rates in eurozone mortgages.</p>

                        <p>It's essential to note that specific conditions, such as the duration of the fixed-rate period, the spread, and other terms, may vary between financial institutions in Portugal!</p>
                        <p>Join us in streamlining and clarifying the financial decision-making process for common housing loans in Portugal.</p>
                    </div>
                @else
                <div class="post">
                    <span class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{ asset('vendor/components/flag-icon-css/flags/1x1/pt.svg')}}">
                    </span>
                    <p>Desenvolvido no âmbito da <b><a href="https://hackweek.opensuse.org/24/projects/mortgage-plan-analyzer">SUSE Hack Week 23 e 24</a></b>, o <b>Mortgage Plan Analyzer</b> é um projeto colaborativo destinado a simplificar a análise de propostas de crédito à habitação, com foco nas configurações mais comuns em Portugal. <br/>
                        Estas propostas frequentemente apresentam duas fases: uma inicial com taxa fixa, seguida por uma fase variável, composta por um spread contratado e Euribor variável, como uma referência usada na determinação de taxas de juros em empréstimos hipotecários na zona do euro.</p>

                    <p>Importante destacar que as condições específicas, como a duração do período de taxa fixa, o spread e outros termos, podem variar entre instituições financeiras em Portugal.</p>
                    <p>Juntem-se a nós para simplificar e esclarecer o processo de decisões financeiras em créditos habitacionais comuns em portugal!</p>
                </div>
                @endif
            </div>
        </div>

    </div>
    <div class="col-12 col-md-4">

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title"><i class="fas fa-link"></i> Links</h4>
            </div>
            <div class="card-body">


                <ul class="list-unstyled">
                    <li>
                        <a href="https://github.com/rjpmestre" class="btn-link text-secondary"><i class="fa-brands fa-xl fa-github pr-2"></i>
                            GitHub Project</a>
                    </li>
                    <li><a href="https://hackweek.opensuse.org/24/projects/mortgage-plan-analyzer" class="btn-link text-secondary"><i class="fa-brands fa-xl fa-suse pr-1"></i>Hack Week 24</a> </li>
                    <li><a href="https://rapidapi.com/lrdavocado-O3qmwiGJQwR/api/euribor/" class="btn-link text-secondary">Euribor API</a></li>
                    <li><a href="https://pt.wikipedia.org/wiki/Tabela_Price" class="btn-link text-secondary">Price table (CAS)</a></li>
                    <li><a href="https://clientebancario.bportugal.pt/credito-habitacao" class="btn-link text-secondary">Banco de Portugal</a></li>
                    <li><a href="https://app.logo.com/" class="btn-link text-secondary">App Logo</a></li>
                </ul>

                @push('css')
                    <style>
                        div.widget-user-2 a:link,
                        div.widget-user-2 a:visited,
                        div.widget-user-2 a:link
                        {
                            color: white;
                        }
                        div.widget-user-2 a:hover{
                            color: #b8daff;
                        }
                        </style>
                @endpush
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-gradient-lightblue">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="https://avatars.githubusercontent.com/u/124290023" style="background-color:white"
                                alt="User avatar: Ricardo Mestre">
                        </div>
                        <h3 class="widget-user-username mb-0">Ricardo Mestre</h3>
                        <h5 class="widget-user-desc">Project Leader</h5>
                    </div>
                    <div class="card-footer bg-gradient-dark">
                        <div class="row">
                            <div class="col-3">
                                <div class="description-block">
                                    <a href="https://github.com/rjpmestre" class="btn-link">
                                        <i class="fab fa-2x fa-github"></i>
                                        <p class="description-text">
                                            <span class="badge">
                                                GitHub
                                            </span>
                                        </p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-3">
                                <a href="mailto:ricardo.mestre@suse.com" class="btn-link">
                                    <div class="description-block">
                                        <i class="fas fa-2x fa-envelope" ></i>
                                        <p class="description-text">
                                            <span class="badge">
                                                Email
                                            </span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

    </div>
</div>


@endsection

@section('footer')
    @include('footer')
@endsection

