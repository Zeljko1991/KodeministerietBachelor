@if (count($errors) > 0)
    <script>
        swal({title: "Error", html: '<?php foreach($errors->all() as $error){ echo $error; echo "<br>"; }?>', type: "error"});
    </script>

@endif

@if (session('success'))
    <script>
    swal({title: "Great success", html: "{{session('success')}}", type: "success"});
    </script>
@endif

@if (session('error'))
    <script>
        swal({title: "Whoopsie dasie!", html: "{{session('error')}}", type: "error"});
    </script>
@endif
