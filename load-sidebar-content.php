<?php
$dbconn = pg_connect("dbname=prosomap-dev user=postgres password=prosomap") or die('Connection Failed');

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
  </script>";

/* WORK PHP */

if($type=='work'){
  $getauthorinfo = pg_query("SELECT author.author_id, author.name, author.surname, authorship.type FROM author JOIN authorship on author.author_id=authorship.author_id JOIN work on authorship.work_id=work.work_id where work.work_id='$id'");
?>
  <script type="text/javascript"> var authorarray = []; </script>
<?php
  while ($result=pg_fetch_assoc($getauthorinfo)){
    $authorid=$result['author_id'];
    $authorname=$result['name'];
    $authorsurname=$result['surname'];
    $authortype=$result['type'];

    echo "<script type=\"text/javascript\">
        var authorinfo = {
          authorid: '$authorid',
          authorname: '$authorname',
          authorsurname: '$authorsurname',
          authortype: '$authortype'
      }
      authorarray.push(authorinfo);
    </script>
   ";
  }
  $getgenreinfo = pg_query("SELECT genre.genre from work join genre on work.genre=genre_id where work_id='$id'");
  while ($result=pg_fetch_assoc($getgenreinfo)){
    $genre=$result['genre'];

    echo "<script type=\"text/javascript\">
        var genreinfo = '$genre';
    </script>
   ";
  }
  $getlanginfo = pg_query("SELECT language.language from work join language on work.language=language_id where work_id='$id'");
  while ($result=pg_fetch_assoc($getlanginfo)){
    $language=$result['language'];

    echo "<script type=\"text/javascript\">
        var langinfo = '$language';
    </script>
   ";
  }
  $getsourceinfo = pg_query("SELECT DISTINCT source.source_id, source.name, source.type from work join derivation on derivation.work_id=work.work_id join source on derivation.source_id=source.source_id where work.work_id='$id'");
?>
  <script type="text/javascript"> var sourcearr = []; </script>
<?php
  while ($result=pg_fetch_assoc($getsourceinfo)){
    $sourceid=$result['source_id'];
    $sourcename=$result['name'];
    $sourcetype=$result['type'];

    echo "<script type=\"text/javascript\">
        var sourceinfo = {
          sourceid: '$sourceid',
          sourcename: '$sourcename',
          sourcetype: '$sourcetype'
      }
      sourcearr.push(sourceinfo);
    </script>
   ";
  }

  $getmentioninfo = pg_query("SELECT place.name from work join mention_place on work.work_id=mention_place.work_id join place on mention_place.place_id=place.place_id where work.work_id='$id'");
?>
  <script type="text/javascript"> var mentionarray = []; </script>
<?php
  while ($result=pg_fetch_assoc($getmentioninfo)){
    $mentioned=$result['name'];

    echo "<script type=\"text/javascript\">
      var mentioned = '$mentioned';
      mentionarray.push(mentioned);
    </script>
   ";
  }

  $getcitationinfo = pg_query("SELECT person.person_id, person.name, person.surname from person join citation on person.person_id=citation.person_id join work on citation.work_id=work.work_id where work.work_id='$id'");
?>
  <script type="text/javascript"> var citarray = []; </script>
<?php
  while ($result=pg_fetch_assoc($getcitationinfo)){
    $personid=$result['person_id'];
    $citname=$result['name'];
    $citsurname=$result['surname'];

    echo "<script type=\"text/javascript\">
        var citinfo = {
          personid: '$personid',
          citname: '$citname',
          citsurname: '$citsurname'
      }
      citarray.push(citinfo);
    </script>
   ";
  }

  $gettenzoneinfo = pg_query("SELECT person.person_id, person.name, person.surname from person join tenzone_with on person.person_id=tenzone_with.person_id join work on tenzone_with.work_id=work.work_id where work.work_id='$id'");
?>
  <script type="text/javascript"> var tenzonearray = []; </script>
<?php
  while ($result=pg_fetch_assoc($gettenzoneinfo)){
    $personid=$result['person_id'];
    $tenzonename=$result['name'];
    $tenzonesurname=$result['surname'];

    echo "<script type=\"text/javascript\">
        var tenzoneinfo = {
          personid: '$personid',
          tenzonename: '$tenzonename',
          tenzonesurname: '$tenzonesurname'
      }
      tenzonearray.push(tenzoneinfo);
    </script>
   ";
  }
  $getotherinfo = pg_query("SELECT incipit, repertoire, end_date_string, end_ante, end_post, rhyme_scheme, syllabic_pattern, metric_repertoire, body from work where work_id='$id'");
  while ($result=pg_fetch_assoc($getotherinfo)){
    $incipit=$result['incipit'];
    $repertoire=$result['repertoire'];
    $end_date_string=$result['end_date_string'];
    $end_ante=$result['end_ante'];
    $end_post=$result['end_post'];
    $rhyme_scheme=$result['rhyme_scheme'];
    $syllabic_pattern=$result['syllabic_pattern'];
    $metric_repertoire=$result['metric_repertoire'];
    $body=$result['body'];

    echo "<script type=\"text/javascript\">
      var otherinfo = {
        incipit: '$incipit',
        repertoire: '$repertoire',
        end_date_string: '$end_date_string',
        end_ante: '$end_ante',
        end_post: '$end_post',
        rhyme_scheme: '$rhyme_scheme',
        syllabic_pattern: '$syllabic_pattern',
        metric_repertoire: '$metric_repertoire',
        body: '$body'
      }
      </script>
    ";
  }
  $getalttitle = pg_query("SELECT alternative_title.title from alternative_title join work on alternative_title.work_id=work.work_id where work.work_id='$id'");
?>
  <script type="text/javascript"> var alttitlearray = []; </script>
<?php
  while ($result=pg_fetch_assoc($getalttitle)){
    $alttitle=$result['title'];

    echo "<script type=\"text/javascript\">
      var alttitle = '$alttitle';
      alttitlearray.push(alttitle);
    </script>
   ";
  }
  $getaltincipit = pg_query("SELECT alternative_incipit.incipit from alternative_incipit join work on alternative_incipit.work_id=work.work_id where work.work_id='$id'");
?>
  <script type="text/javascript"> var altincipitarray = []; </script>
<?php
  while ($result=pg_fetch_assoc($getaltincipit)){
    $altincipit=$result['incipit'];

    echo "<script type=\"text/javascript\">
      var altincipit = '$altincipit';
      altincipitarray.push(altincipit);
    </script>
   ";
  }
}



/* SOURCE PHP */

if($type=='source'){
  $getotherinfo = pg_query("SELECT source.type, sign, pressmark, source_date_string,post, ante, link_to_digital, body from source where source.source_id='$id'");
  while ($result=pg_fetch_assoc($getotherinfo)){
    $sourcetype=$result['type'];
    $sign=$result['sign'];
    $source_date_string=$result['source_date_string'];
    $ante=$result['ante'];
    $post=$result['post'];
    $link_to_digital=$result['link_to_digital'];
    $pressmark=$result['pressmark'];
    $body=$result['body'];

    echo "<script type=\"text/javascript\">
      var otherinfo = {
        sourcetype: '$sourcetype',
        sign: '$sign',
        source_date_string: '$source_date_string',
        ante: '$ante',
        post: '$post',
        link_to_digital: '$link_to_digital',
        pressmark: '$pressmark',
        body: '$body'
      }
      </script>
    ";
  }
  $getgenreinfo = pg_query("SELECT genre from source join source_genre on source.source_id = source_genre.source_id join genre on source_genre.genre_id = genre.genre_id where source.source_id='$id'");
  ?>
  <script type="text/javascript"> var genrearray= []; </script>
  <?php
  while ($result=pg_fetch_assoc($getgenreinfo)){
    $genre=$result['genre'];

    echo "<script type=\"text/javascript\">
      var genreinfo = '$genre';
      genrearray.push(genreinfo);
    </script>
   ";
  }
  $getlanginfo = pg_query("SELECT language.language from source join source_language on source.source_id = source_language.source_id join language on source_language.language_id = language.language_id where source.source_id='$id'");
  ?>
  <script type="text/javascript"> var languagearray= []; </script>
  <?php
  while ($result=pg_fetch_assoc($getlanginfo)){
    $language=$result['language'];

    echo "<script type=\"text/javascript\">
        var langinfo = '$language';
        languagearray.push(langinfo);
    </script>
   ";
  }

  $getworkinfo = pg_query("SELECT work.work_id, work.title from work join derivation on derivation.work_id=work.work_id join source on derivation.source_id=source.source_id where source.source_id='$id'");
  ?>
  <script type="text/javascript"> var workarr= []; </script>
  <?php
  while ($result=pg_fetch_assoc($getworkinfo)){
    $workid=$result['work_id'];
    $worktitle=$result['title'];

    echo "<script type=\"text/javascript\">
        var workinfo = {
          worktitle: '$worktitle',
          workid: '$workid'
        }
        workarr.push(workinfo);
    </script>
   ";
  }
}

/* PERSON PHP */

if($type=='person'){
  $getotherinfo = pg_query("SELECT type, birth_date_string, death_date_string, birth_ante, birth_post, death_ante, death_post, body from person where person.person_id='$id'");
  while ($result=pg_fetch_assoc($getotherinfo)){
    $persontype=$result['type'];
    $birth_date_string=$result['birth_date_string'];
    $death_date_string=$result['death_date_string'];
    $birth_ante=$result['birth_ante'];
    $birth_post=$result['birth_post'];
    $death_ante=$result['death_ante'];
    $death_post=$result['death_post'];
    $body=$result['body'];

    echo "<script type=\"text/javascript\">
      var otherinfo = {
        persontype: '$persontype',
        birth_date_string: '$birth_date_string',
        death_date_string: '$death_date_string',
        birth_ante: '$birth_ante',
        birth_post: '$birth_post',
        death_ante: '$death_ante',
        death_post: '$death_post',
        body: '$body'
      }
      </script>
    ";
  }
  $getlanginfo = pg_query("SELECT language.language from person join person_language on person.person_id = person_language.person_id join language on person_language.language_id = language.language_id where person.person_id='$id'");
  ?>
  <script type="text/javascript"> var languagearray= []; </script>
  <?php
  while ($result=pg_fetch_assoc($getlanginfo)){
    $language=$result['language'];

    echo "<script type=\"text/javascript\">
        var langinfo = '$language';
        languagearray.push(langinfo);
    </script>
   ";
  }
  $getrelativeinfo= pg_query("SELECT root, leaf, p1.name as rootname, p1.surname as rootsurname, relative.type, p2.name as leafname, p2.surname as leafsurname from relative join person p1 on root=p1.person_id join person p2 on leaf=p2.person_id where root='$id' or leaf='$id'");
  ?>
  <script type="text/javascript"> var relativearray= []; </script>
  <?php
  while ($result=pg_fetch_assoc($getrelativeinfo)){
    $root=$result['root'];
    $leaf=$result['leaf'];
    $rootname=$result['rootname'];
    $rootsurname=$result['rootsurname'];
    $leafname=$result['leafname'];
    $leafsurname=$result['leafsurname'];
    $type=$result['type'];

    echo "<script type=\"text/javascript\">
        var relativeinfo = {
          root: $root,
          leaf: $leaf,
          rootname: '$rootname',
          rootsurname: '$rootsurname',
          leafname: '$leafname',
          leafsurname: '$leafsurname',
          type: '$type'
        }
        relativearray.push(relativeinfo);
    </script>
   ";
  }
  $getauthorship=pg_query("SELECT work.work_id, work.title, work.incipit, authorship.type from person join author on person.person_id=author.author_id join authorship on author.author_id=authorship.author_id join work on authorship.work_id=work.work_id where person.person_id='$id'");
  ?>
  <script type="text/javascript"> var authorshiparray= []; </script>
  <?php
  while ($result=pg_fetch_assoc($getauthorship)){
    $workid=$result['work_id'];
    $title=$result['title'];
    $incipit=$result['incipit'];
    $authortype=$result['type'];

    echo "<script type=\"text/javascript\">
        var authorshipinfo = {
          workid: '$workid',
          title: '$title',
          incipit: '$incipit',
          authortype: '$authortype'
        }
        authorshiparray.push(authorshipinfo);
    </script>
   ";
  }
}

/* ACTIVITY PHP */

if($type=='activity'){

  $getpersoninfo=pg_query("SELECT person.person_id, person.name, person.surname from activity join person on activity.person_id=person.person_id where activity.activity_id='$id'");
  while ($result=pg_fetch_assoc($getpersoninfo)){
    $personid=$result['person_id'];
    $personname=$result['name'];
    $surname=$result['surname'];

    echo "<script type=\"text/javascript\">
      var personinfo = {
        personid: '$personid',
        personname: '$personname',
        surname: '$surname'
      }
    </script>
    ";
  }

  $getotherinfo=pg_query("SELECT start_date_string, end_date_string, start_ante, start_post, end_ante, end_post, body from activity where activity_id='$id'");
  while ($result=pg_fetch_assoc($getotherinfo)){
    $start_date_string=$result['start_date_string'];
    $end_date_string=$result['end_date_string'];
    $start_ante=$result['start_ante'];
    $start_post=$result['start_post'];
    $end_ante=$result['end_ante'];
    $end_post=$result['end_post'];
    $body=$result['body'];

    echo "<script type=\"text/javascript\">
      var otherinfo = {
        start_date_string: '$start_date_string',
        end_date_string: '$end_date_string',
        start_ante: '$start_ante',
        start_post: '$start_post',
        end_ante: '$end_ante',
        end_post: '$end_post',
        body: '$body'
      }
    </script>
    ";
  }
}
?>

<script>
var sidebarContent=document.getElementById("sidebar-content");

/* ABOUT JS */

if(markertype=="about"){
  var tabs=document.createElement('div');
  tabs.className='btn-group btn-group-md';
  tabs.id='about-tabs';
  sidebarContent.appendChild(tabs);

  var legendButton=document.createElement('button');
  legendButton.className='btn btn-info';
  legendButton.textContent='Legend';
  legendButton.addEventListener('click', showLegend);
  tabs.appendChild(legendButton);
  var resourceButton=document.createElement('button');
  resourceButton.className='btn btn-dark';
  resourceButton.textContent='Resources';
  resourceButton.addEventListener('click', showResources);
  tabs.appendChild(resourceButton);
  var issueButton=document.createElement('button');
  issueButton.className='btn btn-warning';
  issueButton.textContent='Issues';
  issueButton.addEventListener('click', showIssues);
  tabs.appendChild(issueButton);

  let tabContent=document.createElement('div');
  sidebarContent.appendChild(tabContent);

  function showLegend(){
    tabContent.innerHTML='<p><b>ProsoMap</b> is a platform where you can visualize various information about people, works, sources and activities, all on a map!</p><p>The <b>markers</b> represent different types of elements. Here\'s a small legend:</p><ul style="list-style-type:none;"><li><i class="fas fa-user"></i> People</li><li><i class="fas fa-book-open"></i> Works</li><li><i class="fas fa-scroll"></i> Sources</li><li><i class="fas fa-chess-rook"></i> Activities</li></ul><p>When the map is zoomed out, groups of markers are shown as <b>clusters</b>, like this:</p><img src="css/images/about-clusters.png" alt="cluster example" width=269 height=215 style="margin-bottom:15px;"><p>Use the <b>timeline</b> below to select only the markers from the desired time span. The range is 100 years.</p>';
  }
  function showResources() {
    tabContent.innerHTML='<p>The data in this application is stored in a postrgeSQL database.<p><p>The map is implemented with the <a href="https://leafletjs.com">leaflet.js</a> library, with some additional plugins: <a href="https://github.com/turbo87/leaflet-sidebar/">Leaflet Sidebar</a>, <a href="https://github.com/Leaflet/Leaflet.markercluster">Leaflet Markercluster</a>, <a href="https://github.com/ghybs/Leaflet.FeatureGroup.SubGroup">Leaflet Feature Group/Subgroup</a>.</p><p>The timeline is made with the <a href="https://visjs.github.io/vis-timeline/docs/timeline/">vis.js</a> library.</p><p>ProsoMap is a thesis project for <i>Università degli Studi di Milano</i>, inspired by the platform: <a href="https://oiko.world">oiko.world</a>';
  }
  function showIssues() {
    tabContent.innerHTML='<p>There are some interaction issues between the timeline and the leaflet control <img src="css/images/leaflet_control.png" width=35 height=35>. Through the control you can show and hide specific types of markers on the map. If you use the timeline, you can use the control to only view the marker types you need in a specific time span. <b>When you deselect a marker type and select it again, all the markers of that type are shown, regardless the time span.</b></p><p> If you press the <b>Reset Map</b> button, all markers will be shown again. There is a visual bug in the control which causes <b>the checkbox of previously deselected markers to remain unchecked<b>.</p>';
  }
}

/* WORK JS*/

if(markertype=="work"){
  var thiswork;
  for(i=0; i<workarray.length; i++){
    if(workarray[i].work_id==markerid){
      thiswork=workarray[i];
      break;
    }
  }
  var place=thiswork.place;

 /* general information */
  let generalDiv=document.createElement('div');
  generalDiv.className='sidebar-div';
  let generalTitle = document.createElement('p');
  generalTitle.className='sidebar-subtitle';
  generalTitle.innerHTML = '<i class="fas fa-info-circle"></i> '+'GENERAL INFORMATION';
  generalDiv.appendChild(generalTitle);
    /*author*/
  authorarray.forEach( item =>{
    let author = document.createElement('p');
    author.innerHTML = '<b>Author:</b> ' + item.authorname + ' ' + item.authorsurname + ' ('+item.authortype+')';
    author.className="sidebar-item sidebar-link";
    author.markerID=item.authorid;
    author.type="person";
    author.addEventListener('click', onMarkerClick);
    generalDiv.appendChild(author);
  })
    /*genre*/
  let genre = document.createElement('p');
  genre.className = 'sidebar-item';
  genre.innerHTML = '<b>Genre:</b> ' + genreinfo;
  generalDiv.appendChild(genre);

    /*language*/
  let language = document.createElement('p');
  language.className = 'sidebar-item';
  language.innerHTML = '<b>Language:</b> ' + langinfo;
  language.style.marginTop='1px';
  language.style.marginBottom='1px';
  generalDiv.appendChild(language);

    /*source*/
  sourcearr.forEach( item =>{
    let source = document.createElement('p');
    source.innerHTML = '<b>Source:</b> ' + item.sourcename + ' ' + ' ('+item.sourcetype+')';
    source.className="sidebar-item sidebar-link";
    source.markerID=item.sourceid;
    source.type="source";
    source.addEventListener('click', onMarkerClick);
    generalDiv.appendChild(source);
  })
  sidebarContent.appendChild(generalDiv);

  /*place and time*/
  let placedateDiv=document.createElement('div');
  placedateDiv.className='sidebar-div';
  let placedateTitle = document.createElement('p');
  placedateTitle.className='sidebar-subtitle';
  placedateTitle.innerHTML = '<i class="fas fa-globe"></i> '+'PLACE AND TIME';
  placedateDiv.appendChild(placedateTitle);

  let placeinfo = document.createElement('p');
  placeinfo.innerHTML = '<b>Place of composition:</b> ' + place;
  placeinfo.className = 'sidebar-item';
  placedateDiv.appendChild(placeinfo);

  let dateinfo = document.createElement('p');
  dateinfo.innerHTML = '<b>Date of composition:</b> ' + otherinfo.end_date_string;
  dateinfo.className = 'sidebar-item';
  placedateDiv.appendChild(dateinfo);

  sidebarContent.appendChild(placedateDiv);

  /*related to this work */

  let relatedDiv=document.createElement('div');
  relatedDiv.className='sidebar-div';
  let relatedTitle = document.createElement('p');
  relatedTitle.className='sidebar-subtitle';
  relatedTitle.innerHTML = '<i class="fas fa-angle-double-right"></i> ' + 'RELATED TO THIS WORK';
  relatedDiv.appendChild(relatedTitle);

    /*mentioned places*/
  if(mentionarray[0]!=null){
    mentionarray.forEach( item =>{
      let mention = document.createElement('p');
      mention.className = 'sidebar-item';
      mention.innerHTML = '<b>Mentioned place:</b> ' + item ;
      relatedDiv.appendChild(mention);
    })
  }

    /*mentioned people*/
  if(citarray[0]!=null){
    citarray.forEach( item =>{
      let cit = document.createElement('p');
      cit.innerHTML = '<b>Mentioned person:</b> ' + item.citname + ' ' + item.citsurname ;
      cit.className="sidebar-item sidebar-link";
      cit.markerID=item.personid;
      cit.type="person";
      cit.addEventListener('click', onMarkerClick);
      relatedDiv.appendChild(cit);
    })
  }
    /*tenzone with*/
  if(tenzonearray[0]!=null){
    tenzonearray.forEach( item =>{
      let tenzone = document.createElement('p');
      tenzone.innerHTML = '<b>Tenzone with:</b> ' + item.tenzonename + ' ' + item.tenzonesurname ;
      tenzone.className='sidebar-item sidebar-link';
      tenzone.markerID=item.personid;
      tenzone.type="person";
      tenzone.addEventListener('click', onMarkerClick);
      relatedDiv.appendChild(tenzone);
    })
  }
  if(mentionarray[0]!=null || citarray[0]!=null || tenzonearray[0]!=null){
    sidebarContent.appendChild(relatedDiv);
  }

  /*other information */
  let otherDiv=document.createElement('div');
  otherDiv.className='sidebar-div';

  let otherTitle = document.createElement('p');
  otherTitle.className='sidebar-subtitle';
  otherTitle.innerHTML = '<i class="far fa-sticky-note"></i> ' + 'OTHER INFORMATION';
  otherDiv.appendChild(otherTitle);

  if(alttitlearray[0]!=null){
    alttitlearray.forEach( item =>{
      let altt = document.createElement('p');
      altt.innerHTML = '<b>Alternative title:</b> ' + item ;
      altt.className='sidebar-item';
      otherDiv.appendChild(altt);
    })
  }

  if(otherinfo.incipit!=''){
    let incipit = document.createElement('p');
    incipit.innerHTML = '<b>Incipit:</b> ' + otherinfo.incipit;
    incipit.className='sidebar-item';
    otherDiv.appendChild(incipit);
  }

  if(altincipitarray[0]!=null){
    altincipitarray.forEach( item =>{
      let alti = document.createElement('p');
      alti.innerHTML = '<b>Alternative incipit:</b> ' + item ;
      alti.className='sidebar-item';
      otherDiv.appendChild(alti);
    })
  }

  let repertoire = document.createElement('p');
  repertoire.innerHTML = '<b>Repertoire:</b> ' + otherinfo.repertoire;
  repertoire.className='sidebar-item';
  otherDiv.appendChild(repertoire);

  let end_ante = document.createElement('p');
  end_ante.innerHTML = '<b>Date of composition (ante):</b> ' + otherinfo.end_ante;
  end_ante.className='sidebar-item';
  otherDiv.appendChild(end_ante);

  let end_post = document.createElement('p');
  end_post.innerHTML = '<b>Date of composition (post):</b> ' + otherinfo.end_post;
  end_post.className='sidebar-item';
  otherDiv.appendChild(end_post);

  if(otherinfo.rhyme_scheme!=''){
    let rhyme_scheme = document.createElement('p');
    rhyme_scheme.innerHTML = '<b>Rhyme scheme:</b> ' + otherinfo.rhyme_scheme;
    rhyme_scheme.className='sidebar-item';
    otherDiv.appendChild(rhyme_scheme);
  }
  if(otherinfo.syllabic_pattern!=''){
    let syllabic_pattern = document.createElement('p');
    syllabic_pattern.innerHTML = '<b>Syllabic pattern:</b> ' + otherinfo.syllabic_pattern;
    syllabic_pattern.className='sidebar-item';
    otherDiv.appendChild(syllabic_pattern);
  }
  if(otherinfo.metric_repertoire!=''){
    let metric_repertoire = document.createElement('p');
    metric_repertoire.innerHTML = '<b>Metric repertoire:</b> ' + otherinfo.metric_repertoire;
    metric_repertoire.className='sidebar-item';
    otherDiv.appendChild(metric_repertoire);
    console.log(otherinfo.metric_repertoire);
  }

  sidebarContent.appendChild(otherDiv);

  let bodyDiv=document.createElement('div');
  bodyDiv.className='sidebar-div';

  let bodyTitle = document.createElement('p');
  bodyTitle.className='sidebar-subtitle';
  bodyTitle.innerHTML = '<i class="fas fa-pencil-alt"></i> ' + 'NOTES';
  bodyDiv.appendChild(bodyTitle);

  if(otherinfo.body!=''){
    let notes = document.createElement('p');
    notes.innerHTML = '<b>Note:</b> ' + otherinfo.body;
    notes.className='sidebar-item';
    bodyDiv.appendChild(notes);
    sidebarContent.appendChild(bodyDiv);
  }
}

/* SOURCE JS*/

if(markertype=="source"){
  var thissource;
  for(i=0; i<sourcearray.length; i++){
    if(sourcearray[i].source_id==markerid){
      thissource=sourcearray[i];
      break;
    }
  }

  var place=thissource.sourceplace;

 /* general information */

  let generalDiv=document.createElement('div');
  generalDiv.className='sidebar-div';
  let generalTitle = document.createElement('p');
  generalTitle.className='sidebar-subtitle';
  generalTitle.innerHTML = '<i class="fas fa-info-circle"></i> '+'GENERAL INFORMATION';
  generalDiv.appendChild(generalTitle);

    /* source type */
  let sourcetype = document.createElement('p');
  sourcetype.innerHTML = '<b>Type:</b> ' + otherinfo.sourcetype;
  sourcetype.className='sidebar-item';
  generalDiv.appendChild(sourcetype);

    /*genre*/

  genrearray.forEach( item =>{
    let genre = document.createElement('p');
    genre.innerHTML = '<b>Genre:</b> ' + item;
    genre.className='sidebar-item';
    generalDiv.appendChild(genre);
  })

    /*language*/
  languagearray.forEach( item =>{
    let language = document.createElement('p');
    language.innerHTML = '<b>Language:</b> ' + item;
    language.className='sidebar-item';
    generalDiv.appendChild(language);
  })

  sidebarContent.appendChild(generalDiv);

  /*place and time*/
  let placedateDiv=document.createElement('div');
  placedateDiv.className='sidebar-div';

  let placedateTitle = document.createElement('p');
  placedateTitle.className='sidebar-subtitle';
  placedateTitle.innerHTML = '<i class="fas fa-globe"></i> '+'PLACE AND TIME';
  placedateDiv.appendChild(placedateTitle);

  let placeinfo = document.createElement('p');
  placeinfo.innerHTML = '<b>Place of production:</b> ' + place;
  placeinfo.className='sidebar-item';
  placedateDiv.appendChild(placeinfo);

  let dateinfo = document.createElement('p');
  if(otherinfo.source_date_string!=''){
    dateinfo.innerHTML = '<b>Date:</b> ' + otherinfo.source_date_string;
  }
  else{
    dateinfo.innerHTML = '<b>Date:</b> Unknown';
  }
  dateinfo.className='sidebar-item';
  placedateDiv.appendChild(dateinfo);

  sidebarContent.appendChild(placedateDiv);

  /* contained in this source */
  let containedDiv=document.createElement('div');
  containedDiv.className='sidebar-div';

  let containedTitle = document.createElement('p');
  containedTitle.className='sidebar-subtitle';
  containedTitle.innerHTML = '<i class="fas fa-book-open"></i> '+'CONTAINED IN THIS SOURCE';
  containedDiv.appendChild(containedTitle);

    /*contained works */
  workarr.forEach( item =>{
    let worktitle = document.createElement('p');
    worktitle.innerHTML = '<b>Work:</b> ' + item.worktitle;
    worktitle.className='sidebar-item sidebar-link';
    worktitle.markerID=item.workid;
    worktitle.type="work";
    worktitle.addEventListener('click', onMarkerClick);
    containedDiv.appendChild(worktitle);
  })

  sidebarContent.appendChild(containedDiv);

  /*other information*/
  let otherDiv=document.createElement('div');
  otherDiv.className='sidebar-div';

  let otherTitle = document.createElement('p');
  otherTitle.className='sidebar-subtitle';
  otherTitle.innerHTML = '<i class="far fa-sticky-note"></i> ' + 'OTHER INFORMATION';
  otherDiv.appendChild(otherTitle);

  if(otherinfo.pressmark!=''){
    let pressmark = document.createElement('p');
    pressmark.innerHTML = '<b>Pressmark:</b> ' + otherinfo.pressmark;
    pressmark.className='sidebar-item';
    otherDiv.appendChild(pressmark);
  }

  if(otherinfo.sign!=''){
    let sign = document.createElement('p');
    sign.innerHTML = '<b>Sign:</b> ' + otherinfo.sign;
    sign.className='sidebar-item';
    otherDiv.appendChild(sign);
  }

  if(otherinfo.ante!=''){
    let ante = document.createElement('p');
    ante.innerHTML = '<b>Date (ante):</b> ' + otherinfo.ante;
    ante.className='sidebar-item';
    otherDiv.appendChild(ante);
  }
  if(otherinfo.post!=''){
    let post = document.createElement('p');
    post.innerHTML = '<b>Date (post):</b> ' + otherinfo.post;
    post.className='sidebar-item';
    otherDiv.appendChild(post);
  }
  if(otherinfo.link_to_digital!=''){
    let link_to_digital = document.createElement('p');
    link_to_digital.innerHTML = '<b>Link to digital copy:</b> ' + otherinfo.link_to_digital;
    link_to_digital.className='sidebar-item';
    otherDiv.appendChild(link_to_digital);
  }
  if(otherinfo.pressmark!='' || otherinfo.sign!='' || otherinfo.ante!=null || otherinfo.post!=null || otherinfo.link_to_digital!=''){
    sidebarContent.appendChild(otherDiv);
  }
  let bodyDiv=document.createElement('div');
  bodyDiv.className='sidebar-div';

  let bodyTitle = document.createElement('p');
  bodyTitle.className='sidebar-subtitle';
  bodyTitle.innerHTML = '<i class="fas fa-pencil-alt"></i> ' + 'NOTES';
  bodyDiv.appendChild(bodyTitle);

  if(otherinfo.body!=''){
    let notes = document.createElement('p');
    notes.innerHTML = '<b>Note:</b> ' + otherinfo.body;
    notes.className='sidebar-item';
    bodyDiv.appendChild(notes);
    sidebarContent.appendChild(bodyDiv);
  }
}

/* PERSON JS */

if(markertype=="person"){
  var thisperson;
  for(i=0; i<personarray.length; i++){
    if(personarray[i].person_id==markerid){
      thisperson=personarray[i];
      break;
    }
  }
  var place_of_origin=thisperson.place;

 /* general information */
  let generalDiv=document.createElement('div');
  generalDiv.className='sidebar-div';

  let generalTitle = document.createElement('p');
  generalTitle.className='sidebar-subtitle';
  generalTitle.innerHTML = '<i class="fas fa-info-circle"></i> '+'GENERAL INFORMATION';
  generalDiv.appendChild(generalTitle);

    /* senhal */
  if(otherinfo.senhal!=null){
    let senhal = document.createElement('p');
    senhal.innerHTML = '<b>Senhal:</b> ' + otherinfo.senhal;
    senhal.className='sidebar-item';
    generalDiv.appendChild(senhal);
  }

    /* type */
  let persontype = document.createElement('p');
  persontype.innerHTML = '<b>Type:</b> ' + otherinfo.persontype;
  persontype.className='sidebar-item';
  generalDiv.appendChild(persontype);

    /*language*/
  languagearray.forEach( item =>{
    let language = document.createElement('p');
    language.innerHTML = '<b>Language:</b> ' + item;
    language.className='sidebar-item';
    generalDiv.appendChild(language);
  })

  sidebarContent.appendChild(generalDiv);

  /*place and time*/

  let placedateDiv=document.createElement('div');
  placedateDiv.className='sidebar-div';

  let placedateTitle = document.createElement('p');
  placedateTitle.className='sidebar-subtitle';
  placedateTitle.innerHTML = '<i class="fas fa-globe"></i> '+'ORIGIN';
  placedateDiv.appendChild(placedateTitle);

  let placeinfo = document.createElement('p');
  placeinfo.innerHTML = '<b>Place of birth:</b> ' + place_of_origin;
  placeinfo.className='sidebar-item';
  placedateDiv.appendChild(placeinfo);

  if(otherinfo.birth_date_string!=''){
    let birthdateinfo = document.createElement('p');
    birthdateinfo.innerHTML = '<b>Date of birth:</b> ' + otherinfo.birth_date_string;
    birthdateinfo.className='sidebar-item';
    placedateDiv.appendChild(birthdateinfo);
  }
  if(otherinfo.death_date_string!=''){
    let deathdateinfo = document.createElement('p');
    deathdateinfo.innerHTML = '<b>Date of death:</b> ' + otherinfo.death_date_string;
    deathdateinfo.className='sidebar-item';
    placedateDiv.appendChild(deathdateinfo);
  }

  sidebarContent.appendChild(placedateDiv);

  /* relatives */

  let relativeDiv=document.createElement('div');
  relativeDiv.className='sidebar-div';

  let relativeTitle = document.createElement('p');
  relativeTitle.className='sidebar-subtitle';
  relativeTitle.innerHTML = '<i class="fas fa-users"></i> ' + 'RELATIONSHIPS';
  relativeDiv.appendChild(relativeTitle);

  if(relativearray!=''){
    relativearray.forEach( item =>{
      let relative = document.createElement('p');
      let linkid;
      if(markerid==item.root){
        linkid=item.leaf;
        relative.innerHTML = '<b>Related to:</b> ' + item.leafname + ' ' + item.leafsurname+ ' ('+ item.type +')';
      }
      if(markerid==item.leaf && item.type!='parent'){
        linkid=item.root;
        relative.innerHTML = '<b>Related to:</b> ' + item.rootname + ' ' + item.rootsurname+ ' ('+ item.type +')';
      }
      if(markerid==item.leaf && item.type=='parent'){
        linkid=item.root;
        relative.innerHTML = '<b>Related to:</b> ' + item.rootname + ' ' + item.rootsurname+ ' (son/daughter)';
      }
      relative.className='sidebar-item sidebar-link';
      relative.markerID=linkid;
      relative.type="person";
      relative.addEventListener('click', onMarkerClick);
      relativeDiv.appendChild(relative);
    })
    sidebarContent.appendChild(relativeDiv);
  }

  /* authorship */

  let authorshipDiv=document.createElement('div');
  authorshipDiv.className='sidebar-div';

  let authorshipTitle = document.createElement('p');
  authorshipTitle.className='sidebar-subtitle';
  authorshipTitle.innerHTML = '<i class="fas fa-book-open"></i> ' + 'AUTHORSHIP';
  authorshipDiv.appendChild(authorshipTitle);

  if(otherinfo.persontype=='author' && authorshiparray!=''){
    authorshiparray.forEach( item =>{
      let thiswork = document.createElement('p');
      if(item.title!=null){
        thiswork.innerHTML = '<b>Work:</b> ' + item.title + ' ' + ' ('+ item.authortype +')';
      }
      else{
        thiswork.innerHTML = '<b>Work:</b> ' + item.incipit + ' ' + ' ('+ item.authortype +')';
      }
      thiswork.className='sidebar-item sidebar-link';
      thiswork.markerID=item.workid;
      thiswork.type="work";
      thiswork.addEventListener('click', onMarkerClick);
      authorshipDiv.appendChild(thiswork);
    })
    sidebarContent.appendChild(authorshipDiv);
  }

  /*other information*/
  let otherDiv=document.createElement('div');
  otherDiv.className='sidebar-div';

  let otherTitle = document.createElement('p');
  otherTitle.className='sidebar-subtitle';
  otherTitle.innerHTML = '<i class="far fa-sticky-note"></i> ' + 'OTHER INFORMATION';
  otherDiv.appendChild(otherTitle);

  if(otherinfo.birth_ante!=''){
    let birth_ante = document.createElement('p');
    birth_ante.innerHTML = '<b>Birth date (ante):</b> ' + otherinfo.birth_ante;
    birth_ante.className='sidebar-item';
    otherDiv.appendChild(birth_ante);
  }

  if(otherinfo.birth_post!=''){
    let birth_post = document.createElement('p');
    birth_post.innerHTML = '<b>Birth date (post):</b> ' + otherinfo.birth_post;
    birth_post.className='sidebar-item';
    otherDiv.appendChild(birth_post);
  }

  if(otherinfo.death_ante!=''){
    let death_ante = document.createElement('p');
    death_ante.innerHTML = '<b>Death date (ante):</b> ' + otherinfo.death_ante;
    death_ante.className='sidebar-item';
    otherDiv.appendChild(death_ante);
  }

  if(otherinfo.death_post!=''){
    let death_post = document.createElement('p');
    death_post.innerHTML = '<b>Death date (post):</b> ' + otherinfo.death_post;
    death_post.className='sidebar-item';
    otherDiv.appendChild(death_post);
  }

  if(otherinfo.birth_ante!='' || otherinfo.birth_post!='' || otherinfo.death_ante!='' || otherinfo.death_post!=''){
    sidebarContent.appendChild(otherDiv);
  }

  /* notes */

  let bodyDiv=document.createElement('div');
  bodyDiv.className='sidebar-div';

  let bodyTitle = document.createElement('p');
  bodyTitle.className='sidebar-subtitle';
  bodyTitle.innerHTML = '<i class="fas fa-pencil-alt"></i> ' + 'NOTES';
  bodyDiv.appendChild(bodyTitle);

  if(otherinfo.body!=''){
    let notes = document.createElement('p');
    notes.innerHTML = '<b>Note:</b> ' + otherinfo.body;
    notes.className='sidebar-item';
    bodyDiv.appendChild(notes);
    sidebarContent.appendChild(bodyDiv);
  }
}
/* ACTIVITY JS*/

/* people involved */
if(markertype=='activity'){
  var thisactivity;
  for(i=0; i<activityarray.length; i++){
    if(activityarray[i].activity_id==markerid){
      thisactivity=activityarray[i];
      break;
    }
  }

  let peopleDiv=document.createElement('div');
  peopleDiv.className='sidebar-div';

  let peopleTitle = document.createElement('p');
  peopleTitle.className='sidebar-subtitle';
  peopleTitle.innerHTML = '<i class="fas fa-users"></i> ' + 'PEOPLE INVOLVED';
  peopleDiv.appendChild(peopleTitle);

  let personinvolved = document.createElement('p');
  personinvolved.innerHTML = '<b>Person:</b> ' + personinfo.personname + ' '+ personinfo.surname;
  personinvolved.className='sidebar-item sidebar-link';
  personinvolved.markerID=personinfo.personid;
  personinvolved.type="person";
  personinvolved.addEventListener('click', onMarkerClick);
  peopleDiv.appendChild(personinvolved);

  sidebarContent.appendChild(peopleDiv);

  /*place and time*/

  let placedateDiv=document.createElement('div');
  placedateDiv.className='sidebar-div';

  let placedateTitle = document.createElement('p');
  placedateTitle.className='sidebar-subtitle';
  placedateTitle.innerHTML = '<i class="fas fa-globe"></i> '+'PLACE AND TIME';
  placedateDiv.appendChild(placedateTitle);

  let placeinfo = document.createElement('p');
  placeinfo.innerHTML = '<b>Place:</b> ' + thisactivity.place;
  placeinfo.className='sidebar-item';
  placedateDiv.appendChild(placeinfo);

  let startdateinfo = document.createElement('p');
  startdateinfo.innerHTML = '<b>Start date:</b> ' + otherinfo.start_date_string;
  startdateinfo.className='sidebar-item';
  placedateDiv.appendChild(startdateinfo);

  if(otherinfo.start_ante!=''){
    let startante = document.createElement('p');
    startante.innerHTML = '<b>Start date (ante):</b> ' + otherinfo.start_ante;
    startante.className='sidebar-item';
    placedateDiv.appendChild(startante);
  }
  if(otherinfo.start_post!=''){
    let startpost = document.createElement('p');
    startpost.innerHTML = '<b>Start date (ante):</b> ' + otherinfo.start_post;
    startpost.className='sidebar-item';
    placedateDiv.appendChild(startpost);
  }
  if(otherinfo.end_date_string!=''){
    let enddateinfo = document.createElement('p');
    enddateinfo.innerHTML = '<b>End date:</b> ' + otherinfo.end_date_string;
    enddateinfo.className='sidebar-item';
    placedateDiv.appendChild(enddateinfo);
  }
  if(otherinfo.end_ante!=''){
    let endante = document.createElement('p');
    endante.innerHTML = '<b>Start date (ante):</b> ' + otherinfo.end_ante;
    endante.className='sidebar-item';
    placedateDiv.appendChild(endante);
  }
  if(otherinfo.end_post!=''){
    let endpost = document.createElement('p');
    endpost.innerHTML = '<b>Start date (ante):</b> ' + otherinfo.end_post;
    endpost.className='sidebar-item';
    placedateDiv.appendChild(endpost);
  }

  sidebarContent.appendChild(placedateDiv);

  /* notes */

  let bodyDiv=document.createElement('div');
  bodyDiv.className='sidebar-div';

  let bodyTitle = document.createElement('p');
  bodyTitle.className='sidebar-subtitle';
  bodyTitle.innerHTML = '<i class="fas fa-pencil-alt"></i> ' + 'NOTES';
  bodyDiv.appendChild(bodyTitle);

  if(otherinfo.body!=''){
    let notes = document.createElement('p');
    notes.innerHTML = '<b>Note:</b> ' + otherinfo.body;
    notes.className='sidebar-item';
    bodyDiv.appendChild(notes);
    sidebarContent.appendChild(bodyDiv);
  }
}

</script>
