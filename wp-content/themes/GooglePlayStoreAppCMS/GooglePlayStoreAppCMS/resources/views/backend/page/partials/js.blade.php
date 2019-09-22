@section('scripts')
<script type="text/javascript">
	window.APPMarket.Resources = {
        root          : '{{ route('backend.pages.index') }}',
        index         : '{{ route('appmarket-admin.resource.page.index') }}',
        bulk_deletion : '{{ route('appmarket-admin.resource.page-bulk-deletion.index') }}',
    };
    window.APPMarket.Vars = {
    	hash_id 	: {{ isset($hashId) ? $hashId : 0 }},
        is_create 	: {{ isset($is_create) ? $is_create : 0 }},
        page_lists  : {!! isset($pageLists) ? json_encode(@$pageLists) : json_encode([]) !!},
        status_lists 	: {!! isset($statusLists) ? json_encode(@$statusLists) : json_encode([]) !!},
        dd_actions  : [
        	{
        		code: 'bulk',
        		desc: '{{ trans('backend.common.bulk_action') }}'
        	},
        	{
        		code: 'delete',
        		desc: '{{ trans('backend.common.delete') }}'
        	}
        ],

	};
</script>
<script type="text/javascript" src="{{ asset('assets/js/backend/page.js') }}"></script>
@stop