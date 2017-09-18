/*$('#chgStatus').on('click',function() {
    var keys = $('#w0').yiiGridView('getSelectedRows'); // returns an array of pkeys, and #grid is your grid element id
    $.post({
       url: '/site/calculate-total', // your controller action
       dataType: 'json',
       data: {keylist: keys},
       success: function(data) {
          if (data.status === 'success') {
              alert('Total price is ' + data.total);
          }
       },
    });
    console.log(keys);
});*/