<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="orders"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Orders"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
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
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Date</th>
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
                                                                $orderImage = $order->post->images->first();
                                                            @endphp
                                                            @if ($orderImage)
                                                                <img src="{{ asset('public/storage') . '/' . $orderImage->path }}"
                                                                    alt="{{ $orderImage->title }}" width="60px">
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

                                                <td>
                                                    <span class="text-xs font-weight-bold">
                                                        {{ date('M-d-Y / H:m', strtotime($order->created_at)) }}
                                                    </span>
                                                </td>

                                                <td class="align-middle">
                                                    <a href="{{ URL::to('/order') . '/' . $order->id }}">
                                                        <button class="btn btn-link text-secondary mb-0">
                                                            <i class="fa fa-ellipsis-v text-xs"></i>
                                                        </button>
                                                    </a>
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
            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders.

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
