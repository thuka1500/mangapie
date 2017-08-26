@extends ('layout')

@section ('custom_navbar_right')

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-chevron-down white"></span>Libraries
        </a>
        <ul class="dropdown-menu" style="color: black;">
            @foreach ($libraries as $library)
                <li>
                    <a href="{{ URL::action('MangaController@library', ['id' => $library->getId()]) }}">{{ $library->getName() }}</a>
                <li>
            @endforeach
        </ul>
    </li>  

    <li>
    {{ Form::open(['action' => 'SearchController@search', 'class' => 'navbar-form form-inline']) }}

        {{ Form::hidden('type', 'basic') }}

        <div class="form-group">
        {{ Form::text('query', null, ['class' => 'form-control', 'placeholder' => '...']) }}
        </div>

        {{ Form::submit('Search', ['class' => 'btn btn-primary btn-navbar']) }}

    {{ Form::close() }}
    </li>

@endsection

@section ('content')

    <div class="row">

    @foreach ($manga_list as $manga)
   
    <div class="col-lg-2 col-sm-4 col-xs-6 text-center thumbnail center">
        
        <a href="{{ \Config::get('mangapie.app_url') }}/information/{{ $manga->id }}" >
            <img src="{{ \Config::get('mangapie.app_url') }}/thumbnail/{{ $manga->id }}">
        </a>

        <h4>{{ $manga->name }}</h4>
    </div>

    @endforeach

    </div>


{{-- Render the navigation control only if there is more than one page of results --}}
{{-- 
@if ($pagination->lastPage() > 1)

<nav aria-label="Navigation">

    <ul class="pagination">

        <li>
            <a href="#{{ $pagination->url(1) }}" aria-label="First">
                <span aria-hidden="true">&laquo;</span>
            </a>
        <li>
        
        @foreach ($pagination as $page)
            
        @endforeach

        <li>
            <a href="{{ $pagination->lastPage() }}" aria-label="Last">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>

    </ul>

</nav>

@endif
--}}

@endsection