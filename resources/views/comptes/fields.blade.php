<!-- Code Field -->
<div class="form-group ">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
    @error('code')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Nom Field -->
<div class="form-group ">
    {!! Form::label('nom', 'Nom:') !!}
    {!! Form::text('nom', null, ['class' => 'form-control']) !!}
    @error('nom')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Poste Field -->
<div class="form-group ">
    {!! Form::label('unite_id', 'Unite:')!!}
    {!! Form::select('unite_id', $unites->pluck('nom', 'id')->toArray(), null, ['class' => 'form-control select2', 'style' => 'width: 100%;'])!!}
    @error('unite_id')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>


<!-- Quantite Field -->
<div class="form-group ">
    {!! Form::label('quantite', 'Quantité:') !!}
    {!! Form::number('quantite', null, ['class' => 'form-control', 'step'=> 'any']) !!}
    @error('quantite')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- PU Field -->
<div class="form-group ">
    {!! Form::label('pu', 'PU:') !!}
    {!! Form::number('pu', null, ['class' => 'form-control', 'step'=> 'any']) !!}
    @error('pu')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>


