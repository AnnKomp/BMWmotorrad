<!DOCTYPE html>
<html>
<head>
    <title>BMW Motorrad Paiement Stripe</title>
    <link rel="stylesheet" href="/css/panier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="/js/popup.js"></script>
    <link rel="stylesheet" href="/css/popup.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<div class="container">
<button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Paiement par Stripe</h2>
        <p>Afin de payer votre commande, vous devez renseigner vos informations bancaires.</p>
        <img src="/img/guideimages/stripe.png" alt="" class="popupimg">
        <p>Pour valider la commande cliquez sur "Payer".</p>
        <img src="/img/guideimages/stripebutton.png" alt="" class="popupimg">
    </div>
</div>
    <h1>BMW Motorrad - Paiement Stripe</h1>

    <table>
            <tr>
                <th id=name>Nom</th>
                <th id=price>Prix</th>
                <th id=photo>Photo</th>
                <th id=coloris>xColoris</th>
                <th id=taille>Taille</th>
                <th id=quantity>Quantité</th>
            </tr>




        @foreach ($equipements as $equipement)
            @foreach ($cart[$equipement->idequipement] as $cartItem)
            <tr>
                <td id=name>{{ $equipement->nomequipement }}</td>
                <td id=price>{{ $equipement->prixequipement * $cartItem['quantity'] }} €</td>
                <td id=photo>
                    <img src="{{ $cartItem['photo']->lienmedia }}" alt="Equipement Photo" class="equipement-photo">
                </td>
                <td id=coloris>{{ $cartItem['coloris_name'] }}</td>
                <td id=taille>{{ $cartItem['taille_name'] }}</td>
                <td id=quantity>{{ isset($cartItem['quantity']) ? $cartItem['quantity'] : ''}}</td>
            </tr>
            @endforeach

        @endforeach
    </table>

    <h1>Frais de livraison</h1>
    <p>{{ $fee }} €</p>
    <h1>Total</h1>
    <p>{{ $total}} €</p>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <h2 class="panel-title" >Checkout Forms</h2>
                </div>
                <div class="panel-body">

                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                     <form id='checkout-form' method='post' action="{{ route('paymentstripe') }}">
                        @csrf
                        <input type='hidden' name='stripeToken' id='stripe-token-id'>
                        <br>
                        <div id="card-element" class="form-control" ></div>
                        <button
                            id='pay-btn'
                            class="btn btn-success mt-3"
                            type="button"
                            style="margin-top: 20px; width: 100%;padding: 7px;"
                            onclick="createToken()">Payer {{ $total }} €
                        </button>
                    <form>

                </div>
            </div>
        </div>
    </div>

</div>

</body>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">

    var stripe = Stripe('{{ env('STRIPE_KEY') }}')
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    /*------------------------------------------
    --------------------------------------------
    Create Token Code
    --------------------------------------------
    --------------------------------------------*/
    function createToken() {
        document.getElementById("pay-btn").disabled = true;
        stripe.createToken(cardElement).then(function(result) {

            if(typeof result.error != 'undefined') {
                document.getElementById("pay-btn").disabled = false;
                alert(result.error.message);
            }

            /* creating token success */
            if(typeof result.token != 'undefined') {
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById('checkout-form').submit();
            }
        });
    }
</script>

</html>
