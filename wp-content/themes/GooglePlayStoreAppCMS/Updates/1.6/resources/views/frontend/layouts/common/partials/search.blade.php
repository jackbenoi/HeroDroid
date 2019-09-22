<div class="navbar-search navbar-item">
    {{-- {{ Form::open(['accept-charset'=>'UTF-8', 'url' => route('frontend.search') , 'method' => 'GET','class'=>'search-form']) }}
        <i class="material-icons">search</i>
        <input class="form-control" type="text" name="q" placeholder="Search" />
    {{ Form::close() }} --}}
    <input type="hidden" id="search-url" name="search-url" value="{{ route('frontend.search') }}">
    {{ Form::open(['accept-charset'=>'UTF-8', 'url' => route('frontend.search') , 'method' => 'GET','class'=>'search-form']) }}
	    <i class="material-icons">search</i>
	    <input class="form-control" type="text" name="q" placeholder="Search" />
    {{ Form::close() }}
</div>