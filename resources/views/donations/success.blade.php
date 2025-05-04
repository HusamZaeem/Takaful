@extends('layouts.appMaster')

@section('title', 'Donation Successful')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center bg-dark text-white">
    <div class="text-center px-3">
        <h3 class="text-white">Thank you for your donation!</h3>
        <p class="text-white">We appreciate your support.</p>
        <p class="text-white">
            You will be redirected to the 
            <a href="{{ route('home') }}" class="text-white text-decoration-underline">home page</a> 
            in <span id="countdown">5</span> seconds...
        </p>
    </div>
</div>

<script>
    let seconds = 5;
    const countdownEl = document.getElementById('countdown');

    const interval = setInterval(function () {
        seconds--;
        countdownEl.textContent = seconds;

        if (seconds <= 0) {
            clearInterval(interval);
            window.location.href = "{{ route('home') }}";
        }
    }, 1000);
</script>
@endsection
