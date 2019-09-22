@section('scripts')
<script type="text/javascript">
	window.APPMarket.Resources = {
        root               : '{{ route('backend.apps.index') }}',
        index              : '{{ route('appmarket-admin.resource.appmarket.index') }}',
        app_update         : '{{ route('appmarket-admin.resource.appmarket-update.store') }}',
        app_version_update : '{{ route('appmarket-admin.resource.appmarket-apk-update.store') }}',
        app_search         : '{{ route('backend.apps.search') }}',
        app_import         : '{{ route('backend.apps.import') }}',
        app_android_detail : '{{ route('backend.apps.android.detail') }}',
        app_remove_upload  : '{{ route('backend.apps.remove.upload') }}',
        app_remove_apk     : '{{ route('backend.apps.remove.apk') }}',
    };
    window.APPMarket.Vars = {
        alpha          : {!! json_encode($letters) !!},
        hash_id        : {{ isset($hashId)         ? $hashId : 0 }},
        is_create      : {{ isset($is_create)      ? $is_create : 0 }},
        is_google_play : {{ isset($is_google_play) ? $is_google_play : 0 }},
        parentCatId    : {{ isset($parentCatId)    ? $parentCatId : 0 }},
        categories     : {!! isset($categories)     ? json_encode($categories) : json_encode([]) !!},

	};
</script>
<script type="text/javascript" src="{{ asset('assets/js/backend/apps.js') }}"></script>
@stop