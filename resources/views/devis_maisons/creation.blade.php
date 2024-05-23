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
                                <h5 class="card-title">Creation nouveau devis</h5>
                            </div>
                            {{-- form --}}
                            <form action="{{ route('creation') }}" method="post">
                                @csrf
                                <input type="hidden" name="maison_id" value="{{ $maison->id }}">
                                <div class="card-body">
                                        <div class="form-group">
                                            <label>Finition</label>
                                            <select class="form-control select2" style="width: 100%;" name="finition_id">
                                                @foreach($finitions as $finition)
                                                    <option value="{{ $finition->id }}">{{ $finition->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('finition_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Reference</label>
                                        <input type="text"  class="form-control" id="exampleInputEmail1" placeholder="" name="reference">
                                        @error('reference')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date de devis</label>
                                        <input type="date" step="any" class="form-control" id="exampleInputEmail1" placeholder="En minute" name="datedevis">
                                        @error('datedevis')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date de debut</label>
                                        <input type="date" step="any" class="form-control" id="exampleInputEmail1" placeholder="En minute" name="datedebut">
                                        @error('datedebut')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Lieu </label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ville" name="lieu">
                                        @error('lieu')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @error('error')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
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
