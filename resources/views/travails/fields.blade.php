<!-- Compte Field -->
<div class="form-group ">
    {!! Form::label('compte_id', 'Compte:')!!}
    {!! Form::select('compte_id', $comptes->pluck('nom', 'id')->toArray(), null, ['class' => 'form-control select2', 'style' => 'width: 100%;'])!!}
    @error('compte_id')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Code Field -->
<div class="form-group >
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
    @error('code')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Nom Field -->
<div class="form-group>
    {!! Form::label('nom', 'Nom:') !!}
    {!! Form::text('nom', null, ['class' => 'form-control']) !!}
    @error('nom')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Unite Field -->
<div class="form-group ">
    {!! Form::label('unite_travail_id', 'Unite:')!!}
    {!! Form::select('unite_travail_id', $unites->pluck('nom', 'id')->toArray(), null, ['class' => 'form-control select2', 'style' => 'width: 100%;'])!!}
    @error('unite_travail_id')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- PU Field -->
<div class="form-group>
    {!! Form::label('pu', 'Prix unitaire:') !!}
    {!! Form::number('pu', null, ['class' => 'form-control', 'step' => 'any']) !!}
    @error('pu')
    <span class="text-danger">{{ $message }}</span>
@enderror
</div>
