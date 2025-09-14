<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Thể loại đào tạo</th>
        <th>Ghi chú</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($policies) && is_object($policies))
            @foreach($policies as $policy)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $policy->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $policy->name }}
                </td>
                <td>
                    {{ $policy->note }}
                </td>
                <td class="text-center js-switch-{{ $policy->id }}"> 
                    <input type="checkbox" value="{{ $policy->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($policy->publish == 2) ? 'checked' : '' }} data-modelId="{{ $policy->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('policy.edit', $policy->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('policy.delete', $policy->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $policies->links('pagination::bootstrap-4') }}
