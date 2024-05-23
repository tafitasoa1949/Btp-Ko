<!-- Nom Field -->
<div class="form-group ">
    {!! Form::label('nom', 'Nom:') !!}
    {!! Form::text('nom', null, ['class' => 'form-control']) !!}
    @error('nom')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Surface Field -->
<div class="form-group ">
    {!! Form::label('surface', 'Surface:') !!}
    {!! Form::number('surface', null, ['class' => 'form-control','step' => 'any']) !!}
    @error('surface')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Duree Field -->
<div class="form-group ">
    {!! Form::label('duree', 'Duree:') !!}
    {!! Form::number('duree', null, ['class' => 'form-control','step' => 'any']) !!}
    @error('duree')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
