<!-- resources/views/partial-views/equipment-photos.blade.php -->

<meta name="csrf-token" content="{{ csrf_token() }}">


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



