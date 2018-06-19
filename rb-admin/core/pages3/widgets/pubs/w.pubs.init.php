<?php
// Datos de este widget
$widget = [
  'link_action' => 'addPost1',
  'dir' => 'pubs',
  'name' => 'Publicaciones',
  'desc' => 'Muestra listado de publicaciones',
  'filejs' => 'file.js'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);
?>
<script>
$(".addPost1").click (function (event) {
  event.preventDefault();
  var widgets = $(this).closest(".widgets");
  var widget_id = "widget"+uniqueId();
  $.ajax({
      url: "core/pages3/widgets/pubs/w.pubs.php?temp_id="+widget_id
  })
  .done(function( data ) {
    widgets.append(data);
  });
});
</script>
