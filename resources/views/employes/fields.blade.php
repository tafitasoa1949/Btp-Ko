<!-- Nom Field -->
<div class="form-group ">
    {!! Form::label('nom', 'Nom:') !!}
    {!! Form::text('nom', null, ['class' => 'form-control']) !!}
    @error('nom')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Prenoms Field -->
<div class="form-group ">
    {!! Form::label('prenoms', 'Prenoms:') !!}
    {!! Form::text('prenoms', null, ['class' => 'form-control']) !!}
    @error('prenoms')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Date Field -->
<div class="form-group">
    {!! Form::label('datenaissance', 'Date de naissace:') !!}
    {!! Form::date('datenaissance', null, ['class' => 'form-control']) !!}
    @error('datenaissance')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Poste Field -->
<div class="form-group ">
    {!! Form::label('poste_id', 'Poste:')!!}
    {!! Form::select('poste_id', $postes->pluck('nom', 'id')->toArray(), null, ['class' => 'form-control select2', 'style' => 'width: 100%;'])!!}
    @error('poste_id')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
