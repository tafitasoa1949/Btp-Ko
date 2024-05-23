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
                            <li class="breadcrumb-item active">Liste de devis actuel</li>
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
                        @foreach($maisons as $index => $maison)
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-header text-muted border-bottom-0">
                                        Maison
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="lead"><b>{{ $maison->nom }}</b></h2>
                                                <h2 class="lead"><b>Durée : {{ $maison->duree }} jour(s)</b></h2>
                                                <h2 class="lead"><b>Surface : {{ $maison->surface }} m2</b></h2>
                                                    <?php
                                                    $totalPrix = 0;
                                                    foreach ($maison->comptes as $compte) {
                                                        $prix = $compte->quantite * $compte->pu;
                                                        $totalPrix += $prix;
                                                    }
                                                    ?>
                                                <h2 class="lead"><b>Prix : {{ $totalPrix }} Ar</b></h2>
                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    @foreach($maison->details as $detail)
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> {{ $detail->description }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-5 text-center">
                                                <img src="../../dist/img/photo1.png" alt="user-avatar" class="img-circle img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-right">
                                            <a href="{{ route('devis.details',['id' => $maison->id]) }}" class="btn btn-sm bg-teal">
                                                Details
                                            </a>
                                            <a href="{{ route('creer',['id' => $maison->id]) }}" class="btn btn-sm btn-primary">
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
            @include('adminlte-templates::common.paginate', ['records' => $maisons])
        </div>
    </div>
@endsection
