<nav style="text-align: center;">
    {{--*/ $link_limit = 5; /*--}}
    @if ($paginate->lastPage() > 1)
        <ul class="pagination">
            <li class="page-item {{ ($paginate->currentPage() == 1) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $paginate->url(1) }}">First</a>
             </li>

            @for ($i = 1; $i <= $paginate->lastPage(); $i++)
                <?php
                $half_total_links = floor($link_limit / 2);
                $from = $paginate->currentPage() - $half_total_links;
                $to = $paginate->currentPage() + $half_total_links;
                if ($paginate->currentPage() < $half_total_links) {
                   $to += $half_total_links - $paginate->currentPage();
                }
                if ($paginate->lastPage() - $paginate->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($paginate->lastPage() - $paginate->currentPage()) - 1;
                }
                ?>
                @if ($from < $i && $i < $to)
                    <li class="page-item {{ ($paginate->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $paginate->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor
            <li class="page-item {{ ($paginate->currentPage() == $paginate->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $paginate->url($paginate->lastPage()) }}">Last</a>
            </li>
        </ul>
    @endif
</nav>

