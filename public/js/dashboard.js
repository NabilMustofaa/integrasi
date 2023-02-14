
console.log('dashboard.js loaded');
$(document).ready(function() {
  $('.dropdown').on('click', function() {
    let dropdown =$(`#dropdown-${this.id}`);
    dropdown.toggleClass('-translate-y-[500%]');
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


$('#hamburger').click(function(){
  icon = $(this).find('path');
  console.log(icon);
  icon[0].classList.toggle('opacity-100');
  icon[1].classList.toggle('opacity-0');
  $('#sidebar-placeholder').toggleClass('max-md:-translate-x-full');
  
});

