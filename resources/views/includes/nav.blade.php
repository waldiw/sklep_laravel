<nav class="main-menu">
    <ul>
        <li class="dropdown">
            <a href="{{ route('filter') }}" class="dropdown-toggle">Zamówienia</a>
            <ul class="dropdown-menu">
{{--                <li><a href="{{ route('home') }}">Wszystkie</a></li>--}}
                <li><a href="{{ route('filter') }}">Zamówienia</a></li>
{{--                <li><a href="{{ route('limit') }}">Ostatnie 10</a></li>--}}
{{--                <li><a href="{{ route('exportCSV') }}">Export Csv</a></li>--}}
                <li><a href="{{ route('exportAllCSV') }}">Export Csv rozszerzony</a></li>
            </ul>
        </li>
{{--        <li>--}}
{{--            <a href="{{ route('home') }}">Zamówienia</a>--}}
{{--        </li>--}}
        <li>
            <a href="{{ route('articles') }}">Artykuły</a>
        </li>
        <li>
            <a href="{{ route('admin') }}">Administracja</a>
        </li>
        <li>
            <a href="{{ route('statute') }}">Regulamin</a>
        </li>
        <li>
            <a href="{{ route('contact') }}">Kontakt</a>
        </li>
        <li>
            <a href="#" onclick="document.getElementById('logout-form').submit();" >{{ __('Logout') }}</a>
        </li>
    </ul>
</nav>
