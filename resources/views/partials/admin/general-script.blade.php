<script>
    $(document).ready(function() {

        window.generalSearchRoute = "{{ route('general-search', ['query' => ':query']) }}";
        window.estimateLink = "{{ route('estimate.index') }}";
        window.loadDetailLink = "{{ route('orders.show', ['load_detail' => ':load_detail']) }}";
    });
</script>
