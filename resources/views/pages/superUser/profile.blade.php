<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Profile'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1441260038675-7329ab4cc264?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
                <span class="mask  bg-gradient-dark  opacity-3"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('assets') }}/img/bruce-mars.jpg" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $user->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{ $user->occupation }} / {{ strtoupper($user->role->name) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col-12 col-xl-8">
                            <div class="card card-plain h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-0">Profile Information</h6>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <p class="text-sm">
                                        {{ $user->info }}
                                    </p>
                                    <hr class="horizontal gray-light my-4">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong
                                                class="text-dark">Full Name:</strong> &nbsp; {{ $user->name }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">Mobile:</strong> &nbsp; {{ $user->phone }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">Email:</strong> &nbsp; {{ $user->email }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card card-plain h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Conversations</h6>
                                </div>
                                <div class="card-body p-3"style="filter: blur(1.5px);">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/kal-visuals-square.jpg"
                                                    alt="kal" class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Sophie B.</h6>
                                                <p class="mb-0 text-xs">Hi! I need more information..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/marie.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Anne Marie</h6>
                                                <p class="mb-0 text-xs">Awesome work, can you..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/ivana-square.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Ivanna</h6>
                                                <p class="mb-0 text-xs">About files I can..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>
                                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/team-4.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Peterson</h6>
                                                <p class="mb-0 text-xs">Have a great afternoon..</p>
                                            </div>
                                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"
                                                href="javascript:;">Reply</a>
                                        </li>

                                    </ul>
                                </div>
                                <div
                                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 2rem; color: red; font-weight:900; text-align:center;">
                                    Coming Soon
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @if (count($orders) > 0)

                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Orders table</h6>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center justify-content-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Project</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Budget</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Status</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Completion</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2">
                                                            <div>
                                                                @php
                                                                    $firstImage = $order->post->images->first();
                                                                @endphp
                                                                @if ($firstImage)
                                                                    <img src="{{ asset('public/storage') . '/' . $firstImage->path }}"
                                                                        alt="{{ $firstImage->title }}" width="60px">
                                                                @endif
                                                            </div>
                                                            <div class="my-auto">
                                                                <h6 class="mb-0 text-sm">{{ $order->post->title }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0">
                                                            {{ $order->post->price }}</p>
                                                    </td>
                                                    <td>

                                                        <span class="text-xs font-weight-bold">
                                                            @switch($order->status)
                                                                @case(201)
                                                                    Pending
                                                                @break

                                                                @case(202)
                                                                    Accepted
                                                                @break

                                                                @case(203)
                                                                    Rejected
                                                                @break

                                                                @case(204)
                                                                    Completed
                                                                @break

                                                                @default
                                                                    Unknown
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            @php
                                                                $progress = 0;
                                                                $statusColor = 'bg-gradient-danger'; // Default color for pending status
                                                                switch ($order->status) {
                                                                    case 202: // Accepted status
                                                                        $progress = 20;
                                                                        $statusColor = 'bg-gradient-warning';
                                                                        break;
                                                                    case 204: // Completed status
                                                                        $progress = 100;
                                                                        $statusColor = 'bg-gradient-success';
                                                                        break;
                                                                    // For Rejected status (203) and other statuses, defaults will be used
                                                                }
                                                            @endphp
                                                            <span
                                                                class="me-2 text-xs font-weight-bold">{{ $progress }}%</span>
                                                            <div>
                                                                <div class="progress">
                                                                    <div class="progress-bar {{ $statusColor }}"
                                                                        role="progressbar"
                                                                        aria-valuenow="{{ $progress }}"
                                                                        aria-valuemin="0" aria-valuemax="100"
                                                                        style="width: {{ $progress }}%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="align-middle">
                                                        <button class="btn btn-link text-secondary mb-0">
                                                            <i class="fa fa-ellipsis-v text-xs"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Posts table</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Project</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Budget</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Status</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Completion</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2">
                                                    <div>
                                                        <img src="{{ asset('assets') }}/img/small-logos/logo-asana.svg"
                                                            class="avatar avatar-sm rounded-circle me-2"
                                                            alt="spotify">
                                                    </div>
                                                    <div class="my-auto">
                                                        <h6 class="mb-0 text-sm">Asana</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">$2,500</p>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold">Completed</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="me-2 text-xs font-weight-bold">100%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-success"
                                                                role="progressbar" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 100%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-link text-secondary mb-0">
                                                    <i class="fa fa-ellipsis-v text-xs"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>

</x-layout>
