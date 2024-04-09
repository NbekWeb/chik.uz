<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="posts"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Posts"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @if (count($posts) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Posts table</h6>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center justify-content-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Image</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Title</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Price</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Status</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Category</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Description
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posts as $post)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2">
                                                            <div>
                                                                @php
                                                                    $firstPostImage = $post->images->first();
                                                                @endphp
                                                                @if ($firstPostImage)
                                                                    <img src="{{ asset('public/storage') . '/' . $firstPostImage->path }}"
                                                                        alt="{{ $firstPostImage->title }}"
                                                                        width="60px">
                                                                @endif
                                                            </div>
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
                                                        <p class="text-sm font-weight-bold mb-0">{{ $post->price }}
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
                                                    <td class="text-center">
                                                        <span
                                                            class="text-xs font-weight-bold">{{ $post->category->name }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-xs font-weight-bold">
                                                            {{ \Illuminate\Support\Str::limit($post->body, 10) }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="{{ route('post.id', ['id' => $post->id]) }}">
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
                        {{ $posts->links() }}
                    </div>
                </div>
            @endif
            Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} posts.
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
