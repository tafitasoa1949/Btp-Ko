<!-- Quantite Field -->
<div class="col-sm-12">
    {!! Form::label('quantite', 'Quantite:') !!}
    <p>{{ $detailDevis->quantite }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $detailDevis->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $detailDevis->updated_at }}</p>
</div>

