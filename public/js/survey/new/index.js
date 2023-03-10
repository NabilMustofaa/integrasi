

const popupContentTemplate = function (data) {
  let optionParent = $('<div>').addClass('flex flex-col')

  const optionElement = (type,option,expected=false) => {
    return $('<div>').addClass('flex').append(
      $('<input>').attr('type', type).attr('name', 'option').attr('checked',expected),
      $('<input>').attr('type', 'text').attr('name', 'option').addClass('border border-gray-300 rounded-md p-2').val(option),
      $("<button>").attr('type', 'submit').attr('id', 'edit_option').addClass('bg-blue-500 text-white rounded-md px-4 ml-2').text("Delete Option"),
    )
  };

  let expect = data.expected.length != 0 ? true : false;
  
  if(data.options.length != 0){
    data.options.forEach((option) => {
      if (expect == true){
        data.expected.forEach((expected) => {
          if(option.id == expected.question_option_id){
            optionParent.append(
              optionElement(data.type,option.option,true)
            )
          }
          else{
            optionParent.append(
              optionElement(data.type,option.option,false)
            )
          }
        })
      }
      else{
        optionParent.append(
          optionElement(data.type,option.option,false)
        )
      }
    })
  }


  return $('<form>').attr('id', 'survey_edit').append(
    $('<div>').addClass('flex').append(
      $('<input>').attr('type', 'text').attr('name', 'question').addClass('border border-gray-300 rounded-md p-2').val(data.question),
      $('<button>').attr('type', 'submit').attr('id', 'edit_question').addClass('bg-blue-500 text-white rounded-md px-4 ml-2').text('Save Question')
    ),
    optionParent,
  );
};

const deleteButton = {
  icon: "trash",
  onClick: function (e) {
    alert("Delete button clicked for " + e.row.data.name);
  }
};



$.ajax({
    url: '/api/survey',
    type: 'GET',
    dataType: 'json',
}).done (function(data) {
    surveys = data;
    $(function () {
      $("#dataGrid").dxDataGrid({
          dataSource: surveys,
          columns: [
            {dataField: "id",groupIndex: 0,hidingPriority:2,
            groupCellTemplate: function (element, info) {

              element.append(
                $('<div>').addClass('flex justify-between').append(
                  $('<div>').addClass('my-auto').append(
                    $('<div>').addClass('font-bold').text('Survey ID: '+info.key),
                  ),
                  $('<div>').addClass('my-auto').append(
                    $('<a>').attr('id', 'survey_add').attr('href','/survey/new/'+info.key+'/edit').addClass('text-blue-500 underline').text('Edit Survey')
                  ),
                ),
              );
            },
            },
            {dataField: "question_id", dataType: "number", allowEditing: false,visible: false},
            {dataField: "name", dataType: "string", allowEditing: false,hidingPriority: 1},
            {dataField: "description", dataType: "string", allowEditing: false,hidingPriority: 0},
            {dataField: "question", dataType: "string", allowEditing: false},
            {dataField: "type", dataType: "string", allowEditing: false},
            {
              type: "buttons",
              buttons: [ deleteButton],
              width: 50,
            }
          ],
          
      });
    }
    );
});

$('#survey_add').on('click', function(e){
  console.log('clicked');
  e.preventDefault();
  $.ajax({
    url: '/api/survey',
    type: 'POST',
    dataType: 'json',
    data: {
      name: 'Survey Name',
      description: 'Survey Description',
      survey_category_id: 1,
    }
  }).done(function(data){
    console.log(data);
    //redirect to edit page
    window.location.href = `/survey/new/${data.id}/edit`;


  })
})










