<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Học bổng</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($scholarships) && is_object($scholarships))
            @foreach($scholarships as $scholarship)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $scholarship->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $scholarship->name }}
                </td>
                <td class="text-center js-switch-{{ $scholarship->id }}"> 
                    <input type="checkbox" value="{{ $scholarship->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($scholarship->publish == 2) ? 'checked' : '' }} data-modelId="{{ $scholarship->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('scholarship.edit', $scholarship->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('scholarship.delete', $scholarship->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $scholarships->links('pagination::bootstrap-4') }}
