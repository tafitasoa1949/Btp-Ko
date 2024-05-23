<div class="card-header">
    <h3 class="card-title">Finition</h3>

</div>

<!-- /.card-header -->
<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Pourcentage</th>
            <th style="width: 240px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($finitions as $finition)
            <tr>
                <td>{{ $finition->nom }}</td>
                <td>{{ $finition->pourcentage }}</td>
                <td>
                    {!! Form::open(['route' => ['finitions.destroy', $finition->id], 'method' => 'delete'])!!}
                    <div class='btn-group'>
                        <a class="btn btn-warning btn-sm" href="{{ route('finitions.edit', [$finition->id]) }}" style="margin-right: 10px;">
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
    @if(!empty('errors'))
        @foreach($errors as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif

</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    @include('adminlte-templates::common.paginate', ['records' => $finitions])
</div>

