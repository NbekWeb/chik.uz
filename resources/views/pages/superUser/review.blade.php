<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="reviews"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Reviews"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Reviews table</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Order</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Rate</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Status</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Comment</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Date</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Open Order</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($reviews->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">Нет отзывов.</td>
                                            </tr>
                                        @else
                                            @foreach ($reviews as $review)
                                                <tr class="{{ $review->status == 0 ? 'bg-warning' : '' }}">
                                                    <td>
                                                        <div class="d-flex px-2">
                                                            <div>
                                                                @php
                                                                    $reviewImage = $review->post->images->first();
                                                                @endphp
                                                                @if ($reviewImage)
                                                                    <img src="{{ asset('storage') . '/' . $reviewImage->path }}"
                                                                        alt="{{ $reviewImage->title }}" width="60px">
                                                                @endif
                                                            </div>
                                                            <div class="my-auto">
                                                                <h6 class="mb-0 text-sm">{{ $review->post->title }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-bold mb-0">
                                                            {{ number_format($review->star, 0) }}</p>
                                                    </td>
                                                    <td>

                                                        <span class="text-xs font-weight-bold">
                                                            @switch($review->status)
                                                                @case(0)
                                                                    Pending
                                                                @break

                                                                @case(1)
                                                                    Published
                                                                @break

                                                                @case(2)
                                                                    Rejected
                                                                @break
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            {{ $review->comment }}

                                                        </div>
                                                    </td>

                                                    <td>
                                                        <span class="text-xs font-weight-bold">
                                                            {{ date('M-d-Y / H:i', strtotime($review->created_at)) }}
                                                        </span>
                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="{{ URL::to('/order') . '/' . $review->id }}">
                                                            <button class="btn btn-link text-secondary mb-0">
                                                                <i class="fa fa-ellipsis-v text-xs"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        @if ($review->status == 0)
                                                            <button type="button"
                                                                class="btn btn-danger btn-link update-status-btn"
                                                                data-review-id="{{ $review->id }}" data-status="2">
                                                                <i class="material-icons">block</i>
                                                                <div class="ripple-container"></div>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-success btn-link update-status-btn"
                                                                data-review-id="{{ $review->id }}" data-status="1">
                                                                <i class="material-icons">published_with_changes</i>
                                                                <div class="ripple-container"></div>
                                                            </button>
                                                        @elseif ($review->status == 1)
                                                            <button type="button"
                                                                class="btn btn-danger btn-link update-status-btn"
                                                                data-review-id="{{ $review->id }}" data-status="2">
                                                                <i class="material-icons">block</i>
                                                                <div class="ripple-container"></div>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-success btn-link update-status-btn"
                                                                data-review-id="{{ $review->id }}" data-status="1">
                                                                <i class="material-icons">published_with_changes</i>
                                                                <div class="ripple-container"></div>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{ $reviews->links() }}
                </div>
            </div>
            Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews.

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
<script type="text/javascript">
    $(document).ready(function() {
        // When a button with class 'update-status-btn' is clicked
        $('.update-status-btn').on('click', function() {
            var self = $(this);
            var reviewId = self.data('review-id');
            var status = self.data('status');

            $.ajax({
                url: '/admin/review/' + reviewId,
                type: 'PUT',
                dataType: 'json',
                data: {
                    status: status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });
        });
    });
</script>
