<div class="content-viewport">
  <div class="row">
    <div class="col-lg-12">
      <div class="grid">

        <p class="grid-header">Registro de Proveedor</p>
        <div class="grid-body">
          <div class="item-wrapper">
            <div class="row-12">
              <div >

                <div id="container"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>
  window.jQuery || document.write('<script src="js/jquery-1.8.3.min.js"><\/script>')
</script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<script>
  //My highchart script

  $(function() {
    var chart;
    $(document).ready(function() {
      // $.getJSON("data.php", function(json) {


      chart = new Highcharts.Chart({
        chart: {
          renderTo: 'container',
          type: 'column',
          marginRight: 130,
          marginBottom: 25
        },
        title: {
          text: '<h1 style="color:#F28165;"><b>REPORTES DE CLIENTES</b><h1>',
          x: -20 //center
        },
        subtitle: {
          text: 'Reporte Anual',
          x: -20
        },
        xAxis: {
          categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        },
        yAxis: {
          title: {
            text: 'Ventas por cliente'
          },
          plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
          }]
        },
        tooltip: {
          valueSuffix: ' Soles'
        },
        legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'top',
          x: -10,
          y: 100,
          borderWidth: 0
        },
        series: [

          <?php

          $result2 = mainModel::ejecutar_consulta_simple("SELECT * FROM persona WHERE id_beneficiario=2 and estado='Activo';");

          while ($campos = $result2->fetch()) {
            $id_persona = $campos["id_persona"];
            echo '{';
            echo "name:'" . $campos["razon_social"] . "',";
            echo "data:";


            $result3 = mainModel::ejecutar_consulta_simple("SELECT Date_format(fecha_ordencli,'%M') as fecha, total_ordencli  from ordencliente ord INNER JOIN persona pe on ord.id_persona=pe.id_persona WHERE pe.id_persona='$id_persona'");

            $listaMeses = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $listaganancias = [];
            echo '[';


            for ($i = 0; $i <= count($listaMeses) - 1; $i++) {


              while ($campos2 = $result3->fetch()) {

                $mes = $campos2["fecha"];
                $monto = $campos2["total_ordencli"];
              }

              if ($listaMeses[$i] == $mes) {

                array_push($listaganancias, $monto);
              } elseif ($listaMeses[$i] != $mes) {

                array_push($listaganancias, 0);
              } else {

                array_push($listaganancias, 0);
              }

              echo $listaganancias[$i] . ",";
            }

            echo ']';

            echo '},';
          }


          ?>

        ]
      });
      //  });

    });

  });
</script>
</body>