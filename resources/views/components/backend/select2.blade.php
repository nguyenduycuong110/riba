@props(['heading' => '', 'name', 'options', 'selectedValue'])

<div {{ $attributes->merge(['class' => 'row']) }}>
    <div class="col-lg-12">
        <div class="form-row">
            {!! !empty($heading) ? '<span class="text-danger notice">' . $heading . '</span>' : '' !!}
            <select name="{{ $name }}" class="form-control setupSelect2" id="{{ $name }}-select-2-{{ time() }}">
                @foreach($options as $key => $val)
                <option {{ 
                    $key == old($name, (isset($selectedValue)) ? $selectedValue : '') ? 'selected' : '' 
                    }} value="{{ $key }}">{{ $val }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>