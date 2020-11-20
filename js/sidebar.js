/* creating the sidebar*/

  var sidebar = L.control.sidebar('sidebar', {
    closeButton: false,
    position: 'left'
  });
  mymap.addControl(sidebar);

/* closing sidebar (2 ways) */
  mymap.on('click', function () {
    sidebar.hide();
  });

  var sidebarX=document.getElementById("sidebarX");
  sidebarX.addEventListener('click', hideSidebar );

  function hideSidebar(){
    sidebar.hide();
  }

  let about=document.getElementById("about");
  about.addEventListener('click', showAbout);

  function showAbout(){
    sidebar.show();
    var type="about";
    $("#sidebar-title").load("load-sidebar-title.php", {type: type});
    $("#sidebar-content").load("load-sidebar-content.php", {type: type});
  }

/*display sidebar with dynamic content on marker click*/
function onMarkerClick(e){
    sidebar.show();
    var id=e.target.markerID;
    var type=e.target.type;
    $("#sidebar-title").load("load-sidebar-title.php", {type: type, id: id});
    $("#sidebar-content").load("load-sidebar-content.php", {type: type, id: id});
}
