@extends('layouts.menus')

@section('title', 'Equipements')

<link rel="stylesheet" type="text/css" href="{{ asset('css/equipement.css') }}" />

@section('content')
    <h1>{{ $nomequipement }}</h1>

    <div class="description">{{ $descriptionequipement }}</div>

    <div class="slider-container" data-idequipement="{{ $idequipement }}">
        <div class='slider'>
            @foreach ($equipement_pics as $pic)
                <img src={{ $pic->lienmedia }}>
            @endforeach
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        console.log('Script is running !');

        $(document).ready(function () {

            $('.slider').slick({
                prevArrow: '<button type="button" class="slick-prev"></button>',
                nextArrow: '<button type="button" class="slick-next"></button>',
            });

            $('#coloris').change(function () {
                var selectedColor = $(this).val();
                var idequipement = $('.slider-container').data('idequipement');

                // Make an AJAX request to get updated photos based on the selected coloris
                $.get("/equipement-photos/" + idequipement + "/" + selectedColor)
                    .done(function(data) {
                        // Log the data to the console to check if the response is as expected
                        console.log(data);

                        // Update the slider with the new photos
                        $('.slider').slick('unslick').empty();
                        data.equipement_pics.forEach(function(pic) {
                            $('.slider').append('<img src="' + pic.lienmedia + '">');
                        });
                        $('.slider').slick({
                            prevArrow: '<button type="button" class="slick-prev"></button>',
                            nextArrow: '<button type="button" class="slick-next"></button>',
                        });
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        // Log detailed error information
                        console.error("Failed to fetch equipement photos.", jqXHR.status, textStatus, errorThrown);

                        // Display an error message to the user
                        alert("Failed to fetch equipement photos. Please try again later.");
                    });

                // Update the URL
                var newUrl = window.location.href.split('?')[0] + '?id=' + idequipement + '&idcoloris=' + selectedColor;
                history.replaceState(null, null, newUrl);
            });


            $('#coloris, #taille').change(function () {
                var selectedColor = $('#coloris').val();
                var selectedTaille = $('#taille').val();
                var idequipement = $('.slider-container').data('idequipement');

                // Make an AJAX request to get updated stock based on the selected coloris and taille
                $.get("/equipement-stock/" + idequipement + "/" + selectedColor + "/" + selectedTaille)
                    .done(function(data) {
                        // Log the data to the console to check if the response is as expected
                        console.log(data);

                        // Update the stock and quantity input
                        $('#stock').text('Stock: ' + data.stock);
                        $('#quantity').attr('max', data.stock).val(1);
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        // Log detailed error information
                        console.error("Failed to fetch equipement stock.", jqXHR.status, textStatus, errorThrown);

                        // Display an error message to the user
                        alert("Failed to fetch equipement stock. Please try again later.");
                    });
            });

        });

    </script>

    <h3 id=price>Prix : {{ $prixequipement }} €</h3>
    {{-- faire en sorte de le stock change en tant que les photos --}}
    <h3 id=stock>Stock : {{ $stock }}</h3>

    <form id="addToCartForm">
        @csrf

        @if ($stock && $stock >0)

            <div class="options-container">
                <div class="option-section">
                    <h3>Choix taille :</h3>
                    <select name="taille" id="taille">
                        @foreach ($tailleOptions as $tailleOption)
                            <option value="{{ $tailleOption->idtaille }}">{{ $tailleOption->libelletaille }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="option-section">
                    <h3>Choix coloris :</h3>
                    <select name="coloris" id="coloris">
                        @foreach ($colorisOptions as $colorisOption)
                            <option value="{{ $colorisOption->idcoloris }}">{{ $colorisOption->nomcoloris }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <label for="quantity">Quantité :</label>
            {{-- faire en sorte de le stock change en tant que les photos et redevient 1--}}
            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $stock }}" oninput="validateQuantity()">
            <p id="errorMessage" style="color: red;"></p>


            <button type="button" id="addToCartButton">Ajouter dans le panier</button>
        @else
            <p>Stock épuisé</p>
        @endif
    </form>




    <script>
        function validateQuantity() {
            var quantityInput = document.getElementById('quantity');
            var errorMessage = document.getElementById('errorMessage');
            var maxStock = parseInt(quantityInput.getAttribute('max'));
            var enteredQuantity = parseInt(quantityInput.value);
            var addToCartButton = document.getElementById('addToCartButton');

            if (isNaN(enteredQuantity) || enteredQuantity < 1 || enteredQuantity > maxStock) {
                errorMessage.innerText = 'Veuillez entrer une quantité valide.';
                addToCartButton.disabled = true;
                return false; // Return false to indicate validation failure
            } else {
                errorMessage.innerText = '';
                addToCartButton.disabled = false;
                return true; // Return true to indicate validation success
            }
        }

        $(document).ready(function () {

            $('#quantity').on('input', validateQuantity);

            $('#addToCartButton').click(function () {
                if (validateQuantity()) {
                    // Use AJAX to send the form data to the server
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('panier.add-to-cart', ['id' => $idequipement]) }}",
                        data: $('#addToCartForm').serialize(),
                        success: function (response) {
                            // Update the cart dynamically if needed
                            console.log(response);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>

@endsection
