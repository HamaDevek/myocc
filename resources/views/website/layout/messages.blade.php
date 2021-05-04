@if(count($errors) > 0)
@foreach ($errors->all() as $error)

<script>
 M.toast({html: '{{$error}}', classes: 'red darken-2 ',});
</script>
@endforeach
@endif

@if(session('success'))

<script>
    M.toast({html: '{{session('success')}}', classes: 'black lighten-3 ',});
   </script>
@endif
@if(session('error'))

<script>
    M.toast({html: '{{session('error')}}', classes: 'red darken-2 ',});
   </script>
@endif