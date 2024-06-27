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
                        {{-- <div class="col-xl-6 mb-xl-0 mb-4">
                            <div class="card bg-transparent shadow-xl">
                                <div class="overflow-hidden position-relative border-radius-xl">
                                    <img src="{{ asset('assets') }}/img/illustrations/pattern-tree.svg"
                                        class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100"
                                        alt="pattern-tree">
                                    <span class="mask bg-gradient-dark opacity-10"></span>
                                    <div class="card-body position-relative z-index-1 p-3">
                                        <i class="material-icons text-white p-2">wifi</i>
                                        <h5 class="text-white mt-4 mb-5 pb-2">
                                            4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852
                                        </h5>
                                        <div class="d-flex">
                                            <div class="d-flex">
                                                <div class="me-4">
                                                    <p class="text-white text-sm opacity-8 mb-0">Card Holder</p>
                                                    <h6 class="text-white mb-0">Jack Peterson</h6>
                                                </div>
                                                <div>
                                                    <p class="text-white text-sm opacity-8 mb-0">Expires</p>
                                                    <h6 class="text-white mb-0">11/22</h6>
                                                </div>
                                            </div>
                                            <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                                <img class="w-60 mt-2"
                                                    src="{{ asset('assets') }}/img/logos/mastercard.png" alt="logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div
                                                class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="material-icons opacity-10">account_balance</i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Income</h6>
                                            <span class="text-xs">Freelance account budget</span>
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">+$2000</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div
                                                class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="material-icons opacity-10">account_balance_wallet</i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Expenditure</h6>
                                            <span class="text-xs">Client account budget</span>
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">$455.00</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-12 mb-lg-0 mb-4">
                            <div class="card mt-4-">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-6 d-flex align-items-center">
                                            <h6 class="m-2">Производить оплату</h6>
                                        </div>
                                        {{-- ===================================================== --}}
                                        <form id="paymentForm" method="POST" action="{{ config('payme.payme_url') }}"
                                            target="_blank">

                                            <div class="input-group input-group-outline">
                                                {{-- merchat id --}}
                                                <input type="hidden" name="merchant"
                                                    value="{{ config('payme.merchant_id') }}" />
                                                {{-- amount of value --}}
                                                <label class="form-label">Min 10 000 sum ,Max 10 000 000 sum</label>
                                                <input id="amountDisplay" class="form-control border-rounded rounded"
                                                    min="10000" max="10000000" required name="amountDisplay"
                                                    type="number" />
                                                <span id="clickAmountWarning" style="color: red; display: none;">Please
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
                                            <button type="submit" class="btn btn-info col-4 my-2">
                                                Оплатить с помощью<b> Payme</b> </button>
                                            <img class="w-20 " src="{{ asset('assets') }}/img/logos/payme.png"
                                                alt="logo">
                                        </form>

                                        {{-- ============================================== --}}


                                        <form id="click_form" action="{{ config('click.click_url') }}" method="get"
                                            target="_blank">
                                            <input id="amountClick" hidden name="amount" />
                                            <input type="hidden" name="merchant_id"
                                                value="{{ config('click.merchant_id') }}" />
                                            <input type="hidden" name="merchant_user_id"
                                                value="{{ config('click.login') }}" />
                                            <input type="hidden" name="service_id"
                                                value="{{ config('click.service_id') }}" />
                                            <input type="hidden" name="transaction_param"
                                                value="{{ auth()->user()->id }}" />
                                            <button id="clickButton" type="submit" class="btn btn-success col-4 my-2">
                                                Оплатить с помощью<b> CLICK</b> </button>
                                            <img class="w-20 mx-3 px-4" src="{{ asset('assets') }}/img/logos/click.png"
                                                alt="logo">
                                        </form>
                                        {{-- ============================================= --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Invoices</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <button class="btn btn-outline-primary btn-sm mb-0">View All</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 pb-0">
                            <ul class="list-group">
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark font-weight-bold text-sm">March, 01, 2020</h6>
                                        <span class="text-xs">#MS-415646</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                        $180
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                            PDF</button>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-dark mb-1 font-weight-bold text-sm">February, 10, 2021</h6>
                                        <span class="text-xs">#RV-126749</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                        $250
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                            PDF</button>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-dark mb-1 font-weight-bold text-sm">April, 05, 2020</h6>
                                        <span class="text-xs">#FB-212562</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                        $560
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                            PDF</button>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-dark mb-1 font-weight-bold text-sm">June, 25, 2019</h6>
                                        <span class="text-xs">#QW-103578</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                        $120
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                            PDF</button>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-dark mb-1 font-weight-bold text-sm">March, 01, 2019</h6>
                                        <span class="text-xs">#AR-803481</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                        $300
                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                            PDF</button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-7 mt-4">
                    <div class="card">
                        <div class="card-header pb-0 px-3" style="border-radius: 0.75rem" >
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
                                                        {{-- <div class="ms-auto text-end">
                                                            <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                                href="javascript:;"><i
                                                                    class="material-icons text-sm me-2">delete</i>Delete</a>
                                                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                                                    class="material-icons text-sm me-2">edit</i>Edit</a>
                                                        </div> --}}
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
                                                        {{-- <div class="ms-auto text-end">
                                                            <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                                href="javascript:;"><i
                                                                    class="material-icons text-sm me-2">delete</i>Delete</a>
                                                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                                                    class="material-icons text-sm me-2">edit</i>Edit</a>
                                                        </div> --}}
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
                                    {{-- <i class="material-icons me-2 text-lg">date_range</i> --}}
                                    {{-- <small>23 - 30 March 2020</small> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4 p-3">
                            @if (count($transactions) > 0)
                                {{-- <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6> --}}
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
                                            {{-- <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="material-icons text-lg position-relative me-1">picture_as_pdf</i>
                                        PDF</button> --}}
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

    // Click button click event
    document.getElementById('clickButton').addEventListener('click', function(event) {
        var paymeAmountInput = document.getElementById('amountDisplay');
        var paymeAmount = paymeAmountInput.value.trim();
        var clickForm = document.getElementById('clickForm');
        var clickAmountInput = document.getElementById('amountClick');

        if (paymeAmount < 10000) {
            paymeAmountInput.setCustomValidity(
                'Please enter an amount in the form.');
            paymeAmountInput.reportValidity();
            event.preventDefault();
        }
        if (paymeAmount > 10000000) {
            paymeAmountInput.setCustomValidity(
                'Please enter valid amount in the form.');
            paymeAmountInput.reportValidity();
            event.preventDefault();
        } else {
            paymeAmountInput.setCustomValidity('');
            clickAmountInput.value = paymeAmount;
            clickForm.submit();
        }
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
