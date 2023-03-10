const formSurvey=$('#form_survey');
formSurvey.on('submit', function(e){
  e.preventDefault();
  $.ajax({
    url: '/api/survey',
    type: 'POST',
    data: formSurvey.serialize(),
    dataType: 'json',
  }).done(function(data){
    console.log(data);
    $('#survey_question').toggleClass('hidden');
    $('#form_survey_question').attr('action', `/api/survey/${data.id}/question`);
    $('#survey_button').children()[1].innerHTML='Update';
    formSurvey.on('submit', function(e){
      e.preventDefault();
      $.ajax({
        url: `/api/survey/${data.id}`,
        type: 'PUT',
        data: formSurvey.serialize(),
        dataType: 'json',
      }).done(function(data){
        console.log(data);
      }).fail(function(data){
        console.log(data.responseJSON);
      });
    });
  }).fail(function(data){
    console.log(data.responseJSON);
  });
});;

const formSurveyQuestion=$('#form_survey_question');
const option=['radio', 'checkbox', 'select'];
formSurveyQuestion.on('submit', function(e){
  e.preventDefault();
  $.ajax({
    url: formSurveyQuestion.attr('action'),
    type: 'POST',
    data: formSurveyQuestion.serialize(),
    dataType: 'json',
  }).done(function(data){
  
    if(option.includes(data.type)){
      createOptionQuestion(data);
    }
    else{
      createBasicQuestion(data);
    }

    $('#form_survey_question').attr('action', `/api/survey/${data.survey_id}/question`);
    

  }).fail(function(data){
    console.log(data.responseJSON);
  });
});

const createBasicQuestion = (data) => {
  let form=`<form method="POST" action="/api/question/${data.id}/expected" class="flex flex-col" id="question_${data.id}">
  <div class="flex gap-2">
  <label class="text-lg font-bold my-auto" for="expected">${data.question}</label>
  <button type="button"class="text-red-400 underline" onclick="deleteQuestion(${data.survey_id},${data.id})">Delete</button>
  
  </div>
  <input type="${data.type}" name="expected" id="expected" class="border border-gray-500 rounded-md shadow-md">
  </form>`;

  $('#preview_question').append(form);
  $('#preview_question').removeClass('hidden');
};

const createOptionQuestion = (data) => {
  let form;
  if (data.type=='select'){
    form = `<form method="POST" action="/api/question/${data.id}/expected" class="flex flex-col" id="question_${data.id}">
    <div class="flex gap-2">
      <label class="text-lg font-bold my-auto" for="option_${data.id}">${data.question}</label>
      <button type="button"class="text-red-400 underline" onclick="deleteQuestion(${data.survey_id},${data.id})">Delete</button>
      
    </div>
    <select name="question_option_id" id="option_select_${data.id}" class="border border-gray-500 rounded-md shadow-md">
    </select>
    <div class="flex">
    <input type="text" name="option" id="option_${data.id}" class="border border-gray-500 rounded-md shadow-md">
    <button type="button"class="text-red-400 underline" onclick="createOption('${data.id}','${data.type}')">Add Option</button>
    </div>
    </form>`;
  }
  else{
    form = `
  <form method="POST" action="/api/question/${data.id}/expected" class="flex flex-col" id="question_${data.id}"> 
  <div class="flex gap-2">
      <label class="text-lg font-bold my-auto" for="option_${data.id}">${data.question}</label>

      <button type="button" class="text-red-400 underline" onclick="deleteQuestion(${data.survey_id},${data.id})">Delete</button>

      

    </div>
  <div class="flex">
    <input type="text" name="option" id="option_${data.id}" class="border border-gray-500 rounded-md shadow-md">
    <button type="button"class="text-red-400 underline" onclick="createOption('${data.id}','${data.type}')">Add Option</button>
  </div>
  </form>`
  }
  $('#preview_question').append(form);
};

const createOption = (id,type) => {
  let option = $('#option_'+id).val();
  $.ajax({
    url: `/api/question/${id}/option`,
    type: 'POST',
    data: {option: option},
    dataType: 'json',
  }).done(function(data){
    if(type=='select'){
      $('select[id="option_select_'+id+'"]').append(`<option value="${data.id}">${data.option}</option>`);
    }
    else{
      $('label[for="option_'+id+'"]').after(`<div class="flex">
    <input type="${type}" name="question_option_id" value="${data.id}" class="border border-gray-500 rounded-md shadow-md">
    <label class="text-lg font-bold my-auto" for="expected">${data.option}</label>
    </div>`);
    }
  }).fail(function(data){
    console.log(data.responseJSON);
  });
};

const deleteQuestion = (survey_id,id) => {
  $.ajax({
    url: `/api/survey/${survey_id}/question/${id}`,
    type: 'DELETE',
  })
  .done(function(data){
    $('#question_'+id).remove();
  })
  .fail(function(data){});
};

const saveExpected = (survey_id,id) => {
  const form=$('#question_'+id);
  $.ajax({
    url: form.attr('action'),
    type: form.attr('method'),
    data: form.serialize(),
    dataType: 'json',
  }).done(function(data){
    console.log(data);
    //set the button to green
    $('button[onclick="saveExpected('+survey_id+','+id+')"]').addClass('text-green-400').removeClass('text-red-400');
  }).fail(function(data){
    console.log(data.responseJSON);
  });
};