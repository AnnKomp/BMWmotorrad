<!-- resources/views/partial-views/equipment-photos.blade.php -->



<div class="slider-container">
    <div class = 'slider'>
    @foreach ($equipement_pics as $pic)
        <img src={{$pic->lienmedia}}>
    @endforeach
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.slider').slick({
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
        });
    });

</script>



{{--
<script>
    // This JavaScript code assumes you are using jQuery
    // Make sure to include jQuery in your main layout or page

    $(document).ready(function () {
        // Change images when coloris selection changes
        $('#coloris').change(function () {
            var selectedColor = $(this).val();

            // Make an AJAX request to fetch images based on the selected coloris
            $.ajax({
                url: '{{ route('fetch-equipment-photos') }}', // Replace with your actual route
                method: 'POST',
                data: {
                    idequipement: {{ $idequipement }},
                    idcoloris: selectedColor
                },
                success: function (data) {
                    // Update the equipment-photos div with the new images
                    $('#equipment-photos').html(data);
                },
                error: function () {
                    console.error('Error fetching equipment photos.');
                }
            });
        });
    });
</script> --}}
