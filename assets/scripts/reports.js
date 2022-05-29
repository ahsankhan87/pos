var Reports = function () {

    
 //FOR SALES REPORTS USAGES
 var initTable__sales_reports = function () {
        var table = $('#sample_sales_reports');

        var oTable = table.dataTable({
            
            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

            //GET TOTAL AT FOOTER OF GRID
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\Cr,\Dr,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                    
            };
 
            // Total over all pages
            total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            // Total over this page
            pageTotal_5 = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
                
            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            pageTotal_7 = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            // Total over this page
            pageTotal_8 = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            // Total over this page
            pageTotal_9 = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
                
            // Update footer
            $( api.column( 5 ).footer() ).html(
                pageTotal_5
            );
            
            $( api.column( 6 ).footer() ).html(
                pageTotal.toFixed(2)
            );
            
            $( api.column( 7 ).footer() ).html(
                pageTotal_7
            );
            
            $( api.column( 8 ).footer() ).html(
                pageTotal_8.toFixed(2)
            );
            
            $( api.column( 9 ).footer() ).html(
                pageTotal_9.toFixed(2)
            );
            
        },
        ///////////////////////////
        
            "order": [
                [0, 'desc']
            ],
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            "pageLength": 20,
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
                    messageBottom: 'Powered by: <i>khybersoft.com</i>'
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
                    messageBottom: '<span style="text-align:center;">Powered by: <i>Powered by: <i>khybersoft.com</i></span>',
                },
                'colvis'
            ],
            columnDefs: [ {
                    //targets: 0,
                    visible: false
                } ],
            
        });

        var tableWrapper = $('#sample_sales_reports_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
 
 //FOR SALES REPORTS USAGES
 var receiving_reports = function () {
    var table = $('#sample_receiving_reports');

    var oTable = table.dataTable({
        
        "language": {
            "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
        },

        //GET TOTAL AT FOOTER OF GRID
        "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\Cr,\Dr,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
                
        };

        // Total over all pages
        total = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );
        
        // Total over this page
        pageTotal_5 = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );
            
        // Total over this page
        pageTotal = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );
        
        pageTotal_7 = api
            .column( 7, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );
        
        // Update footer
        $( api.column( 5 ).footer() ).html(
            pageTotal_5
        );
        
        $( api.column( 6 ).footer() ).html(
            pageTotal.toFixed(2)
        );
        
        $( api.column( 7 ).footer() ).html(
            pageTotal_7.toFixed(2)
        );
        
    },
    ///////////////////////////
    
        "order": [
            [0, 'desc']
        ],
        "lengthMenu": [
            [20, 50, 100, -1],
            [20, 50, 100, "All"] // change per page values here
        ],
        "pageLength": 20,
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
                messageBottom: 'Powered by: <i>khybersoft.com</i>'
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
                messageBottom: '<span style="text-align:center;">Powered by: <i>Powered by: <i>khybersoft.com</i></span>',
            },
            'colvis'
        ],
        columnDefs: [ {
                //targets: 0,
                visible: false
            } ],
        
    });

    var tableWrapper = $('#sample_receiving_reports_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
    tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
}

//////////
var sales_report = function () {
    
        var table = $('#sales_report');

        
        /* Set tabletools buttons and button container */
        var oTable = table.dataTable({
            
            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\Dr,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                    
            };
 
            // Total over all pages
            total = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                pageTotal.toFixed(2)
            );
        },
        
            "order": [
                [0, 'desc']
            ],
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            buttons: [
                    'copy', 'excel', 'pdf'
                ],
            // set the initial value
            "pageLength": 20,
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
                    messageBottom: 'Powered by: <i>khybersoft.com</i>'
                },
                {
                    extend: 'print',
                    footer:true,
                    key: 'p',
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
                    messageBottom: '<span style="text-align:center;">Powered by: <i>khybersoft.com</i></span>',
                    //customize: function (win) {
//                            $(win.document.body)
//                                .css( 'font-size', '10pt' )
//                                .prepend(
//                                    '<img src="'+path+'images/company/thumb/company_logo.jpg" style="position:absolute; top:0; left:0;" />'
//                                );
//         
//                            $(win.document.body).find( 'table' )
//                                .addClass( 'compact' )
//                                .css( 'font-size', 'inherit' );
//                                    
//                                }
                },
                'colvis'
            ],
            columnDefs: [ {
                    targets: 0,
                    visible: false
                } ],
            
        });

        var tableWrapper = $('#sales_report_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
    
    //////////
///FOR SALES REPORTS SUMMARY 
var sales_summary = function () {
    
        var table = $('#sales_summary');
        
        /* Set tabletools buttons and button container */
        var oTable = table.dataTable({
            
            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\Dr,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                    
            };
 
            // Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
           
            // Total over this page
            // pageTotal_3 = api
            // .column( 3, { page: 'current'} )
            // .data()
            // .reduce( function (a, b) {
            //     return intVal(parseFloat(a)) + intVal(parseFloat(b));
            // }, 0 );

            // Update footer
            $( api.column( 2 ).footer() ).html(
                pageTotal.toFixed(2)
            );

            // Update footer
            // $( api.column( 3 ).footer() ).html(
            //     pageTotal_3.toFixed(2)
            // );
        },
        
            "order": [
                [0, 'desc']
            ],
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            buttons: [
                    'copy', 'excel', 'pdf'
                ],
            // set the initial value
            "pageLength": 20,
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
                    messageBottom: 'Powered by: <i>khybersoft.com</i>'
                },
                {
                    extend: 'print',
                    footer:true,
                    key: 'p',
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
                    messageBottom: '<span style="text-align:center;">Powered by: <i>khybersoft.com</i></span>',
                },
                'colvis'
            ],
            columnDefs: [ {
                    targets: 0,
                    visible: false
                } ],
            
        });

        var tableWrapper = $('#sales_summary_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

  //////////
///FOR Category wise SALES REPORTS SUMMARY 
var category_sales_summary = function () {
    
        var table = $('#category_sales_summary');
        
        /* Set tabletools buttons and button container */
        var oTable = table.dataTable({
            
            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\Dr,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                    
            };
 
            // Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
           
            // Total over this page
            pageTotal_3 = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );

            // Update footer
            $( api.column( 2 ).footer() ).html(
                pageTotal.toFixed(2)
            );

            // Update footer
            $( api.column( 3 ).footer() ).html(
                pageTotal_3.toFixed(2)
            );
        },
        
            "order": [
                [0, 'desc']
            ],
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            buttons: [
                    'copy', 'excel', 'pdf'
                ],
            // set the initial value
            "pageLength": 20,
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
                    messageBottom: 'Powered by: <i>khybersoft.com</i>'
                },
                {
                    extend: 'print',
                    footer:true,
                    key: 'p',
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
                    messageBottom: '<span style="text-align:center;">Powered by: <i>khybersoft.com</i></span>',
                },
                'colvis'
            ],
            columnDefs: [ {
                    targets: 0,
                    visible: false
                } ],
            
        });

        var tableWrapper = $('#sales_summary_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

 
    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            sales_report(); //self defined function by ahsan
            initTable__sales_reports();//self defined function by ahsan
            sales_summary();//self defined function by ahsan
            category_sales_summary();
            receiving_reports();
        }

    };

}();