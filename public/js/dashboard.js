
console.log('dashboard.js loaded');
$(document).ready(function() {
  $('.dropdown').on('click', function() {
    let dropdown =$(`#dropdown-${this.id}`);
    dropdown.toggleClass('hidden');
  })  

  $('#timeplan').click(function(){
    $('#timeplan-upload').click();
    $('#timeplan-upload').change(function(){
      let data= new FormData();
      data.append('file', $('#timeplan-upload')[0].files[0]);
      $('label[for="timeplan-upload"]').text(this.files[0].name);
      $.ajax({
        url: 'api/timeplan/draft/upload',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
      }).done(function(data){
        console.log(data);
      });
    });
  });
});