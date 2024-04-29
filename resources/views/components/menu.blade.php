<nav class="col-md-2 d-none d-md-block sidebar">
    <ul class="nav flex-column sidebar">
        <li class="nav-item">
            <a class="nav-link" href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock mr-2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3"/>
                    <path d="M16 3v4"/>
                    <path d="M8 3v4"/>
                    <path d="M4 11h10"/>
                    <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                    <path d="M18 16.5v1.5l.5 .5"/>
                </svg>
                {{__('translations.events')}}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-notes">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"/>
                    <path d="M9 7l6 0"/>
                    <path d="M9 11l6 0"/>
                    <path d="M9 15l4 0"/>
                </svg>
                {{__('translations.contracts')}}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('packages.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-packages">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"/>
                    <path d="M2 13.5v5.5l5 3"/>
                    <path d="M7 16.545l5 -3.03"/>
                    <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"/>
                    <path d="M12 19l5 3"/>
                    <path d="M17 16.5l5 -3"/>
                    <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5"/>
                    <path d="M7 5.03v5.455"/>
                    <path d="M12 8l5 -3"/>
                </svg>
                {{__('translations.packages')}}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path
                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"/>
                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
                </svg>
                {{__('translations.settings')}}
            </a>
        </li>
    </ul>
</nav>


