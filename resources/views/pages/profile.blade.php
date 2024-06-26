<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Profile'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ auth()->user()->image ? Storage::url(auth()->user()->image) : asset('assets/img/avatar.png') }}"
                                alt="profile_image" class="rounded-circle shadow-sm" alt="profile_image"
                                style="width:75px; height:75px; object-fit: cover; ">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{ auth()->user()->occupation }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class=" position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 " href="{{ route('user-profile') }}">
                                        <i class="material-icons text-lg position-relative">settings</i>
                                        <span class="ms-1">Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col-12 col-xl-4">
                            <div class="card card-plain h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Пользовательские настройки</h6>
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="text-uppercase text-body text-xs font-weight-bolder">Настройки
                                        электронной почты</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox"
                                                    id="flexSwitchCheckDefault" checked>
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                                    for="flexSwitchCheckDefault">Когда в заказе есть новости</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox"
                                                    id="flexSwitchCheckDefault1">
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                                    for="flexSwitchCheckDefault1">Когда будет новый заказ</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card card-plain h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-0">Информация о пользователе</h6>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <a href="{{ route('user-profile') }}">
                                                <i class="fas fa-user-edit text-secondary text-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Edit Profile"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <p class="text-sm">
                                        {{ auth()->user()->info }}
                                    </p>
                                    <hr class="horizontal gray-light my-4">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong
                                                class="text-dark">Баланс:</strong> &nbsp;
                                            {{ number_format(auth()->user()->cash, 2) . ' ' . 'sum' }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0 ps-0 text-sm"><strong
                                                class="text-dark">Имя пользователя:</strong> &nbsp;
                                            {{ auth()->user()->name }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">Номер телефона:</strong> &nbsp;
                                            {{ auth()->user()->phone }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">Электронная почта:</strong> &nbsp;
                                            {{ auth()->user()->email }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-xl-4">
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
                                        <li class="list-group-item border-0 d-flex align-items-center px-0">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets') }}/img/team-3.jpg" alt="kal"
                                                    class="border-radius-lg shadow">
                                            </div>
                                            <div class="d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Nick Daniel</h6>
                                                <p class="mb-0 text-xs">Hi! I need more information..</p>
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
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>

</x-layout>
