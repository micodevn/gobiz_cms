@php $isActive = Request::is(['contests*', 'exams*', 'rounds*']); @endphp
<li class="nav-item">
    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"
       href="#contestsPage" data-bs-toggle="collapse"
       role="button" aria-expanded="false" aria-controls="contestsPage">
        <i class="mdi mdi-candy"></i> <span
            data-key="t-contest-learning">Quản lý bài thi & ĐGNL</span>
    </a>
    <div
        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"
        id="contestsPage">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('contests.index') }}"
                   class="nav-link{{Request::is('contests.index') ? ' active' : '' }}"
                   data-key="t-contest"> Quản lý bài thi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('exams.index') }}"
                   class="nav-link{{Request::is('exams.index') ? ' active' : '' }}"
                   data-key="t-contest">Quản lý đề thi
                </a>
            </li>
        </ul>
    </div>
</li>
