<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Khu vực</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($areas) && is_object($areas))
            @foreach($areas as $area)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $area->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $area->name }}
                </td>
                <td class="text-center js-switch-{{ $area->id }}"> 
                    <input type="checkbox" value="{{ $area->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($area->publish == 2) ? 'checked' : '' }} data-modelId="{{ $area->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('area.edit', $area->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('area.delete', $area->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $areas->links('pagination::bootstrap-4') }}
