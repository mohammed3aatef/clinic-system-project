<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <nav class="navbar navbar-expand-lg main-navbar shadow-sm">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <div class="brand-icon">
                    <i class="bi bi-hospital"></i>
                </div>
                <span class="brand-text">{{ __('general.patient_system') }}</span>
            </a>

            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <i class="bi bi-list"></i>
            </button>

            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">

                @if (auth()->user()->role === 'doctor' || auth()->user()->role === 'secretary')
                    <ul class="navbar-nav {{ app()->getLocale() === 'ar' ? 'ms-auto' : 'me-auto' }} gap-lg-3 nav-links">

                        @if (auth()->user()->role === 'secretary')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('patients.index') ? 'active' : '' }}"
                                    href="{{ route('patients.index') }}">
                                    <i class="bi bi-people-fill"></i>
                                    <span>{{ __('general.patients') }}</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}"
                                    href="{{ route('appointments.index') }}">
                                    <i class="bi bi-calendar-check-fill"></i>
                                    <span>{{ __('general.appointments') }}</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role === 'doctor')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('prescriptions.index') ? 'active' : '' }}"
                                    href="{{ route('prescriptions.index') }}">
                                    <i class="bi bi-file-medical"></i>
                                    <span>{{ __('general.prescriptions') }}</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                @endif

                <ul
                    class="navbar-nav
                {{ app()->getLocale() === 'ar' ? 'me-auto' : 'ms-auto' }}
                align-items-lg-center gap-lg-3">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle lang-btn" href="#" role="button"
                            data-bs-toggle="dropdown">
                            🌍 {{ app()->getLocale() === 'ar' ? 'AR' : 'EN' }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow lang-menu mt-2">
                            <li>
                                <a class="dropdown-item" href="/lang/en">
                                    <span class="text-primary">EN</span> -- English
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="/lang/ar">
                                    <span class="text-primary">AR</span> -- العربية
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown ms-lg-0 ms-2">
                        <a class="nav-link dropdown-toggle profile-btn" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <span class="d-none d-lg-inline">
                                {{ Auth::user()->name ?? 'User' }}
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow profile-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="bi bi-person-gear me-2"></i> {{ __('general.profile') }}
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal"
                                    data-bs-target="#logoutModal">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('general.logout') }}
                                </button>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <button class="btn btn-outline-secondary btn-sm shadow-sm mode" id="themeToggle" title="Mode">
                            <i class="bi bi-moon"></i>
                        </button>
                    </li>

                </ul>

            </div>
        </div>
    </nav>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="bi bi-exclamation-triangle"></i> {{ __('general.confirm_logout') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <p class="fs-5 mb-0">
                        {{ __('general.are_you_sure_logout') }}
                    </p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> {{ __('general.cancel') }}
                    </button>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right"></i> {{ __('general.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div>
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/ae1dc0e488.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script>
        const html = document.documentElement;
        const toggleBtn = document.getElementById('themeToggle');
        const icon = toggleBtn.querySelector('i');

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            html.setAttribute('data-bs-theme', savedTheme);
            updateIcon(savedTheme);
        }

        toggleBtn.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            icon.className = theme === 'dark' ?
                'bi bi-sun' :
                'bi bi-moon';
        }
    </script>
</body>

</html>
