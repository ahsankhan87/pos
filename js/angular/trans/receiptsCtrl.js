////////////////////////////////////////////////////////
//THIS IS receipt CONTROLLER 
///////////////////////////////////////////////////////
app.controller('receiptsCtrl', function ($scope, $http) {

    $scope.exp_date = new Date();

    //get all products for sales
    $scope.getAllCustomers = function () {

        $http.get(site_url + '/pos/C_customers/get_act_customers_JSON').then(function (response) {

            $scope.allCustomers = response.data;
            // console.log(response);
        });
    }

    //clear All the cart
    $scope.clearCart = function () {
        $scope.receipt = {
            items: []
        };
    }

    //call the clear cart function to clear all product
    $scope.clearCart();

    /////////////////////
    $scope.isCust = 0;
    $scope.isSupp = 0;
    $scope.isBank = 0;
    //get all products
    $scope.get_ref_accounts = function (acc_code) {

        $http.get(site_url + '/pos/C_customers/get_customers_JSON/' + acc_code).then(function (response) {

            if (response.data.length > 0)//if customers has then load
            {
                $scope.ref_accounts = response.data;
                $scope.isCust = 1;
                $scope.isSupp = 0;
                $scope.isBank = 0;
                //console.log(data);
            }

        });

        $http.get(site_url + '/pos/Suppliers/get_suppliers_JSON/' + acc_code).then(function (response) {

            if (response.data.length > 0)//if Suppliers has then load
            {
                $scope.ref_accounts = response.data;
                $scope.isCust = 0;
                $scope.isSupp = 1;
                $scope.isBank = 0;
                //console.log(data);
            }
        });

        $http.get(site_url + '/pos/C_banking/get_banks_JSON/' + acc_code).then(function (response) {

            if (response.data.length > 0)//if Suppliers has then load
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

    $scope.ref_id = '';
    //Add product to purchasing cart
    $scope.addItem = function (id) {

        //search receipts using exp id
        var returnData = $.grep($scope.allCustomers, function (element, index) {
            return element.id == id;
        })

        $scope.receipt.items.push({
            id: parseInt(returnData[0].id),
            account_code: returnData[0].account_code,
            title: returnData[0].first_name,
            name: returnData[0].last_name,
            tax_id: 0,
            description: '',

        });
    }

    // Save receipt 
    $scope.savereceipts = function () {
        var confirmSale = confirm('Are you sure you want to save?');

        if (confirmSale) {

            if ($scope.receipt.items.length > 0) {
                if ($scope.cash_account == 0 || $scope.cash_account == undefined) {
                    alert('please select cash account');
                }
                else {
                    $scope.cart_loader = true;//show loader gif

                    //collect all cart info and submit to db
                    $scope.receipt = {
                        cash_account: $scope.cash_account,
                        credit_account: $scope.credit_account,
                        narration: $scope.narration,
                        exp_date: $scope.exp_date,
                        supplier_invoice_no: $scope.supplier_invoice_no,
                        isCust: $scope.isCust,
                        isSupp: $scope.isSupp,
                        isBank: $scope.isBank,
                        ref_id: $scope.ref_id,

                        ref_name: $("#ref_id option:selected").text(),

                        items: $scope.receipt.items
                    };
                    ///////

                    var file = site_url + '/trans/C_receipts/savereceipts';

                    // fields in key-value pairs
                    $http.post(file, $scope.receipt).then(function (response) {

                        console.log(response.data);
                        alert('Successfully Received');
                        // refresh and clear the cart
                        $scope.clearCart();
                        $scope.cart_loader = false;//hide loader gif
                        //$scope.cash_account = 0;
                        $scope.narration = '';

                    });
                }
            } else {
                alert('Please select receipt account');
            }
        }//confirm msg
    }
    ///// end sale product 

    //delete item from cart
    $scope.removeItem = function (index) {
        $scope.receipt.items.splice(index, 1);
    },

        //get total of the cart products
        $scope.total = function () {

            var total = 0;
            angular.forEach($scope.receipt.items, function (item) {
                total += item.amount + (item.tax_id * item.amount / 100);
            })
            // console.log(total);
            return parseFloat(total).toFixed(2);
        }

});