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
        @if(isset($trains) && is_object($trains))
            @foreach($trains as $train)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $train->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $train->name }}
                </td>
                <td>
                    {{ $train->note }}
                </td>
                <td class="text-center js-switch-{{ $train->id }}"> 
                    <input type="checkbox" value="{{ $train->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($train->publish == 2) ? 'checked' : '' }} data-modelId="{{ $train->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('train.edit', $train->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('train.delete', $train->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $trains->links('pagination::bootstrap-4') }}
