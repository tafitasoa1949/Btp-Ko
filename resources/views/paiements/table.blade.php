<div class="card-header">
    <h3 class="card-title">Postes</h3>
    <a href="{{ route('paiements.create') }}" style="display: block; float: right;width: 80px" class="btn btn-block bg-gradient-primary btn-sm">Ajouter</a>

</div>

<!-- /.card-header -->
<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>Client</th>
            <th>Ref devis</th>
            <th>Montant</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paiements as $paiment)
            <tr>
                <td>{{ $paiment->devisMaison->client->numero }} </td>
                <td>{{ $paiment->reference }}</td>
                <td>{{ $paiment->montant }} Ar</td>
                <td>{{ $paiment->date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    @include('adminlte-templates::common.paginate', ['records' => $paiements])
</div>

