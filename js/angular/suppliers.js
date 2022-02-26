////////////////////////////////////////////////////////
//THIS IS supplier CONTROLLER 
///////////////////////////////////////////////////////
app.controller('supplierCtrl', function($scope,$http) {
    
    //get all products for sales
    $scope.getAllSuppliers= function(){
     
        $http.get(site_url+'/pos/suppliers/get_allSuppliers').then(function(response){
       
        $scope.allSuppliers = response.data;
    
        });
    }
    
    //clear All the cart
    $scope.clearCart = function()
    {   
        $scope.supplier = {
            items: []
            };
    }
    
    //call the clear cart function to clear all product
    $scope.clearCart();
    
    
     //Add product to purchasing cart
    $scope.addItem = function(id) {
        
         
        //search Suppliers using exp id
        var returnData = $.grep($scope.allSuppliers,function(element,index){
        return element.id == id;
        })
       
        $scope.supplier.items.push({
                id: parseInt(returnData[0].id),
                 
                name: returnData[0].name,
                 
            });
    }
    
    
    // Save Supplier 
    $scope.saveSuppliers = function(){
        
         //collect all cart info and submit to db
        $scope.Supplier = {
            cash_account:$scope.cash_account,
            
            items: $scope.Supplier.items
            };
         ///////
         
         
         var file = site_url+'/pos/c_suppliers/saveSuppliers';
         
        // fields in key-value pairs
        $http.post(file, $scope.supplier).then(function (response, status, headers, config) {
             
            alert('Successfully Paid');    
            // refresh and clear the cart
            $scope.clearCart();
            
        }).error(function(response.data){
                alert(response.data); 
            });
    }
    ///// end sale product 
    
    //delete item from cart
    $scope.removeItem = function(index) {
        $scope.supplier.items.splice(index, 1);
    },
    
    //get total of the cart products
    $scope.total = function() {
        var total = 0;
        angular.forEach($scope.supplier.items, function(item) {
            total += item.amount;
        })

        return total;
    }
    
});