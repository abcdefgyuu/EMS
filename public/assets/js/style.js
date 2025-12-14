$(document).ready(function () {
  $('.menu-bar').click(function () {
    $(this).toggleClass('active');
    $('.sidebar').toggleClass('active');
  });


$(window).on('load', function () {
  const toast = $('.toast-success, .dup-att');

  if (toast.length) {
    toast.fadeIn(300); // optional: fade in smoothly
    setTimeout(() => {
      toast.fadeOut(500, function () {
        $(this).remove();
      });
    }, 3000); // show for 3 seconds
  }
});
});