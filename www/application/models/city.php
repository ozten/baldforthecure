<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Data entry on cities is probably going to be sloppy.
 * The cities table is a loose way to glop cities back together
 * for Leaderboards.
 * 
 * cities - id, user_city_name, canonical_citiy_name
 * 
 * user_city_name - lowercase version of the user's city
 * canonical_city_name - Displayable City name
 *
 * TODO - why won't
 ALTER TABLE
    users ADD CONSTRAINT city_id_fk FOREIGN KEY (city_id) REFERENCES cities (id)
 *
 * Started changing the design to just have user and city table and do funky
 * stuff against the user table of matching up good known
 */
class City_Model extends ORM
{
    //protected $belongs_to = array('user');
}
?>