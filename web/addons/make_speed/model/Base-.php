<?php
 namespace Model; defined("\x49\116\137\111\101") or exit("\x41\143\143\x65\163\x73\x20\104\x65\x6e\151\x65\144"); class Base { public static $W; public function __construct() { } public function replaceImgUrl(&$array) { goto rS4dg; XgH4A: if (!is_array($array)) { goto b1ah1; } goto tbQQt; FmQRg: fkj_4: goto Wtu4e; XCU8A: $array = str_replace("\57\165\x70\x6c\x6f\141\x64\x73", $modelUrl . "\x63\x6f\x72\x65\57\x70\x75\142\154\x69\x63\x2f\165\x70\x6c\x6f\x61\x64\163", $array); goto XgH4A; Wtu4e: b1ah1: goto hEv5M; rS4dg: $modelUrl = str_replace("\155\141\153\x65\137\163\160\145\145\144\137\160\x6c\165\x67\x69\156\x5f\x66\162\x65\x69\147\x68\164", "\155\141\x6b\x65\137\163\x70\x65\145\x64", MODULE_URL); goto XCU8A; hEv5M: return $array; goto Assr6; tbQQt: foreach ($array as $key => $val) { goto jcA_7; NDtiO: EVUuM: goto SZg9g; rS3kd: $this->replaceImgUrl($array[$key]); goto vQez7; vQez7: WEms2: goto NDtiO; jcA_7: if (!is_array($val)) { goto WEms2; } goto rS3kd; SZg9g: } goto FmQRg; Assr6: } }