<h1>Welcome, {{ $admin->first_name }} ({{ $admin->role->type }})</h1>

@if($canViewCases)
    <section>
        <h2>Cases Section</h2>
        <!-- Cases content here -->
    </section>
@endif

@if($canViewDonations)
    <section>
        <h2>Donations Section</h2>
        <!-- Donations content here -->
    </section>
@endif

<form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
