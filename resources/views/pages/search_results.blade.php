<!-- resources/views/admin/search_results.blade.php -->
<div id="search-results">
    @if ($users->isNotEmpty())
        <h3>Users</h3>
        @foreach ($users as $user)
            <p>{{ $user->name }} ({{ $user->email }})</p>
        @endforeach
    @endif

    @if ($orders->isNotEmpty())
        <h3>Orders</h3>
        @foreach ($orders as $order)
            <p>Order by {{ $order->user->name }}: {{ $order->post->name }}</p>
        @endforeach
    @endif

    @if ($complaints->isNotEmpty())
        <h3>Complaints</h3>
        @foreach ($complaints as $complaint)
            <p>Complaint by {{ $complaint->user->name }}: {{ $complaint->post->name }}</p>
        @endforeach
    @endif

    @if ($categories->isNotEmpty())
        <h3>Categories</h3>
        @foreach ($categories as $category)
            <p>{{ $category->name }}</p>
        @endforeach
    @endif
</div>
