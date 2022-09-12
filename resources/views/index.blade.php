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
              <div id="widget"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center" id="payFunc" style="display:none;">
        <div class="col-md-2">
          <input type="text" name="curr_balance" id="curr_balance" class="form-control" readonly>
          <button type="button" class="btn btn-primary" id="btn_bal" onClick="showBalance();">Show Balance</button>
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
          <button type="button" class="btn btn-primary" id="btn_show" onClick="showBeneficiary();">Show Beneficiary</button>
          <div id="beneficiary_list"></div>
        </div>
        
      </div>
    </section>
    <div class="modal fade" id="beneficiaryModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Beneficiary Form</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="#" method="POST" id="frmEmp">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="fname">Full name</label>
                    <input type="text" name="fname" id="fname" value="" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" name="nickname" id="nickname" value="" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="bcountry">Country</label>
                <input type="text" name="bcountry" id="bcountry" class="form-control" value="United Arab Emirates" required>
              </div>
              <div class="form-group">
                <label for="bcity">City</label>
                <input type="text" name="bcity" id="bcity" class="form-control" value="Abu Dhabi" required>
              </div>
              <div class="form-group">
                <label for="baddress">Street Address</label>
                <input type="text" name="baddress" id="baddress" class="form-control" value="Maryam Street" required>
              </div>
              <h5>Bank Details</h5>
              <hr>
              <div class="form-group">
                <label for="biban">IBAN</label>
                <input type="text" name="biban" id="biban" class="form-control" value="DAPIBANKAEMSHRQB1662990143750835525698" required>
              </div>
              <div class="form-group">
                <label for="accNum">AccountNumber</label>
                <input type="number" name="accNum" id="accNum" class="form-control" value="1662990143750835525698" required>
              </div>
              <div class="form-group">
                <label for="swift_code">SWIFT Code</label>
                <input type="text" name="swift_code" id="swift_code" class="form-control" value="DAPIBANK_AE_LIV" required>
              </div>
              <div class="form-group">
                <label for="bank_name">Bank Name</label>
                <input type="text" name="bank_name" id="bank_name" class="form-control" value="United Arab Bank" required>
              </div>
              <div class="form-group">
                <label for="branch_name">Branch Name</label>
                <input type="text" name="branch_name" id="branch_name" class="form-control" value="Main Branch" required>
              </div>
              <div class="form-group">
                <label for="branch_country">Country</label>
                <input type="text" name="branch_country" id="branch_country" class="form-control" value="United Arab Emirates" required>
              </div>
              <div class="form-group">
                <label for="branch_address">Branch Address</label>
                <input type="text" name="branch_address" id="branch_address" class="form-control" value="Dubai Mall" required>
              </div>
              <div class="form-group">
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id="btn_add">Add</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
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
              showBalance();
          },
          onFailedLogin: function(err) {
              if (err != null) {
              console.log("Failed Login Error");
              console.log(err);
              $('#widget').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+err.responseJSON.message+'</div>');
              } else {
              console.log("No error");
              }
          },
          onReady: function() {
            console.log("Ready!"),
            connectLoading = false;
            $('#widget').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Ready!</div>');
              //handler.open(); // opens the Connect widget
          },
          onExit: function() {
              console.log("User exited the flow")
              $('#widget').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>User exited the flow</div>');
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
                $('#widget').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Widget is loading. Please wait!</div>');
                console.error("Widget is loading. Please wait!");
            }
        };

        function showBalance() {
          $('#btn_bal').html('<span class="spinner-border spinner-border-sm"></span> Loading..');
          $('#btn_bal').attr('disabled', true);
          if(ba != null){
            ba.data.getAccounts()
              .then(payload => {
                $('#btn_bal').html('Show Balance');
                $('#btn_bal').removeAttr('disabled');
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
          
        }
        function showBeneficiary() {
          $('#btn_show').html('<span class="spinner-border spinner-border-sm"></span> Loading..');
          $('#btn_show').attr('disabled', true);
          $('#beneficiary_list').html("");
          ba.payment.getBeneficiaries()
              .then(benefResponse => {
                $('#btn_bal').html('Show Beneficiaries');
                $('#btn_bal').removeAttr('disabled');
                if(benefResponse.status === "done") {
                  console.dir(benefResponse)
                  $('#btn_show').html('Show Beneficiary');
                  $('#btn_show').removeAttr('disabled');
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
                  $('#btn_show').html('Show Beneficiary');
                  $('#btn_show').removeAttr('disabled');
                }
              })
              .catch(error => {
                $('#btn_bal').html('Show Beneficiaries');
                $('#btn_bal').removeAttr('disabled');
                console.dir(error)
            })
        }
        function addBeneficiary() {
          $('#frmEmp')[0].reset();
          $('#beneficiaryModal').modal('show');
        }
        $('#frmEmp').on('submit', (e)=>{
          e.preventDefault();
          $('#btn_add').html('<span class="spinner-border spinner-border-sm"></span> Loading..');
          $('#btn_add').attr('disabled', true);
          var beneficiary = {
            name: $('#fname').val(),
              nickname: $('#nickname').val(),
            iban: $('#biban').val(),
            accountNumber: $('#accNum').val(),
            type: "local",
            swiftCode: $('#swift_code').val(),
            address: {
                line1: $('#baddress').val(),
                line2: $('#bcity').val(),
                line3: $('#bcountry').val()
            },
            country: $('#branch_country').val(),
            branchAddress: $('#branch_address').val(),
            branchName: $('#branch_name').val()  
          }
          $('#beneficiary_msg').html("");
          ba.payment.createBeneficiary(beneficiary)
              .then(benefResponse => {
                $('#btn_add').html('Add');
                $('#btn_add').removeAttr('disabled');
                $('#beneficiaryModal').modal('hide');
                if(benefResponse.status === "done") {
                  console.dir(benefResponse)
                  showBeneficiary();
                  $('#beneficiary_msg').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Beneficiary has been successfully added</div>');
                } else {
                  console.error("API Responded with an error")
                  console.dir(benefResponse)
                  $('#beneficiary_msg').html('<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+benefResponse.msg+'</div>');
                }
              })
              .catch(error => {
                $('#beneficiaryModal').modal('hide');
                console.dir(error)
            })
        });


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
                $('#payment_msg').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Payment success</div>');
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