@php $isActive = Request::is(['provinces*', 'districts*', 'schools*']); @endphp
<li class="nav-item">
    <a class="nav-link menu-link{{$isActive ? ' collapsed' : '' }}"
       href="#provinceDistrictPage" data-bs-toggle="collapse"
       role="button" aria-expanded="false" aria-controls="provinceDistrictPage">
        <i class="mdi mdi-candy"></i> <span
            data-key="t-province-district">Province - District</span>
    </a>
    <div
        class="collapse menu-dropdown{{$isActive ? ' show' : '' }}"
        id="provinceDistrictPage">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('provinces.index') }}"
                   class="nav-link{{Request::is('provinces*') ? ' active' : '' }}"
                   data-key="t-provinces">Province
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('districts.index') }}"
                   class="nav-link{{Request::is('districts*') ? ' active' : '' }}"
                   data-key="t-districts">District
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('schools.index') }}"
                   class="nav-link{{Request::is('schools*') ? ' active' : '' }}"
                   data-key="t-schools">School
                </a>
            </li>
        </ul>
    </div>
</li>
