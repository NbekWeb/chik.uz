<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="complaints"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Жалобы"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">complaints table</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Post</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Post status</th>
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
                                                Open Post</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($complaints->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">Жалоб нет.</td>
                                            </tr>
                                        @else
                                            @foreach ($complaints as $complaint)
                                                <tr class="{{ $complaint->status == 0 ? 'bg-warning' : '' }}">
                                                    <td>
                                                        <div class="d-flex px-2">
                                                            <div>
                                                                @php
                                                                    $complaintImage = $complaint->post->images->first();
                                                                @endphp
                                                                @if ($complaintImage)
                                                                    <img src="{{ asset('storage') . '/' . $complaintImage->path }}"
                                                                        alt="{{ $complaintImage->title }}"
                                                                        width="60px">
                                                                @endif
                                                            </div>
                                                            <div class="my-auto">
                                                                <h6 class="mb-0 text-sm">{{ $complaint->post->title }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-xs font-weight-bold">
                                                            @switch($complaint->post->is_active)
                                                                @case(0)
                                                                    Deactive
                                                                @break

                                                                @case(1)
                                                                    Active
                                                                @break
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-xs font-weight-bold">
                                                            @switch($complaint->status)
                                                                @case(0)
                                                                    Не прочитано
                                                                @break

                                                                @case(1)
                                                                    Прочитано
                                                                @break
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            {{ $complaint->comment }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <span class="text-xs font-weight-bold">
                                                            {{ date('M-d-Y / H:i', strtotime($complaint->created_at)) }}
                                                        </span>
                                                    </td>

                                                    <td class="align-middle text-center">
                                                        <a href="{{ URL::to('/blog') . '/' . $complaint->post->slug }}">
                                                            <button class="btn btn-link text-secondary mb-0">
                                                                <i class="fa fa-ellipsis-v text-xs"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        <button type="button"
                                                            class="btn btn-success btn-link update-status-btn"
                                                            data-complaint-id="{{ $complaint->id }}" data-status="1">
                                                            <i class="material-icons">lock_open</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-danger btn-link update-status-btn"
                                                            data-complaint-id="{{ $complaint->id }}" data-status="0">
                                                            <i class="material-icons">lock</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{ $complaints->links() }}
                </div>
            </div>
            Showing {{ $complaints->firstItem() }} to {{ $complaints->lastItem() }} of {{ $complaints->total() }}
            complaints.

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
<script type="text/javascript">
    $(document).ready(function() {
        $('.update-status-btn').on('click', function() {
            var self = $(this);
            var complaintId = self.data('complaint-id');
            var status = self.data('status');

            $.ajax({
                url: '/admin/complaint/' + complaintId,
                type: 'PUT',
                dataType: 'json',
                data: {
                    status: status,
                    _method: 'PUT',
                    _token: $('meta[name="csrf-token"]').attr('content')
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
