@props(['titlePage'])

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $titlePage }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $titlePage }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline" style="border-radius: 5px">
                    <label class="form-label">Введите здесь...</label>
                    <input type="text" class="form-control" id="search-input">
                    <div id="search-results" class="dropdown-menu dropdown-menu-end px-2 py-3">
                        <!-- Search results will be injected here -->
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                @csrf
            </form>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-user me-sm-1">
                        </i> <span class="d-sm-inline d-none">Выйти</span>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="{{ route('user-profile') }}" class="nav-link text-body p-0">
                        <i class="fa fa-cog cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                        @if ($notifications->isNotEmpty())
                            <span
                                class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-1 px-2">
                                <span class="small">{{ $notifications->count() }}</span>
                                <span class="visually-hidden">Непрочитанные уведомления</span>
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        @if ($notifications->isNotEmpty())
                            @foreach ($notifications as $notification)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="{{ $notification->url }}">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="{{ asset('assets') }}/img/avatar.png"
                                                    class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">Новое сообщение </span>от
                                                    {{ $notification->user->name }}
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="text-center">
                                <span class="font-weight-bold text-warning">Ничего нету!</span>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    $(document).ready(function() {
        $('#search-input').on('keyup', function() {
            var query = $(this).val();
            if (query.length > 2) {
                $.ajax({
                    url: '/admin/search',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        var resultsHTML = '';
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                resultsHTML +=
                                    '<li class="mb-2"><a class="dropdown-item border-radius-md" href="' +
                                    data[i].url +
                                    '"><div class="d-flex py-1"><div class="my-auto"><img src="' +
                                    data[i].image +
                                    '" class="avatar avatar-sm me-3"></div><div class="d-flex flex-column justify-content-center"><h6 class="text-sm font-weight-normal mb-1 search-result-title">' +
                                    data[i].name +
                                    '</h6><p class="text-xs text-secondary mb-0"><i class="fa fa-clock me-1"></i>' +
                                    data[i].created_at + '</p></div></div></a></li>';
                            }
                            $('#search-results').html(resultsHTML).show();
                        } else {
                            $('#search-results').html('').hide();
                        }
                    }
                });
            } else {
                $('#search-results').html('').hide();
            }
        });

        $(document).on('click', '#search-results a', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            $('#search-results').hide();
            window.location.href = url;
        });

        $(document).click(function(event) {
            if (!$(event.target).closest('#search-input, #search-results').length) {
                $('#search-results').hide();
            }
        });
    });
</script>
