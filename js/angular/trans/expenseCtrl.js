////////////////////////////////////////////////////////
//THIS IS expense CONTROLLER 
///////////////////////////////////////////////////////
app.controller('expenseCtrl', function($scope,$http) {
    
    $scope.exp_date = new Date();
    
    //get all products for sales
    $scope.getAllExpenses= function(){
     
        $http.get(site_url+'/trans/C_expenses/get_allExpenses').then(function(response){
       
        $scope.allExpenses = response.data;
        console.log(response);
        });
    }
    
    //clear All the cart
    $scope.clearCart = function()
    {   
        $scope.expense = {
            items: []
        };
    }
    
    //call the clear cart function to clear all product
    $scope.clearCart();
    
    /////////////////////
    $scope.isCust=0;
    $scope.isSupp = 0;
    $scope.isBank = 0;
    //get all products
    $scope.get_ref_accounts= function(acc_code){
     
        $http.get(site_url+'/pos/C_customers/get_customers_JSON/'+acc_code).then(function(response){
        
            if(response.data.length > 0)//if customers has then load
            {
                $scope.ref_accounts = response.data;
                $scope.isCust = 1;
                $scope.isSupp = 0;
                $scope.isBank = 0;
                //console.log(data);
            }
        
        });
        
        $http.get(site_url+'/pos/Suppliers/get_suppliers_JSON/'+acc_code).then(function(response){
        
            if(response.data.length > 0)//if Suppliers has then load
            {
                $scope.ref_accounts = response.data;
                $scope.isCust = 0;
                $scope.isSupp = 1;
                $scope.isBank = 0;
                //console.log(data);
            }
        });
        
        $http.get(site_url+'/pos/C_banking/get_banks_JSON/'+acc_code).then(function(response){
        
            if(response.data.length > 0)//if Suppliers has then load
            {
                $scope.ref_accounts = response.data;
                $scope.isCust = 0;
                $scope.isSupp = 0;
                $scope.isBank = 1;
                //console.log(data);
            }
        });
    }
    ////////////

    $scope.ref_id='';
    //Add product to purchasing cart
    $scope.addItem = function(id) {
        
        //search expenses using exp id
        var returnData = $.grep($scope.allExpenses,function(element,index){
        return element.id == id;
        })
       
        $scope.expense.items.push({
                id: parseInt(returnData[0].id),
                account_code: returnData[0].account_code,
                title: returnData[0].title,
                name: returnData[0].name,
                tax_id: 0,
                
            });
    }
    
    
    // Save Expense 
    $scope.saveExpenses = function(){
        
        if($scope.expense.items.length > 0)
        {
            if($scope.cash_account == 0 || $scope.cash_account == undefined)
            {
                alert('please select cash account');
            }
            else
            {
                $scope.cart_loader = true;//show loader gif
                
                 //collect all cart info and submit to db
                $scope.expense = {
                    cash_account:$scope.cash_account,
                    tax_account:$scope.tax_account,
                    narration:$scope.narration,
                    exp_date:$scope.exp_date,
                    supplier_invoice_no:$scope.supplier_invoice_no,
                    isCust:$scope.isCust,
                    isSupp:$scope.isSupp,
                    isBank:$scope.isBank,
                    ref_id:$scope.ref_id,
                    ref_name: $("#ref_id option:selected").text(),
                
                    items: $scope.expense.items
                    };
                 ///////
                
                 var file = site_url+'/trans/C_expenses/saveExpenses';
                 
                // fields in key-value pairs
                $http.post(file, $scope.expense).then(function (response) {
                     
                    console.log(response.data);
                    alert('Successfully Paid');    
                    // refresh and clear the cart
                    $scope.clearCart();
                    $scope.cart_loader = false;//hide loader gif
                    //$scope.cash_account = 0;
                    $scope.narration = '';
                    
                });
            }
        }else
        {
            alert('Please select expense account');
        }
    }
    ///// end sale product 
    
    //delete item from cart
    $scope.removeItem = function(index) {
        $scope.expense.items.splice(index, 1);
    },
    
    //get total of the cart products
    $scope.total = function() {
        
        var total = 0;
        angular.forEach($scope.expense.items, function(item) {
            total += item.amount+(item.tax_id*item.amount/100);
        })
        console.log(total);
        return parseFloat(total).toFixed(2);
    }
    
});