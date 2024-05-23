<!-- Montant Field -->
<div class="col-sm-12">
    {!! Form::label('montant', 'Montant:') !!}
    <p>{{ $paiement->montant }}</p>
</div>

<!-- Date Field -->
<div class="col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $paiement->date }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $paiement->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $paiement->updated_at }}</p>
</div>

