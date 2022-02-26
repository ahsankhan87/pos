app.controller('purchaseordersCtrl', function($scope,$http,$timeout) {
    
    //console.log(site_url);
    $scope.sale_date = new Date();
    
    $scope.loader = true;//show loader gif
    //get all products
    $scope.getAllProduct= function(){
     
        $http.get(site_url+'/pos/Items/get_allItems',{cache: true}).then(function(response){
       
        $scope.loader = false;//hide loader gif
        $scope.products = response.data;
        //console.log(response);
        });
    }
    
    //get all products for sales
    $scope.getsupplierCurrency = function(supplier_id){
       
       $scope.curr_loader = true;//show loader gif
       //INITIALIZE
        $scope.supplier_currency_id = 0;
        $scope.supplier_currency_code = '';
        $scope.supplier_currency_name = '';
        $scope.supplier_currency_symbol = '';
        
        $http.get(site_url+'/trans/C_purchaseOrders/getSupplierCurrencyJSON/'+supplier_id).then(function(response){
        
        if(response.data.length > 0)
        {
            $scope.supplier_currency_id = parseInt(response.data[0].id);
            $scope.supplier_currency_code = response.data[0].code;
            $scope.supplier_currency_name = response.data[0].name;
            $scope.supplier_currency_symbol = response.data[0].symbol;
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
    $scope.clearCart = function()
    {   
        $scope.invoice = {
            supplier_id:'',
            supplier_invoice_no:'',
            
            items: []
            };
    }
    
    //call the clear cart function to clear all product
    $scope.clearCart();
    
   //add product by barcode in purchase form
    $scope.addItemByBarcode = function (barcode){
            $timeout(function () {
                $scope.barcode; //from input
                //console.log($scope.barcode);
        
        //search product using barcode
        var returnData = $.grep($scope.products,function(element,index){
        return (element.barcode == barcode);
        })
       
        $scope.invoice.items.push({
                item_id: parseInt(returnData[0].item_id),
                quantity: parseFloat(1),
                //name: returnData[0].name + ' - '+ returnData[0].size,
                name: returnData[0].name + (returnData[0].size == null ? '' : ' '+returnData[0].size),
                unit_price: parseFloat(returnData[0].unit_price),
                cost_price:parseFloat(returnData[0].avg_cost),
                unit:'',
                size_id:(returnData[0].size_id == null ? 0 : returnData[0].size_id),
                unit_id:(returnData[0].unit_id == null ? 0 : returnData[0].unit_id),
                color_id:0,
                tax_id:parseFloat(returnData[0].tax_id),
                tax_rate:parseFloat((returnData[0].tax_rate == null ? 0 : returnData[0].tax_rate)),
                tax_name:returnData[0].tax_name,
                service:parseInt(returnData[0].service),
                avg_cost: parseFloat(returnData[0].avg_cost)
            });
            
        $scope.barcode = '';
        },10);
    }
    //Add product to purchasing cart
    $scope.addItem = function(item_id,size_id) {
        
         
        //search product name using product id
        var returnData = $.grep($scope.products,function(element,index){
        return (element.item_id == item_id && element.size_id == size_id);
        })
       
        $scope.invoice.items.push({
                item_id: parseInt(returnData[0].item_id),
                quantity: parseFloat(1),
                //name: returnData[0].name,
                name: returnData[0].name + (returnData[0].size == null ? '' : ' '+returnData[0].size),
                unit_price: parseFloat(returnData[0].unit_price),
                avg_cost: parseFloat(returnData[0].avg_cost),
                size_id:(returnData[0].size_id == null ? 0 : returnData[0].size_id),
                unit_id:(returnData[0].unit_id == null ? 0 : returnData[0].unit_id),
                color_id:0,
                tax_id:parseFloat(returnData[0].tax_id),
                tax_rate:parseFloat((returnData[0].tax_rate == null ? 0 : returnData[0].tax_rate)),
                tax_name:returnData[0].tax_name,
                service:parseInt(returnData[0].service),
                cost_price:parseFloat(returnData[0].avg_cost),
                unit:''
                
            });
    }
    
    // Purchase products 
    $scope.purchaseProducts = function(){
      
      var confirmSale = confirm('Are you absolutely sure you want to purchase?');
      
      //console.log($scope.supplier_id);
      
      if (confirmSale) {
          
       if($scope.invoice.items.length > 0)
        {
            if(parseInt($scope.supplier_id) == 0 || $scope.supplier_id == null)
            {
                alert('please select supplier');
            }
            else
            {
                $scope.cart_loader = true;//show loader gif
                
                //collect all cart info and submit to db
                $scope.invoice = {
                    supplier_id:parseInt($scope.supplier_id),
                    emp_id:$scope.emp_id,
                    supplier_invoice_no:$scope.supplier_invoice_no,
                    purchaseType:$scope.purchaseType,
                    register_mode:$scope.register_mode,
                    amount_due:0,
                    total_tax:$scope.total_tax(),
                    description:$scope.description,
                    discount:$scope.discount,
                    sale_date:$scope.sale_date,
                    exchange_rate: ($scope.exchange_rate === undefined ? '' : $scope.exchange_rate),
                    currency_id:($scope.supplier_currency_id === undefined ? '' : $scope.supplier_currency_id),
                    total_amount:$scope.total_amount,
                    
                    items: $scope.invoice.items
                    };
                 ///////
                 
                 var file = site_url+'/trans/C_purchaseOrders/purchaseProducts';
                 
                // fields in key-value pairs
                $http.post(file, $scope.invoice).then(function (response) {
                     
                    //alert('thenfully Purchased'+response.data);    
                    //console.log(response);
                    $scope.cart_loader = false;//hide loader gif
                    $scope.clearCart();       
                    //$scope.getAllProduct();     
                    if(response.data.invoice_no == 'no-posting-type')
                   {
                     alert('Please assign posting type to supplier otherwise amount will not be posting to accounts');
                     window.location = site_url+"/trans/C_purchaseOrders";
                   }else
                   {
                        console.log(response.data);
                      window.location = site_url+"/trans/C_purchaseOrders/receipt/"+response.data.invoice_no;
                   }
                    //console.log(response.data.invoice_no);
                    
                });
            }
        }
        else
        {
            alert('Please select product');
        }
        
        }//confirm 
    }
    ///// end Purchase Products 
    
    //delete item from cart
    $scope.removeItem = function(index) {
        $scope.invoice.items.splice(index, 1);
    },
    
    //get discount of the cart products
    $scope.Tdiscount = function() {
        var discount = 0;
        angular.forEach($scope.invoice.items, function(item) {
            discount += (item.quantity * item.cost_price)*item.discount/100;
        })

        return discount.toFixed(2);
    }
    
    //get total of the cart products
    $scope.total = function() {
        var total = 0.00;
        angular.forEach($scope.invoice.items, function(item) {
            if(item.service){
                total += parseFloat(item.quantity * item.unit_price)+(item.quantity * item.unit_price)*item.tax_rate/100;
            }else{
                total += parseFloat(item.quantity * item.cost_price)+(item.quantity * item.cost_price)*item.tax_rate/100;
            }
            
        })
        //console.log(total);
        $scope.total_amount = total.toFixed(2);
        //return Math.ceil(total).toFixed(2);
        return total.toFixed(2);
    }
    
     //CALCULATE TOTAL TAX
     $scope.total_tax = function() {
        var tax = 0;
        angular.forEach($scope.invoice.items, function(item) {
            if(!isNaN(item.tax_rate))
            {
                if(item.service){
                    tax += (item.quantity * item.unit_price)*item.tax_rate/100;    
                }else{
                    tax += (item.quantity * item.cost_price)*item.tax_rate/100;    
                }
            }
            
        })
        return tax.toFixed(4);
    }
    
});