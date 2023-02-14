$.ajax({
  url: '/api/plans',
  type: 'GET',
  dataType: 'json',
}).done(function(data) {
  console.log(data);
  $(function () {
    $("#dataGrid").dxDataGrid({
        dataSource: data,
        columns: [
          {dataField: "id", caption: "ID", width: 20},
          {dataField: "survey_name", caption: "Survey Name"},
          {dataField: "store_name", caption: "Store Name"},
          {dataField: "date", caption: "Survey Date",groupIndex: 0},
          {dataField: "qa_name", caption: "QA Name", "groupIndex": 1, groupCellTemplate: function (element, info) {
            element.append(
              $('<div>').addClass('flex justify-between').append(
                $('<div>').addClass('my-auto').append(
                  $('<div>').addClass('font-bold').text('QA Name: '+info.key[1]),
                ),
                $('<div>').addClass('my-auto').append(
                  $('<a>').attr('id', 'survey_add').attr('href','/survey/new/'+info.key+'/edit').addClass('text-blue-500 underline').text('Check Route')
                ),
              ),
            );
          }},
          {dataType: "Button", caption: "Action", width: 100, cellTemplate: function (container, options) {
            var button = $("<a/>").addClass("btn btn-primary btn-sm").text("Fill Form").attr("href", "/plan/" + options.data.id);
            container.append(button);
          }}
        ],
        columnAutoWidth: true,
        showBorders: true,
        groupPanel: {
          visible: true
        },

    });
  })
}).fail(function(data){
  console.log(data.responseText);
});