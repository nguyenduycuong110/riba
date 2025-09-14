<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Nhóm học bổng</th>
        <th>Ghi chú</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($scholarshipCatalogues) && is_object($scholarshipCatalogues))
            @foreach($scholarshipCatalogues as $scholarshipCatalogue)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $scholarshipCatalogue->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $scholarshipCatalogue->name }}
                </td>
                <td>
                    {{ $scholarshipCatalogue->note }}
                </td>
                <td class="text-center js-switch-{{ $scholarshipCatalogue->id }}"> 
                    <input type="checkbox" value="{{ $scholarshipCatalogue->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($scholarshipCatalogue->publish == 2) ? 'checked' : '' }} data-modelId="{{ $scholarshipCatalogue->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('scholarship.catalogue.edit', $scholarshipCatalogue->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('scholarship.catalogue.delete', $scholarshipCatalogue->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $scholarshipCatalogues->links('pagination::bootstrap-4') }}
