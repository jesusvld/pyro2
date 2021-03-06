<?php
// Datos de este widget
$widget = [
  'link_action' => 'addSlide',
  'dir' => 'slide',
  'name' => 'Galeria',
  'desc' => 'Añade una galeria de imagenes',
  'filejs' => 'w.slide.js',
  'img' => 'gallery.png',
  'file' => 'widgets/slide/w.slide.php',
  'type' => 'slide'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);
?>
<script>
$(".addSlide").click (function (event) {
  event.preventDefault();
  var widgets = $(this).closest(".widgets");
  var widget_id = "widget"+uniqueId();
  $.ajax({
      url: "core/pages3/widgets/slide/w.slide.php?temp_id="+widget_id
  })
  .done(function( data ) {
    notify("Elemento <?= $widget['name'] ?> añadido");
    widgets.append(data);
  });
});
</script>
