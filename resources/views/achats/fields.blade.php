<!-- Datedebut Field -->
<div class="form-group col-sm-6">
    {!! Form::label('datedebut', 'Datedebut:') !!}
    {!! Form::text('datedebut', null, ['class' => 'form-control','id'=>'datedebut']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#datedebut').datepicker()
    </script>
@endpush