<button name="filter_submit" id="{{ $prefix }}_reset_filter" value="reset" class="btn btn-danger"><span class="fa fa-times"></span> @lang('laravel_eloquent_filter::filter.reset')</button>
<script>
    (function () {
        var resetButton = document.getElementById("{{ $prefix }}_reset_filter");
        resetButton.addEventListener('click', function (e) {
            var inputs = document.querySelectorAll('[data-eloquent-filter][name*={{ $prefix }}_]');
            inputs.forEach(function (input) {
                input.value = null;
            });
        });
    })();
</script>