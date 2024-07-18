<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</script> --}}
<script type="text/javascript">
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
    </script>
    