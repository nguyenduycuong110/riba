@vite('resources/js/app.backend.js')

@if(isset($config['extendJs']) && $config['extendJs'] === true)
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="{{ asset("vendor/backend/plugins/ckfinder_2/ckfinder.js") }}"></script>
<script type="text/javascript" src="{{ asset("vendor/backend/plugins/ckeditor/ckeditor.js") }}"></script>
@endif
<script src="{{ asset('backend/plugins/jquery-ui.js') }}"></script>
<script src="{{ asset('backend/js/plugins/nestable/jquery.nestable.js') }}"></script>
