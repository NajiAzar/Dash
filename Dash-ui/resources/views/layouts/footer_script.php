<script>
    $(document).ready(function(){
        $('.product_thumbnail_slides').owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            navText: [
                "<span class='nav-arrow prev-arrow'></span>",
                "<span class='nav-arrow next-arrow'></span>"
            ],
            autoplay: true,
            autoplayTimeout: 3000
        });
    });
</script>
<script>
    // Define a JavaScript variable and assign the value from PHP
    const category_id = {{ $category_id ?? 'null' }};
    
    $(document).ready(function() {
        // Get the select element
        const $select = $('#sortByselect');

        // Listen for changes in the select element
        $select.change(function() {
            const selectedOption = $select.val();
            
            // Check if category_id is defined
            if (category_id) {
                // Redirect to the URL with the selected sort option and category_id
                window.location.href = `{{ route('frontend.products.index', ['category_id' => '']) }}/${category_id}?sort=${selectedOption}`;
            } else {
                // Redirect to the URL with the selected sort option only
                window.location.href = `{{ route('frontend.products.index', ['category_id' => '']) }}?sort=${selectedOption}`;
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        var slider = $(".slider-range-price");
        var minPrice = parseInt(slider.attr("data-min"));
        var maxPrice = parseInt(slider.attr("data-max"));

        slider.slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [minPrice, maxPrice],
            slide: function (event, ui) {
                $(".range-price").text(
                    "Range: $" + ui.values[0] + " - $" + ui.values[1]
                );
            }
        });
    });
</script>


