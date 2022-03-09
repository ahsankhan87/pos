app.controller('editEntriesCtrl', function($scope,$http,$timeout) {
    
    //var site_url = 'http://localhost/pos_new/index.php';
    $scope.tran_date = new Date();
    
    //get all products
    $scope.getAllDetailAccounts= function(){
     
     $scope.loader = true;//show loader gif
     
        $http.get(site_url+'/accounts/C_groups/get_detailAccountsJSON').then(function(response){
      //$http.get('http://khybersoft.com/accounts/index.php/pos/items/get_allItems').then(function(response){
        
        $scope.loader = false;//show loader gif
        $scope.detail_accounts = response.data;
        //console.log(response);
        });
    }
    
    //clear All the cart
    $scope.editEntryList = function(invoice_no=null, edit=false)
    {   
        if(edit == true)
           {
                $http.get(site_url+'/accounts/C_entries/get_entry_by_invoiceNo/'+invoice_no).then(function(response){

                console.log(response.data);
                $timeout(function(){
                    
                //find the player
                angular.forEach(response.data, function (returnData, index) {
                    
                    
                    $scope.entries.items.push({
                        invoice_no: returnData.invoice_no,
                        dr_amount:parseFloat(returnData.debit),
                        cr_amount:parseFloat(returnData.credit),
                        title: returnData.title,
                        title_ur: returnData.title_ur,
                        title_ar: returnData.title_ar,
                        account: returnData.account_code,
                        narration: returnData.narration,
                        ref_id:returnData.ref_account_id,
                        ref_name: returnData.customer_store_name+returnData.supplier_name+returnData.bank_name,
                    
                        isCust:parseInt(returnData.is_cust),
                        isSupp:parseInt(returnData.is_supp),
                        isBank:parseInt(returnData.is_back),
                    });
                    
                        
                });
                
                });//$timeout
               
                console.log($scope.entries);
            });

           }
       else
           {
            $scope.entries = {
            items: []
                };
           }
    }
    
    //call the clear cart function to clear all product
    $scope.editEntryList();
    
    $scope.ref_id='';
    
     //Add product to Sales cart
    $scope.addItem1 = function(account) {
        
        //alert($scope.account);
         if($scope.account == '' || $scope.account == undefined)
            {
                alert('please select dr account');
            }
            else
            {   
                //GET ACCOUNT NAME
                var dr_returnData = $.grep($scope.detail_accounts, function(item) {
                    return (item.account_code == account);
                })
                //console.log(dr_returnData);
                
               $scope.entries.items.push({
                    dr_amount: parseFloat(0),
                    cr_amount: parseFloat(0),
                    dr_entry:true,
                    cr_entry:false,
                    account: $scope.account,
                    title: dr_returnData[0].title,
                    title_ur: dr_returnData[0].title_ur,
                    narration:$scope.narration,
                    ref_id:$scope.ref_id,
                    ref_name: $("#ref_id option:selected").text(),
                    isCust:$scope.isCust,
                    isSupp:$scope.isSupp,
                    isBank:$scope.isBank
                });
                
                //console.log($scope.entries.items);
                
                $scope.account = '';
                $scope.narration = '';
                //$scope.amount = '';
                $scope.ref_id='';
                $scope.ref_accounts=[];
    
            }
                
    }
    
    //Add product to Sales cart
    
     //delete item from cart
    $scope.removeItem = function(index) {
        $scope.entries.items.splice(index, 1);
    }
    
    // Sale products 
    $scope.saleEntries = function(){
        
        var confirmSale = confirm('Are you absolutely sure you want to save entries?');
        
        if (confirmSale) {
            
        if($scope.entries.items.length > 0)
        {
           if($scope.total_amount_dr == 0 && $scope.total_amount_cr ==0)
            {
                alert('please enter amount cant be zero');
            }
            else if($scope.total_amount_dr !== $scope.total_amount_cr)
            {
                alert('Total Balance must be equal.');
            }
            else
            { 
             $scope.cart_loader = true;//show loader gif
                
                 //collect all cart info and submit to db
                $scope.entries = {
                    entry_no:($scope.entry_no == undefined ? '' : $scope.entry_no),
                    tran_date: $scope.tran_date,
                    dr_total: $scope.total_amount_dr,
                    cr_total:$scope.total_amount_cr,
                    //description : $scope.narration,
                    
                    items: $scope.entries.items
                    };
                 ///////
                 
                 
                 var file = site_url+'/accounts/C_entries/saveJournalEntries/'+1+'/'+$scope.invoice_no;
                 
                // fields in key-value pairs
                $http.post(file, $scope.entries).then(function (response, status, headers, config) {
                     
                    alert('Entry saved successfully');    
                    //console.log(response.data);
                    //window.location = site_url+"/accounts/C_entries/receipt/"+data.invoice_no; 
                    // refresh and clear the cart
                    $scope.cart_loader = false;//hide loader gif
                    $scope.editEntryList();
                   // $scope.getAllProduct(); 
                   //if(data.invoice_no == 'no-posting-type')
//                   {
//                     alert('Please assign posting type to customer otherwise amount will not be posting to accounts');
//                     window.location = site_url+"/trans/C_sales";
//                   }else
//                   {
                      //window.location = site_url+"/trans/C_sales/receipt/"+data.invoice_no; 
                   //}
                   
                    
                }).error(function(response){
                        console.log(response.data);
                        alert(response.data); 
                    });
                    
             }
            
        }
        else
        {
            alert('Please select product');
        }
        
        }//confirm msg
    }
    ///// end sale product 
    
    //get total of the cart products
    $scope.total_cr = function() {
        var total = 0;
        angular.forEach($scope.entries.items, function(item) {
            total += item.cr_amount;
        })
        $scope.total_amount_cr = total.toFixed(2);
        
        return total.toFixed(2);
    }
    
    //get total of the cart products
    $scope.total_dr = function() {
        var total = 0;
        angular.forEach($scope.entries.items, function(item) {
            total += item.dr_amount;
        })
        $scope.total_amount_dr = total.toFixed(2);
        
        return total.toFixed(2);
    }
    
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
    
    //get all products for sales
    $scope.getCustomerCurrency = function(customer_id){
       
        $scope.loader = true;//show loader gif
       //INITIALIZE
        $scope.customer_currency_id = 0;
        $scope.customer_currency_code = '';
        $scope.customer_currency_name = '';
        $scope.customer_currency_symbol = '';
        
        $http.get(site_url+'/trans/C_sales/getCustomerCurrencyJSON/'+customer_id).then(function(response){
        
        $scope.customer_currency_id = parseInt(response.data[0].id);
        $scope.customer_currency_code = response.data[0].code;
        $scope.customer_currency_name = response.data[0].name;
        $scope.customer_currency_symbol = response.data[0].symbol;
        //console.log(data);
        
        $http.get(site_url+'/pos/C_currencies/currency_rate/'+$scope.customer_currency_code).then(function(response){
        
        $scope.exchange_rate = parseFloat(response.data);
        //console.log(data);
            });
        
        });
        $scope.loader = false;//hide loader gif
    }
    
    //ADD DOUBLE ENTRY IN CART
    //$scope.addItem = function(dr_account,cr_account) {
//        
//        //alert($scope.account);
//         if($scope.dr_account == '' || $scope.dr_account == undefined)
//            {
//                alert('please select dr account');
//            }
//            else if($scope.cr_account == '' || $scope.cr_account == undefined)
//            {
//                alert('please select cr account');
//            }
//            else
//            {   
//                //GET ACCOUNT NAME
//                var dr_returnData = $.grep($scope.detail_accounts, function(item) {
//                    return (item.account_code == dr_account);
//                })
//                //console.log(dr_returnData);
//                
//               $scope.entries.items.push({
//                    dr_amount: parseFloat($scope.amount),
//                    cr_amount: parseInt(0),
//                    dr_entry:true,
//                    cr_entry:false,
//                    dr_account: $scope.dr_account,
//                    cr_account: $scope.cr_account,
//                    title: dr_returnData[0].title,
//                    title_ur: dr_returnData[0].title_ur,
//                    narration:$scope.narration,
//                    customer_id:$scope.customer_id
//                    
//                });
//                
//                //GET ACCOUNT NAME
//                var cr_returnData = $.grep($scope.detail_accounts, function(item) {
//                    return (item.account_code == cr_account);
//                })
//                //console.log(cr_returnData);
//                
//                $scope.entries.items.push({
//                    dr_amount: parseInt(0),
//                    cr_amount: parseFloat($scope.amount),
//                    dr_entry:false,
//                    cr_entry:true,
//                    dr_account: $scope.dr_account,
//                    cr_account: $scope.cr_account,
//                    title: cr_returnData[0].title,
//                    title_ur: cr_returnData[0].title_ur,
//                    narration:$scope.narration,
//                    customer_id:$scope.customer_id
//                });
//                
//                console.log($scope.entries.items);
//                
//                $scope.dr_account = '';
//                $scope.cr_account = '';
//                $scope.narration = '';
//                $scope.amount = '';
//                
//            }     
//    }
});