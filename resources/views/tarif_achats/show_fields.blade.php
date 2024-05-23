<!-- Prix Finition Field -->
<div class="col-sm-12">
    {!! Form::label('prix_finition', 'Prix Finition:') !!}
    <p>{{ $tarifAchat->prix_finition }}</p>
</div>

<!-- Montant Total Field -->
<div class="col-sm-12">
    {!! Form::label('montant_total', 'Montant Total:') !!}
    <p>{{ $tarifAchat->montant_total }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $tarifAchat->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $tarifAchat->updated_at }}</p>
</div>

