@extends('layouts.appMaster')

@section('title', 'Make a Donation')

<div style="background-color: #1f2936; min-height: 137px;"></div>


<div class="position-relative mb-0 text-center">
  <img src="{{ asset('images/donation-bg.jpg') }}" alt="Make a Donation" class="img-fluid rounded shadow w-100" style="object-fit: cover; max-height: 400px;">
 
</div>

<style>
  

  select.form-control option {
    background-color: #545c6a;  /* dark background */
    color: white;               /* white text */
  }

  textarea.form-control {
    background-color: #545c6a; /* Bootstrap's secondary */
    color: white;
    border: 0;
  }

</style>



@section('content')

<div class="container-fluid text-white py-5 px-4 rounded-0 shadow-lg" style="background-color: #1f2936;">

  <div class="container">
    <h2>Make a Donation</h2>

    <form id="donationForm" method="POST" action="{{ route('donations.store') }}">
      @csrf

      {{-- Guest Info --}}
      @guest
        <div class="mb-3">
          <label for="guest_name">Name</label>
          <input type="text" class="form-control text-white border-0" style="background-color: #545c6a;" name="guest_name" id="guest_name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="guest_email">Email</label>
          <input type="email" class="form-control text-white border-0" style="background-color: #545c6a;" name="guest_email" id="guest_email" class="form-control" required>
        </div>
      @endguest

      {{-- Donation Amount --}}
      <div class="mb-3">
        <div class="row">
          <div class="col-md-8 mb-2 mb-md-0">
            <label for="amount">Donation Amount</label>
            <input type="number" class="form-control text-white border-0" style="background-color: #545c6a;" step="0.01" name="amount" id="amount" required>
          </div>
          <div class="col-md-4">
            <label for="currency">Currency</label>
            <select name="currency" id="currency" class="form-control text-white border-0" style="background-color: #545c6a;" required>
              <option value="">Select currency</option>
              <option value="USD">USD</option>
              <option value="EUR">EUR</option>
              <option value="ILS">ILS</option>
              <option value="GBP">GBP</option>
              <option value="SAR">SAR</option>
              <option value="AED">AED</option>
              <option value="KWD">KWD</option>
            </select>
          </div>
        </div>
      </div>
      

      {{-- Payment Method --}}
      <div class="mb-3">
        <label for="payment_method">Payment Method</label>
        <select name="payment_method" id="payment_method" class="form-control text-white border-0" style="background-color: #545c6a;" required>
          <option value="">Select a method</option>
          <option value="paypal">PayPal</option>
          <option value="credit_card">Credit Card</option>
          <option value="bank_transfer">Bank Transfer</option>
          <option value="apple_pay">Apple Pay</option>
          <option value="google_pay">Google Pay</option>
        </select>
      </div>

      {{-- Dynamic Payment Details --}}
      <div id="paypalFields" class="payment-section d-none">
        <p style="color:white;">You'll be redirected to PayPal after submitting the form.</p>
      </div>

      <div id="creditCardFields" class="payment-section d-none">
        <div class="mb-3">
          <label for="card_holder">Card Holder Name</label>
          <input type="text" class="form-control text-white border-0" style="background-color: #545c6a;" name="card_holder" class="form-control">
        </div>
        <div class="mb-3">
          <label for="card_number">Card Number</label>
          <input type="text" class="form-control text-white border-0" style="background-color: #545c6a;" name="card_number" class="form-control">
        </div>
        <div class="mb-3">
          <label for="card_expiry">Expiry Date</label>
          <input type="month" class="form-control text-white border-0" style="background-color: #545c6a;" name="card_expiry" class="form-control">
        </div>
        <div class="mb-3">
          <label for="card_cvv">CVV</label>
          <input type="text" class="form-control text-white border-0" style="background-color: #545c6a;" name="card_cvv" class="form-control">
        </div>
      </div>

      <div id="bankTransferFields" class="payment-section d-none">
        <p>Please transfer your donation to the following bank account:</p>
        <ul>
          <li>Bank Name: Takaful Bank</li>
          <li>Account Number: 123456789</li>
          <li>IBAN: TK00012345678900</li>
          <li>SWIFT: TKFGBH01</li>
        </ul>
        <div class="mb-3">
          <label for="payment_reference">Bank Reference Number</label>
          <input type="text" class="form-control text-white border-0" style="background-color: #545c6a;" name="payment_reference" class="form-control">
        </div>
      </div>

      <div id="applePayFields" class="payment-section d-none">
        <p style="color:white;">You'll be redirected to Apple Pay after submitting the form.</p>
      </div>
      
      <div id="googlePayFields" class="payment-section d-none">
        <p style="color:white;">You'll be redirected to Google Pay after submitting the form.</p>
      </div>
      

      <div class="mb-3">
        <label for="notes">Notes (optional)</label>
        <textarea name="notes" class="form-control text-white border-0" style="background-color: #545c6a;"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Donate Now</button>
    </form>
  </div>
  
</div>




  <script>
    const paymentMethod = document.getElementById('payment_method');
    const sections = document.querySelectorAll('.payment-section');

    paymentMethod.addEventListener('change', function () {
      sections.forEach(section => section.classList.add('d-none'));

      const selected = this.value;
      if (selected === 'paypal') document.getElementById('paypalFields').classList.remove('d-none');
      if (selected === 'credit_card') document.getElementById('creditCardFields').classList.remove('d-none');
      if (selected === 'bank_transfer') document.getElementById('bankTransferFields').classList.remove('d-none');
      if (selected === 'apple_pay') document.getElementById('applePayFields').classList.remove('d-none');
      if (selected === 'google_pay') document.getElementById('googlePayFields').classList.remove('d-none');
    });

    document.getElementById('donationForm').addEventListener('submit', function (e) {
      let valid = true;

      // Clear previous errors
      document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

      function setInvalid(field, message) {
        field.classList.add('is-invalid');
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        feedback.innerText = message;
        field.parentNode.appendChild(feedback);
        valid = false;
      }

      // Guest-only validation
      const guestName = document.getElementById('guest_name');
      const guestEmail = document.getElementById('guest_email');
      if (guestName && guestEmail) {
        if (!guestName.value.trim()) setInvalid(guestName, 'Name is required.');
        if (!guestEmail.value.trim()) {
          setInvalid(guestEmail, 'Email is required.');
        } else if (!/^\S+@\S+\.\S+$/.test(guestEmail.value)) {
          setInvalid(guestEmail, 'Invalid email format.');
        }
      }

      // Common fields
      const amount = document.getElementById('amount');
      if (!amount.value || parseFloat(amount.value) <= 0) setInvalid(amount, 'Enter a valid donation amount.');

      if (!paymentMethod.value) setInvalid(paymentMethod, 'Select a payment method.');

      // Payment-specific validation
      switch (paymentMethod.value) {
        case 'credit_card':
          const cardHolder = document.querySelector('[name="card_holder"]');
          const cardNumber = document.querySelector('[name="card_number"]');
          const cardExpiry = document.querySelector('[name="card_expiry"]');
          const cardCvv = document.querySelector('[name="card_cvv"]');
          if (!cardHolder.value.trim()) setInvalid(cardHolder, 'Card holder name is required.');
          if (!cardNumber.value.trim()) setInvalid(cardNumber, 'Card number is required.');
          if (!cardExpiry.value.trim()) setInvalid(cardExpiry, 'Expiry date is required.');
          if (!cardCvv.value.trim()) setInvalid(cardCvv, 'CVV is required.');
          break;

        case 'bank_transfer':
          const paymentRef = document.querySelector('[name="payment_reference"]');
          if (!paymentRef.value.trim()) setInvalid(paymentRef, 'Bank reference number is required.');
          break;
      }

      if (!valid) e.preventDefault();
    });
  </script>

@endsection
