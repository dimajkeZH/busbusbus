/* DROP GARBAGE */
DROP DATABASE IF EXISTS BUSBUSBUS;
CREATE DATABASE BUSBUSBUS CHARACTER SET UTF8 COLLATE UTF8_General_Ci;
/* DROP GARBAGE END */

/* CREATE TABLES */
USE BUSBUSBUS;
CREATE TABLE LIB_TEMPLATES(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`NAME` VARCHAR(128) NOT NULL,
	`PATH` VARCHAR(128) NOT NULL,
	`ID_TYPE` INT(11) NOT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE LIB_TEMPLATE_TYPES(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`NAME` VARCHAR(128) NOT NULL,
	`DESCR` VARCHAR(256) DEFAULT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE LIB_LOCATIONS(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`NAME` VARCHAR(128) NOT NULL,
	`CONTROLLER` VARCHAR(128) NOT NULL,
	`ACTION` VARCHAR(128) NOT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE LIB_FIELD_TYPES(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`NAME` VARCHAR(128) NOT NULL,
	`VALUE` INT(3) NOT NULL,
	`DESCR` VARCHAR(256),
	PRIMARY KEY(`ID`)
);

CREATE TABLE LIB_VIEWS(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`NAME` VARCHAR(128) NOT NULL,
	`DESCR` VARCHAR(256),
	PRIMARY KEY(`ID`)
);

CREATE TABLE LIB_VIEW_FIELDS(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_VIEW` INT(11) NOT NULL,
	`CMS_TITLE` VARCHAR(128) NOT NULL,
	`CMS_DESCR` VARCHAR(256) NOT NULL,
	`CMS_TYPE` INT(3) NOT NULL,
	`VAR` VARCHAR(128) NOT NULL,
	PRIMARY KEY(`ID`)
);


CREATE TABLE PAGES(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_LOCATION` INT(11) NOT NULL,
	`ID_VIEW` INT(11) NOT NULL,
	`ID_PARENT` INT(11) NOT NULL,

	`CAN_BE_SUPPLEMENTED` INT(1) NOT NULL,
	`MAY_HAVE_THE_PARENT` INT(1) NOT NULL,
	
	`URI` VARCHAR(128) NOT NULL,
	`LOC_NUMBER` INT(3) NOT NULL,

	`CHOICE_TITLE` VARCHAR(64) NOT NULL,
	
	`IMAGE` VARCHAR(128) NOT NULL,
	`IMAGE_SIGN` VARCHAR(256) NOT NULL,

	`HTML_TITLE` VARCHAR(64) NOT NULL,
	`HTML_DESCR` VARCHAR(512) NOT NULL,
	`HTML_KEYWORDS` VARCHAR(512) NOT NULL,

	PRIMARY KEY(`ID`)
);

	CREATE TABLE PAGE_CONTENT(
		`ID` INT(11) NOT NULL AUTO_INCREMENT,
		`ID_PAGE` INT(11) NOT NULL,

		`ID_FIELD` INT(11) NOT NULL,
		`VAL` VARCHAR(2048) NOT NULL,

		PRIMARY KEY(`ID`)
	);








/* INDEX */
/* INDEX END */

/* List Images */
/* List Images END */

/* List Short */
/* List Short END */

/* Transport */
/* Transport END */

/* Contacts */
/* Contacts END */










#INSERT INTO PAGE_CONTENT (`ID_FULL_PAGE`, `CMS_TITLE`, `CMS_DESCR`, `CMS_TYPE`, `VAR`, `VAL`) VALUES
/* Order Images */
#common
	#(0, '', '', 0, 'CHOICE_TITLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'HTML_DESCR', ''),
	#(0, '', '', 0, 'HTML_KEYWORDS', ''),
#header images
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'LEFT_IMAGE', ''),
	#(0, '', '', 0, 'LEFT_IMAGE_SIGN', ''),
	#(0, '', '', 0, 'RIGHT_IMAGE', ''),
	#(0, '', '', 0, 'RIGHT_IMAGE_SIGN', ''),
	#(0, '', '', 0, 'MIDDLE_IMAGE', ''),
	#(0, '', '', 0, 'MIDDLE_IMAGE_SIGN', ''),
#multitable
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'SUBTITLE', ''),
	#(0, '', '', 0, 'ID_MULTITABLE', ''),
	#(0, '', '', 0, 'SUBTITLE', ''),
	#(0, '', '', 0, 'SERIAL_NUMBER', ''),
#table
	#(0, '', '', 0, 'ID_TABLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'SUBTITLE', ''),
#text
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'TEXT', ''),
/* Order Images END */



/* Order Form */
#common
	#(0, '', '', 0, 'CHOICE_TITLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'HTML_DESCR', ''),
	#(0, '', '', 0, 'HTML_KEYWORDS', ''),
#header order
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'LEFT_IMAGE', ''),
	#(0, '', '', 0, 'LEFT_IMAGE_SIGN', ''),
	#(0, '', '', 0, 'RIGHT_IMAGE', ''),
	#(0, '', '', 0, 'RIGHT_IMAGE_SIGN', ''),
	#(0, '', '', 0, 'FORM_MODE', ''),
#table
	#(0, '', '', 0, 'ID_TABLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'SUBTITLE', ''),
#text
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'TEXT', ''),
#images
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE_LINK', ''),
	#(0, '', '', 0, 'SUBTITLE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'SERIAL_NUMBER', ''),
/* Order Form END */



/* Info Card */
#common
	#(0, '', '', 0, 'CHOICE_TITLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'HTML_DESCR', ''),
	#(0, '', '', 0, 'HTML_KEYWORDS', ''),
#text
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'TEXT', ''),
/* Info Card END */



/* Catalog */
#common
	#(0, '', '', 0, 'CHOICE_TITLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'HTML_DESCR', ''),
	#(0, '', '', 0, 'HTML_KEYWORDS', ''),
#links
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'IS_BUSES', ''),
	#(0, '', '', 0, 'IS_MINIVANS', ''),
#text
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'TEXT', ''),
/* Catalog END */



/* Exc1 */
#common
	#(0, '', '', 0, 'CHOICE_TITLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'HTML_DESCR', ''),
	#(0, '', '', 0, 'HTML_KEYWORDS', ''),
#Exc1

/* Exc1 END */



/* Exc0 */
#common
	#(0, '', '', 0, 'CHOICE_TITLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'HTML_DESCR', ''),
	#(0, '', '', 0, 'HTML_KEYWORDS', ''),
#header images
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'LEFT_IMAGE', ''),
	#(0, '', '', 0, 'LEFT_IMAGE_SIGN', ''),
	#(0, '', '', 0, 'RIGHT_IMAGE', ''),
	#(0, '', '', 0, 'RIGHT_IMAGE_SIGN', ''),
	#(0, '', '', 0, 'MIDDLE_IMAGE', ''),
	#(0, '', '', 0, 'MIDDLE_IMAGE_SIGN', ''),
#text
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'TEXT', ''),
#images
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE_LINK', ''),
	#(0, '', '', 0, 'SUBTITLE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'SERIAL_NUMBER', ''),
/* Exc1 END */



/* BUS */
#common
	#(0, '', '', 0, 'CHOICE_TITLE', ''),
	#(0, '', '', 0, 'TITLE', ''),
	#(0, '', '', 0, 'DESCR', ''),
	#(0, '', '', 0, 'IMAGE', ''),
	#(0, '', '', 0, 'IMAGE_SIGN', ''),
	#(0, '', '', 0, 'HTML_DESCR', ''),
	#(0, '', '', 0, 'HTML_KEYWORDS', ''),
#
/* BUS END */







CREATE TABLE DATA_VACANCIES(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`TITLE` VARCHAR(128) NOT NULL,
	`IMAGE` VARCHAR(128) NOT NULL,
	`DESCR` VARCHAR(1024) NOT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE DATA_BUSES(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_COUNTRY` INT(11) NOT NULL,
	`URI` VARCHAR(128) NOT NULL,
	`TITLE` VARCHAR(128) NOT NULL,
	`IMAGE_OUTER` VARCHAR(128) NOT NULL,
	`IMAGE_INNER` VARCHAR(128) NOT NULL,
	`TECH_TITLE` VARCHAR(1024) NOT NULL,
	`TECH_DESCR` VARCHAR(1024) NOT NULL,
	`SUBTITLE` VARCHAR(128) NOT NULL,
	`TEXT` VARCHAR(2048) NOT NULL,
	`SERIAL_NUMBER` INT(3) NOT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE DATA_MINIVANS(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_COUNTRY` INT(11) NOT NULL,
	`URI` VARCHAR(128) NOT NULL,
	`TITLE` VARCHAR(128) NOT NULL,
	`IMAGE_OUTER` VARCHAR(128) NOT NULL,
	`IMAGE_INNER` VARCHAR(128) NOT NULL,
	`TECH_TITLE` VARCHAR(1024) NOT NULL,
	`TECH_DESCR` VARCHAR(1024) NOT NULL,
	`SUBTITLE` VARCHAR(128) NOT NULL,
	`TEXT` VARCHAR(2048) NOT NULL,
	`SERIAL_NUMBER` INT(3) NOT NULL,
	PRIMARY KEY(`ID`)
);

	CREATE TABLE DATA_COUNTRIES(
		`ID` INT(11) NOT NULL AUTO_INCREMENT,
		`NAME` VARCHAR(128) NOT NULL,
		`TITLE` VARCHAR(128) NOT NULL,
		`IMAGE` VARCHAR(128) NOT NULL,
		`SERIAL_NUMBER` INT(3) NOT NULL,
		PRIMARY KEY(`ID`)
	);

CREATE TABLE DATA_NEWS(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`TITLE` VARCHAR(128) NOT NULL,
	`DATE_ADD` DATE NOT NULL,
	`TIME_ADD` TIME NOT NULL,
	`TEXT` VARCHAR(2048) NOT NULL,
	`IMAGE` VARCHAR(128) NOT NULL,
	`ON_INDEX` INT(1) NOT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE DATA_TABLE(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_TABLE` INT(11) NOT NULL,
	`ROW` INT(3) NOT NULL,
	`COL` INT(3) NOT NULL,
	`VAL` VARCHAR(256) DEFAULT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE DATA_MULTITABLE(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_MULTITABLE` INT(11) NOT NULL,
	`SUBTITLE` VARCHAR(128) NOT NULL,
	`SERIAL_NUMBER` INT(3) NOT NULL,
	PRIMARY KEY(`ID`)
);

	CREATE TABLE DATA_MULTITABLE_CONTENT(
		`ID` INT(11) NOT NULL AUTO_INCREMENT,
		`ID_DATA_MULTITABLE` INT(11) NOT NULL,
		`ROW` INT(3) NOT NULL,
		`COL` INT(3) NOT NULL,
		`VAL` VARCHAR(256) DEFAULT NULL,
		PRIMARY KEY(`ID`)
	);

CREATE TABLE DATA_IMAGES(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_IMAGES` INT(11) NOT NULL,
	`IMAGES_IMAGE_LINK` VARCHAR(128) NOT NULL,
	`IMAGES_IMAGE_SUBTITLE`  VARCHAR(128) NOT NULL,
	`IMAGES_IMAGE_SIGN`  VARCHAR(2048) NOT NULL,
	`SERIAL_NUMBER` INT(3) NOT NULL,
	PRIMARY KEY(`ID`)
);













CREATE TABLE ADMIN_ACCOUNTS(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`FULL_NAME` VARCHAR(64) NOT NULL,
	`NAME` VARCHAR(128) NOT NULL,
	`PASS` VARCHAR(128) NOT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE ADMIN_SESSIONS(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_ADMIN` INT(11) NOT NULL,
	`HASH_S` VARCHAR(128) NOT NULL,
	`HASH_C` VARCHAR(128) NOT NULL,
	`IP` VARCHAR(128) NOT NULL,
	`BROWSER` VARCHAR(256) NOT NULL,
	`DT_CREATE` DATETIME NOT NULL,
	`DT_DESTROY` DATETIME NOT NULL,
	PRIMARY KEY(`ID`)
);

CREATE TABLE ADMIN_LOGS(
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`ID_SESSION` INT(11) NOT NULL,
	`ID_TYPE` INT(11) NOT NULL,
	`CUR_ACTION` VARCHAR(128) NOT NULL,
	`DT_INCIDENT` DATETIME NOT NULL,
	PRIMARY KEY(`ID`)
);

	CREATE TABLE ADMIN_LOG_TYPES(
		`ID` INT(11) NOT NULL AUTO_INCREMENT,
		`NAME` VARCHAR(128) NOT NULL,
		`DESCR` VARCHAR(256) NOT NULL,
		PRIMARY KEY(`ID`)
	);
/* CREATE TABLES END */