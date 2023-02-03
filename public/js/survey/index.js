
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

      let options = [];
      for (let i = 0; i < data.options.length; i++) {
        options.push(data.options[i].option);
      }
      
      // set the data as an option in the contentTemplate
      $("#popup").dxPopup({
        title: "Edit Survey",
        data: data,
        contentTemplate: function (contentElement) {
          contentElement.append(
            $("<div>").dxTextBox({
              value: data.question,
            }),
          );
          console.log(data.type,options);
          if (data.type === "radio") {
            $("<div>").dxRadioGroup({
              items: options,
            }).appendTo(contentElement);
          }
          else if (data.type === "checkbox") {
            for (let i = 0; i < options.length; i++) {
              $("<div>").dxCheckBox({
                text: options[i],
                name: 'checkbox'
              }).appendTo(contentElement);
            }
          }
          

        }
      });
      //c
      // show the popup
      $("#popup").dxPopup("instance").show();


    });
  }
};

const deleteButton = {
  icon: "trash",
  onClick: function (e) {
    alert("Delete button clicked for " + e.row.data.name);
  }
};

$(function () {
  $("#popup").dxPopup({
    title: "Edit Survey",
    //paramter to receive data from grid
    contentTemplate: function (contentElement) {
      contentElement.append(
        $("<div>").dxTextBox({
          value: contentElement.model.data.name,
        })
      );
    }
  });
 
});

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
            //don't show the id column but use as group
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

