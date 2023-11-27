$(document).ready(function () {
    // Stocke la largeur d'origine des éléments
    var originalWidth = $('.equipement_lien').css('width');

    $('#search-button').click(function () {
        var query = $('#search-input').val().toLowerCase();

        // Réinitialise tous les éléments en supprimant la classe 'hidden'
        $('.equipement_box').removeClass('hidden');

        // Cache les éléments qui ne correspondent pas à la recherche
        $('.equipement_box').each(function () {
            var equipementName = $(this).find('.equipement_name').text().toLowerCase();

            if (!equipementName.includes(query)) {
                $(this).addClass('hidden');
            }
        });

        // Réinitialise la disposition après la recherche
        $('.equipement_wrapper').css('justify-content', 'flex-start');
        $('.equipement_wrapper').css('flex-wrap', 'wrap');

        // Ajuste la disposition après la recherche si des éléments sont cachés
        if ($('.equipement_box.hidden').length > 0) {
            $('.equipement_wrapper').css('justify-content', 'flex-end');
            $('.equipement_wrapper').css('flex-wrap', 'wrap');

            // Ajuste la largeur des éléments en fonction du nombre d'éléments cachés
            var hiddenCount = $('.equipement_box.hidden').length;
            var newWidth = 'calc(20% - ' + (20 * hiddenCount) + 'px)';
            $('.equipement_lien:not(.hidden)').css('width', newWidth);
        } else {
            // Réinitialise la taille des éléments si aucun élément n'est caché
            $('.equipement_lien').css('width', originalWidth);
        }
    });
});
