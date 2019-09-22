@section('scripts')
<script type="text/javascript">
	window.APPMarket.Resources = {
        root       : '{{ route('backend.category.index') }}',
        subCatRoot : '{{ route('backend.sub.category.index') }}',
        index      : '{{ route('appmarket-admin.resource.parent-category.index') }}',
        subindex   : '{{ route('appmarket-admin.resource.category.index') }}',
    };
    window.APPMarket.Vars = {
        alpha         : {!! json_encode($letters) !!},
        hash_id       : {{ isset($hashId) ? $hashId : 0 }},
        is_create     : {{ isset($is_create) ? $is_create : 0 }},
        parentCatId   : {{ isset($parentCatId) ? $parentCatId : 0 }},
        // dd_actions : [
        // 	{
        // 		code: 'bulk',
        // 		desc: '{{ trans('backend.common.bulk_action') }}'
        // 	},
        // 	{
        // 		code: 'delete',
        // 		desc: '{{ trans('backend.common.delete') }}'
        // 	}
        // ],

	};
</script>
<script type="text/javascript" src="{{ asset('assets/js/backend/category.js') }}"></script>
@stop