<?php

/**
 * This class helps you to find xml nodes by given parameters. Ezgamel is a xml 
 * content filter tool. It can be used for a lot of porpuses. Ezgamel aims to 
 * provie a simple way to apply filter or search in xml files. 
 * 
 * This is a beta version.
 *
 * @author cagdas.emek
 * @
 */
class Egzamel {

    public static $xml_parser = null;
    public static $cursor_pos = -1;
    public static $result_set = array();
    public static $map_array = array();

    public static function startElement($_parser, $org_name, $attrs) {

	$name = mb_strtolower($org_name, 'UTF-8');
	if (isset(self::$map_array[$name])) {
	    $found = false;
	    if (is_array(self::$map_array[$name])) {
		foreach (self::$map_array[$name] as $attr => $val) {
		    if ($attrs[$attr] == $val) {
			$found = true;
			break;
		    }
		}
	    } else {
		$found = true;
	    }

	    if ($found) {
		self::$cursor_pos++;
		self::$result_set[self::$cursor_pos] = array('tag' => $org_name, 'value' => '', 'attrs' => $attrs);
		$found = false;
	    }
	}
    }

    public static function endElement($_parser, $org_name) {
//	$name = mb_strtolower($org_name, 'UTF-8');
//	if (isset(self::$map_array[$name])) {
//	    echo "</".$name.">";
//	}
    }

    public static function characterData($_parser, $data) {
//	echo self::$cursor_pos."--". $data;
//	$data = trim($data);
	if (isset(self::$result_set[self::$cursor_pos]['value']) && $data!=='' )
	    self::$result_set[self::$cursor_pos]['value'] = $data;
    }

    public static function toXml() {
	$xml = new SimpleXMLElement('<result/>');

	foreach (self::$result_set as $row) {
	    $xmlchild = $xml->addChild($row["tag"], $row["value"]);
	    if (sizeof($row["attrs"]) > 0) {
		foreach ($row["attrs"] as $attr => $val)
		    $xmlchild->addAttribute($attr, $val);
	    }
	}
	echo $xml->asXML();
	unset($xml);
    }
    
    public static function toArray()
    {
	return self::$result_set;
    }

    public static function parse($file, $map) {
	self::$map_array = $map;
	self::$xml_parser = xml_parser_create();
	// use case-folding so we are sure to find the tag in $map_array
	xml_parser_set_option(self::$xml_parser, XML_OPTION_SKIP_WHITE, true);
	xml_parser_set_option(self::$xml_parser, XML_OPTION_CASE_FOLDING, FALSE);
	xml_set_element_handler(self::$xml_parser, array(self, "startElement"), array(self, "endElement"));
	xml_set_character_data_handler(self::$xml_parser, array(self, "characterData"));
	if (!($fp = fopen($file, "r"))) {
	    die("could not open XML input");
	}

	while ($data = fread($fp, 4096)) {
	    if (!xml_parse(self::$xml_parser, $data, feof($fp))) {
		die(sprintf("XML error: %s at line %d", xml_error_string(xml_get_error_code(self::$xml_parser)), xml_get_current_line_number(self::$xml_parser)));
	    }
	}
	xml_parser_free(self::$xml_parser);
  
    }

}

?>
