@props([
    'model' => null,
    'with' => null,
    'dropdown' => [],
    'name' => 'Danh mục khác',
    'field' => 'catalogue',
    'excludeId' => null, // ID cần loại bỏ (danh mục cha)
])

{{-- @dd($excludeId) --}}

@php
    // Lấy danh sách ID đang được chọn từ quan hệ hoặc old()
    $selected = [];
    if ($model && $with && isset($model->{$with})) {
        $selected = $model->{$with}->pluck('id')->toArray();
    }
    $selected = old($field, $selected);

    // Nếu có danh mục cha, loại bỏ nó khỏi dropdown
    if ($excludeId) {
        $dropdown = collect($dropdown)->except($excludeId)->toArray();
    }
@endphp

<div class="form-group">
    <label class="control-label">{{ $name }}</label>
    <select
        multiple
        name="{{ $field }}[]"
        class="form-control setupSelect2"
        data-placeholder="Chọn {{ strtolower($name) }}"
    >
        @foreach($dropdown as $key => $val)
            <option value="{{ $key }}" @selected(in_array($key, (array) $selected))>
                {{ $val }}
            </option>
        @endforeach
    </select>
</div>
