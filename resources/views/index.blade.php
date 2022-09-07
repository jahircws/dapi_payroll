<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DAPI Testing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.32/dist/sweetalert2.all.min.js"></script>
    <script>var baseURL = '{{url('')}}'; var _token = '{{csrf_token()}}';</script>
  </head>
  <body>
    <section class="container py-5">
      <h2 class="text-center">Client Website</h2>
      <div class="row justify-content-center" id="login">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body text-center">
              <button type="button" class="btn btn-primary" onClick="dapiLogin();">Login now</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center" id="payFunc" style="display:none;">
        <div class="col-md-2">
          <input type="text" name="curr_balance" id="curr_balance" class="form-control" readonly>
          <button type="button" class="btn btn-primary" onClick="showBalance();">Show Balance</button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-primary" onClick="addBeneficiary();">Add Beneficiary</button>
          <div id="beneficiary_msg"></div>
        </div>
        <div class="col-md-2">
          {{-- <button type="button" class="btn btn-primary" onClick="payBeneficiary();">Pay Beneficiary</button> --}}
          <div id="payment_msg"></div>
        </div>
        <div class="col-md-6">
          <button type="button" class="btn btn-primary" onClick="showBeneficiary();">Show Beneficiary</button>
          <div id="beneficiary_list"></div>
        </div>
        
      </div>
    </section>
    <div class="modal fade" id="payoutModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Payroll Process</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="#" method="POST" id="frmPayout">
              <input type="hidden" name="receiverID" id="receiverID">
              <div class="form-group">
                <label for="accountNumber">Account Number</label>
                <input type="text" name="accountNumber" id="accountNumber" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="iban">IBAN</label>
                <input type="text" name="iban" id="iban" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" name="fullname" id="fullname" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
              </div>
              <div class="form-group">
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Payout</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.dapi.co/dapi/v2/sdk.js"></script>
    <script>
        let connectLoading = true;
        var ba = null;
        var senderID = null;
        console.log(ba)

        var handler = Dapi.create({
          environment: Dapi.environments.sandbox, //or .production
          appKey: "0cda695a3fdfdd74d9b09c30961c3c636f5f57c6221fb40a53c87ae383f4d33d", 
          countries: ["AE"],
          bundleID: "solus.dev", // bundleID you set on Dashboard
          clientUserID: "01",  
          isCachedEnabled: false,
          isExperimental: false,
          clientHeaders: {},
          clientBody: {},
          onSuccessfulLogin: function(bankAccount) {
              ba = bankAccount; 
              $('#login').hide();
              $('#payFunc').show();
          },
          onFailedLogin: function(err) {
              if (err != null) {
              console.log("Error");
              console.log(err);
              } else {
              console.log("No error");
              }
          },
          onReady: function() {
            console.log("Ready!"),
            connectLoading = false;
              //handler.open(); // opens the Connect widget
          },
          onExit: function() {
              console.log("User exited the flow")
          },
          onAuthModalOpen: function() {
            console.log("MFA modal opened")
            },
            onAuthModalSubmit: function() {
            console.log("MFA answer submitted")
            }
        });
        function dapiLogin() {
            if (!connectLoading) {
                handler.open();
            } else {
                console.error("Widget is loading. Please wait!");
            }
        };

        function showBalance() {
          ba.data.getAccounts()
              .then(payload => {

                ba.showAccountsModal(
                "Your message to the user",
                payload.accounts,
                (account) => {
                    console.dir(account)
                    $('#curr_balance').val(account.balance.currency.code+" "+account.balance.amount);
                    senderID = account.id;
                },
                () => {
                    console.dir("User Cancelled")
                })
            })
        }
        function showBeneficiary() {
          $('#beneficiary_list').html("");
          ba.payment.getBeneficiaries()
              .then(benefResponse => {
                if(benefResponse.status === "done") {
                  console.dir(benefResponse)
                  if(benefResponse.success){
                    if(benefResponse.beneficiaries.length > 0){
                      $.each(benefResponse.beneficiaries, (i, val)=>{
                        $('#beneficiary_list').append('<div class="card mb-2"><div class="card-header"><h4 class="card-title">'+val.name+'</h4></div><div class="card-body"><p>IBAN: '+val.iban+'<br>AccountNumber: '+val.accountNumber+'<br>Status: '+val.status+'<br>Type: '+val.type+'<br>IBAN: '+val.iban+'<br></p></div><div class="card-footer text-center"><button type="button" class="btn btn-info" onClick="setPayout(`'+val.iban+'`,`'+val.accountNumber+'`,`'+val.name+'`,`'+val.id+'`);">Payout Now</button></div></div>');
                      })
                    }else{
                      $('#beneficiary_list').html('Add your beneficiaries');
                    }
                  }else{
                    $('#beneficiary_list').html('Something went wrong.');
                  }
                  
                } else {
                  console.error("API Responded with an error")
                  console.dir(benefResponse)
                }
              })
              .catch(error => {
                console.dir(error)
            })
        }
        function addBeneficiary() {
          var beneficiary = {
            name: "Amit Sukla",
              nickname: "Amit",
            iban: "DAPIBANKAEMSHRQB1662531241437317563394",
            accountNumber: "1662531241437317563394",
            type: "local",
            swiftCode: "DAPIBANK_AE_LIV",
            address: {
                line1: "Maryam Street",
                line2: "Abu Dhabi",
                line3: "United Arab Emirates"
            },
            country: "United Arab Emirates",
            branchAddress: "Dubai Mall",
            branchName: "Main Branch"  
          }

          $('#beneficiary_msg').html("");
          ba.payment.createBeneficiary(beneficiary)
              .then(benefResponse => {
                if(benefResponse.status === "done") {
                  console.dir(benefResponse)
                  $('#beneficiary_msg').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Beneficiary has been successfully added</div>');
                } else {
                  console.error("API Responded with an error")
                  console.dir(benefResponse)
                  $('#beneficiary_msg').html('<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+benefResponse.msg+'</div>');
                }
              })
              .catch(error => {
                console.dir(error)
            })
        }


        $('#frmPayout').on('submit', (e)=>{
          e.preventDefault();
          $('#payment_msg').html("");
          var transfer = {
            senderID: senderID,
            receiverID: $('#receiverID').val(),
            accountNumber: $('#accountNumber').val(),
            name: $('#fullname').val(),
            iban: $('#iban').val(),
            amount: $('#amount').val(),
            remarks: "",
          };
          ba.payment.createTransfer(transfer)
            .then(transferResponse => {
              $('#payoutModal').modal('hide');
              if(transferResponse.status === "done") {
                console.dir(transferResponse)
              } else {
                console.error("API Responded with an error")
                console.dir(transferResponse)
                $('#payment_msg').html('<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+transferResponse.msg+'</div>');
              }
            })
            .catch(error => {
              console.dir(error)
          });
        });

        function setPayout(iban, accountNumber, name, receiverid) {
          $('#receiverID').val(receiverid);
          $('#iban').val(iban);
          $('#accountNumber').val(accountNumber);
          $('#fullname').val(name);
          $('#payoutModal').modal('show');
        }


        function payBeneficiary()
        {
          $('#payment_msg').html("");
          var transfer = {
            senderID: "ntV7rbYoexYaGDRfLCAo8vw1xXgu2VaXXtqvNoMU0sfy6aNErfUEGMD+P6lAlkzu/GKxPeoef7d7eNoxlHKyRw==",
            receiverID: "kSSWuq7RXww1VZpvF05KBfeiQxr8nb/uHQ35ZqSmhnp2gVoqZ7+DCnI/zRLzcg32myS/e8BLPhMJaT7mJ3z9Uw==",
            accountNumber: "1619116273261987517393",
            name: "Mohammad Omar Amr",
            iban: "DAPIBANKAELIV1619116273261987517393",
            amount: 10,
            remarks: "",
          };
          ba.payment.createTransfer(transfer)
            .then(transferResponse => {
              if(transferResponse.status === "done") {
                console.dir(transferResponse)
              } else {
                console.error("API Responded with an error")
                console.dir(transferResponse)
                $('#payment_msg').html('<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+transferResponse.msg+'</div>');
              }
            })
            .catch(error => {
              console.dir(error)
          });
          // ba.payment.transferAutoflow(transfer)
          //   .then(transferResponse => {
          //     if(transferResponse.status === "done") {
          //       console.dir(transferResponse)
          //     } else {
          //       console.error("API Responded with an error")
          //       console.dir(transferResponse)
          //       $('#payment_msg').html('<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+transferResponse.msg+'</div>');
          //     }
          //   })
          //   .catch(error => {
          //     console.dir(error)
          // })
        }
    </script>
    {{-- <script src="https://cdn.dapi.com/connect/v3/connector.js"></script>
    <script>
      var connectLoading = true;
      var handler = Dapi.create({
        environment: Dapi.environments.sandbox,
        appKey: '0cda695a3fdfdd74d9b09c30961c3c636f5f57c6221fb40a53c87ae383f4d33d',
        countries: ['AE'],
        isExperimental: false,
        onSuccess: (d) => {
          console.log(d)
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': _token
            },
            url: `${baseURL}/get-access-token`,
            method: 'POST',
            data: d,
            dataType: 'json',
            success: (respond)=>{
              console.log(respond)
              if(respond.status){
                alert('Your access token has been set and is validate for 30 mins.')
              }else{
                alert(respond.message)
              }
            },
            error: (err)=>{
              alert(err.responseJSON.message)
            }
          });
        },
        onFailure: (e) => console.log(e),
        onReady: (r) => {
          console.log("Ready!"),
          connectLoading = false;
          //handler.open()
        }
      });
      function clickMe() {
            if (!connectLoading) {
              handler.open();
            } else {
                console.error("Widget is loading. Please wait!");
            }
        };
    </script> --}}
  </body>
</html>