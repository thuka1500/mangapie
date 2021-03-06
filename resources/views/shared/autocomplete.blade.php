<script type="text/javascript">
    $(function () {
        let baseUrl = '{{ \URL::to('/manga') }}';

        $('#searchbar').typeahead({
            minLength: 3,
            delay: 250,
            source: function (query, process) {
                return $.getJSON('{{ \URL::to('/search/autocomplete') }}', { query : query}, function (data) {
                    return process(data);
                });
            },
            followLinkOnSelect: true,
            itemLink: function (manga) {
                return baseUrl + '/' + manga.id;
            }
        });

        $('#searchbar-small').typeahead({
            minLength: 3,
            delay: 250,
            source: function (query, process) {
                return $.getJSON('{{ \URL::to('/search/autocomplete') }}', { query : query}, function (data) {
                    return process(data);
                });
            },
            followLinkOnSelect: true,
            itemLink: function (manga) {
                return baseUrl + '/' + manga.id;
            }
        });
    });
</script>
