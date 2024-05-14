{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{ Request::is('banners*') ? 'active' : '' }}"--}}
{{--       href="{{ route('banners.index') }}">--}}
{{--        <i class="mdi mdi-lead-pencil"></i> <span data-key="t-banner">Banner</span>--}}
{{--    </a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{ Request::is('grades*') ? 'active' : '' }}"--}}
{{--       href="{{ route('grades.index') }}">--}}
{{--        <i class="mdi mdi-warehouse"></i> <span data-key="t-grade">Grades</span>--}}
{{--    </a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{ Request::is('subjects*') ? 'active' : '' }}"--}}
{{--       href="{{ route('subjects.index') }}">--}}
{{--        <i class="mdi mdi-lead-pencil"></i> <span data-key="t-subjects">Subjects</span>--}}
{{--    </a>--}}
{{--</li>--}}

{{--@php $isActive = Request::is(['schedules*', 'stage*']); @endphp--}}
{{--<li class="nav-item">--}}
{{--    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"--}}
{{--       href="#schedulePages" data-bs-toggle="collapse"--}}
{{--       role="button" aria-expanded="false" aria-controls="schedulePages">--}}
{{--        <i class="mdi mdi-candy"></i> <span--}}
{{--            data-key="t-sticker-topic-items">Lịch học</span>--}}
{{--    </a>--}}
{{--    <div--}}
{{--        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"--}}
{{--        id="schedulePages">--}}
{{--        <ul class="nav nav-sm flex-column">--}}
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('schedules.index') }}"--}}
{{--                   class="nav-link{{Request::is('schedules*') ? ' active' : '' }}"--}}
{{--                   data-key="t-schedules">Lịch học--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('stages.index') }}"--}}
{{--                   class="nav-link{{Request::is('stages*') ? ' active' : '' }}"--}}
{{--                   data-key="t-stages">Stages--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('time-slots.index') }}"--}}
{{--                   class="nav-link{{Request::is('stages*') ? ' active' : '' }}"--}}
{{--                   data-key="t-stages">Khung giờ học--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</li>--}}


@php $isActive = Request::is(['levels*', 'unit*', 'parts*']); @endphp
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
                <a href="{{ route('levels.index') }}"
                   class="nav-link{{Request::is('levels*') ? ' active' : '' }}"
                   data-key="t-course">Level
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('units.index') }}"
                   class="nav-link{{Request::is('units*') ? ' active' : '' }}"
                   data-key="t-unit">Unit
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('lessons.index') }}"--}}
{{--                   class="nav-link{{Request::is('lessons*') ? ' active' : '' }}"--}}
{{--                   data-key="t-lessons">Lesson--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a href="{{ route('parts.index') }}"
                   class="nav-link{{Request::is('parts*') ? ' active' : '' }}"
                   data-key="t-parts">Part
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('activities.index') }}"
                   class="nav-link{{Request::is('activities*') ? ' active' : '' }}"
                   data-key="t-parts">Activity
                </a>
            </li>
        </ul>
    </div>
</li>


@php $isActive = Request::is(['files*']); @endphp
<li class="nav-item">
    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"
       href="#mediaResourcePages" data-bs-toggle="collapse"
       role="button" aria-expanded="false" aria-controls="mediaResourcePages">
        <i class="mdi mdi-candy"></i> <span
            data-key="t-sticker-topic-items">File Management</span>
    </a>
    <div
        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"
        id="mediaResourcePages">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('files.index') }}"
                   class="nav-link{{Request::is('files*') ? ' active' : '' }}"
                   data-key="t-files">File
                </a>
            </li>
        </ul>
    </div>
</li>

@php $isActive = Request::is(['words*']); @endphp
<li class="nav-item">
    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"
       href="#mediaResourcePages" data-bs-toggle="collapse"
       role="button" aria-expanded="false" aria-controls="mediaResourcePages">
        <i class="mdi mdi-candy"></i> <span
            data-key="t-sticker-topic-items">Grammar Management</span>
    </a>
    <div
        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"
        id="mediaResourcePages">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('words.index') }}"
                   class="nav-link{{Request::is('words*') ? ' active' : '' }}"
                   data-key="t-files">Word
                </a>
            </li>
        </ul>
    </div>
</li>


@php $isActive = Request::is(['questions*', 'exercises*', 'exercise-types*', 'questionPlatforms*']); @endphp
<li class="nav-item">
    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"
       href="#exerciseQuestionsPage" data-bs-toggle="collapse"
       role="button" aria-expanded="false" aria-controls="exerciseQuestionsPage">
        <i class="mdi mdi-candy"></i> <span
            data-key="t-sticker-topic-items">Exercises & Questions</span>
    </a>
    <div
        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"
        id="exerciseQuestionsPage">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('exercises.index') }}"
                   class="nav-link{{Request::is('exercises*') ? ' active' : '' }}"
                   data-key="t-exercises">Exercise
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('exercise-types.index') }}"
                   class="nav-link{{Request::is('exercise-types*') ? ' active' : '' }}"
                   data-key="t-exercise-types">Exercise Type
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('questions.index') }}"
                   class="nav-link{{Request::is('questions*') ? ' active' : '' }}"
                   data-key="t-questions">Question
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('questionPlatforms.index') }}"
                   class="nav-link{{Request::is('questionPlatforms*') ? ' active' : '' }}"
                   data-key="t-question-platforms">Question Platforms
                </a>
            </li>
        </ul>
    </div>
</li>

{{--@include('adaptivelearning::layouts.sidebar')--}}

{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{ Request::is('labels*') ? 'active' : '' }}"--}}
{{--       href="{{ route('labels.index') }}">--}}
{{--        <i class="mdi mdi-warehouse"></i> <span data-key="t-labels">Labels</span>--}}
{{--    </a>--}}
{{--</li>--}}

{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{ Request::is('topics*') ? 'active' : '' }}"--}}
{{--       href="{{ route('topics.index') }}">--}}
{{--        <i class="mdi mdi-warehouse"></i> <span data-key="t-topics">Topics</span>--}}
{{--    </a>--}}
{{--</li>--}}

{{--@include('province::layouts.sidebar')--}}
{{--@include('contest::layouts.sidebar')--}}
@php $isActive = Request::is(['configs*']); @endphp
<li class="nav-item">
    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"
       href="#configPages" data-bs-toggle="collapse"
       role="button" aria-expanded="false" aria-controls="configPages">
        <i class="mdi mdi-cog-refresh-outline"></i> <span
            data-key="t-configs-items">Config</span>
    </a>
    <div
        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"
        id="configPages">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('configs.index') }}"
                   class="nav-link{{Request::is('configs*') ? ' active' : '' }}"
                   data-key="t-configs-list">Config
                </a>
            </li>
        </ul>
    </div>
</li>

