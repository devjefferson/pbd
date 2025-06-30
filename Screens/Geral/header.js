$(document).ready(function () {
  // Manipulação de tamanho de fonte
  const maxFontSize = 12;
  const minFontSize = 8;

  function changeFontSize(action) {
      $('html, body').each(function () {
          let size = parseInt($(this).css('font-size'));

          if (action === 'aumentar' && size < maxFontSize) {
              $(this).css('font-size', size + 1);
          } else if (action === 'diminuir' && size > minFontSize) {
              $(this).css('font-size', size - 1);
          }
      });
  }

  $('#increase-font').click(function () {
      changeFontSize('aumentar');
  });

  $('#decrease-font').click(function () {
      changeFontSize('diminuir');
  });

  // Alternância de modo claro/escuro
  const iconDL = $('#mode-icon');
  const htmlElement = $('html');

  iconDL.on('click', function () {
      htmlElement.toggleClass("light");

      if (iconDL.hasClass('fa-moon')) {
          iconDL.removeClass('fa-moon').addClass('fa-sun');
      } else {
          iconDL.removeClass('fa-sun').addClass('fa-moon');
      }
  });

});