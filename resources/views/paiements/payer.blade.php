@extends('layouts.menu')
@section('content')
    {{-- content --}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> BTP-Ko</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Maison</a></li>
                            <li class="breadcrumb-item active">Creation</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Faire un paiement</h5>
                            </div>
                            <div class="card-body">
                                <h3>Travail : {{ $achat->devisMaison->maison->nom }}</h3>
                                <h3>Montant reçu : {{ $montantRecu }} Ar</h3>
                                <h3>Reste à payer : {{ $reste }} Ar</h3>
                            </div>
                            {{-- form --}}
                            <form action="{{ route('payer_achat') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="hidden" name="achat_id" value="{{ $achat->id }}">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Montant</label>
                                            <input type="montant" step="any" class="form-control" id="exampleInputEmail1" placeholder="" name="montant">
                                            @error('montant')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Reference</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="reference">
                                        @error('reference')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date</label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" placeholder="En minute" name="date">
                                        @error('date')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @error('error')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Payer</button>
                                </div>
                            </form>
                            {{--  --}}
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{--  --}}
@endsection
