<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='User Profile'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <form method='POST' action='{{ route('user-profile.update') }}' enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row gx-4 mb-2">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative mt-2 mx-3">
                                <!-- Avatar Image -->
                                <div class="d-flex justify-content-center">
                                    <img id="selectedAvatar"
                                        src="{{ auth()->user()->image ? Storage::url(auth()->user()->image) : asset('assets/img/avatar.png') }}"
                                        class="rounded-circle shadow-sm" alt="profile_image" onclick="openFileInput()"
                                        style="width:75px; height:75px; object-fit: cover; cursor:pointer;" />
                                    <!-- Edit Icon -->
                                    <div class="position-absolute bottom-0 end-0">
                                        <i class="fas fa-pencil-alt fa-sm text-dark"
                                            style="margin-right:-10px; cursor: pointer;" onclick="openFileInput()"></i>
                                    </div>
                                </div>
                                <!-- Input file field -->
                                <input name="image" type="file" class="form-control d-none" id="customFile2"
                                    onchange="displaySelectedImage(event, 'selectedAvatar')" />
                                @error('image')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
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

                    </div>
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-3">Profile Information</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            @if (session('success'))
                                <div class="row">
                                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ session('success') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="row">
                                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ session('error') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif


                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control border border-2 p-2"
                                        value='{{ old('email', auth()->user()->email) }}'>
                                    @error('email')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control border border-2 p-2"
                                        value='{{ old('name', auth()->user()->name) }}'>
                                    @error('name')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control border border-2 p-2"
                                        value='{{ old('phone', auth()->user()->phone) }}'>
                                    @error('phone')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Occupation</label>
                                    <input type="text" name="occupation" class="form-control border border-2 p-2"
                                        value='{{ old('occupation', auth()->user()->occupation) }}'>
                                    @error('occupation')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                                @if (auth()->user()->role_id !== 1)
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Freelancer or Client</label>
                                        <select name="role_id" class="form-select border border-2 p-2">
                                            <option value="2"
                                                {{ old('role_id', auth()->user()->role_id) == 2 ? 'selected' : '' }}>
                                                Freelancer</option>
                                            <option value="3"
                                                {{ old('role_id', auth()->user()->role_id) == 3 ? 'selected' : '' }}>
                                                Client
                                            </option>
                                        </select>
                                        @error('role_id')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif

                                <div class="mb-3 col-md-12">
                                    <label for="floatingTextarea2">Info</label>
                                    <textarea class="form-control border border-2 p-2" placeholder=" Say something about yourself" id="floatingTextarea2"
                                        name="info" rows="4" cols="50">{{ old('info', auth()->user()->info) }}</textarea>
                                    @error('info')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn bg-gradient-dark">Submit</button>

                        </div>
                    </div>
                </form>
            </div>

        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>

</x-layout>
<script>
    function displaySelectedImage(event, elementId) {
        const selectedImage = document.getElementById(elementId);
        const fileInput = event.target;

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                selectedImage.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    function openFileInput() {
        document.getElementById('customFile2').click();
    }
</script>
