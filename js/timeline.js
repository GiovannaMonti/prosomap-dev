/* INITIALIZE TIMELINE */

var timeline;
var timelineinfo=[];

function initializeTimeline(){
  var container = document.getElementById('visualization');
  var workmarker={};
  var sourcemarker={};
  var personmarker={};
  var activitymarker={};
  var timelineitems;

  var groupnames = ['Works', 'Sources', 'People', 'Activities'];
  var groupCount=groupnames.length;
  var groups = new vis.DataSet();
  for (var g = 0; g < groupCount; g++) {
    groups.add({
      id: 'group'+g,
      content: groupnames[g],
      className: 'groupclass'+g
    });
  }

  for(i=0; i<workarray.length; i++){
    workmarker={
      id: workarray[i].work_id,
      title: workarray[i].title,
      group: 'group0',
      type: 'point',
      style: 'font-size: 0%',
      start: workarray[i].date
    }
    timelineinfo.push(workmarker);
  }
  for(i=0; i<sourcearray.length; i++){
    sourcemarker={
      id: sourcearray[i].source_id,
      title: sourcearray[i].sourcename,
      group: 'group1',
      type: 'point',
      style: 'font-size: 0%',
      start: sourcearray[i].date
    }
    timelineinfo.push(sourcemarker);
  }
  for(i=0; i<personarray.length; i++){
    personmarker={
      id: personarray[i].person_id,
      title: personarray[i].personname + ' ' + personarray[i].surname,
      group: 'group2',
      type: 'point',
      style: 'font-size: 0%',
      start: personarray[i].birth_date,
      end: personarray[i].death_date
    }
    timelineinfo.push(personmarker);
  }
  for(i=0; i<activityarray.length; i++){
    activitymarker={
      id: activityarray[i].activity_id,
      title: activityarray[i].description,
      group: 'group3',
      type: 'point',
      style: 'font-size: 0%',
      start: activityarray[i].start_date,
      end: activityarray[i].end_date
    }
    timelineinfo.push(activitymarker);
  }

  let maxDateObj = timelineinfo.reduce(function (a, b) {
      return a.start > b.start ? a : b;
  });
  let maxDate= maxDateObj.start;
  let maxYear=maxDate.getFullYear();
  let maxMargin=new Date(maxYear+30, 12, 31);

  let minDateObj = timelineinfo.reduce(function (x, y) {
      return x.start < y.start ? x : y;
  });
  let minDate= minDateObj.start;
  let minYear=minDate.getFullYear();
  let minMargin=new Date(minYear-30, 12, 31);

  var middleDate= new Date((minMargin.getTime() + maxMargin.getTime()) / 2);

  timelineitems = new vis.DataSet(timelineinfo);

  // Configuration for the Timeline
  var options = {
    stack: false,
    maxHeight: '300px',
    start: minMargin,
    end: maxMargin,
    moveable: false,
    timeAxis: {scale: 'year', step: 50},
    snap: null
  };

  // Create a Timeline
  timeline = new vis.Timeline(container, timelineitems, options);
  timeline.setGroups(groups);
  timeline.addCustomTime(middleDate, 'customtime');
  timeline.addEventListener('timechange', displayTimeMarkers); //when the custom time bar is dragged it triggers the function

}

/*DISPLAY TIME MARKERS*/

var currenttimemarkers;

function displayTimeMarkers(){
  clusteredmarkers.clearLayers();
  var selectedmarkers=[];
  for(var j=0; j<timelineinfo.length; j++){
    var startdate=timelineinfo[j].start;
    var currenttime=timeline.getCustomTime('customtime').getYear();
    if(startdate.getYear()>currenttime-50 && startdate.getYear()<currenttime+50){
      selectedmarkers.push(timelineinfo[j]);
    }
  }
  currenttimemarkers=[];
  for(var i=0; i<selectedmarkers.length; i++){
    for(k=0; k<workmarkers.length; k++){
      if(workmarkers[k].markerID==selectedmarkers[i].id){
        currenttimemarkers.push(workmarkers[k]);
        break;
      }
    }
  }
  for(var f=0; f<selectedmarkers.length; f++){
    for(z=0; z<sourcemarkers.length; z++){
      if(sourcemarkers[z].markerID==selectedmarkers[f].id){
        currenttimemarkers.push(sourcemarkers[z]);
        break;
      }
    }
  }
  for(var f=0; f<selectedmarkers.length; f++){
    for(z=0; z<personmarkers.length; z++){
      if(personmarkers[z].markerID==selectedmarkers[f].id){
        currenttimemarkers.push(personmarkers[z]);
        break;
      }
    }
  }
  for(var f=0; f<selectedmarkers.length; f++){
    for(z=0; z<activitymarkers.length; z++){
      if(activitymarkers[z].markerID==selectedmarkers[f].id){
        currenttimemarkers.push(activitymarkers[z]);
        break;
      }
    }
  }

  currenttimelayer=L.layerGroup(currenttimemarkers);
  clusteredmarkers.addLayer(currenttimelayer);
  mymap.addLayer(clusteredmarkers);
}
