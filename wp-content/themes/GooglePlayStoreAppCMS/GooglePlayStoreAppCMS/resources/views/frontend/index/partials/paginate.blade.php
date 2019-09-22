<nav style="text-align: center;">

    {{--*/ $link_limit = 4; /*--}}
    @if ($apps->lastPage() > 1)
        <ul class="pagination">
            <li class="page-item {{ ($apps->currentPage() == 1) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $apps->url(1) }}">First</a>
             </li>

            @for ($i = 1; $i <= $apps->lastPage(); $i++)
                <?php
                $half_total_links = floor($link_limit / 2);
                $from = $apps->currentPage() - $half_total_links;
                $to = $apps->currentPage() + $half_total_links;
                if ($apps->currentPage() < $half_total_links) {
                   $to += $half_total_links - $apps->currentPage();
                }
                if ($apps->lastPage() - $apps->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($apps->lastPage() - $apps->currentPage()) - 1;
                }
                ?>
                @if ($from < $i && $i < $to)
                    <li class="page-item {{ ($apps->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $apps->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor
            <li class="page-item {{ ($apps->currentPage() == $apps->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $apps->url($apps->lastPage()) }}">Last</a>
            </li>
        </ul>
    @endif
</nav>