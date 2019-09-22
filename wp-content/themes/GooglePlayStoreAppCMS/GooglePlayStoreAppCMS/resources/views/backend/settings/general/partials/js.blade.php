@section('scripts')
<script type="text/javascript">
	window.APPMarket.Resources = {
        index       : '{{ route('appmarket-admin.resource.configuration.index') }}',
        validateApi : '{{ route('appmarket-admin.resource.validate-download-api.index') }}',
        uploadLogo  : '{{ route('backend.setting.upload.logo') }}'
    };
    window.APPMarket.Vars = {
    	

	};
</script>
<script type="text/javascript" src="{{ asset('assets/js/backend/general.js') }}"></script>
@stop