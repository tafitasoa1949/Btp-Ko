@extends('layouts.menu')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Maison</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item" ><a href="#">Accueil</a></li>
                            <li class="breadcrumb-item active">Maison</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card card-solid">
                <div class="card-body pb-0">
                        <div class="row">
                            @foreach($devisMaisons as $index => $devis)
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-header text-muted border-bottom-0">
                                        Maison
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="lead"><b>{{ $devis->maison->nom }}</b></h2>
                                                <h2 class="lead"><b>Durée : {{ $devis->maison->duree }} jour(s)</b></h2>
                                                <h2 class="lead"><b>Surface : {{ $devis->maison->surface }} m2</b></h2>
                                                    <?php
                                                        $totalPrix = 0;
                                                        foreach ($devis->detailDevis as $detailDevis) {
                                                            $prix = $detailDevis->quantite * $detailDevis->pu;
                                                            $totalPrix += $prix;
                                                        }
                                                    ?>
                                                <h2 class="lead"><b>Prix : {{ $totalPrix }} Ar</b></h2>
                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    @foreach($devis->maison->details as $detail)
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> {{ $detail->description }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-5 text-center">
                                                <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-right">
                                            <a href="{{ route('devis.export',['id' => $devis->id]) }}" class="btn btn-sm bg-teal">
                                                Export
                                            </a>
                                            <a href="{{ route('creer',['id' => $devis->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-user"></i> Créer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
        <div class="card-footer clearfix">
            @include('adminlte-templates::common.paginate', ['records' => $devisMaisons])
        </div>
    </div>
@endsection
