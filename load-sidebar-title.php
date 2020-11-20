
<?php

  $type=$_POST['type'];
  $id="";
  if($type!="about"){
    $id=$_POST['id'];
  }
  echo "<script type=\"text/javascript\">
    var markertype='$type';
    var markerid;
    if(markertype!=\"about\"){
      markerid='$id';
    }
    </script>"

?>
<script>
  var sidebarTitle=document.getElementById("sidebar-title");
  var typelabel=document.createElement('h2');

  /* About */

  if(markertype=="about"){
    typelabel.innerHTML='About ProsoMap';
  }

  /* Work */

  if(markertype=="work"){
    var thiswork;
    for(i=0; i<workarray.length; i++){
      if(workarray[i].work_id==markerid){
        thiswork=workarray[i];
        break;
      }
    }
    var title=thiswork.title;
    var incipit=thiswork.incipit;

    if(title!=null){
      typelabel.innerHTML='<span class="badge badge-pill badge-primary" style="background-color:#72B026; font-family: Poppins;">'+ markertype+ '</span> ' + title;
    }
    else{
      typelabel.innerHTML='<span class="badge badge-pill badge-primary" style="background-color:#72B026; font-family: Poppins">'+ markertype+ '</span> ' + incipit;
    }
  }

  /* Source */

  if(markertype=="source"){
    var thissource;
    for(i=0; i<sourcearray.length; i++){
      if(sourcearray[i].source_id==markerid){
        thissource=sourcearray[i];
        break;
      }
    }
    var sourcename=thissource.sourcename;
    typelabel.innerHTML='<span class="badge badge-pill badge-primary" style="background-color:#38AADD; font-family: Poppins;">'+ markertype+ '</span> ' + sourcename;
  }

  sidebarTitle.appendChild(typelabel);

  /* Person */

  if(markertype=="person"){
    var thisperson;
    for(i=0; i<personarray.length; i++){
      if(personarray[i].person_id==markerid){
        thisperson=personarray[i];
        break;
      }
    }
    var personname=thisperson.personname;
    var surname=thisperson.surname;
    typelabel.innerHTML='<span class="badge badge-pill badge-primary" style="background-color:#D63E2A; font-family: Poppins;">'+ markertype+ '</span> ' + personname + ' '+ surname;
  }

  /* Activity */

  if(markertype=="activity"){
    var thisactivity;
    for(i=0; i<activityarray.length; i++){
      if(activityarray[i].activity_id==markerid){
        thisactivity=activityarray[i];
        break;
      }
    }
    var desc=thisactivity.description;
    typelabel.innerHTML='<span class="badge badge-pill badge-primary" style="background-color:#D252B9; font-family: Poppins;">'+ markertype+ '</span> ' + desc;
  }

  sidebarTitle.appendChild(typelabel);

</script>
