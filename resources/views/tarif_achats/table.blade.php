<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="tarif-achats-table">
            <thead>
            <tr>
                <th>Prix Finition</th>
                <th>Montant Total</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tarifAchats as $tarifAchat)
                <tr>
                    <td>{{ $tarifAchat->prix_finition }}</td>
                    <td>{{ $tarifAchat->montant_total }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['tarifAchats.destroy', $tarifAchat->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('tarifAchats.show', [$tarifAchat->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('tarifAchats.edit', [$tarifAchat->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $tarifAchats])
        </div>
    </div>
</div>
