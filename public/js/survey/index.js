const editButton = {
  icon: "edit",
  onClick: function (e) {
    // access the data of the clicked row
    let data = e.row.data;
    console.log(data);
    $.ajax({
      url: `/api/survey/${data.id}/question/${data.question_id}`,
      type: "GET",
      dataType: "json",
    }).done(function (data) {
      console.log(data);
      
      $("#popup").dxPopup({
        title: "Edit Survey",
        contentTemplate: popupContentTemplate(data),
        showTitle: true,
        width: 400,
        height: 350,
        hideOnOutsideClick: true,
      });
      $("#popup").dxPopup("instance").show();
    });
  }
};

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
            {dataField: "id", dataType: "number", allowEditing: false, groupIndex: 0},
            {dataField: "question_id", dataType: "number", allowEditing: false,visible: false},
            {dataField: "name", dataType: "string", allowEditing: false},
            {dataField: "description", dataType: "string", allowEditing: false},
            {dataField: "question", dataType: "string", allowEditing: false},
            {dataField: "type", dataType: "string", allowEditing: false},
            {
              type: "buttons",
              buttons: [editButton, deleteButton],
              width: 100,
            }
          ],
      });
    });
});

