var Customers = function () {

    
  //FOR SALES REPORTS USAGES
 var initTable_sample_customer = function () {
        var table = $('#sample_customer');

        var oTable = table.dataTable({
            
            "createdRow": function( nRow, aData, iDisplayIndex ) {
                
                $('td:eq(3)', nRow).css('text-align','right');
                $('td:eq(4)', nRow).css('text-align','right');
                //$('td:eq(4)', nRow).html(parseFloat(aData['avg_cost']).toFixed(2));
                
                $('td:eq(5)', nRow).css('text-align','right');
                //$('td:eq(5)', nRow).html(parseFloat(aData['unit_price']).toFixed(2));
  
                return nRow;
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
            pageTotal_3 = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
                
            // Total over this page
            pageTotal_4 = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            pageTotal_5 = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            
            // Update footer
            $( api.column( 3 ).footer() ).css('text-align','right');
            $( api.column( 3 ).footer() ).html(
                pageTotal_3.toFixed(2)
            );
            $( api.column( 4 ).footer() ).css('text-align','right');
            $( api.column( 4 ).footer() ).html(
                pageTotal_4.toFixed(2)
            );
            
            $( api.column( 5 ).footer() ).css('text-align','right');
            $( api.column( 5 ).footer() ).html(
                (pageTotal_3-pageTotal_4).toFixed(2)
            );
            
            
            
        },
        ///////////////////////////
        
            "order": [
                [1, 'desc']
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
                    targets: 1,
                    // visible: false
                } ],
            
        });

        var tableWrapper = $('#sample_customer_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
 
 //////////
 
 //FOR SALES REPORTS USAGES
 var initgetAllCustomerWithBalance = function () {
        var table = $('#getAllCustomerWithBalance');

        var oTable = table.dataTable({
            
            "ajax":site_url+"/pos/C_customers/getCustomersWithBalanceJSON",
            "deferRender": true,
            
            "createdRow": function( nRow, aData, iDisplayIndex ) {
                
                $('td:eq(3)', nRow).css('text-align','right');
                $('td:eq(4)', nRow).css('text-align','right');
                //$('td:eq(4)', nRow).html(parseFloat(aData['avg_cost']).toFixed(2));
                
                $('td:eq(5)', nRow).css('text-align','right');
                //$('td:eq(5)', nRow).html(parseFloat(aData['unit_price']).toFixed(2));
  
                return nRow;
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
            pageTotal_4 = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
                
            // Total over this page
            pageTotal_5 = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            pageTotal_6 = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            
            // Update footer
            $( api.column( 4 ).footer() ).css('text-align','right');
            $( api.column( 4 ).footer() ).html(
                pageTotal_4.toFixed(2)
            );

            $( api.column( 5 ).footer() ).css('text-align','right');
            $( api.column( 5 ).footer() ).html(
                pageTotal_5.toFixed(2)
            );
            
            $( api.column( 6 ).footer() ).css('text-align','right');
            $( api.column( 6 ).footer() ).html(
                (pageTotal_4-pageTotal_5).toFixed(2)
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

        var tableWrapper = $('#getAllCustomerWithBalance_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
 
 //////////
 
 //FOR SALES REPORTS USAGES
 var initgetAllCustomer = function () {
        var table = $('#getAllCustomer');

        var oTable = table.dataTable({
            
            //Retrieve all Customers and populate
            //"ajax":site_url+"/pos/C_customers/getCustomersJSON",
            "ajax":{
                    "url": site_url+"/pos/C_customers/get_act_customers_JSON",
                    "dataSrc": "",
                    "cache": true,
                },
            //"deferRender": true,
            "columns": [
                        { "data": "id" },
                        { "data": "first_name" },
                        { "data": "store_name" },
                        { "data": "address" },
                        { "data": "city" },
                        { "data": "mobile_no" },
                        { "data": "id" }
                        
                    ],
            "createdRow": function( nRow, aData, iDisplayIndex ) {
                            $('td:eq(0)', nRow).html('<a href="'+site_url+'/pos/C_customers/customerDetail/' + aData['id'] + '">' +
                                aData['first_name'] + '</a>');
                                
                            $('td:eq(5)', nRow).html('<a href="'+site_url+'/pos/C_customers/edit/' + aData['id'] + 
                            '"><i class=\'fa fa-pencil-square-o fa-fw\'></i></a> | <a href="'+site_url+'/pos/C_customers/delete/' + aData['id'] + '/' + aData['op_balance_dr'] + '/' + aData['op_balance_cr'] + '" onclick="return confirm(\'Are you sure you want to permanent delete customer and his account transactions?\')"; title=\'Permanent Delete\'><i class=\'fa fa-trash-o fa-fw\'></i></a>');
            //                 '<div class="btn-group">'+
            //                 '<button type="button" class="btn btn-success">Sales</button>'+
			// '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>'+
			// '<ul class="dropdown-menu" role="menu">'+
			// '<li><a href="'+site_url+'/trans/C_sales/index/cash/' + aData['id'] + '">Cash Sales</a></li>' +
			// '<li><a href="'+site_url+'/trans/C_sales/index/credit/' + aData['id'] + '">Credit Sales</a></li>' +
			// '<li><a href="'+site_url+'/trans/C_sales/index/cashReturn/' + aData['id'] + '">Cash Return</a></li>' +
			// '<li><a href="'+site_url+'/trans/C_sales/index/creditReturn/' + aData['id'] + '">Credit Return</a></li></ul></div>');
                            
                            return nRow;
                        },
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

        var tableWrapper = $('#getAllCustomer_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
 
 //////////
   
    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            initTable_sample_customer();//self defined function by ahsan
            initgetAllCustomer();
            initgetAllCustomerWithBalance();
            
            }

    };

}();