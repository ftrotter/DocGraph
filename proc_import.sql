
CREATE DATABASE IF NOT EXISTS munge;

CREATE TABLE IF NOT EXISTS munge.procdata (
  `npi` int(11) DEFAULT NULL,
  `nppes_provider_last_org_name` varchar(71) DEFAULT NULL,
  `nppes_provider_first_name` varchar(21) DEFAULT NULL,
  `nppes_provider_mi` varchar(2) DEFAULT NULL,
  `nppes_credentials` varchar(21) DEFAULT NULL,
  `nppes_provider_gender` varchar(2) DEFAULT NULL,
  `nppes_entity_code` varchar(2) DEFAULT NULL,
  `nppes_provider_street1` varchar(56) DEFAULT NULL,
  `nppes_provider_street2` varchar(56) DEFAULT NULL,
  `nppes_provider_city` varchar(41) DEFAULT NULL,
  `nppes_provider_zip` varchar(21) DEFAULT NULL,
  `nppes_provider_state` varchar(3) DEFAULT NULL,
  `nppes_provider_country` varchar(3) DEFAULT NULL,
  `provider_type` varchar(44) DEFAULT NULL,
  `medicare_participation_indicator` varchar(2) DEFAULT NULL,
  `place_of_service` varchar(2) DEFAULT NULL,
  `hcpcs_code` varchar(6) DEFAULT NULL,
  `hcpcs_description` varchar(31) DEFAULT NULL,
  `line_srvc_cnt` int(11) DEFAULT NULL,
  `bene_unique_cnt` int(11) DEFAULT NULL,
  `bene_day_srvc_cnt` int(11) DEFAULT NULL,
  `average_Medicare_allowed_amt` float DEFAULT NULL,
  `stdev_Medicare_allowed_amt` float DEFAULT NULL,
  `average_submitted_chrg_amt` float DEFAULT NULL,
  `stdev_submitted_chrg_amt` float DEFAULT NULL,
  `average_Medicare_payment_amt` float DEFAULT NULL,
  `stdev_Medicare_payment_amt` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



LOAD DATA LOCAL INFILE
-- change this to the location of your file
'/home/ftrotter/proc/Medicare-Physician-and-Other-Supplier-PUF-CY2012.txt' 
INTO TABLE 
munge.procdata
FIELDS TERMINATED BY '\t' IGNORE 2 LINES;

ALTER TABLE  munge.procdata ADD INDEX (  `npi` );
ALTER TABLE  munge.procdata ADD INDEX (  `place_of_service` );
ALTER TABLE  munge.procdata ADD INDEX (  `hcpcs_code` );
ALTER TABLE  munge.procdata ADD INDEX (  `provider_type` );

-- If you suspicious by nature, you can use this to prove to yourself that the aggregation is accurate.
-- HINT: it is.
-- ALTER TABLE  `procdata` ADD UNIQUE (
--	`npi` ,
--	`place_of_service` ,
--	`hcpcs_code`
--	);


