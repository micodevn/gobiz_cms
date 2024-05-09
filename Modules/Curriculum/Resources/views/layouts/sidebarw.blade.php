@php $isActive = Request::is(['courses*', 'lessons*', 'parts*']); @endphp
<li class="nav-item">
    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"
       href="#curriculumsPage" data-bs-toggle="collapse"
       role="button" aria-expanded="false" aria-controls="curriculumsPage">
        <i class="mdi mdi-candy"></i> <span
            data-key="t-curriculums">Curriculums</span>
    </a>
    <div
        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"
        id="curriculumsPage">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('courses.index') }}"
                   class="nav-link{{Request::is('courses*') ? ' active' : '' }}"
                   data-key="t-course">Course
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lessons.index') }}"
                   class="nav-link{{Request::is('lessons*') ? ' active' : '' }}"
                   data-key="t-lessons">Lesson
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('parts.index') }}"
                   class="nav-link{{Request::is('parts*') ? ' active' : '' }}"
                   data-key="t-parts">Part
                </a>
            </li>
        </ul>
    </div>
</li>
