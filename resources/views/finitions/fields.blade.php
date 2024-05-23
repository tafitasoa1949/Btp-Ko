<!-- Nom Field -->
<div class="form-group ">
    {!! Form::label('nom', 'Nom:') !!}
    {!! Form::text('nom', null, ['class' => 'form-control']) !!}
    @error('nom')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Pourcentage Field -->
<div class="form-group ">
    {!! Form::label('pourcentage', 'Pourcentage:') !!}
    {!! Form::number('pourcentage', null, ['class' => 'form-control', 'step' => 'any']) !!}
    @error('pourcentage')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
