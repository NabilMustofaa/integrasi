let surveyFormTimeout,optionsTimeout,expectedTimeout;
let surveyId= $('#survey_id').val();
let mainContent = $('#main_content');

$('#survey_form').on('keyup change paste', 'input, select, textarea', function(){
  clearTimeout(surveyFormTimeout);
  surveyFormTimeout=setTimeout(function(){
    const form = $('#survey_form');
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(),
    }).done(function(data){
      console.log(data);
    });
  }, 1000);
});

const type = ['text', 'textarea', 'radio', 'checkbox', 'select'];
const selectOptions = function (){
  let options = '';
  type.forEach(function(option){
    options += `<option value="${option}">${option}</option>`;
  });
  return options;
}

$('#question_add').on('click', function(){
  console.log('clicked');
  $.ajax({
    url: '/api/survey/'+surveyId+'/question',
    type: 'POST',
    data: {
      question: 'New Question',
      type: 'text',
    }
  }).done(function(data){
    let dataQuestion = data;
    $.ajax({
      url : `/api/question/${dataQuestion.id}/option`,
      type: 'POST',
      data: {
        option: 'New Option',
      },
    }).done(function(data){
    let questionPlacehoder=`
    <form class=" w-[60vw] mx-auto px-20 py-12 border border-gray-100 rounded-md shadow-md flex flex-col question-form" action="/api/survey/${surveyId}/question/${dataQuestion.id}" method="PUT" id="question_form_${dataQuestion.id}">  
      <div class="flex">
        <input type="text" name="question" id="question_${dataQuestion.id}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none w-4/5" value="${dataQuestion.question}">
        <select name="type" id="type_${dataQuestion.id}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none w-1/5" onchange="changeInput(${dataQuestion.id})">
          ${selectOptions()}
        </select>
      </div>
      <input type="text" name="answer_${dataQuestion.id}" id="answer_${dataQuestion.id}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none" value="ini contoh input type text" disabled>
      <div id="options_${dataQuestion.id}" class="hidden flex flex-col">
        <div class="flex" id="option_place_${data.id}">
          <input type="radio" name="option_${dataQuestion.id}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none option_${dataQuestion.id} w-8" disabled onchange="saveExpected('${dataQuestion.id}')" value="${data.id}">
          <input id="option_label_${data.id}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none " placeholder="option 1" onchange="changeOption('${data.id}')">
          <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded my-4" onclick="deleteOption('${data.id}')">Hapus</button>
        </div>
        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-4" onclick="addOption('${dataQuestion.id}')">Tambah Opsi</button>
    </form> 
    `;

    mainContent.append(questionPlacehoder);

    $('.question-form').on('keyup change paste', 'input, select, textarea', function(){
      form=$(this).parents("form");
      clearTimeout(surveyFormTimeout);
      surveyFormTimeout=setTimeout(function(){
        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: form.serialize(),
        }).done(function(data){
          console.log(data);
        }).fail(function(data){
          console.log(data.responseJSON);
        });
      }, 1000);
    });
    });
  });
});

const changeInput = (id) => {
  let select = $(`select[id="type_${id}"]`);
  let input = $(`input[name="answer_${id}"]`);
  let option = $(`div[id="options_${id}"]`);
  

  if(select.val() == 'radio' || select.val() == 'checkbox' || select.val() == 'select'){
    option.removeClass('hidden');
    input.addClass('hidden');
    console.log( $(`input[name="option_${id}[]"]`));
    let i=1;
    $(`.option_${id}`).each(function(){
      if(select.val() == 'select'){
        $(this).attr('type', 'radio');
        $(this).attr('placeholder', `${i++}`);
      }
      else{
        $(this).attr('type', select.val());
      }
    });
  }
  else{
    option.addClass('hidden');
    input.removeClass('hidden');
    input.attr('type', select.val());
    input.val('ini contoh input type '+select.val());
    console.log(select.val());
  }
};

$('.question-form').on('keyup change paste', 'input, select, textarea', function(){
  form=$(this).parents("form");
  clearTimeout(surveyFormTimeout);
  surveyFormTimeout=setTimeout(function(){
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(),
    }).done(function(data){
    }).fail(function(data){
    });
  }, 1000);
});

const addOption = (id,type) => {
  $.ajax({
    url : `/api/question/${id}/option`,
    type: 'POST',
    data: {
      option: 'New Option',
    },
  }).done(function(data){
    let type = $(`select[id="type_${id}"]`).val();
    type = type == 'select' ? 'text' : type;
    let option = data;
    console.log(option);
    let optionPlaceholder = `
    <div class="flex" id="option_place_${option.id}">
      <input type="${type}" name="option_${id}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none option_${option.id} w-8" disabled onchange="saveExpected('${id}')" value="${data.id}">
      <input id="option_label_${option.id}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none" value="${option.option}" onchange="changeOption('${option.id}')">
      <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded my-4" onclick="deleteOption('${option.id}')">Hapus</button>
    </div>
    `;
    $(`div[id="options_${id}"]`).prepend(optionPlaceholder);
  });
};

const changeOption = (id) => {
  console.log(id);
  let option = $(`input[id="option_label_${id}"]`);
  let value = option.val();
  console.log(value,option);
  clearTimeout(optionsTimeout);
  optionsTimeout=setTimeout(function(){
    $.ajax({
      url: '/api/question/option/'+id,
      type: 'PUT',
      data: {
        option: value,
      },
    }).done(function(data){
      console.log(data);
    }).fail(function(data){
      console.log(data.responseJSON);
    });
  }, 1000);
};

const deleteOption = (id) => {
  $.ajax({
    url: '/api/question/option/'+id,
    type: 'DELETE',
  }).done(function(data){
    console.log(data);
    $(`div[id="option_place_${id}"]`).remove();
  }).fail(function(data){
    console.log(data.responseJSON);
  });
};

const deleteQuestion = (survey_id,option_id) => {
  $.ajax({
    url: '/api/survey/'+survey_id+'/question/'+option_id,
    type: 'DELETE',
  }).done(function(data){
    $(`form[id="question_form_${option_id}"]`).remove();
  }).fail(function(data){
    console.log(data.responseJSON);
  });
};

const makeQuestion = (question_id) => {
  let button = $(this);
  let question = $(`.option_${question_id}`);
  question.each(function(){
    if ($(this).attr('type') == 'select'){
      $(this).attr('type', 'radio');
    }
    $(this).attr('disabled', false);
  });
  console.log(button);
};


const saveExpected = (id) => {
  let inputs = $(`input[name="option_${id}"]:checked`);
  let type = inputs[0].type;
  console.log(inputs[0].value);

  clearTimeout(expectedTimeout);
  expectedTimeout=setTimeout(function(){
    $.ajax({
      url: '/api/question/'+id+'/expected',
      type: 'GET',
    }).done(function(data){
      console.log(data);
  
      if (data.length == 0) {
        //post 
        if (type == 'checkbox'){
          inputs.each(function(){
            $.ajax({
              url: '/api/question/'+id+'/expected',
              type: 'POST',
              data: {
                question_option_id: this.value,
              },
            }).done(function(data){
              console.log(data);
            }).fail(function(data){
              console.log(data.responseJSON);
            });
          });
        }
        else{
          $.ajax({
            url: '/api/question/'+id+'/expected',
            type: 'POST',
            data: {
              question_option_id: inputs[0].value,
            },
          })
          .done(function(data){
            console.log(data);
          })
          .fail(function(data){
            console.log(data.responseJSON);
          });
        }

        
      }
      else{
        if (type == 'checkbox'){
          let expectedIds = [];
          data.forEach(function(item){
            expectedIds.push(item.question_option_id.toString());
          });
  
          let answerIds = [];
          inputs.each(function(){
            answerIds.push(this.value);
          });

  
          console.log(expectedIds,answerIds);
  
          const diff = expectedIds.filter(x => !answerIds.includes(x));
          console.log(diff);
          diff.forEach(function(item){
            index = data.findIndex(x => x.question_option_id == item);
            $.ajax({
              url: '/api/question/'+id+'/expected/'+data[index].id,
              type: 'DELETE',
            })
            .done(function(data){
              console.log(data);
            })
            .fail(function(data){
              console.log(data.responseJSON);
            });
          });
  
          const diff2 = answerIds.filter(x => !expectedIds.includes(x));
          console.log(diff2);
          diff2.forEach(function(item){
            $.ajax({
              url: '/api/question/'+id+'/expected',
              type: 'POST',
              data: {
                question_option_id: item,
              },
            })
            .done(function(data){
              console.log(data);
            })
            .fail(function(data){
              console.log(data.responseJSON);
            });
          });
  
        }
        else{
          $.ajax({
            url: '/api/question/'+id+'/expected/'+data[0].id,
            type: 'PUT',
            data: {
              question_option_id: inputs[0].value,
            },
          })
          .done(function(data){
            console.log(data);
          })
          .fail(function(data){
            console.log(data.responseJSON);
          });
        }
      }
      
    });
  }, 1000);
};