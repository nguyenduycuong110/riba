<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Dự án</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($projects) && is_object($projects))
            @foreach($projects as $project)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $project->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $project->name }}
                </td>
                <td class="text-center js-switch-{{ $project->id }}"> 
                    <input type="checkbox" value="{{ $project->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($project->publish == 2) ? 'checked' : '' }} data-modelId="{{ $project->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('project.edit', $project->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('project.delete', $project->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $projects->links('pagination::bootstrap-4') }}
