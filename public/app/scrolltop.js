    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {  // Tampilkan tombol jika scroll lebih dari 100px
        $('#scrollToTopBtn').fadeIn();
      } else {
        $('#scrollToTopBtn').fadeOut();
      }
    });

    // Fungsi untuk scroll ke atas ketika tombol diklik
    $('#scrollToTopBtn').click(function() {
      $('html, body').animate({ scrollTop: 0 }, 'slow');  // Scroll perlahan ke atas
      return false;
    });