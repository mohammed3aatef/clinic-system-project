@php
    $types = [
        'success' => ['icon' => 'bi-check-circle-fill', 'class' => 'alert-success'],
        'danger' => ['icon' => 'bi-x-circle-fill', 'class' => 'alert-danger'],
        'warning' => ['icon' => 'bi-exclamation-triangle-fill', 'class' => 'alert-warning'],
        'info' => ['icon' => 'bi-info-circle-fill', 'class' => 'alert-info'],
    ];
@endphp

@foreach ($types as $type => $data)
    @if (session($type))
        <div class="container-fluid float-start">
            <div class="row">
                <div class="col-4 d-flex justify-content-center">
                    <div id="alert-{{ $type }}"
                        class="alert {{ $data['class'] }} d-flex align-items-center text-center shadow-sm mt-4"
                        role="alert">
                        <i class="bi {{ $data['icon'] }} me-2"></i>
                        <div>{{ session($type) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('alert-{{ $type }}');
                if (alert) {
                    alert.classList.add('fade');
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, {{ $duration ?? 1000 }});
        </script>
    @endif
@endforeach
