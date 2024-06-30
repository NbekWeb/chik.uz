<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="arbitraj"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Арбитраж"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Send Message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group input-group-outline my-3">
                                    <input disabled type="email" class="form-control" id="recipient-email">
                                    <input disabled type="email" class="form-control" id="recipient-email2">
                                    <input type="hidden" id="item-id">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select class="form-select px-2" id="order-status-select"
                                        aria-label="Default select example">
                                        <option selected disabled>Change order status</option>
                                        <option value="200">Chatting</option>
                                        <option value="201">Pending to start order</option>
                                        <option value="202">Preparing Order</option>
                                        <option value="206">Rejected</option>
                                        <option value="205">Completed Request</option>
                                        <option value="204">Completed</option>
                                        <option value="203">Arbitraj</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-dynamic">
                                    <textarea class="multisteps-form__textarea form-control" rows="5" id="message-body"
                                        placeholder="Say last word to both side and play your arbitraj role" spellcheck="false"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary send-message-btn">Send Message</button>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Таблица арбитражных запросов</h6>
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
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Client</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                Supplier</th>
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
                                        @if ($arbitraj->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">Жалоб нет.</td>
                                            </tr>
                                        @else
                                            @foreach ($arbitraj as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2">
                                                            <div>
                                                                @php
                                                                    $itemImage = $item->post->images->first();
                                                                @endphp
                                                                @if ($itemImage)
                                                                    <img src="{{ asset('storage') . '/' . $itemImage->path }}"
                                                                        alt="{{ $itemImage->title }}" width="60px">
                                                                @endif
                                                            </div>
                                                            <div class="my-auto">
                                                                <h6 class="mb-0 text-sm">{{ $item->post->title }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            {{ $item->user->name }}</div>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            {{ $item->post->user->name }}</div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-xs font-weight-bold">{{ date('M-d-Y / H:i', strtotime($item->updated_at)) }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ URL::to('/order') . '/' . $item->id }}">
                                                            <button class="btn btn-link text-secondary mb-0">
                                                                <i class="fa fa-ellipsis-v text-xs"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary open-modal-btn"
                                                            data-toggle="modal" data-target="#exampleModalCenter"
                                                            data-email="{{ $item->user->email }}"
                                                            data-item-id="{{ $item->id }}"
                                                            data-email2="{{ $item->post->user->email }}">
                                                            Modal
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
                    {{ $arbitraj->links() }}
                </div>
            </div>
            Showing {{ $arbitraj->firstItem() }} to {{ $arbitraj->lastItem() }} of {{ $arbitraj->total() }} arbitraj
            item.
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
<script type="text/javascript">
    $(document).ready(function() {
        // Populate modal with data
        $('.open-modal-btn').on('click', function() {
            var email = $(this).data('email');
            var email2 = $(this).data('email2');
            var itemId = $(this).data('item-id');
            $('#recipient-email').val(email);
            $('#recipient-email2').val(email2);
            $('#item-id').val(itemId); // Set item-id in hidden input
        });

        // Send message button functionality
        $('.send-message-btn').on('click', function() {
            var email = $('#recipient-email').val();
            var email2 = $('#recipient-email2').val();
            var status = $('#order-status-select').val();
            var message = $('#message-body').val();
            var itemId = $('#item-id').val();

            $.ajax({
                url: '/admin/arbitraj/' + itemId, // Use item-id in the URL
                type: 'POST',
                dataType: 'json',
                data: {
                    email: email,
                    email2: email2,
                    status: status,
                    message: message,
                    _method: 'PUT', // Use PUT method
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Message sent successfully!');
                    $('#exampleModalCenter').modal('hide');
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                    alert('An error occurred while sending the message.');
                }
            });
        });
    });
</script>
