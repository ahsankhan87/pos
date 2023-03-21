////////////////////////////////////////////////////////
//THIS IS SALES CONTROLLER 
///////////////////////////////////////////////////////
app.controller('salesProductCtrl', function($scope,$http,$timeout) {
    
    $scope.sale_date = new Date();
    $scope.due_date = new Date();
    $scope.is_taxable = true;
    $scope.customer_vat_no = '';
        
    //get all products for sales
    $scope.getAllProduct= function(){
     
     $scope.loader = true;//show loader gif
        
        $http.get(site_url+'/pos/Items/get_items',{cache: true}).then(function(response){
       
        $scope.loader = false;//hide loader gif
        $scope.products = response.data;
        console.log(response.data);
        });
    }
    //get Customer VAT No.
    $scope.getCustomer = function(customer_id){
       
        $scope.curr_loader = true;//show loader gif
        //INITIALIZE
        $http.get(site_url+'/pos/C_customers/get_active_customers_JSON/'+customer_id).then(function(response){
        
        if(response.data.length > 0)
        {
            $scope.customer_vat_no = response.data[0].vat_no;
            //console.log(response.data);
        }
       
        $scope.curr_loader = false;//hide loader gif
        });
        
    }
    
    //get all products for sales
    $scope.getCustomerCurrency = function(customer_id){
       
        $scope.curr_loader = true;//show loader gif
        //INITIALIZE
        $scope.customer_currency_id = 0;
        $scope.customer_currency_code = '';
        $scope.customer_currency_name = '';
        $scope.customer_currency_symbol = '';
        
        $http.get(site_url+'/trans/C_sales/getCustomerCurrencyJSON/'+customer_id).then(function(response){
        
        if(response.data.length > 0)
        {
            $scope.customer_currency_id = parseInt(response.data[0].id);
            $scope.customer_currency_code = response.data[0].code;
            $scope.customer_currency_name = response.data[0].name;
            $scope.customer_currency_symbol = response.data[0].symbol;
        //console.log(response);
        }
        
        $http.get(site_url+'/pos/C_currencies/currency_rate/'+$scope.customer_currency_code).then(function(response){
        
        $scope.exchange_rate = parseFloat(response);
        //console.log(response);
            });
        $scope.curr_loader = false;//hide loader gif
        });
        
    }
    
    //get all products for sales
    $scope.getsupplierCurrency = function(supplier_id){
       
       $scope.curr_loader = true;//show loader gif
       //INITIALIZE
        $scope.customer_currency_id = 0;
        $scope.customer_currency_code = '';
        $scope.customer_currency_name = '';
        $scope.customer_currency_symbol = '';
        
        $http.get(site_url+'/trans/C_receivings/getSupplierCurrencyJSON/'+supplier_id).then(function(response){
        
        if(response.data.length > 0)
        {
            $scope.customer_currency_id = parseInt(response.data[0].id);
            $scope.customer_currency_code = response.data[0].code;
            $scope.customer_currency_name = response.data[0].name;
            $scope.customer_currency_symbol = response.data[0].symbol;
        //console.log(response);
        }
        
        $http.get(site_url+'/pos/C_currencies/currency_rate/'+$scope.supplier_currency_code).then(function(response){
        
        $scope.exchange_rate = parseFloat(response);
        //console.log(response);
            });
        
        $scope.curr_loader = false;//hide loader gif
        });
        
    }
    
    //clear All the cart
    $scope.clearCart = function(invoice_no)
    {   
        if(invoice_no)
           {
                $http.get(site_url+'/trans/C_estimate/getEstimateItemsJSON/'+invoice_no).then(function(response){

                //console.log(response);
                $timeout(function(){
                    
                //find the player
                angular.forEach(response.data, function (returnData, index) {
                    
                    
                    $scope.invoice.items.push({
                        item_id: parseInt(returnData.item_id),
                        //quantity: parseFloat(1),
                        quantity:parseFloat(returnData.quantity_sold),
                        name: returnData.name + (returnData.size == null ? '' : ' '+returnData.size),
                        unit_price: parseFloat(returnData.item_unit_price),
                        cost_price:parseFloat(returnData.item_cost_price),
                        discount_percent:parseFloat(returnData.discount_percent),
                        discount_value:parseFloat(returnData.discount_value),
                        exchange_rate:parseFloat(returnData.exchange_rate),
                        currency_id:parseInt(returnData.currency_id),
                        service:parseInt(returnData.service),
                        size_id:parseInt(returnData.size_id),
                        color_id:0,
                        unit_id:(returnData.unit_id == null ? 0 : returnData.unit_id),
                        tax_id:parseFloat(returnData.tax_id),
                        tax_rate:parseFloat((returnData.tax_rate == null ? 0 : returnData.tax_rate)),
                        tax_name:returnData.tax_name,
                        inventory_acc_code : (returnData.inventory_acc_code == undefined ? 0 : returnData.inventory_acc_code),
                        
                    });
                    
                        $scope.customer_id = parseInt(returnData.customer_id);
                        $('#cust').val(null).trigger('change');//Clearing selections
                        $('#cust').val(returnData.customer_id).trigger('change');

                        // $('#emp').val(null).trigger('change');//Clearing selections
                        // $('#emp').val(returnData.employee_id).trigger('change');

                        // $scope.register_mode = returnData.register_mode;
                        // $scope.description = returnData.description;
                        // $scope.discount = parseFloat(returnData.discount_value);
                        // $scope.sale_date = new Date(returnData.sale_date);
                        // $scope.saleType = returnData.account;
                        
                        // console.log(returnData.customer_id.toString());
                        
                });
                
                });//$timeout
               //console.log($scope.invoice.items);
            });

           }
       else
           {
               $scope.invoice = {
                items: []
                };
           }
    }
    
    //call the clear cart function to clear all product
    $scope.clearCart();
    
    var sno = 0;
    //add product by barcode in sales form
    $scope.addItemByBarcode = function (barcode){
            $timeout(function () {
               // $scope.barcode; //from input
              
        //search product using barcode
        var returnData = $.grep($scope.products,function(element,index){
        return (element.barcode == barcode);
        })
       //IF QTY IS ZERO THEN ALERT ERROR MSG
       if(parseInt(returnData[0].quantity) <= 0 && parseInt(returnData[0].service) == 0)
       {
            alert('Product is not in stock, Please Purchase Product');
       }else //ADD PR0DUCT TOTHE CART
       {
        sno++;
        $scope.invoice.items.push({
                sno:sno,
                item_id: parseInt(returnData[0].item_id),
                quantity: parseFloat(1),
                item_qty:parseFloat(returnData[0].quantity),
                name: returnData[0].name + (returnData[0].size == null ? '' : ' '+returnData[0].size),
                unit_price: parseFloat(returnData[0].unit_price),
                cost_price:parseFloat(returnData[0].avg_cost),
                discount_percent:parseFloat(0),
                discount_value:parseFloat(0),
                size_id:(returnData[0].size_id == null ? 0 : returnData[0].size_id),
                unit_id:(returnData[0].unit_id == null ? 0 : returnData[0].unit_id),
                color_id:0,
                tax_id:parseFloat(returnData[0].tax_id),
                tax_rate:parseFloat((returnData[0].tax_rate == null ? 0 : returnData[0].tax_rate)),
                tax_name:returnData[0].tax_name,
                exchange_rate:0,
                currency_id:0,
                service:parseInt(returnData[0].service),
                avg_cost: parseFloat(returnData[0].avg_cost),
                inventory_acc_code : returnData[0].inventory_acc_code,
                wip_acc_code : returnData[0].wip_acc_code,
            });
        }
        $scope.barcode = '';
        },10);
    }
        
    //$scope.inventory_acc_amount = array();
   //$scope.inventory_acc_code = array();
    //Add product to Sales cart
    $scope.addItem = function(item_id,size_id) {
                
        //search product using product id
        var returnData = $.grep($scope.products,function(element,index){
        return (element.item_id == item_id && element.size_id == size_id);
        })
       
       if(parseInt(returnData[0].quantity) <= 0 && parseInt(returnData[0].service) == 0 && $scope.register_mode == 'sale')
       {
            alert('Product is not in stock, Please Purchase Product');
       }else //ADD PR0DUCT TOTHE CART
       {
         
         sno++;
         $scope.invoice.items.push({
                sno:sno,
                item_id: parseInt(returnData[0].item_id),
                quantity: parseFloat(1),
                item_qty:parseFloat(returnData[0].quantity),
                name: returnData[0].name + (returnData[0].size == null ? '' : ' '+returnData[0].size),
                unit_price: parseFloat(returnData[0].unit_price),
                cost_price:parseFloat(returnData[0].avg_cost),
                discount_percent:parseFloat(0),
                discount_value:parseFloat(0),
                exchange_rate:0,
                currency_id:0,
                tax_id:parseFloat(returnData[0].tax_id),
                tax_rate:parseFloat((returnData[0].tax_rate == null ? 0 : returnData[0].tax_rate)),
                tax_name:returnData[0].tax_name,
                service:parseInt(returnData[0].service),
                size_id:(returnData[0].size_id == null ? 0 : returnData[0].size_id),
                unit_id:(returnData[0].unit_id == null ? 0 : returnData[0].unit_id),
                color_id:0,
                inventory_acc_code : returnData[0].inventory_acc_code,
                wip_acc_code : returnData[0].wip_acc_code,
            });
            
            //GET INVENTORY AND WIP ACCOUNT CODE AND  AMOUNT FROM ITEMS TABLE
            //if ($scope.inventory_acc_code != returnData[0].inventory_acc_code) {
                
               
            //} 
            ////////////////
            
       }
       //console.log($scope.invoice.items);
      
    },
    
    // Sale products 
    $scope.saleProducts = function(){
        
        var confirmSale = confirm('Are you absolutely sure you want to sale?');
        
        if (confirmSale) {
            
        if($scope.invoice.items.length > 0)
        {
            if(parseInt($scope.customer_id) !== 0 || parseInt($scope.supplier_id) !== 0 || $scope.supplier_id == null || $scope.customer_id == null)
            
            {
                $scope.cart_loader = true;//show loader gif
                
                 //collect all cart info and submit to db
                $scope.invoice = {
                    customer_id:$('#cust').val(),//parseInt($scope.customer_id),
                    emp_id:$scope.emp_id,
                    saleType:$scope.saleType,
                    register_mode:$scope.register_mode,
                    amount_due:0,//$scope.amount_due,
                    total_amount:$scope.total_amount,
                    total_tax:$scope.total_tax(),
                    description:$scope.description,
                    //discount:$scope.discount, //DISCOUNT BY VALUES
                    discount: ($scope.discount_value === undefined ? '' : $scope.discount_value), //BY PERCENT
                    sale_date:$scope.sale_date,
                    due_date:($scope.due_date === undefined ? '' : $scope.due_date),
                    exchange_rate: ($scope.exchange_rate === undefined ? '' : $scope.exchange_rate),
                    currency_id:($scope.customer_currency_id === undefined ? '' : $scope.customer_currency_id),
                    supplier_id:($scope.supplier_id === undefined ? '' : $scope.supplier_id),
                    // is_taxable: ($scope.is_taxable === undefined ? 1 : $scope.is_taxable),
                    is_taxable: $scope.is_taxable,

                    items: $scope.invoice.items
                    };
                 ///////
                 
                var file = site_url+'/trans/C_sales/saleProducts';
                 
                // fields in key-value pairs
                $http.post(file, $scope.invoice).then(function (response) {
                     
                    //alert(response);    
                    //console.log(response);
                    // refresh and clear the cart
                    $scope.cart_loader = false;//hide loader gif
                    $scope.clearCart();
                   // $scope.getAllProduct(); 
                   if(response.data.invoice_no == 'no-posting-type')
                   {
                     alert('Please assign posting type to customer otherwise amount will not be post to accounts');
                     window.location = site_url+"/trans/C_sales";
                   }else
                   {
                      window.location = site_url+"/trans/C_sales/receipt/"+response.data.invoice_no; 
                      console.log(response.data);
                   }
                   
                    
                });
            }
            else{
                alert('Please select customer');
            }
            
        }
        else
        {
            alert('Please select product');
        }
        
        }//confirm msg
    }
    ///// end sale product 
    
    
     //delete item from cart
    $scope.removeItem = function(item) {
        // $scope.invoice.items.splice(index, 1);
        $scope.invoice.items.splice($scope.invoice.items.indexOf(item), 1);
    },
    
    //get discount of the cart products ONLY BY VALUES
    $scope.Tdiscount = function() {
        var discount = 0;
        angular.forEach($scope.invoice.items, function(item) {
            discount += (item.quantity * item.unit_price)*item.discount_percent/100;
        })

        return discount.toFixed(4);
    }
    
    //IT USES DISCOUNT PERCENT
    $scope.Tdiscount_value = function() {
        var discount = 0;
        angular.forEach($scope.invoice.items, function(item) {
            discount += item.discount_value;
        })
        $scope.discount_value = discount.toFixed(4);
        return discount.toFixed(4);
    }
    
     //CALCULATE TOTAL TAX
    $scope.total_tax = function() {
        var tax = 0;
        angular.forEach($scope.invoice.items, function(item) {
            if(!isNaN(item.tax_rate))
            {
                tax += ((item.quantity * item.unit_price)-item.discount_value)*item.tax_rate/100;    
            }
            
        })
        return tax.toFixed(4);
    }
    
    
    //get total of the cart products
    $scope.total = function() {
        var total = 0;
        angular.forEach($scope.invoice.items, function(item) {
            let tax = (item.tax_rate/100);
            total += ((item.quantity * item.unit_price)+((item.quantity * item.unit_price)-item.discount_value)*($scope.is_taxable == true ? tax : 0));//unit price + tax
        })
        $scope.total_amount = total.toFixed(4);
        
        return total.toFixed(4);
    }
});