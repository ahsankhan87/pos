var Logs = function () {

var initgetAllLogs = function () {
        var table = $('#getAllLogs');

        var oTable = table.dataTable({
            
            //"ajax":site_url+"/pos/Items/get_items",
            "ajax":{
                    "url": site_url+"/setting/C_logs/get_logs_JSON",
                    "dataSrc": ""
                },
            //"deferRender": true,
            "columns": [
                        { "data": "id" },
                        { "data": "date" },
                        { "data": "user" },
                        { "data": "module" },
                        { "data": "message_desc" },
                        { "data": "host_ip" }
                        
                    ],
            
            
            "order": [
                [0, 'desc']
            ],
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            //buttons: ['copy', 'excel', 'pdf'],
            // set the initial value
            "pageLength": 20,
            //dom: "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            dom: 'Bflrtip',
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: function(){
                             return $('#print_title').text(); 
                          },
                    //messageTop: 'The information in this table is copyright to kasbook Inc.'
                },
                {
                    extend: 'pdf',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: function(){
                             return $('#print_title').text(); 
                          },
                    messageBottom: 'Powered by: <i>kasbook.com, Cell:03119809070</i>'
                },
                {
                    extend: 'print',
                    key: 'p',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: '',
                    autoPrint:false,
                    messageTop:function(){
                             var header = '<p style="text-align:center; font-size:18px;color:#999;">';
                                 //header += '<img src="'+path+'images/company/thumb/company_logo.jpg" style="height:100px; left:100px;" />';
                                 header += $('.company_name').text()+'</p>';
                                 header += '<p style="font-size:14px">'+  $('#print_title').text() +"</p>";
                                
                             return  header;
                          },
                    messageBottom: '<span style="text-align:center;">Powered by: <i>kasbook.com, Cell:03119809070</i></span>',
                },
                'colvis'
            ],
            columnDefs: [ {
                    targets: 0,
                    visible: false
                } ],
            
        });

        var tableWrapper = $('#getAllLogs_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
 
 //////////

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            initgetAllLogs();
            
        }

    };

}();