<!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <script src="{{ asset('js/isotope.min.js') }}"></script>
  <script src="{{ asset('js/owl-carousel.js') }}"></script>
  <script src="{{ asset('js/lightbox.js') }}"></script>
  <script src="{{ asset('js/tabs.js') }}"></script>
  <script src="{{ asset('js/video.js') }}"></script>
  <script src="{{ asset('js/slick-slider.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script>
      //according to loftblog tut
      $('.nav li:first').addClass('active');

      var showSection = function showSection(section, isAnimate) {
        var
        direction = section.replace(/#/, ''),
        reqSection = $('.section').filter('[data-section="' + direction + '"]'),
        reqSectionPos = reqSection.offset().top - 0;

        if (isAnimate) {
          $('body, html').animate({
            scrollTop: reqSectionPos },
          800);
        } else {
          $('body, html').scrollTop(reqSectionPos);
        }

      };

      var checkSection = function checkSection() {
        $('.section').each(function () {
          var
          $this = $(this),
          topEdge = $this.offset().top - 80,
          bottomEdge = topEdge + $this.height(),
          wScroll = $(window).scrollTop();
          if (topEdge < wScroll && bottomEdge > wScroll) {
            var
            currentId = $this.data('section'),
            reqLink = $('a').filter('[href*=\\#' + currentId + ']');
            reqLink.closest('li').addClass('active').
            siblings().removeClass('active');
          }
        });
      };

      $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
        e.preventDefault();
        showSection($(this).attr('href'), true);
      });

      $(window).scroll(function () {
        checkSection();
      });
  </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
      const menuToggle = document.getElementById("menuToggle");
      const mainNav = document.querySelector(".main-nav");
  
      menuToggle.addEventListener("click", () => {
        mainNav.classList.toggle("menu-open");
      });
    });
  </script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  
<!-- Bootstrap Select JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script>
  $(function() {
    $('.selectpicker').selectpicker();
  });
</script>

