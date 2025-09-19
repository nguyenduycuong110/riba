@props(['heading' => '', 'name', 'options', 'selectedValue' => null])
<div {{ $attributes->merge(['class' => 'row']) }}>
    <div class="col-lg-12">
        <div class="form-row">
            {!! !empty($heading) ? '<span class="text-danger notice">' . $heading . '</span>' : '' !!}
            <select name="{{ $name }}" class="form-control setupSelect2" id="{{ $name }}-select-2-{{ time() }}">
                <option value="0">--- {{ __('messages.choose') }} ---</option>
                @foreach($options as $key => $val)
                    @php
                        $c_id = $val->id;
                        $c_name = $val->languages?->first()->pivot->name ?? $val->name;
                        $currentSelected = old($name, $selectedValue);
                        $isSelected = $c_id == $currentSelected ? 'selected' : '';
                    @endphp
                    <option value="{{ $c_id }}" {{ $isSelected }}>{{ $c_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>