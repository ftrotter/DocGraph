DocGraph Data
========

The data release system for DocGraph, the doctor social graph

This is a <a href='http://docgraph.org'>DocGraph Journal</a> project.

DocGraph Software
========

We also have some useful scripts here for munging NPI data...

Licenses
========

Generally, all of the data in this tarball is licensed under the Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) unless otherwise noted.
All of the software is licensed under the AGPL v3


If you download this data and merge it with other data, we expect you to release the resulting compilation under the CC BY-SA 3.0 license. If you deevlop software that leverages this data, you have to release it too, however, because CC is not a software license, we will consider any release of software that is approved by both the Free Software Foundation and the Open Source Initiative as being compliant with the Open Source requirements of the data release. 

Enjoy,
<a href='http://fredtrotter.com'>Fred Trotter</a>


Data
========

The DocGraph data set is available for download at <a href='http://docgraph.org'>DocGraph.org</a>

<a href='http://nppes.viva-it.com/NPI_Files.html'>NPESS data download (the node database)</a>


Documentation
========
Take a look at the original <a href='http://strata.oreilly.com/2012/11/docgraph-open-social-doctor-data.html'>DocGraph Strata Article</a>

Generally, running the command 

```
> php simple.php npi_data.currentversion.csv
```

This should output a new file called simple_npi.csv which will have just one taxonomy. The script chooses taxonomies based on the priority scales listed in [taxonomy.php](https://github.com/ftrotter/DocGraph/blob/master/taxonomy.php). Lower "priority" numbers in that file will be choosen over higher ones. Practically, if this means that you want to be sure that you get all of the Cardiologists in the data set, even if they are cross listed as Internal Medicine, then you need to find the two entries in the data (which look like this:
```
   '207RI0011X' => 
  array (
    'desc' => 'Interventional Cardiology',
    'priority' => 5,
  ),
```
.....
``` 
  '207R00000X' => 
  array (
    'desc' => 'Internal Medicine',
    'priority' => 3,
  ),
```
and change them to look like this:
```
   '207RI0011X' => 
  array (
    'desc' => 'Interventional Cardiology',
    'priority' => 2,
  ),
``` 
.....
``` 
    '207R00000X' => 
  array (
    'desc' => 'Internal Medicine',
    'priority' => 3,
  ),
```  
Now, the cardiology taxonomy will take priority and the script will prefer to Cardiologist. If you want to ensure that you have all the cardiologist no matter what.. just make the priority 1. I am pretty sure that there is no priority below 2 in the default file...
  
