<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="billing"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Billing"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12 mb-lg-0 mb-4">
                            <div class="card mt-4-">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-12 d-flex align-items-center">
                                            <h6 class="">Производить оплату</h6>
                                        </div>
                                        <ul class="nav nav-tabs px-3" id="payTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active text-info text-bold" id="payme-tab"
                                                    data-bs-toggle="tab" data-bs-target="#paypayme" type="button"
                                                    role="tab" aria-controls="paypayme" aria-selected="true">
                                                    <img style="width: 100px"
                                                        src="{{ asset('assets') }}/img/logos/payme2.png" alt="logo">
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link text-info text-bold" id="payclick-tab"
                                                    data-bs-toggle="tab" data-bs-target="#payclick" type="button"
                                                    role="tab" aria-controls="payclick" aria-selected="false">
                                                    <img width="80px" src="{{ asset('assets') }}/img/logos/click2.png"
                                                        alt="logo">
                                                </button>
                                            </li>

                                        </ul>
                                        <div class="tab-content" id="payTabContent">
                                            <div class="tab-pane fade show active" id="paypayme" role="tabpanel"
                                                aria-labelledby="paypayme-tab">
                                                <div class="card-body pt-4 p-3">

                                                    <form id="paymentForm" method="POST"
                                                        action="{{ config('payme.payme_url') }}" target="_blank">

                                                        <div class="input-group input-group-outline">
                                                            {{-- merchat id --}}
                                                            <input type="hidden" name="merchant"
                                                                value="{{ config('payme.merchant_id') }}" />
                                                            {{-- amount of value --}}
                                                            <label class="form-label">Min 10 000 sum ,Max 10 000 000
                                                                sum</label>
                                                            <input id="amountDisplay"
                                                                class="form-control border-rounded rounded"
                                                                min="10000" max="10000000" required
                                                                name="amountDisplay" type="number" />
                                                            <span id="clickAmountWarning"
                                                                style="color: red; display: none;">Please
                                                                enter a valid amount.</span>
                                                            {{-- new field for sending actuall money value in tyin --}}
                                                            <input id="amountInput" name="amount" hidden type="number"
                                                                class="form-controll" />
                                                            {{--  --}}
                                                            <input type="hidden" name="account[id]"
                                                                value="{{ auth()->user()->id }}" />
                                                            <input type="hidden" name="description"
                                                                value="{{ auth()->user()->name }}" />
                                                        </div>
                                                        <button type="submit" class="btn btn-info col-md-4 my-2">
                                                            Оплатить</button>

                                                    </form>
                                                </div>
                                            </div>


                                            {{-- click tab --}}
                                            <div class="tab-pane fade" id="payclick" role="tabpanel"
                                                aria-labelledby="payclick-tab">
                                                <div class="card-body pt-4 p-3">
                                                    <form id="click_form" action="{{ config('click.click_url') }}"
                                                        method="get" target="_blank">
                                                        <div class="input-group input-group-outline">
                                                            <input placeholder="Min 10 000 sum ,Max 10 000 000 sum"
                                                                style="border: 1px solid #d2d6da;"
                                                                class="form-control border-rounded rounded"
                                                                id="amountClick" name="amount" />
                                                            <input type="hidden" name="merchant_id"
                                                                value="{{ config('click.merchant_id') }}" />
                                                            <input type="hidden" name="merchant_user_id"
                                                                value="{{ config('click.login') }}" />
                                                            <input type="hidden" name="service_id"
                                                                value="{{ config('click.service_id') }}" />
                                                            <input type="hidden" name="transaction_param"
                                                                value="{{ auth()->user()->id }}" />
                                                        </div>
                                                        <button id="clickButton" type="submit"
                                                            class="btn btn-success col-md-4 my-2">
                                                            Оплатить</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 mt-4">
                    <div class="card">
                        <div class="card-header pb-0 px-3" style="border-radius: 0.75rem">
                            <h6 class="mb-0">Платежная информация</h6>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active text-info text-bold" id="payme-tab"
                                        data-bs-toggle="tab" data-bs-target="#payme" type="button" role="tab"
                                        aria-controls="payme" aria-selected="true">Payme</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link text-info text-bold" id="click-tab" data-bs-toggle="tab"
                                        data-bs-target="#click" type="button" role="tab" aria-controls="click"
                                        aria-selected="false">Click</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="payme" role="tabpanel"
                                    aria-labelledby="payme-tab">
                                    <div class="card-body pt-4 p-3">
                                        @if (count($payme_transactions) > 0)
                                            <ul class="list-group">
                                                @foreach ($payme_transactions as $item)
                                                    <li
                                                        class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-3 text-sm">
                                                                {{ date('d-M-Y, H:i A', strtotime($item->created_at)) }}
                                                            </h6>
                                                            <span class="mb-2 text-xs">Status:
                                                                <span class="text-dark ms-sm-2 font-weight-bold">
                                                                    @php
                                                                        $status = 'Unknown Status';

                                                                        switch ($item->state) {
                                                                            case \App\Enums\PaymeState::Pending:
                                                                                $status = 'Pending';
                                                                                break;
                                                                            case \App\Enums\PaymeState::Done:
                                                                                $status = 'Done';
                                                                                break;
                                                                            case \App\Enums\PaymeState::Cancelled:
                                                                                $status = 'Cancelled';
                                                                                break;
                                                                            case \App\Enums\PaymeState::Cancelled_After_Success:
                                                                                $status = 'Cancelled After Success';
                                                                                break;
                                                                        }
                                                                    @endphp

                                                                    {{ $status }}
                                                                </span>
                                                            </span>
                                                            <span class="text-xs">Amount: <span
                                                                    class="text-dark ms-sm-2 font-weight-bold">{{ $item->amount }}</span></span>
                                                        </div>

                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="p-2 pt-3 text-danger text-bold">Платежи не найдены</p>
                                        @endif
                                    </div>
                                </div>


                                {{-- click tab --}}
                                <div class="tab-pane fade" id="click" role="tabpanel"
                                    aria-labelledby="click-tab">
                                    <div class="card-body pt-4 p-3">
                                        @if (count($click_transactions) > 0)
                                            <ul class="list-group">
                                                @foreach ($click_transactions as $item)
                                                    <li
                                                        class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-3 text-sm">
                                                                {{ date('d-M-Y, H:i A', strtotime($item->created_at)) }}
                                                            </h6>
                                                            <span class="mb-2 text-xs">Status:
                                                                <span class="text-dark ms-sm-2 font-weight-bold">
                                                                    @php
                                                                        $status = 'Unknown Status';

                                                                        switch ($item->state) {
                                                                            case \App\Enums\PaymeState::Pending:
                                                                                $status = 'Pending';
                                                                                break;
                                                                            case \App\Enums\PaymeState::Done:
                                                                                $status = 'Done';
                                                                                break;
                                                                            case \App\Enums\PaymeState::Cancelled:
                                                                                $status = 'Cancelled';
                                                                                break;
                                                                            case \App\Enums\PaymeState::Cancelled_After_Success:
                                                                                $status = 'Cancelled After Success';
                                                                                break;
                                                                        }
                                                                    @endphp

                                                                    {{ $status }}
                                                                </span>
                                                            </span>
                                                            <span class="text-xs">Amount: <span
                                                                    class="text-dark ms-sm-2 font-weight-bold">{{ $item->amount }}</span></span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="p-2 pt-3 text-danger text-bold">Платежи не найдены</p>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-4">
                    <div class="card h-100 mb-4">
                        <div class="card-header pb-0 px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Ваша транзакция</h6>
                                </div>
                                <div
                                    class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">

                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4 p-3">
                            @if (count($transactions) > 0)

                                <ul class="list-group">
                                    @foreach ($transactions as $transaction)
                                        <li
                                            class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <button
                                                    class="btn btn-icon-only btn-rounded mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center
                                                     {{ $transaction->transaction_type === 'deduction'
                                                         ? 'btn-outline-danger'
                                                         : ($transaction->transaction_type === 'transfer_to_back'
                                                             ? 'btn-outline-info'
                                                             : ($transaction->transaction_type === 'transfer_to_seller'
                                                                 ? 'btn-outline-success'
                                                                 : 'btn-outline-warning')) }}"><i
                                                        class="material-icons text-lg">expand_more</i></button>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">
                                                        {{ $transaction->order->post->title }}</h6>
                                                    <span class="text-xs">
                                                        {{ date('d-M-Y, H:i A', strtotime($transaction->created_at)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex align-items-center text-gradient text-sm font-weight-bold
                                                {{ $transaction->transaction_type === 'deduction'
                                                    ? 'text-danger'
                                                    : ($transaction->transaction_type === 'transfer_to_back'
                                                        ? 'text-info'
                                                        : ($transaction->transaction_type === 'transfer_to_seller'
                                                            ? 'text-success'
                                                            : 'text-warning')) }}">
                                                {{ number_format($transaction->amount, 2) }} UZS
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            @else
                                <p class="p-2 pt-5 text-danger text-bold">Транзакции не найдены</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
<script>
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        var amountDisplay = document.getElementById('amountDisplay').value;
        var amountCents = parseInt(amountDisplay) * 100;
        document.getElementById('amountInput').value = amountCents;
    });
</script>
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
