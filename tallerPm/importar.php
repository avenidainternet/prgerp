<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.1/dist/xlsx.full.min.js"></script>
<div id="navbar"><span>Leer Excel </span></div>
  <div id="wrapper">
    <input type="file" id="input-excel"/>
</div>

<script>
    $('#input-excel').change(function(e){
      var reader = new FileReader();
      reader.readAsArrayBuffer(e.target.files[0]);
      reader.onload = function(e) {
        var data = new Uint8Array(reader.result);
        var wb = XLSX.read(data,{type:'array'});
        //alert(data);
        var htmlstr = XLSX.write(wb,{sheet:"Hoja1", type:'binary',bookType:'html'});
        $('#wrapper')[0].innerHTML += htmlstr;
      }
    });
</script>
