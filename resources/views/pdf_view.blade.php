<!DOCTYPE html>
<html>
<head>
  <title>Reporte de comportamientos</title>
  <style>
    table{
      border-collapse: collapse;
      margin: auto;
      font-family: 'Montserrat', sans-serif;
      font-style: normal;
      font-weight: normal;
      src: url('/fonts/Montserrat/Montserrat-Regular.ttf') format('truetype');
    }

    .verticalTableHeader {
      text-align:center;
      white-space:nowrap;
      transform-origin:50% 50%;
      transform: rotate(90deg);
    }
    .verticalTableHeader:before {
      content:'';
      padding-top:110%;/* takes width as reference, + 10% for faking some extra padding */
      display:inline-block;
      vertical-align:middle;
    }
    small{
      font-size: 0.7em;
    }
  </style>

  
</head>
<body>

  <table>
    <tr>
      <td>
        <img src="{{ public_path('/img/log.png')}}" width="140">
      </td>
    </tr>
  </table>
  
  <table border="1">
    <tr>
      <td align="center" colspan="5">
        <strong>
          <span style="font-size: 0.8em;">REPORTE DE CASOS QUE AFECTAN LA CONVIVENCIA ESCOLAR</span>
        </strong>
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <strong>
          INSTITUCIÓN EDUCATIVA: LA RIVERA
        </strong>
      </td>
      <td colspan="2">
        <strong>
          FECHA: {{$comportamientos['fecha']}}
        </strong>
      </td>
    </tr>

    <tr>
      <td rowspan="2" style="width: 25%;">
        <strong>
          <small>
            SITUACIONES QUE AFECTAN LA CONVIVENCIA ESCOLAR
          </small>
        </strong>
      </td>
      <td rowspan="2" align="center">
        <strong>
          <small>
            CASO PRESENTADO
          </small>
        </strong>
      </td>
      
      <td align="center" rowspan="2">
        <strong>
          <small>GRADO(S)</small>
        </strong>
      </td>
      <td rowspan="2" style="width: 20%;">
        <strong>
          <small>
            ESTRATEGIA UTILIZADA PARA LA ATENCIÓN DEL CASO
          </small>
        </strong>
        
      </td>
      <td align="center">
        <strong>
          <small>
            ESTADO DE ACTIVIDAD
          </small>
        </strong>
      </td>
    </tr>
    <tr>
      <td>
        <table border="1" style="width: 100%;">
          <tr>
            <td align="center" style="width: 33%;">CM</td>
            <td align="center" style="width: 33%;">IC</td>
            <td align="center" style="width: 33%;">EE</td>
          </tr>
        </table>
      </td>
    </tr>
    @foreach ($comportamientos['data'] as $item)
        <tr>
          <td>{{$item->titulo}}</td>
          <td align="center"> {{$item->casos}} </td>
          <td align="center"> {{$item->nivel}} </td>
          <td align="center"> {{$item->estrategia}} </td>
          <td align="center"> 
            <table style="width: 100%;">
              <tr>
                <td style="width: 33%; text-align: center;">{{$item->estado == 1 ? 'X' : '&emsp;'}}</td>
                <td style="width: 33%; text-align: center;">{{$item->estado == 2 ? 'X' : '&emsp;'}}</td>
                <td style="width: 33%; text-align: center;">{{$item->estado == 0 ? 'X' : '&emsp;'}}</td>
              </tr>
            </table>
          </td>
        </tr>
    @endforeach
  </table>

  
</body>
</html>