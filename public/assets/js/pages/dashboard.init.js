!function(){function e(e){if(null!==document.getElementById(e)){var t=document.getElementById(e).getAttribute("data-colors");if(t)return(t=JSON.parse(t)).map((function(e){var t=e.replace(" ","");if(-1===t.indexOf(",")){var a=getComputedStyle(document.documentElement).getPropertyValue(t);return a?a=a.replace(" ",""):t}var r=e.split(",");if(2==r.length){var o=getComputedStyle(document.documentElement).getPropertyValue(r[0]);return o="rgba("+o+","+r[1]+")"}return t}))}}setTimeout((function(){$("#subscribeModal").modal("show")}),2e3);var t=e("stacked-column-chart");if(t){var a={chart:{height:360,type:"bar",stacked:!0,toolbar:{show:!1},zoom:{enabled:!0}},plotOptions:{bar:{horizontal:!1,columnWidth:"15%",endingShape:"rounded"}},dataLabels:{enabled:!1},series:[{name:"Series A",data:[44,55,41,67,22,43,36,52,24,18,36,48]},{name:"Series B",data:[13,23,20,8,13,27,18,22,10,16,24,22]},{name:"Series C",data:[11,17,15,15,21,14,11,18,17,12,20,18]}],xaxis:{categories:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]},colors:t,legend:{position:"bottom"},fill:{opacity:1}};new ApexCharts(document.querySelector("#stacked-column-chart"),a).render()}var r=e("radialBar-chart");if(r){a={chart:{height:200,type:"radialBar",offsetY:-10},plotOptions:{radialBar:{startAngle:-135,endAngle:135,dataLabels:{name:{fontSize:"13px",color:void 0,offsetY:60},value:{offsetY:22,fontSize:"16px",color:void 0,formatter:function(e){return e+"%"}}}}},colors:r,fill:{type:"gradient",gradient:{shade:"dark",shadeIntensity:.15,inverseColors:!1,opacityFrom:1,opacityTo:1,stops:[0,50,65,91]}},stroke:{dashArray:4},series:[67],labels:["Series A"]};new ApexCharts(document.querySelector("#radialBar-chart"),a).render()}}();