

var legend;
var selected;

function generateChartData() {
  var chartData = [];
  for (var i = 0; i < types.length; i++) {
    if (i == selected) {
      for (var x = 0; x < types[i].subs.length; x++) {
        chartData.push({
          type: types[i].subs[x].type,
          percent: types[i].subs[x].percent,
          color: types[i].color,
          pulled: true
        });
      }
    } else {
      chartData.push({
        type: types[i].type,
        percent: types[i].percent,
        color: types[i].color,
        id: i
      });
    }
  }
  return chartData;
}


var chart = AmCharts.makeChart("chartContainer1", {
"type": "pie",
"outlineAlpha": 0.4,
"innerRadius": "0",
"radius": 150,
"theme": "dark",
"startDuration": 0,
"marginTop":0,
"color": "white",
"depth3D": 15,
"angle": 30,
"fontSize":9,
  "dataProvider": generateChartData(),
  "labelText": "[[title]]: [[value]]",
  "balloonText": "[[title]]: [[value]]",
  "titleField": "type",
  "pulledField": "pulled",
  "valueField": "percent",
  "outlineColor": "#FFFFFF",
  "labelsEnabled": true,
  "outlineAlpha": 0.8,
  "outlineThickness": 1,
  "colorField": "color",
  "titles": [{
    "text": "Trendx Monthly"
  }],
  "responsive": {
      enabled: true
    },

  "defs": {
    "filter": [{
      "id": "shadow",
      "width": "200%",
      "height": "200%",
      "fontSize": 13,
      "feOffset": {
        "result": "offOut",
        "in": "SourceAlpha",
        "dx": 0,
        "dy": 0
      },
      "feGaussianBlur": {
        "result": "blurOut",
        "in": "offOut",
        "stdDeviation": 5
      },
      "feBlend": {
        "in": "SourceGraphic",
        "in2": "blurOut",
        "mode": "normal"
      }
    }]
  },
  "listeners": [{
    "event": "clickSlice",
    "method": function(event) {
      var chart = event.chart;
      if (event.dataItem.dataContext.id != undefined) {
        selected = event.dataItem.dataContext.id;
      } else {
        selected = undefined;
      }
      chart.dataProvider = generateChartData();
      chart.validateData();
    }
  }],
  "export": {
    "enabled": true
  }
});

