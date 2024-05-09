@php $isActive = Request::is(['learningObjectives*', 'skillVerbs*', 'targetLanguages*']); @endphp
<li class="nav-item">
    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"
       href="#adaptiveLearningPage" data-bs-toggle="collapse"
       role="button" aria-expanded="false" aria-controls="adaptiveLearningPage">
        <i class="mdi mdi-candy"></i> <span
            data-key="t-adaptive-learning">Adaptive Learning</span>
    </a>
    <div
        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"
        id="adaptiveLearningPage">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('learningObjectives.index') }}"
                   class="nav-link{{Request::is('learningObjectives*') ? ' active' : '' }}"
                   data-key="t-learning-objectives">Learning Objectives
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('skillVerbs.index') }}"
                   class="nav-link{{Request::is('skillVerbs*') ? ' active' : '' }}"
                   data-key="t-skill-verbs">Skill Verbs
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('targetLanguages.index') }}"
                   class="nav-link{{Request::is('targetLanguages*') ? ' active' : '' }}"
                   data-key="t-skill-target-languages">Target Languages
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('conditionals.index') }}"
                   class="nav-link{{Request::is('conditionals*') ? ' active' : '' }}"
                   data-key="t-conditionals">Conditional
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('goals.index') }}"
                   class="nav-link{{Request::is('goals*') ? ' active' : '' }}"
                   data-key="t-goals">Goal
                </a>
            </li>
        </ul>
    </div>
</li>
