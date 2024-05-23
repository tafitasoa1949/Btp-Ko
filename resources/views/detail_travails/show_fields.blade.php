<!-- Nom Field -->
<div class="col-sm-12">
    {!! Form::label('nom', 'Nom:') !!}
    <p>{{ $detailTravail->nom }}</p>
</div>

<!-- Pu Field -->
<div class="col-sm-12">
    {!! Form::label('pu', 'Pu:') !!}
    <p>{{ $detailTravail->pu }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $detailTravail->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $detailTravail->updated_at }}</p>
</div>

