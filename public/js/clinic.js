// window.semantic = {
//   handler: {

//   }
// };

var clinic = {
  callsCount: 0,
  setCallsCount: function(count) {
    if (count) {
      if (!this.callsCount) {
        if (location.pathname == '/clinic/calls') {
          location.reload();
        }
        else {
          $('#callsMenuItem').addClass('red');
          $('#callsMenuItemText').text(count).removeClass('hidden');
        }
      }
    }
  },
};

$(function() {
  $('.dropdown').dropdown({
    // transition: 'drop'
  });
  $.fn.api.settings.api.search = '/clinic/search/?query={value}';
  var $checkbox = $('body').not('.static').find('.ui.checkbox');
  $checkbox.checkbox();
  $('body').find('.ui.search')
  .search({
    apiSettings: {
      url: '/clinic/search?query={query}'
    },
    onSelect: function(result, response) {
      // console.log(result);
      // console.log(response);
      // $('.ui.search').search('hide results');
      window.location.href = '/clinic/clients/' + result.client_id;
      return false;
    },
    cache: false,
    error: {
      noResults: 'Клиенты не найдены',
      serverError: 'К сожалению возникла проблема при связи с сервером',
    }
  });

  $('.ui.sticky').sticky({
      context: '#clinic',
      pushing: true,
  });

  // $('#clinic').css('background-color', 'black');

  $('.rating').rating();

  $('.popup').popup();

  $('.sidebar').sidebar('setting', 'exclusive', false).sidebar('show');

  setInterval(function() {
    $.ajax({
      url: '/clinic/calls/countUncalled',
    })
    .done(function(data) {
      clinic.setCallsCount(data.count);
    });
  }, 1000);
});