Egzamel Examples
================

You can find examples of how to use Egzamel tool in your projects


First example
=============

A simple example of search nodes in the document.

 
    require_once '../class/Egzamel.php';

    $file = './data/example1.xml';
    $query = array(
	'student' => TRUE
    );

    Egzamel::parse($file, $query);
    Egzamel::toXml();
 

Output

    <?xml version="1.0"?>
    <result><student name="Matthew" surname="Gambardella" age="22" gender="male">
	</student><student name="Kim" surname="Ralls" age="23" gender="female">
	</student><student name="Cynthia" surname="Randall" age="23" gender="male">
	</student><student name="Eva" surname="Corets" age="22" gender="female">
	</student><student name="Paula" surname="Thurman" age="20" gender="female">
	</student><student name="Stefan" surname="Knorr" age="22" gender="male">
	</student><student name="Mike" surname="Galos" age="21" gender="male">
    </student></result>


Second example
==============
Search by giving attribute with value

 
	require_once '../class/Egzamel.php';

	$file = './data/example1.xml';
        $query = array(
	'student' => array( "age" => "22")

	);

	Egzamel::parse($file, $query);
	Egzamel::toXml();
 

Output


    <?xml version="1.0"?>
    <result><student name="Matthew" surname="Gambardella" age="22" gender="male">
	</student><student name="Eva" surname="Corets" age="22" gender="female">
	</student><student name="Stefan" surname="Knorr" age="22" gender="male">
    </student></result>
