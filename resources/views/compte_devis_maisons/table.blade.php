<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="compte-devis-maisons-table">
            <thead>
            <tr>
                <th>Nom</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($compteDevisMaisons as $compteDevisMaison)
                <tr>
                    <td>{{ $compteDevisMaison->nom }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['compteDevisMaisons.destroy', $compteDevisMaison->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('compteDevisMaisons.show', [$compteDevisMaison->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('compteDevisMaisons.edit', [$compteDevisMaison->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $compteDevisMaisons])
        </div>
    </div>
</div>
