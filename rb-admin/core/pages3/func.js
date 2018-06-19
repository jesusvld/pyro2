// Funcion de ambito global
/**
 * Creates a string that can be used for dynamic id attributes
 * http://www.frontcoded.com/javascript-create-unique-ids.html
 * Example: "id-so7567s1pcpojemi"
 * @returns {string}
*/
var uniqueId = function() {
  return Math.random().toString(36).substr(2, 16);
};

$(document).ready(function() {
  // Arrastrar y soltar para bloques
  $( "#boxes" ).sortable({
    placeholder: "placeholder",
    handle: ".box-header"
  });

  // Arrastrar y soltar para columnas
  $( ".cols" ).sortable({
      placeholder: "placeholder",
      handle: ".col-header"
  });

  // Arrastrar y soltar para widgets
  $( ".widgets" ).sortable({
      placeholder: "placeholder",
      handle: ".widget-header"
  });

  // ***** AÑADIR BLOQUE, CAJAS ********
  $(".wrap-boton-new-block").on("click", "#boxNew", function (event) {
    event.preventDefault();
    $.ajax({
        url: "core/pages3/page-box-new.php?temp_id="+uniqueId()
    })
    .done(function( data ) {
       $('#boxes').append( data );
    });
  });

  // borrar cada bloque. caja, box
  $("#boxes").on("click", ".boxdelete", function (event) {
    event.preventDefault();
    var msg = confirm("¿Desea quitar?");
    if(msg){
      $(this).closest("li").remove();
    }
  });

  // ***** AÑADIR COLUMNAS ********
  $("#boxes").on("click", ".addNewCol", function (event) {
    event.preventDefault();
    var cols = $(this).closest("li").find(".cols");
    $.ajax({
        url: "core/pages3/page-col-new.php?temp_id="+uniqueId()
    })
    .done(function( data ) {
      cols.append(data);
    });
  });

  // ***** AÑADIR WIDGETS ********
  $("#boxes").on("click", ".addNewWidget", function (event) {
    event.preventDefault();
    $('.bg-opacity').show();
    var widgets = $(this).closest("li").find(".widgets");
    $(".bg-opacity").show();
    $.ajax({
      url: "core/pages3/widget.availables.php",
      cache: false
    })
    .done(function( data ) {
      widgets.append(data);
      $("#editor-widget").show();
    });
  });

  // Añadir Columna Personalizada
  $("#boxes").on("click", ".addCustom", function (event) {
  //$(".addCustom").click(function (event) {
    event.preventDefault();
    var custom_id = $(this).attr('data-id');
    var widgets = $(this).closest(".widgets");
    //var box_edit = $(this).closest("li").find(".widgets");
    $.ajax({
        url: "core/pages3/widget-custom.php?custom_id="+custom_id
    })
    .done(function( data ) {
      console.log(data);
      widgets.append(data);
    });
  });

  //*** EDITOR MODAL BOX ****

  // Mostrar Editor CSS
  $("#editCSSFile").click(function (event) {
    $(".bg-opacity").show();
    $("#editor-css").show();
    event.preventDefault();
  });

  // Mostrar Modal Guardar Widget
  $("#boxes").on("click", ".showEditBlock", function (event) {
    //Capturar valores del widget
    var blo = $(this).closest(".widget");
    var blo_class = $(blo).attr('data-class');
    var blo_id = $(blo).attr('data-id');
    var blo_typ = $(blo).attr('data-type');
    var blo_val = $(blo).attr('data-values');
    var blo_json = "";
    var htmlt_content_widget = "";

      switch (blo_typ) {
        case 'html':
        case 'htmlraw':
          htmlt_content_widget = $(blo).find('.box-edit-html').html();
          htmlt_content_widget = htmlEntities(htmlt_content_widget);
        break;
      }
      var blo_json = '{"widget_id": "'+blo_id+'", "widget_content" : "'+htmlt_content_widget+'", "widget_type" : "'+blo_typ+'", "widget_class" : "'+ blo_class +'", "widget_values" : '+blo_val+'}'

    $('#block_content').val( blo_json );
    $('#block_item_id').val( blo_id );

    $(".bg-opacity").show();
    $("#editor-block").show();
    event.preventDefault();
  });

  // Mostrar Editor de Bloque
  $("#boxes").on("click", ".showEditBox", function (event) {
    var box_id = $(this).closest(".box").attr('data-id');

    //Bloque externos valores
    var boxext_class = $(this).closest(".box").attr('data-extclass');
    var boxext_values_string = $(this).closest(".box").attr('data-extvalues');
    var boxext_jsonvals = JSON.parse(boxext_values_string); //Pasando a json

    var boxext_parallax = boxext_jsonvals.parallax;
    var boxext_bgimage = boxext_jsonvals.bgimage;
    var boxext_bgcolor = boxext_jsonvals.bgcolor;
    var boxext_paddingtop = boxext_jsonvals.paddingtop;
    var boxext_paddingright = boxext_jsonvals.paddingright;
    var boxext_paddingbottom = boxext_jsonvals.paddingbottom;
    var boxext_paddingleft = boxext_jsonvals.paddingleft;

    //Bloque interno valores
    var boxin_class = $(this).closest(".box").attr('data-inclass');
    var boxin_values_string = $(this).closest(".box").attr('data-invalues');
    var boxin_jsonvals = JSON.parse(boxin_values_string); //Pasando a json

    var boxin_height = boxext_jsonvals.height;
    var boxin_width = boxext_jsonvals.width;
    var boxin_bgimage = boxext_jsonvals.bgimage;
    var boxin_bgcolor = boxext_jsonvals.bgcolor;
    var boxin_paddingtop = boxext_jsonvals.paddingtop;
    var boxin_paddingright = boxext_jsonvals.paddingright;
    var boxin_paddingbottom = boxext_jsonvals.paddingbottom;
    var boxin_paddingleft = boxext_jsonvals.paddingleft;

    $('#eb_id').val(box_id);
    $('#boxin_height').val(boxin_height);
    $('#boxin_width').val(boxin_width);
    $('#boxin_bgimage').val(boxin_bgimage);
    $('#boxin_bgcolor').val(boxin_bgcolor);
    $('#boxin_paddingtop').val(boxin_paddingtop);
    $('#boxin_paddingright').val(boxin_paddingright);
    $('#boxin_paddingbottom').val(boxin_paddingbottom);
    $('#boxin_paddingleft').val(boxin_paddingleft);
    $('#boxin_class').val(boxin_class);

    $('#boxext_bgimage').val(boxext_bgimage);
    $('#boxext_bgcolor').val(boxext_bgcolor);
    $('#boxext_paddingtop').val(boxext_paddingtop);
    $('#boxext_paddingright').val(boxext_paddingright);
    $('#boxext_paddingbottom').val(boxext_paddingbottom);
    $('#boxext_paddingleft').val(boxext_paddingleft);
    $('#boxext_class').val(boxext_class);
    if(boxext_parallax==1){
      $('#boxext_parallax').prop('checked', true);
    }else{
      $('#boxext_parallax').prop('checked', false);
    }

    $(".bg-opacity").show();
    $("#editor-box").show();
    event.preventDefault();
  });

  // Remover columnas y widgets
  $("#boxes").on("click", ".close-column", function (event) {
    event.preventDefault();
    var msg = confirm("¿Desea quitar?");
      if(msg){
        $(this).closest("li").remove();
      }
  });

  // button hide/show
  $( ".arrow-up" ).hide();
  $("#boxes").on("click", ".toggle", function (event) {
    event.preventDefault();
    $(this).closest("li").find(".box-body").toggle();
    $(this).closest("li").find(".arrow-up, .arrow-down").toggle();
  });

  // ******* ENVIAR LOS DATOS PARA SER GUARDADOS ********
  function htmlEntities(str) {
    // Remplaza codigo HTML con otras entidades (Como: &, <, >, ", espacio en blancos, ')
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/\n|\r/g, "").replace(/'/g, '&#39;');
  }
  function nl2br(str) {
    var break_tag = '<br>';
    return (str + '').replace(/([^>rn]?)(rn|nr|r|n)/g, '' + break_tag + '');
  }

  $( "#btnGuardar" ).click(function() {
    event.preventDefault();
    var pagina_title = $('#titulo').val();
    var pagina_id = $('#pagina_id').val();
    var menu_id = $('select[name=menu]').val()
    var pagina_enlace = $('#pagina_enlace').val()
    var mode = $('#mode').val();

    if(pagina_title == "" ){
      notify('Escriba el titulo de la página');
      $('#titulo').focus();
      return false;
    }
    var boxesmain_string_start = '{"boxes": [';
    var boxesmain_string_end = ']}';
    var boxes_coma = '';
    var final_string_content = '';
    var i=0;
    var all_columns_string = '';

    // Revisando cada box - caja
    $('#boxes li.box').each(function(indice, elemento) {
      var box_string_init = '{"box_id" : "'+$(elemento).attr('data-id')+'"';
      var box_string_values_ext = ',"boxext_class" : "'+$(elemento).attr('data-extclass')+'","boxext_values" : '+$(elemento).attr('data-extvalues');
      var box_string_values_in = ',"boxin_class" : "'+$(elemento).attr('data-inclass')+'","boxin_values" : '+$(elemento).attr('data-invalues');
      var cols_string_start = ',"columns":[';
      var cols_string_end = ']';
      var cols_string_content = '';
      var cols_coma = '';
      var cols_count=0;

      var $this = $(this);
      // Revisando cada columna
      $this.find(".cols .col").each(function(indice, elemento) {
        var widgets_string_content = '';
        var widgets_coma = '';
        var widgets_count=0;

        var col_id = $(elemento).attr('data-id');
        var col_type = $(elemento).attr('data-type');
        var col_class = $(elemento).attr('data-class');
        var col_values = $(elemento).attr('data-values');
        var col_save_id = $(elemento).attr('data-saved-id');

        // Revisando cada widget
        var $this = $(this);
        $this.find(".widgets .widget").each(function(indice, elemento) {
          var widget_id = $(elemento).attr('data-id');
          var widget_type = $(elemento).attr('data-type');
          var widget_class = $(elemento).attr('data-class');
          var widget_values = $(elemento).attr('data-values');
          var widget_save_id = $(elemento).attr('data-saved-id');
          htmlt_content_widget = "";

          switch (widget_type) {
            case 'htmlraw':
            case 'html':
              htmlt_content_widget = $(elemento).find('.box-edit-html').html();
              htmlt_content_widget = encodeURIComponent(htmlEntities(htmlt_content_widget));
            break;
          }

          if(widget_save_id>0){
            widgets_string_content += widgets_coma + '{"widget_save_id": "'+widget_save_id+'"}';
            //Guardar cambios realizados en el bloque
            var blo_json = '{"widget_id": "'+widget_id+'", "widget_content" : "'+htmlt_content_widget+'", "widget_type" : "'+widget_type+'", "widget_class" : "'+ widget_class +'", "widget_values" : '+widget_values+'}'
            $.ajax({
      		  	method: "post",
      		  	url: "core/pages3/save.block.php",
      		  	data: 'block_id='+widget_save_id+'&block_content='+blo_json+'&block_name=none'
      			}).done(function( msg ) {
              console.log(msg)
      			});
          }else{
            widgets_string_content += widgets_coma + '{"widget_save_id" : "0", "widget_id" : "'+widget_id+'","widget_content" : "'+htmlt_content_widget+'","widget_type":"'+ widget_type + '", "widget_class" : "'+ widget_class +'","widget_values": '+widget_values+'}';
          }
          widgets_coma = ",";
          widgets_count++;
        });// fin revision widget

        /*if(col_save_id>0){ // -->pendiente, cuando se pueda grabar una columna
          cols_string_content += cols_coma + '{"col_save_id": "'+col_save_id+'"}';
          //Guardar cambios realizados en el bloque
          var blo_json = '{"col_id": "'+col_id+'", "col_type" : "'+col_type+'", "col_class" : "'+ col_class +'", "col_values" : '+col_values+'}'
          $.ajax({
    		  	method: "post",
    		  	url: "core/pages2/save.block.php",
    		  	data: 'block_id='+col_save_id+'&block_content='+blo_json+'&block_name=none'
    			}).done(function( msg ) {
            console.log(msg)
    			});
        }else{*/
        cols_string_content += cols_coma + '{"col_save_id" : "0", "col_id" : "'+$(elemento).attr('data-id')+'","col_type":"'+ col_type + '", "col_class" : "'+ col_class +'","col_values": '+col_values+' , "widgets": ['+widgets_string_content+'], "widgets_nums": '+ widgets_count +' }';
        //}
        cols_coma = ",";
        cols_count++;
      });// fin revision column

      cols_nums = ',"num_cols":"'+ cols_count +'"}';
      all_columns_string += boxes_coma + box_string_init + box_string_values_ext + box_string_values_in + cols_string_start + cols_string_content + cols_string_end + cols_nums;
      boxes_coma = ",";
    });
    final_string_content += boxesmain_string_start + all_columns_string + boxesmain_string_end;
    console.log(final_string_content); // no es necesario pasar a json en js antes JSON.stringify

    //return false;
    if ($('#sheader').is(':checked')) {
			sheader = 1;
		}else{
			sheader = 0;
		}
    if ($('#sfooter').is(':checked')) {
			sfooter = 1;
		}else{
			sfooter = 0;
		}
    $.ajax({
      url: "core/pages3/page.save.php",
      method: 'post',
      data: "title="+pagina_title+"&content="+final_string_content+"&pid="+pagina_id+"&mode="+mode+"&title_enlace="+pagina_enlace+"&sh="+sheader+"&sf="+sfooter
    })
    .done(function( data ) {
      if(data.resultado=="ok"){
        notify("La página se guardo en la base de datos");
        /*setTimeout(function(){
          window.location.href = data.url+'/rb-admin/index.php?pag=pages&opc=edt&id='+data.last_id;
        }, 1000);*/
      }else{
        notify("Existe un error al intentar guardar en la base de datos");
        console.log(data.contenido);
      }
    });
  });
});
