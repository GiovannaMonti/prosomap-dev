<!DOCTYPE html>
<html lang="it">
<?php
    $dbconn = pg_connect("dbname=prosomap-dev user=postgres password=prosomap") or die('Connection Failed'); ?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to ProsoMap</title>
  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- LEAFLET -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
  integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
  crossorigin=""></script>
  <script src="js/leaflet-categorized-layers.js"></script>
  <!-- JQUERY -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <!-- VIS TIMELINE -->
  <script type="text/javascript" src="//unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
  <link href="//unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
  <!-- LEAFLET SIDEBAR -->
  <script src="http://turbo87.github.io/leaflet-sidebar/src/L.Control.Sidebar.js"></script>
  <link rel="stylesheet" href="http://turbo87.github.io/leaflet-sidebar/src/L.Control.Sidebar.css">
  <!-- FONTAWESOME + AWESOMEMARKERS-->
  <script src="https://kit.fontawesome.com/eda5598d52.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.js"></script>
  <!-- GOOGLE FONT -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Volkhov">
  <!-- MARKERCLUSTER -->
  <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
  <!-- LEAFLET FEATURE GROUP/SUB GROUP -->
  <script src="https://unpkg.com/leaflet.featuregroup.subgroup@1.0.2/dist/leaflet.featuregroup.subgroup.js"></script>
  <!-- JS FUNCTIONS -->
  <script src="js/baselayers.js"></script>
  <script src="js/timeline.js"></script>
  <!-- END JS FUNCTIONS -->

  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">ProsoMap</a>
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav"> --><!-- elementi della navbar che vengono collassati nell'ham menu -->
      <!--<ul class="navbar-nav ml-auto"> --> <!-- ml-auto to align menu elements to the right -->
        <li class="nav-item">
          <a class="nav-link" id="about" href="#"><i class="fas fa-info-circle"></i> About</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- END NAVBAR -->

  <!-- PAGE CONTENT -->
  
  <div id="container">
    <!-- MAP -->
    <div id="mapid" >
    </div>
    <!-- END MAP -->

    <!-- SIDEBAR -->
    <div id="sidebar">
        <a class="close" id="sidebarX">✕</a>
        <div id="sidebar-title"></div>
        <hr>
        <div id="sidebar-content"></div>
    </div>
    <!-- END SIDEBAR -->

    <!-- TIMELINE -->
    <div class="vis-panel vis-background vis-horizontal" id="visualization"></div>
    <!-- END TIMELINE -->

  </div>
  <!-- END PAGE CONTENT -->

  <!-- JAVASCRIPT/PHP -->
  <script type="text/javascript">

    $(document).ready(initializeTimeline);
    $(document).ready(getBaseLayers);
    $(document).ready(showResetButton);
  </script>

  <script src="js/map.js"></script>
  <script src="js/sidebar.js"></script>

  <?php
  /*WORK INFO*/
  $workquery = pg_query("SELECT work_id, title, incipit, name, latitude, longitude, end_date FROM work join place on place_of_composition = place_id");?>
  <script type="text/javascript"> var workarray = []; </script>
  <?php
  while ($workrow=pg_fetch_assoc($workquery)){
    $work_id=$workrow['work_id'];
    $title=$workrow['title'];
    $incipit=$workrow['incipit'];
    $place=$workrow['name'];
    $latitude=$workrow['latitude'];
    $longitude=$workrow['longitude'];
    $date=$workrow['end_date'];

    echo "<script type=\"text/javascript\">
        workinfo = {
        work_id: $work_id,
        title: '$title',
        incipit: '$incipit',
        place: '$place',
        latitude : $latitude,
        longitude : $longitude,
        date: new Date('$date'),
      }
      workarray.push(workinfo);
    </script>
   ";
  }
  /*END WORK INFO*/

  /*SOURCE INFO*/
  $sourcequery = pg_query("SELECT source.source_id, source.name as sourcename, latitude, longitude, source_date, place.name as placename FROM source join production on source.source_id = production.source_id join place on production.place_id = place.place_id");?>
  <script type="text/javascript"> var sourcearray = []; </script>
  <?php
  while ($sourcerow=pg_fetch_assoc($sourcequery)){
    $source_id=$sourcerow['source_id'];
    $sourcename=$sourcerow['sourcename'];
    $latitude=$sourcerow['latitude'];
    $longitude=$sourcerow['longitude'];
    $date=$sourcerow['source_date'];
    $sourceplace=$sourcerow['placename'];

    echo "<script type=\"text/javascript\">
        sourceinfo = {
        source_id: $source_id,
        sourcename: '$sourcename',
        latitude : $latitude,
        longitude : $longitude,
        date: new Date('$date'),
        sourceplace: '$sourceplace'
      }
      sourcearray.push(sourceinfo);
    </script>
   ";
  }
  /*END WORK INFO*/

  /*PERSON INFO*/
  $personquery = pg_query("SELECT person.person_id, person.name as personname, surname, place.name as placename, latitude, longitude, birth_date, death_date FROM person join place on place_of_origin = place_id");?>
  <script type="text/javascript"> var personarray = []; </script>
  <?php
  while ($personrow=pg_fetch_assoc($personquery)){
    $person_id=$personrow['person_id'];
    $personname=$personrow['personname'];
    $surname=$personrow['surname'];
    $place=$personrow['placename'];
    $latitude=$personrow['latitude'];
    $longitude=$personrow['longitude'];
    $birth_date=$personrow['birth_date'];
    $death_date=$personrow['death_date'];

    echo "<script type=\"text/javascript\">
        personinfo = {
        person_id: $person_id,
        personname: '$personname',
        surname: '$surname',
        place: '$place',
        latitude : $latitude,
        longitude : $longitude,
        birth_date: new Date('$birth_date'),
        death_date: new Date('$death_date')
      }
      personarray.push(personinfo);
    </script>
   ";
  }
  /*END PERSON INFO*/

  /*ACTIVITY INFO*/
  $activityquery = pg_query("SELECT activity.activity_id, activity.start_date, activity.end_date, place.name, place.latitude, place.longitude, activity.description from activity join person on activity.person_id=person.person_id join place on activity.place_id=place.place_id");?>
  <script type="text/javascript"> var activityarray = []; </script>
  <?php
  while ($activityrow=pg_fetch_assoc($activityquery)){
    $activity_id=$activityrow['activity_id'];
    $place=$activityrow['name'];
    $latitude=$activityrow['latitude'];
    $longitude=$activityrow['longitude'];
    $start_date=$activityrow['start_date'];
    $end_date=$activityrow['end_date'];
    $description=$activityrow['description'];

    echo "<script type=\"text/javascript\">
        activityinfo = {
        activity_id: '$activity_id',
        place: '$place',
        latitude : $latitude,
        longitude : $longitude,
        start_date: new Date('$start_date'),
        end_date: new Date('$end_date'),
        description: '$description'
      }
      activityarray.push(activityinfo);
    </script>
   ";
  }
  /*ACTIVITY INFO*/
  ?>
</body>
</html>
