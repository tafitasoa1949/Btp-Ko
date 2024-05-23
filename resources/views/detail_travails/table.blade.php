<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="detail-travails-table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Pu</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($detailTravails as $detailTravail)
                <tr>
                    <td>{{ $detailTravail->nom }}</td>
                    <td>{{ $detailTravail->pu }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['detailTravails.destroy', $detailTravail->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('detailTravails.show', [$detailTravail->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('detailTravails.edit', [$detailTravail->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $detailTravails])
        </div>
    </div>
</div>
