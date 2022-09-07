<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DAPI Testing</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>var baseURL = '{{url('')}}'; var _token = '{{csrf_token()}}';</script>
  </head>
  <body>
    <div
      style="display: flex; flex-direction: column; flex: 1; justify-content: center; align-items: center; width: 100%; height: 100%"
    >
      <h1>Client Website!!</h1>
      @if (Session::has('dapiAccess'))
      <a
      style="height: 2rem;width: 20rem;background: beige;border: 1px solid black; margin-top: 2rem;"
      href="{{route('dislink.user')}}"
    >
      Disconnect
    </a>
    @php
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    @endphp
      @else
      <button
        style="height: 2rem;width: 20rem;background: beige;border: 1px solid black; margin-top: 2rem;"
        onclick="clickMe()"
      >
        Login Now
      </button>
      @endif
    </div>
    <script src="https://cdn.dapi.com/connect/v3/connector.js"></script>
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
    </script>
   {{-- <script src="https://cdn.dapi.co/dapi/v2/sdk.js"></script>
    <script>
        let connectLoading = true;
        var ba = null;
        // var transfer = {
        //   senderID: "",
        //   amount: 0,
        //   remarks: "",
        //   beneficiary: {
        //     name: "Mohammad Omar Amr",
        //     nickname: "Mohammad Omar LIV",
        //     iban: "DAPIBANKAELIV1619116273261987517393",
        //     accountNumber: "1619116273261987517393",
        //     swiftCode: "DAPIBANK_AE_LIV",
        //     address: {
        //         line1: "Maryam Street",
        //         line2: "Abu Dhabi",
        //         line3: "United Arab Emirates"
        //     },
        //     country: "AE",
        //     branchAddress: "Dubai Mall",
        //     branchName: "Main Branch"  
        //   }
        // }

        var handler = Dapi.create({
        environment: Dapi.environments.sandbox, //or .production
        appKey: "0cda695a3fdfdd74d9b09c30961c3c636f5f57c6221fb40a53c87ae383f4d33d", 
        countries: ["AE"],
        bundleID: "solus.dev", // bundleID you set on Dashboard
        clientUserID: "01",  
        isCachedEnabled: true,
        isExperimental: false,
        clientHeaders: {},
        clientBody: {},
        onSuccessfulLogin: function(bankAccount) {
            ba = bankAccount; //explained in the next step
            ba.data.getIdentity()
            .then((identityResponse)=>{
            if (identityResponse.status === "done") {
                console.log(identityResponse.identity)
                } else {
                console.error("API Responded with an error")
                console.dir(identityResponse)
                }
            })
            // ba.data.getAccounts()
            // .then(payload => {

            //     ba.showAccountsModal(
            //     "Your message to the user",
            //     payload.accounts,
            //     (account) => {
            //         console.dir(account)
            //     },
            //     () => {
            //         console.dir("User Cancelled")
            //     })
            // })
            //for auto payment
            // ba.payment.transferAutoflow(transfer)
            // .then(transferResponse => {
            //   if(transferResponse.status === "done") {
            //     console.dir(transferResponse)
            //   } else {
            //     console.error("API Responded with an error")
            //     console.dir(transferResponse)
            //   }
            // })
            // .catch(error => {
            //     console.dir(error)
            // })
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