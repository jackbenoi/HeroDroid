@section('scripts')
<script type="text/javascript">
	window.APPMarket.Resources = {
        index         : '{{ route('appmarket-admin.resource.ads.index') }}'
    };
    window.APPMarket.Vars = {
    	

	};
</script>
<script type="text/javascript" src="{{ asset('assets/js/backend/ads.js') }}"></script>
@stop