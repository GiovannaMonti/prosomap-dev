# ProsoMap
ProsoMap is part of a curricular internship project carried out at Università degli Studi di Milano. The internship's aim was to create a Single-Page Application for the visualization of a Prosopographic Atlas of literary works.

## General information

ProsoMap is a PHP-based application which requires PHP (version 7.3.0 or higher). The database where all the data is stored requires PostgreSQL (version 9.6 or higher), an open source DMBS for the management of relational databases.

A database dump can be found in this repository: the **prosomap-db-schema** file contains the database schema's dump, which can be interpreted by a PostgreSQL DBMS. The **prosomap-db-data** file stores all the test data used while developing the app. The database needs to be installed for the data to be displayed correctly on the map and in the sidebar section: export the schema and data files to a new PostgreSQL database to make it work.

## Notes
The current database name is set to **prosomap-dev** and the respective passoword is **prosomap**. These two parameters can be changed at any time: to make the application work with different parameters, the files named **index.php** and **load-sidebar-content.php** need to be modified.

Both files contain the following line:

```
$dbconn = pg_connect("dbname=prosomap-dev user=postgres password=prosomap") or die('Connection Failed');
```

To rename the database or change the password, replace the current name with the desired one in the **dbname** field, or the new password in the **password** field. 
