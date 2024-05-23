<div class="card-header">
    <h3 class="card-title">Travail</h3>
    <a href="{{ route('travails.create') }}" style="display: block; float: right;width: 80px" class="btn btn-block bg-gradient-primary btn-sm">Ajouter</a>

</div>

<!-- /.card-header -->
<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>Compte</th>
            <th>Code</th>
            <th>Nom</th>
            <th>PU</th>
            <th>Unite</th>
            <th style="width: 240px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($travails as $travail)
            <tr>
                <td>{{ $travail->compte->nom }}</td>
                <td>{{ $travail->code }}</td>
                <td>{{ $travail->nom }}</td>
                <td>{{ $travail->pu }} Ar</td>
                <td>{{ $travail->unite->nom }}</td>
                <td>
                    {!! Form::open(['route' => ['travails.destroy', $travail->id], 'method' => 'delete'])!!}
                    <div class='btn-group'>
                        <a class="btn btn-warning btn-sm" href="{{ route('travails.edit', [$travail->id]) }}" style="margin-right: 10px;">
                            <i class="far fa-edit"></i>
                            Edit
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"])!!}
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
    @include('adminlte-templates::common.paginate', ['records' => $travails])
</div>

