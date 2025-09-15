<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Loại hình trường</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($schoolCatalogues) && is_object($schoolCatalogues))
            @foreach($schoolCatalogues as $schoolCatalogue)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $schoolCatalogue->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $schoolCatalogue->name }}
                </td>
                <td class="text-center js-switch-{{ $schoolCatalogue->id }}"> 
                    <input type="checkbox" value="{{ $schoolCatalogue->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($schoolCatalogue->publish == 2) ? 'checked' : '' }} data-modelId="{{ $schoolCatalogue->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('school.catalogue.edit', $schoolCatalogue->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('school.catalogue.delete', $schoolCatalogue->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $schoolCatalogues->links('pagination::bootstrap-4') }}
