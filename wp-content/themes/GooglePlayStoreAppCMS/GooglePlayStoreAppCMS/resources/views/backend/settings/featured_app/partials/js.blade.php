@section('scripts')
<script type="text/javascript">
	window.APPMarket.Resources = {
        root                 : '{{ route('backend.apps.index') }}',
        index                : '{{ route('appmarket-admin.resource.appmarket.index') }}',
        addToFeaturedItem    : '{{ route('backend.setting.addToFeaturedItem') }}',
        removeToFeaturedItem : '{{ route('backend.setting.remove.featured.item') }}',
    };
    window.APPMarket.Vars = {
        alpha          : {!! json_encode($letters) !!},
        hash_id        : {{ isset($hashId)         ? $hashId : 0 }},
        is_create      : {{ isset($is_create)      ? $is_create : 0 }},

	};
</script>
<script type="text/javascript" src="{{ asset('assets/js/backend/featuredApp.js') }}"></script>
@stop