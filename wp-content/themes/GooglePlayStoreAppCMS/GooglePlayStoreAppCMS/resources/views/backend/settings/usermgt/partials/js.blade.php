@section('scripts')
<script type="text/javascript">
	window.APPMarket.Resources = {
        root          : '{{ route('backend.setting.usermgt') }}',
        index         : '{{ route('appmarket-admin.resource.user.index') }}',
    };
    window.APPMarket.Vars = {
    	hash_id 	: {{ isset($hashId) ? $hashId : 0 }},
        is_create   : {{ isset($is_create) ? $is_create : 0 }},
        userRoles 	: {!! isset($userRoles) ? json_encode($userRoles) : json_encode([]) !!},

	};
</script>
<script type="text/javascript" src="{{ asset('assets/js/backend/user.js') }}"></script>
@stop