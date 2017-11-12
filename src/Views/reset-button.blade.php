<button value="true" class="btn btn-danger {{ $prefix }}_reset_form">@lang('laravel_eloquent_filter::filter.reset')</button>
<script>
    (function () {
        var resetButton = document.scripts[document.scripts.length - 1].parentNode.getElementsByClassName("{{ $prefix }}_reset_form")[0];
        resetButton.addEventListener('click', function (e) {
            var inputs = document.querySelectorAll('[name*={{ $prefix }}_]');
            inputs.forEach(function (input) {
                input.value = null;
            });
        });
    })();
</script>