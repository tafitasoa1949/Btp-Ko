<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="devis-maisons-table">
            <thead>
            <tr>
                <th>Maison</th>
                <th>Duree</th>
                <th>Date de creation</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($devisMaisons as $devis)
                <tr>
                    <td>{{ $devis->maison->nom }}</td>
                    <td>{{ $devis->duree }}</td>
                    <td>{{ $devis->date }}</td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="" style="margin-right: 10px;">
                            <i class="fas fa-eye"></i>
                            Details
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $devisMaisons])
        </div>
    </div>
</div>
