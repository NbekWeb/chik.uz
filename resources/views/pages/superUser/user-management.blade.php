<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                PHOTO</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NAME</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                EMAIL</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ROLE</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Budget</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                CREATION DATE
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                status
                                            </th>

                                            {{-- <th class="text-secondary opacity-7">editstatus</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr data-id="{{ $user->id }}">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="mb-0 text-sm">{{ $users->firstItem() + $key }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset('assets') }}/img/team-2.jpg"
                                                                class="avatar avatar-sm me-3 border-radius-lg"
                                                                alt="user1">
                                                        </div>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $user->name }}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs text-secondary mb-0">{{ $user->email }}
                                                    </p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $user->role->name }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $user->cash . ' sum' }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ date('d-m-Y', strtotime($user->created_at)) }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a class="button btn btn-success btn-link update-status-btn"
                                                        href="{{ route('user.id', ['id' => $user->id]) }}">
                                                        <i class="material-icons">visibility</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    @if ($user->status == 1)
                                                        <button type="button"
                                                            class="btn btn-success btn-link update-status-btn"
                                                            data-user-id="{{ $user->id }}" data-status="0">
                                                            <i class="material-icons">lock_open</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-danger btn-link update-status-btn"
                                                            data-user-id="{{ $user->id }}" data-status="1">
                                                            <i class="material-icons">lock</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{ $users->links() }}
                </div>
            </div>
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users.
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
            var userId = self.data('user-id');
            var status = self.data('status');

            $.ajax({
                url: '/admin/user-edit/' + userId,
                type: 'PUT',
                dataType: 'json',
                data: {
                    status: status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.message === '200') {
                        // Update the data-status attribute
                        var newStatus = (status === 1) ? 0 : 1;
                        self.data('status', newStatus);

                        // Update the button appearance based on the new status
                        if (newStatus === 1) {
                            self.removeClass('btn-success').addClass('btn-danger');
                            self.find('.material-icons').text('lock');
                        } else {
                            self.removeClass('btn-danger').addClass('btn-success');
                            self.find('.material-icons').text('lock_open');
                        }
                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });
        });
    });
</script>
