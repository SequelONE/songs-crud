<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<div class="input-group">
    <input
        type="text"
        id="shortlink"
        name="{{ $field['name'] }}"
        value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
        class="form-control"
        @include('crud::fields.inc.attributes')
    >
    <span class="input-group-append">
        <button type="button" id="shortlink-gen-button" class="btn btn-light btn-sm"><i class="la la-bolt"></i> {{ trans('releases-crud::releasescrud.generate') }}</button>
    </span>
</div>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- no styles -->
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            let generate = document.getElementById("shortlink-gen-button");
            let shortlink = document.getElementById("shortlink");

            function genShortlink() {
                let global = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                let numeric = "0123456789";
                let small = "abcdefghijklmnopqrstuvwxyz";
                let small_alphanumeric = "0123456789abcdefghijklmnopqrstuvwxyz";
                let big = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                let big_alphanumeric = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                let special = "!@#$%^&*()";
                let chars = {{ $field['generate'] }};
                let shortlinkLength = {{ $field['length'] }};
                let shortlink = "";
                for (let i = 1; i <= shortlinkLength; i++) {
                    let randomNumber = Math.floor(Math.random() * chars.length);
                    shortlink += chars.substring(randomNumber, randomNumber +1);
                }
                document.getElementById("shortlink").value = shortlink;
            }

            generate.addEventListener("click", function () {
                genShortlink();
            });
        </script>
    @endpush
@endif
