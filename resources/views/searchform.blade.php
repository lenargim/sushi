<form role="search" method="get" class="header__search-form search-form" action="{{ esc_url( home_url( '/' ) ) }}">
  <label>
    <input type="search" class="search-field" placeholder="Поиск..." value="{{ get_search_query() }}" name="s" />
  </label>
</form>
