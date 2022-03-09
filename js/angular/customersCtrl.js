app.controller('customersCtrl', function($scope,$http) {
    
    $scope.payment_date = new Date();
    
      $scope.GetCreditSales = function(customer_id)
      {
        $http.get(site_url+'/pos/C_customers/getCreditSalesJSON/'+customer_id).then(function(response){
       
        $scope.CreditSales = [];
        
        if(response.data.length > 0)
        {
            //$scope.disable = false;
            var total = 0;
            
            angular.forEach(response.data, function(returnData,index) {
            //$scope.amount1 = ((returnData.total_amount-returnData.paid)*returnData.exchange_rate)-$scope.amount;
            
            if($scope.multi_currency === 1)
            {
                var bal = ((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
            
            }else{
                var bal = ((returnData.total_amount-returnData.paid));
            
            }
            //var bal = ((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
            total += bal;
            
            $scope.CreditSales.push({
                        invoice_no: returnData.invoice_no,
                        total_amount: returnData.total_amount,
                        paid: returnData.paid,
                        exchange_rate: returnData.exchange_rate,
                        balance:parseFloat(bal.toFixed(2)),
                        customer_id: parseInt(returnData.customer_id),
                        currency_id: returnData.currency_id,
                        account: returnData.account,
                        company_id: returnData.company_id,
                        comment: returnData.comment,
                        sale_date: returnData.sale_date,
                        cr_amount: parseFloat(bal.toFixed(2)),
                        credit_amount:$scope.credit_amount
                    });
            
            })
            
            $scope.amount = total.toFixed(0);
        }else
        {
            //$scope.disable = true;
        }
        

        //console.log($scope.CreditSales);
        });
      }
      
      $scope.update = function(){
        
        var amount = $scope.amount == '' ? 0 : $scope.amount;
        
        //var creditAmount = 0;
        angular.forEach($scope.CreditSales, function(returnData,index) {
            
            //PREV BALANCE
            if($scope.multi_currency === 1)
            {
                var cr_balance = ((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
            
            }else{
                var cr_balance = ((returnData.total_amount-returnData.paid));
            
            }
            //var cr_balance = ((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
            //console.log(cr_balance);
            
            var bal = amount;
            
            //console.log(bal);
            
            if(bal > cr_balance)
            {
                bal = cr_balance.toFixed(2);
            }else if(bal < cr_balance){
                bal = amount;
            }
            
            $scope.CreditSales.splice(index,1,{
                        invoice_no: returnData.invoice_no,
                        total_amount: returnData.total_amount,
                        paid: returnData.paid,
                        exchange_rate: returnData.exchange_rate,
                        balance:parseFloat(bal),
                        customer_id: parseInt(returnData.customer_id),
                        currency_id: returnData.currency_id,
                        account: returnData.account,
                        company_id: returnData.company_id,
                        comment: returnData.comment,
                        sale_date: returnData.sale_date,
                        cr_amount: parseFloat(bal),
                        credit_amount:$scope.credit_amount
                    });
                    
            if($scope.multi_currency === 1)
            {
                bal = amount-((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
            
            }else{
                bal = amount-((returnData.total_amount-returnData.paid));
            
            }        
            //bal = amount-((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
            
            if(bal >0)
            {
                amount = bal.toFixed(2);
            }else{
                amount=0;
            }
            
            
        })

        
      }
      
    //get total of the cart products
    $scope.total = function() {
        var total = 0;
        angular.forEach($scope.CreditSales, function(item) {
            total += item.cr_amount;
        })
        $scope.amount = total.toFixed(2);
        
        return total.toFixed(2);
    }
    
      $scope.saveCustomerPayment = function(){
        
        if($scope.exchange_rate < 0)
        {
            alert("Please enter exchange rate");
        }
        else
        {
             $scope.squad_loader = true;//show loading gif
             
            //collect all cart info and submit to db
            $scope.creditInvoices = {
                payment_type:$scope.payment_type,
                bank_id : ($scope.bank_id == '' ? 0 :$scope.bank_id),
                customer_id: $scope.customer_id,
                amount:$scope.amount,
                exchange_rate : $scope.exchange_rate,
                discount_amount:($scope.discount_amount == '' ? 0 : $scope.discount_amount),
                narration : ($scope.comment== '' ? '' :$scope.comment),
                
                creditSales: $scope.CreditSales
                
                };
             ///////
             
             var file = site_url+'pos/C_customers/ngMakePayment';
             
            // fields in key-value pairs
            $http.post(file, $scope.creditInvoices).then(function (response, status, headers, config) {
            
            $scope.squad_loader = false;//hide loading gif
            //alert(data);    
              //console.log(data);  
            //window.location = site_url+"pos/C_customers/";
                
            }).error(function(data){
                    console.log(data); 
                    //$scope.clearCart();
                });
        }
    }
    
    
});