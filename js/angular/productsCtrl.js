app.controller('productsCtrl', function($scope,$http) {
    
    //var site_url = 'http://localhost/pos_new/index.php';
    //var site_url = 'http://khybersoft.com/accounts/index.php';
    //get all products
    $scope.getAllProducts= function(){
     
        $scope.loader = true;//show loader gif
     
        $http.get(site_url+'/pos/items/get_allItems').then(function(response){
      //$http.get('http://khybersoft.com/accounts/index.php/pos/items/get_allItems').then(function(data){
        
        $scope.loader = false;//show loader gif
        $scope.products = response.data;
    
        });
    }
    
    
     // clear variable / form values
    $scope.clearForm = function(){
        $scope.item_id = "";
        $scope.name = "";
        $scope.category = "";
        $scope.packets =0,
        $scope.default_tablets_qty=0,
                
        $scope.category_id = 0;
        $scope.item_company = '';
        $scope.ingrediants = '';
    }
    
    //Add product to purchasing cart
    $scope.editItem = function(item_id,size_id) {
        
        if(item_id === 'new')
        {
            
            $scope.edit = true;
            $scope.clearForm();
        }
        else
        {
            $scope.edit = false;
            
            //search product using product id
            var returnData = $.grep($scope.products,function(element,index){
            return (element.item_id == item_id && element.size_id == size_id);
            })
           
            $scope.item_id=parseInt(returnData[0].item_id);
            $scope.size_id=parseInt(returnData[0].size_id);
            $scope.quantity=parseInt(returnData[0].quantity);
            $scope.unit_price=parseInt(returnData[0].unit_price);
            $scope.cost_price=parseInt(returnData[0].avg_cost);
        } 
        
    }
    
     // create new or upadte product 
    $scope.createProduct = function(type){
        
        if(type === 'update')
        {
             
            var file = site_url+'/pos/items/ngEdit';
            //var file = 'http://khybersoft.com/accounts/index.php/pos/items/ngEdit';
        }
        else
        {
            var file = site_url+'/pos/items/ngCreate';
            //var file = 'http://khybersoft.com/accounts/index.php/pos/items/ngCreate';
        }
        
        // fields in key-value pairs
        $http.post(file, {
                'item_id' : $scope.item_id,
                'size_id' : $scope.size_id, 
                'quantity' : $scope.quantity,
                'cost_price' : $scope.cost_price, 
                'unit_price' : $scope.unit_price
                
            }
        ).then(function (response, status, headers, config) {
             
            alert('Successfully Updated'+response.data);
            // refresh the list
            $scope.getAllProducts();
            
        }).error(function(data){
            alert(data); 
        });
    }
});