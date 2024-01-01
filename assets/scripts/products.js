var Products = function () {

var initGetAllProducts = function () {
        var table = $('#getAllProducts');

        var oTable = table.dataTable({
            
            //"ajax":site_url+"/pos/Items/get_items",
            "ajax":{
                    "url": site_url+"/pos/Items/get_items",
                    "dataSrc": ""
                },
            
                "language": {
                    "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
                },
            //"deferRender": true,
            "columns": [
                        { "data": "item_id" },
                        { "data": "name" },
                        { "data": "unit_name" },
                        { "data": "category" }, //{ "data": "item_type" }, 
                        // { "data": "location_name" },
                        { "data": "quantity" },
                        { "data": "avg_cost" },
                        { "data": "unit_price" },
                        { "data": "item_id" }
                        
                    ],
            "createdRow": function( nRow, aData, iDisplayIndex ) {
                            $('td:eq(0)', nRow).html('<a href="'+site_url+'/pos/Items/item_transactions/' + aData['item_id'] + '">' +
                                aData['name'] + ' '+(aData['size'] = 'null' ? '' : aData['size'])+ '</a>');
                            
                            var total_cost = (aData['quantity']*aData['avg_cost']);
                            
                            $('td:eq(3)', nRow).css('text-align','right');
                            $('td:eq(4)', nRow).css('text-align','right');
                            $('td:eq(4)', nRow).html(parseFloat(aData['avg_cost']).toFixed(2));
                            
                            $('td:eq(5)', nRow).css('text-align','right');
                            $('td:eq(5)', nRow).html(parseFloat(aData['unit_price']).toFixed(2));
              
                            if(aData['service'] == parseInt("1")){
                                
                                // $('td:eq(2)', nRow).html('<div>Service</div>');
                                
                                $('td:eq(6)', nRow).html('<a href="'+site_url+'/pos/Items/editService/' + aData['item_id'] + 
                                    '" title=\'Edit\'><i class=\'fa fa-pencil-square-o fa-fw\'></i></a><a href="'+site_url+'/pos/Items/delete/' + 
                                    aData['item_id'] + '/' + aData['inventory_acc_code'] + '/' + total_cost + '/' + aData['size_id'] + 
                                    '" onclick="return confirm(\'Are you sure you want to delete?\')"; title=\'Make Inactive\'><i class=\'fa fa-trash-o fa-fw\'></i></a>');
                            }else{
                                // $('td:eq(2)', nRow).html('<div>Product</div>');
                                
                                $('td:eq(6)', nRow).html('<a href="'+site_url+'/pos/Items/edit/' + aData['item_id'] + '/' + aData['size_id'] + 
                                    '"><i class=\'fa fa-pencil-square-o fa-fw\'></i></a><a href="'+site_url+'/pos/Items/delete/' + 
                                    aData['item_id'] + '/' + aData['inventory_acc_code'] + '/' + total_cost + '/' + aData['size_id'] + 
                                    '" onclick="return confirm(\'Are you sure you want to delete?\')"; title=\'Make Inactive\'><i class=\'fa fa-trash-o fa-fw\'></i></a>');
                            
                                }
                            
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
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                //pageTotal.toFixed(2) +' ('+ total.toFixed(2) +' total)'
                pageTotal.toFixed(2)
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
                    messageBottom: 'Powered by: <i>khybersoft.com, Cell:03119809070</i>'
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
                    messageBottom: '<span style="text-align:center;">Powered by: <i>khybersoft.com, Cell:03119809070</i></span>',
                },
                'colvis'
            ],
            columnDefs: [ {
                    targets: 0,
                    visible: false
                } ],
            
        });

        var tableWrapper = $('#sample_2_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
 
 //////////

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            initGetAllProducts();
            
        }

    };

}();