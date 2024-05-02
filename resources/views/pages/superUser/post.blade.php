<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="post"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{ $post->title }}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                        <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="" style="height: 100%; " class="img-fluid" id="modalImage" alt="Popup Image">
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Post ma'lumotlari</h6>
                            </div>
                        </div>
                        {{-- if else --}}
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Images</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Title</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Budget</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Status</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Category</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Date</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Content</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2">
                                                    @foreach ($post->images as $image)
                                                        <img src="{{ asset('storage') . '/' . $image->path }}"
                                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                                            data-image-url="{{ asset('storage') . '/' . $image->path }}"
                                                            class="img-thumbnail"
                                                            alt="{{ asset('storage') . '/' . $image->title }}"
                                                            width="60px" style="cursor: :pointer">
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2">
                                                    <div class="my-auto">
                                                        <h6 class="mb-0 text-sm">{{ $post->title }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ number_format($post->price, 2) }}
                                                </p>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold">

                                                    @php
                                                        switch ($post->is_active) {
                                                            case 1:
                                                                echo 'Active';
                                                                break;
                                                            case 0:
                                                                echo 'Not active';
                                                                break;
                                                        }
                                                    @endphp

                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span
                                                    class="text-xs font-weight-bold">{{ $post->category->name }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold">{{ date('M-d-Y / H:i', strtotime($post->created_at)) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button class="btn btn-link text-secondary mb-0"
                                                    data-bs-toggle="collapse" href="#postInfo">
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

            <div class="mb-4">
                <div class="collapse" id="postInfo">
                    <div class="card card-body">
                        {{ $post->body }}
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        @if (count($postOrders) > 0)
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Postga bo'lgan buyurtmalar</h6>
                                </div>
                            </div>
                        @else
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Postga buyurtma bo'lmagan</h6>
                                </div>
                            </div>
                        @endif

                        @if (count($postOrders) > 0)

                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center justify-content-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Client Name</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Date</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Status</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Completion</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    See</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($postOrders as $order)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2">
                                                            <div>
                                                                <img src="{{ $order->user->image ? Storage::url($order->user->image) : asset('assets/img/avatar.png') }}"
                                                                    class="border-radius-lg shadow-sm"
                                                                    alt="profile_image"
                                                                    style="width:55px; height:55px; object-fit: cover; "
                                                                    alt="{{ $order->user->image }}">
                                                            </div>
                                                            <div class="my-auto">
                                                                <h6 class="mb-0 text-sm">
                                                                   &nbsp; {{ $order->user->name }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-xs font-weight-bold">{{ date('M-d-Y / H:i', strtotime($order->created_at)) }}</span>
                                                    </td>
                                                    <td>

                                                        <span class="text-xs font-weight-bold">
                                                            @switch($order->status)
                                                                @case(200)
                                                                    Chatting
                                                                @break

                                                                @case(201)
                                                                    Pending
                                                                @break

                                                                @case(202)
                                                                    Accepted by freelancer
                                                                @break

                                                                @case(203)
                                                                    Orbitraj
                                                                @break

                                                                @case(204)
                                                                    Completed
                                                                @break

                                                                @case(205)
                                                                    Pending for completion
                                                                @break

                                                                @case(206)
                                                                    Cancelled
                                                                @break

                                                                @default
                                                                    Unknown
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            @php
                                                                $progress = 1;
                                                                $statusColor = 'bg-gradient-danger'; // Default color for pending status
                                                                switch ($order->status) {
                                                                    case 201: // Pending status
                                                                        $progress = 2;
                                                                        $statusColor = 'bg-gradient-warning';
                                                                        break;
                                                                    case 202: // Accepted status
                                                                        $progress = 20;
                                                                        $statusColor = 'bg-gradient-warning';
                                                                        break;
                                                                    case 203: // Orbitraj status
                                                                        $progress = 50;
                                                                        $statusColor = 'bg-gradient-danger';
                                                                        break;
                                                                    case 204: // Completed status
                                                                        $progress = 100;
                                                                        $statusColor = 'bg-gradient-success';
                                                                        break;
                                                                    case 205: // request status
                                                                        $progress = 80;
                                                                        $statusColor = 'bg-gradient-info';
                                                                        break;
                                                                    case 206: // rejected status
                                                                        $progress = 100;
                                                                        $statusColor = 'bg-gradient-danger';
                                                                        break;
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
                                                        <a href="{{ URL::to('/order') . '/' . $order->id }}">
                                                            <button class="btn btn-link text-secondary mb-0">
                                                                <i class="fa fa-share text-xs"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        @endif

                    </div>
                    {{ $postOrders->links() }}
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));

        $('#imageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var imageUrl = button.data('image-url');
            var modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
        });
    });
</script>
