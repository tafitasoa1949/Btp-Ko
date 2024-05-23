<div class="card-header">
    <h3 class="card-title">Compte</h3>
{{--    <a href="{{ route('comptes.create') }}" style="display: block; float: right;width: 80px" class="btn btn-block bg-gradient-primary btn-sm">Ajouter</a>--}}

</div>

<!-- /.card-header -->
<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th>Unite</th>
            <th>Quantite</th>
            <th>PU</th>
            <th style="width: 240px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($comptes as $compte)
            <tr>
                <td>{{ $compte->code }}</td>
                <td>{{ $compte->nom }}</td>
                <td>{{ $compte->unite->nom }}</td>
                <td>{{ $compte->quantite }}</td>
                <td>{{ $compte->pu }}</td>
                <td>
                    {!! Form::open(['route' => ['comptes.destroy', $compte->id], 'method' => 'delete'])!!}
                    <div class='btn-group'>
                        <a class="btn btn-warning btn-sm" href="{{ route('comptes.edit', [$compte->id]) }}" style="margin-right: 10px;">
                            <i class="far fa-edit"></i>
                            Edit
                        </a>
{{--                        {!! Form::button('<i class="far fa-trash-alt"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"])!!}--}}
                    </div>
                    {!! Form::close()!!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    @include('adminlte-templates::common.paginate', ['records' => $comptes])
</div>

