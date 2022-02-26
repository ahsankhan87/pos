app.controller('suppliersCtrl', function($scope,$http) {
        
    $scope.payment_date = new Date();
    
      $scope.GetCreditPurchase = function(supplier_id)
      {
        $http.get(site_url+'/pos/Suppliers/getCreditPurchasesJSON/'+supplier_id).then(function(response){
       
        $scope.CreditPurchase = [];
        
        if(response.data.length > 0)
        {
            $scope.disable = false;
            var total = 0;
            
                angular.forEach(response.data, function(returnData,index) {
                    //$scope.amount1 = ((returnData.total_amount-returnData.paid)*returnData.exchange_rate)-$scope.amount;
                    
                    if($scope.multi_currency === 1)
                    {
                        var bal = ((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
                    
                    }else{
                        var bal = ((returnData.total_amount-returnData.paid));
                    }
                    total += bal;
                    
                    $scope.CreditPurchase.push({
                                invoice_no: returnData.invoice_no,
                                total_amount: returnData.total_amount,
                                paid: returnData.paid,
                                exchange_rate: returnData.exchange_rate,
                                balance:parseFloat(bal.toFixed(2)),
                                supplier_id: parseInt(returnData.supplier_id),
                                currency_id: returnData.currency_id,
                                account: returnData.account,
                                company_id: returnData.company_id,
                                comment: returnData.comment,
                                sale_date: returnData.receiving_date,
                                cr_amount: parseFloat(bal.toFixed(2)),
                                credit_amount:$scope.credit_amount
                            });
                    
                })
            $scope.amount = total.toFixed(2);
        }else
        {
            $scope.disable = true;
        }
        //console.log($scope.CreditPurchase);
        });
      }
      
      $scope.update = function(){
        
        var amount = $scope.amount;
        
        //var creditAmount = 0;
        angular.forEach($scope.CreditPurchase, function(returnData,index) {
            
            //PREV BALANCE
            if($scope.multi_currency === 1)
            {
                var cr_balance = ((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
            
            }else{
                var cr_balance = ((returnData.total_amount-returnData.paid));
            
            }
            //console.log(cr_balance);
            
            //CURRENT PAYMENT AMOUNT
            var bal = amount;
            
            //IF CURRENT AMOUNT IS > PREV BALANCE THE GET PREV TOTAL AMOUTN 
            //OTHERWISE GET CURRENT AMOUNT
            if(bal > cr_balance)
            {
                bal = cr_balance.toFixed(2);
            }else if(bal < cr_balance){
                bal = amount;
            }
            
            $scope.CreditPurchase.splice(index,1,{
                        invoice_no: returnData.invoice_no,
                        total_amount: returnData.total_amount,
                        paid: returnData.paid,
                        exchange_rate: returnData.exchange_rate,
                        balance:parseFloat(bal),
                        supplier_id: parseInt(returnData.supplier_id),
                        currency_id: returnData.currency_id,
                        account: returnData.account,
                        company_id: returnData.company_id,
                        comment: returnData.comment,
                        sale_date: returnData.sale_date,
                        cr_amount: parseFloat(bal),
                        credit_amount:$scope.credit_amount
                    });
            
            //SUBTRACT THE PREV BALANCE FROM CURRENT AMOUNT IF NOT ZERO
            
            if($scope.multi_currency === 1)
            {
                bal = amount-((returnData.total_amount-returnData.paid)*returnData.exchange_rate);
            
            }else{
                bal = amount-((returnData.total_amount-returnData.paid));
            
            }
                    
            if(bal > 0)
            {
                amount = bal.toFixed(2);
            }else{
                amount=0;
            }
            
        })
        //console.log($scope.CreditPurchase);
        
      }
      
      $scope.savesupplierPayment = function(){
        
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
                supplier_id: $scope.supplier_id,
                amount:$scope.amount,
                exchange_rate : $scope.exchange_rate,
                discount_amount:($scope.discount_amount == '' ? 0 : $scope.discount_amount),
                narration : ($scope.comment== '' ? '' :$scope.comment),
                
                creditPurchase: $scope.CreditPurchase
                
                };
             ///////
             
             var file = site_url+'pos/Suppliers/ngMakePayment';
             
            // fields in key-value pairs
            $http.post(file, $scope.creditInvoices).then(function (response, status, headers, config) {
            
            $scope.squad_loader = false;//hide loading gif
            //alert(data);    
              //console.log(data);  
            //window.location = site_url+"pos/C_suppliers/";
                
            }).error(function(data){
                    console.log(data); 
                    //$scope.clearCart();
                });
        }
    }
    
    
});