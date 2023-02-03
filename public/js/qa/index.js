let data;
const dataGrid = $('#dataGrid')
let popup ;
const dataGridInstance = () => {
  $.ajax({
    url: '/api/qa',
    type: 'GET',
    dataType: 'json',

}).done(function (data) {
  data = data;
  dataGrid.dxDataGrid({
    dataSource: data,
    columns: [
      {dataField: 'id', caption: 'ID',width: 100},
      {dataField: 'name', caption: 'Quality Assurance Name'},
      {dataField: 'phone', caption: 'Quality Assurance Phone'},
      {dataField: 'address', caption: 'Quality Assurance Address'},
      {
        type: "buttons",
        buttons: [editButton, deleteButton],
        width: 100,
      }
    ],
  })
})
}
dataGridInstance();

const editButton = {
  icon: 'edit',
  onClick: function (e) {
    let data = e.row.data;
    let url = `/api/qa/${data.id}`;
    console.log(url);
    console.log(data);
    popup= $('#popup').dxPopup({
      title: 'Create Quality Assurance',
      contentTemplate: popupContentTemplateWithEdit(data),
      showTitle: true,
      width:400,
      height: 350,
      visible: false,
      dragEnabled: false,
      closeOnOutsideClick: true,
    }).dxPopup('instance');
    popup.show();
    $('#edit').on('click', function (e) {
      e.preventDefault();
      let data = $('#qa_edit').serializeArray();
      console.log(data);
      $.ajax({
        url: url,
        type: 'PUT',
        data: data,
        dataType: 'json',
      }).done(function (data) {
        popup.hide();
        dataGridInstance();
      })
    });
  },

};

const deleteButton = {
  icon: 'trash',
  onClick: function (e) {
    console.log(e.row.data);
    let data = e.row.data;
    $.ajax({
      url: `/api/qa/${data.id}`,
      type: 'DELETE',
      dataType: 'json',
    }).done(function (data) {
      dataGridInstance();
    })
  }
};

const popupContentTemplateWithEdit = function (data) {
  return $('<form>').attr('id', 'qa_edit').append(
    $('<div>').addClass('flex flex-col').append(
      $('<label>').text('Quality Assurance Name').addClass('mb-2'),
      $('<input>').attr('type', 'text').attr('name', 'name').addClass('border border-gray-300 rounded-md p-2 mb-2').val(data.name),
    ),
    $('<div>').addClass('flex flex-col').append(
      $('<label>').text('Quality Assurance Phone').addClass('mb-2'),
      $('<input>').attr('type', 'text').attr('name', 'phone').addClass('border border-gray-300 rounded-md p-2 mb-2').val(data.phone),
    ),
    $('<div>').addClass('flex flex-col').append(
      $('<label>').text('Quality Assurance Address').addClass('mb-2'),
      $('<input>').attr('type', 'text').attr('name', 'address').addClass('border border-gray-300 rounded-md p-2 mb-2 h-24').val(data.address),
    ),
    $('<button>').text('Edit').addClass('bg-blue-500 text-white p-2 rounded-md').attr('type', 'submit').attr('id', 'edit')
  );
}

const popupContentTemplate = function () {
  return $('<form>').attr('id','qa_form').append(
    $('<div>').addClass('flex flex-col').append(
      $('<label>').text('Quality Assurance Name').addClass('mb-2'),
      $('<input>').attr('type', 'text').attr('name', 'name').addClass('border border-gray-300 rounded-md p-2 mb-2'),
    ),
    $('<div>').addClass('flex flex-col').append(
      $('<label>').text('Quality Assurance Phone').addClass('mb-2'),
      $('<input>').attr('type', 'text').attr('name', 'phone').addClass('border border-gray-300 rounded-md p-2 mb-2'),
    ),
    $('<div>').addClass('flex flex-col').append(
      $('<label>').text('Quality Assurance Address').addClass('mb-2'),
      $('<input>').attr('type', 'text').attr('name', 'address').addClass('border border-gray-300 rounded-md p-2 mb-2 h-24'),
    ),
    $('<button>').text('Create').addClass('bg-blue-500 text-white p-2 rounded-md').attr('type','submit').on('click', function (e) {
      e.preventDefault();
      $.ajax({
        url: '/api/qa',
        type: 'POST',
        dataType: 'json',
        data: $('#qa_form').serialize()
      }).done(function (data) {
        popup.hide();
        dataGridInstance();

      }).fail(function (data) {
        console.log(data.responseJSON);
      });
    }),
  )
}



const qa_add = $('#qa_add');
qa_add.on('click', function () {
  popup= $('#popup').dxPopup({
    title: 'Create Quality Assurance',
    contentTemplate: popupContentTemplate,
    showTitle: true,
    width:400,
    height: 350,
    visible: false,
    dragEnabled: false,
    closeOnOutsideClick: true,
  }).dxPopup('instance');
  popup.show();
});
