DocGraph Data
========

The data release system for DocGraph, the doctor social graph

This is a <a href='http://notonlyfor.com'>Not Only Development</a> and <a href='http://docgraph.org'>DocGraph Journal</a> project.

DocGraph Software
========

In order to make the DocGraph system more usable, we are releasing some tools that serve to simplify the node database (linked below).
This code will take the complex node structure from the NPPES and simplify it usefully. 

* We collaspe the complex names scheme into what you probably want to be able to search for and what you probably want to use as a label
* We toss out mailing address as not important, and only show practice address
* There is one and only one taxonmy for each provider type
* Toss out most of the random remaining fields (look in all.php to see what we are not including)

There are multiple possible taxonomies possible for every NPI. This taxonomy is a tree taxonomy which means that children taxonomies
of nodes are supposed to count as parent types. (i.e. a "surgeon" still counts as a "physician" a "heart surgeon" should count as a "surgeon" etc etc
This makes for a massive normalization headache since this tree must be traversed 
anytime searches by taxonomy are performed... to fix this we will need to move to a json output or something...
For now, the main decision that this script makes is "what taxonomy is 'really' the taxonomy. It makes that decision, based on a file called taxonomy.php, which contains priorities for every potential taxonomy.

For each NPI with multiple taxoomies, the user can modifiry the pirorties (lower numbers take precedence), so that their studied taxonmies will appear

If you would like to use this tool, clone the repo to your local drive with php-cli available... and then run the command

```bash
php simple_npi.php npidata_20130513-20130519.csv out.csv
```
The first argument is the link the NPPES node download. The second file is the resulting simple node database.
note that your npidata file will have differnt dates... 

Licenses
========

Generally, all of the data in this tarball is licensed under the Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) unless otherwise noted.
All of the software is licensed under the AGPL v3


If you download this data and merge it with other data, we expect you to release the resulting compilation under the CC BY-SA 3.0 license. If you deevlop software that leverages this data, you have to release it too, however, because CC is not a software license, we will consider any release of software that is approved by both the Free Software Foundation and the Open Source Initiative as being compliant with the Open Source requirements of the data release. 

Enjoy,
<a href='http://fredtrotter.com'>Fred Trotter</a>


Data
========
Please use and seed the torrent from this github repository...

If you need... here is the DropBox link...

<a href='http://bit.ly/DocGraph2011'>2011 DocGraph v1 edge data set</a>

<a href='http://nppes.viva-it.com/NPI_Files.html'>NPESS data download (the node database)</a>


Documentation
========
Take a look at the original <a href='http://strata.oreilly.com/2012/11/docgraph-open-social-doctor-data.html'>DocGraph Strata Article</a>

