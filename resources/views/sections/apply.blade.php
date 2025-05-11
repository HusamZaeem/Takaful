<section class="apply-now" id="apply">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="row">
            <div class="col-lg-12">
              <div class="item">
                <h3>Report a Loss</h3>
                <p>If your home was damaged or a loved one was martyred, help us reach you by submitting your case.</p>
                <div class="main-button-red">
                    @auth
                        <a href="{{ route('case.registration.form') }}">Register Now!</a>
                    @else
                        <a href="javascript:void(0);" onclick="alertLoginRequired()">Register Now!</a>
                    @endauth
                </div>                               
              </div>
            </div>
            <div class="col-lg-12">
              <div class="item">
                <h3>Make a Donation</h3>
                <p>Your donation provides urgent aid—food, shelter, and medical support—for families in crisis.</p>
                <div class="main-button-yellow">
                  <div><a href="{{ route('donations.create') }}">Donate Now!</a></div>
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="accordions is-first-expanded">
            <article class="accordion">
                <div class="accordion-head">
                    <span>Who Can Register a Case?</span>
                    <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                    </span>
                </div>
                <div class="accordion-body">
                    <div class="content">
                        <p>If your home in Gaza has been partially or completely destroyed, or if you’ve lost a family member due to the ongoing aggression, you are eligible to register a case. This includes direct victims and their immediate family members. All submissions are reviewed and verified to ensure aid reaches those truly in need.</p>
                    </div>
                </div>
            </article>
            <article class="accordion">
                <div class="accordion-head">
                    <span>Required Information for Case Submission</span>
                    <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                    </span>
                </div>
                <div class="accordion-body">
                    <div class="content">
                        <p>To register a case, you'll need to provide personal identification, a brief description of the damage or loss, and any supporting documents or photos if available. Accurate information helps speed up verification and aid delivery. Rest assured, all shared data is securely stored and used strictly for assistance purposes.</p>
                    </div>
                </div>
            </article>
            <article class="accordion">
                <div class="accordion-head">
                    <span>How Your Donation Helps</span>
                    <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                    </span>
                </div>
                <div class="accordion-body">
                    <div class="content">
                        <p>Each contribution is directly used to support families affected by the war in Gaza. Donations help provide emergency food parcels, medical aid, shelter, and psychological support. Even small donations can make a life-saving difference on the ground.</p>
                    </div>
                </div>
            </article>
            <article class="accordion last-accordion">
                <div class="accordion-head">
                    <span>Donation Transparency & Security</span>
                    <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                    </span>
                </div>
                <div class="accordion-body">
                    <div class="content">
                        <p>We ensure every donation is tracked and reported for transparency. Funds are distributed through verified local partners and organizations operating inside Gaza. Your payment details are securely encrypted, and you’ll receive confirmation once your donation is processed.</p>
                    </div>
                </div>
            </article>
        </div>
        </div>
      </div>
    </div>
  </section>