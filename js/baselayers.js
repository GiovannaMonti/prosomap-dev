/*GET AND DISPLAY BASE LAYERS (WORK, PERSON/AUTHOR, SOURCE, ACTIVITY)*/

let placelayer;
let workmarkers=[];
let worklayer;
let sourcemarkers=[];
let sourcelayer;
let personmarkers=[];
let personlayer;
let activitymarkers=[];
let activitylayer;
var clusteredmarkers;
let categories = {};
let layerControl;

function getBaseLayers(){

  /*WORK LAYER*/
  for(var j=0; j<workarray.length; j++){

    /*init*/

    var workid=workarray[j].work_id;
    var title=workarray[j].title;
    var incipit=workarray[j].incipit;
    var place=workarray[j].place;
    var latitude=workarray[j].latitude;
    var longitude=workarray[j].longitude;

    /*tooltip content*/

    if(title!=null){
      var worktooltip='<div style="text-align:center; font-weight: bold; font-family: Volkhov">'+place+'</div><div style="font-family=Poppins"><span class="badge badge-pill badge-primary" style="background-color:#72B026; ">Work</span> ' + title + '</div>';
    }
    else{
      var worktooltip='<div style="text-align:center; font-weight: bold; font-family: Volkhov">'+place+'</div><div style="font-family=Poppins"><span class="badge badge-pill badge-primary style="background-color:#72B026; ">Work</span> ' + incipit + '</div>';
    }

    /*creation of work markers*/
    var workicon = L.AwesomeMarkers.icon({
      icon: 'book-open',
      iconColor: 'white',
      prefix: 'fa',
      markerColor: 'green'
    });

    let marker= L.marker([latitude, longitude], {icon: workicon});
    marker.markerID=workid;
    marker.type='work';
    marker.on('click', onMarkerClick);
    marker.bindTooltip(worktooltip);
    workmarkers.push(marker);
  }
  /* grouping work markers in a single layer */

  worklayer = L.layerGroup(workmarkers);


  /* adding category 'Works' */

  //categories.Works=worklayer;

  /*SOURCE LAYER*/

  for(var j=0; j<sourcearray.length; j++){

    /*init*/

    var sourceid=sourcearray[j].source_id;
    var sourcename=sourcearray[j].sourcename;
    var latitude=sourcearray[j].latitude;
    var longitude=sourcearray[j].longitude;
    var sourceplace=sourcearray[j].sourceplace;

    /*tooltip content*/

    var sourcetooltip='<div style="text-align:center; font-weight: bold; font-family: Volkhov">'+sourceplace+'</div><div style="font-family=Poppins"><span class="badge badge-pill badge-primary" style="background-color:#38AADD;">Source</span> ' + sourcename + '</div>';
    /*creation of source markers*/
    var sourceicon = L.AwesomeMarkers.icon({
      icon: 'scroll',
      iconColor: 'white',
      prefix: 'fa',
      markerColor: 'blue'
    });

    let marker= L.marker([latitude, longitude], {icon: sourceicon});
    marker.markerID=sourceid;
    marker.type='source';
    marker.on('click', onMarkerClick);
    marker.bindTooltip(sourcetooltip);
    sourcemarkers.push(marker);
  }
  /* grouping source markers in a single layer */

  sourcelayer = L.layerGroup(sourcemarkers);


  /* adding category 'Sources' */

  //categories.Sources=sourcelayer;

  /* adding all categories to map*/

//  L.control.layers({}, categories, false).addTo(mymap);

/*PERSON LAYER*/
for(var j=0; j<personarray.length; j++){

  /*init*/

  var personid=personarray[j].person_id;
  var personname=personarray[j].personname;
  var surname=personarray[j].surname;
  var place=personarray[j].place;
  var latitude=personarray[j].latitude;
  var longitude=personarray[j].longitude;

  /*tooltip content*/

  var persontooltip='<div style="text-align:center; font-weight: bold; font-family: Volkhov">'+place+'</div><div style="font-family=Poppins"><span class="badge badge-pill badge-primary" style="background-color:#D63E2A;">Person</span> ' + personname + ' '+ surname + '</div>';

  /*creation of work markers*/
  var personicon = L.AwesomeMarkers.icon({
    icon: 'user',
    iconColor: 'white',
    prefix: 'fa',
    markerColor: 'red'
  });

  let marker= L.marker([latitude, longitude], {icon: personicon});
  marker.markerID=personid;
  marker.type='person';
  marker.on('click', onMarkerClick);
  marker.bindTooltip(persontooltip);
  personmarkers.push(marker);
}
/* grouping person markers in a single layer */

  personlayer = L.layerGroup(personmarkers);

  /*ACTIVITY LAYER*/
  for(var j=0; j<activityarray.length; j++){

    /*init*/

    var activityid=activityarray[j].activity_id;
    var place=activityarray[j].place;
    var latitude=activityarray[j].latitude;
    var longitude=activityarray[j].longitude;
    var description=activityarray[j].description;
    var startdate=activityarray[j].start_date;

    var dd = String(startdate.getDate()).padStart(2, '0');
    var mm = String(startdate.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = startdate.getFullYear();

    startdate = dd + '/' + mm + '/' + yyyy;

    /*tooltip content*/

    var activitytooltip='<div style="text-align:center; font-weight: bold; font-family: Volkhov">'+place+'</div><div style="font-family=Poppins"><span class="badge badge-pill badge-primary" style="background-color:#D252B9;">Activity</span> ' + description + '</div>';

    /*creation of work markers*/
    var activityicon = L.AwesomeMarkers.icon({
      icon: 'chess-rook',
      iconColor: 'white',
      prefix: 'fa',
      markerColor: 'purple'
    });

    let marker= L.marker([latitude, longitude], {icon: activityicon});
    marker.markerID=activityid;
    marker.type='activity';
    marker.on('click', onMarkerClick);
    marker.bindTooltip(activitytooltip);
    activitymarkers.push(marker);
  }
  /* grouping activity markers in a single layer */

  activitylayer = L.layerGroup(activitymarkers);

  clusteredmarkers=L.markerClusterGroup();
  worksubgroup=L.featureGroup.subGroup(clusteredmarkers, workmarkers);
  sourcesubgroup=L.featureGroup.subGroup(clusteredmarkers, sourcemarkers);
  personsubgroup=L.featureGroup.subGroup(clusteredmarkers, personmarkers);
  activitysubgroup=L.featureGroup.subGroup(clusteredmarkers, activitymarkers);
  //clusteredmarkers.addLayer(worklayer);
  //clusteredmarkers.addLayer(sourcelayer);
  clusteredmarkers.addTo(mymap);
  worksubgroup.addTo(mymap);
  sourcesubgroup.addTo(mymap);
  personsubgroup.addTo(mymap);
  activitysubgroup.addTo(mymap);

  layerControl = L.control.layers().addTo(mymap);

  layerControl.addOverlay(worksubgroup, 'Works');
  layerControl.addOverlay(sourcesubgroup, 'Sources');
  layerControl.addOverlay(personsubgroup, 'People');
  layerControl.addOverlay(activitysubgroup, 'Activities');

}

function showResetButton(){
L.Control.ResetMap = L.Control.extend({
  onAdd: function(mymap) {
    var reset = L.DomUtil.create('button');
    reset.textContent = 'RESET MAP';
    reset.className= 'btn btn-dark';
    reset.style.fontFamily = 'Volkhov';
    reset.addEventListener('click', resetMap);
    return reset;
  },

  onRemove: function(mymap) {
      // Nothing to do here
  }
});

L.control.reset = function(opts) {
  return new L.Control.ResetMap(opts);
}

L.control.reset({ position: 'bottomleft' }).addTo(mymap);

}

function resetMap(){
  clusteredmarkers.clearLayers();
  clusteredmarkers.addLayer(worklayer);
  clusteredmarkers.addLayer(sourcelayer);
  clusteredmarkers.addLayer(personlayer);
  clusteredmarkers.addLayer(activitylayer);

  mymap.removeControl(layerControl);
  layerControl = L.control.layers().addTo(mymap);
  layerControl.addOverlay(worksubgroup, 'Works');
  layerControl.addOverlay(sourcesubgroup, 'Sources');
  layerControl.addOverlay(personsubgroup, 'People');
  layerControl.addOverlay(activitysubgroup, 'Activities');

}
